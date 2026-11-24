<?php
require '../includes/auth.php';
header('Content-Type: application/json');

if (!user() || !in_array(user()['role'], ['traveler', 'admin'])) {
  http_response_code(403);
  exit(json_encode(['ok' => false, 'error' => 'Please log in as a traveler']));
}

$in = json_decode(file_get_contents('php://input'), true) ?: [];

$title = trim($in['title'] ?? '');
$destination = trim($in['destination'] ?? 'Philippines');
$budget = max(0, (float)($in['budget'] ?? 0));
$start_date = !empty($in['start_date']) ? $in['start_date'] : null;
$end_date = !empty($in['end_date']) ? $in['end_date'] : null;
$pax = max(1, min(9, (int)($in['pax'] ?? 1)));
$legs = array_map('intval', $in['legs'] ?? []);
$activities = is_array($in['activities'] ?? null) ? $in['activities'] : [];
$stay_type = trim($in['stay_type'] ?? 'hotel');
$hotel_est = $stay_type === 'relative' ? 0.0 : max(0, (float)($in['hotel_est'] ?? 0));
$contact_phone = trim($in['contact_phone'] ?? '');
$contact_email = trim($in['contact_email'] ?? '');
$kyc_id_type = trim($in['kyc_id_type'] ?? '');
$kyc_id_number = trim($in['kyc_id_number'] ?? '');

if (!$title) {
  $title = "Trip to " . $destination . ($budget > 0 ? " (₱" . number_format($budget) . " Budget)" : "");
}

$pdo->beginTransaction();
try {
  $flight_ref = null;
  $flight_total = 0;

  // 1. Reserve flights if selected
  if (!empty($legs)) {
    if (count($legs) > 2) {
      throw new Exception('Invalid number of flight legs.');
    }
    foreach ($legs as $fid) {
      $s = $pdo->prepare('SELECT price, seats FROM flights WHERE id=? FOR UPDATE');
      $s->execute([$fid]);
      $f = $s->fetch();
      if (!$f || $f['seats'] < $pax) {
        throw new Exception('Not enough flight seats left for one or more selected flights.');
      }
      $flight_total += $f['price'] * $pax;
    }
    $flight_ref = 'PH-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
    $pdo->prepare('INSERT INTO flight_bookings(ref, user_id, flight_id, return_flight_id, pax, contact_phone, contact_email, kyc_id_type, kyc_id_number, total) VALUES(?,?,?,?,?,?,?,?,?,?)')
        ->execute([$flight_ref, user()['id'], $legs[0], $legs[1] ?? null, $pax, $contact_phone, $contact_email, $kyc_id_type, $kyc_id_number, $flight_total]);

    foreach ($legs as $fid) {
      $pdo->prepare('UPDATE flights SET seats=seats-? WHERE id=?')->execute([$pax, $fid]);
    }

    // Save KYC to user profile for 2nd booking autofill
    if (!empty($kyc_id_number)) {
      $pdo->prepare('UPDATE users SET phone=?, id_type=?, id_number=?, kyc_verified=1 WHERE id=?')
          ->execute([$contact_phone, $kyc_id_type, $kyc_id_number, user()['id']]);
    }
  }

  // 2. Create the unified Trip
  $stmtTrip = $pdo->prepare('INSERT INTO trips(user_id, title, destination, budget, stay_type, stay_cost, start_date, end_date) VALUES(?,?,?,?,?,?,?,?)');
  $stmtTrip->execute([user()['id'], $title, $destination, $budget, $stay_type, $hotel_est, $start_date, $end_date]);
  $trip_id = (int)$pdo->lastInsertId();

  // 3. Insert planned activities into itineraries
  $act_stmt = $pdo->prepare('INSERT INTO itineraries(trip_id, day_no, activity) VALUES(?,?,?)');
  $total_activities_cost = 0;
  $day_counter = 1;

  foreach ($activities as $act) {
    $act_name = trim($act['name'] ?? '');
    $act_day = max(1, (int)($act['day'] ?? $day_counter++));
    $act_cost = max(0, (float)($act['cost'] ?? 0));
    $total_activities_cost += $act_cost * $pax;

    if ($act_name) {
      $desc = $act_name . ($act_cost > 0 ? " (Est. ₱" . number_format($act_cost) . "/pax)" : "");
      $act_stmt->execute([$trip_id, $act_day, $desc]);
    }
  }

  // 4. Record itemized budget expenses into expenses table
  $exp_stmt = $pdo->prepare('INSERT INTO expenses(trip_id, category, amount, note) VALUES(?,?,?,?)');

  if ($flight_total > 0) {
    $exp_stmt->execute([$trip_id, 'Flights', $flight_total, 'Domestic flights (Ref: ' . $flight_ref . ') for ' . $pax . ' pax']);
  }
  if ($total_activities_cost > 0) {
    $exp_stmt->execute([$trip_id, 'Activities & Tours', $total_activities_cost, 'Planned destination attractions & tours']);
  }
  if ($stay_type === 'relative') {
    $exp_stmt->execute([$trip_id, 'Accommodation & Meals', 0.0, "Staying at relative's / friend's place (₱0 Free accommodation & home meals)"]);
  } elseif ($hotel_est > 0) {
    $exp_stmt->execute([$trip_id, 'Accommodation & Meals', $hotel_est, 'Estimated stay & dining budget allocation']);
  }

  $pdo->commit();

  echo json_encode([
    'ok' => true,
    'trip_id' => $trip_id,
    'ref' => $flight_ref,
    'title' => $title,
    'total_cost' => $flight_total + $total_activities_cost + $hotel_est,
    'message' => 'Trip planned & saved successfully!'
  ]);
} catch (Exception $e) {
  $pdo->rollBack();
  http_response_code(400);
  echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
}
