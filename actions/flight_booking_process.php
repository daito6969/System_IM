<?php 
require '../includes/auth.php'; 
header('Content-Type: application/json');

if (!user() || !in_array(user()['role'], ['traveler', 'admin'])) { 
  http_response_code(403); 
  exit('{"ok":false,"error":"Log in as a traveler or admin"}'); 
}

$in = json_decode(file_get_contents('php://input'), true) ?: [];

if (!empty($in['cancel'])) {                                   // cancel and give the seats back
  $pdo->beginTransaction();
  $s = $pdo->prepare("SELECT * FROM flight_bookings WHERE id=? AND (user_id=? OR ?='admin') AND status IN ('confirmed', 'delayed')"); 
  $s->execute([(int)$in['cancel'], user()['id'], user()['role']]);
  if ($b = $s->fetch()) {
    $pdo->prepare("UPDATE flight_bookings SET status='cancelled' WHERE id=?")->execute([$b['id']]);
    foreach (array_filter([$b['flight_id'], $b['return_flight_id']]) as $fid) {
      $pdo->prepare('UPDATE flights SET seats=seats+? WHERE id=?')->execute([$b['pax'], $fid]);
    }
  }
  $pdo->commit(); 
  exit('{"ok":true}');
}

$legs = array_map('intval', $in['legs'] ?? []); 
$pax = max(1, min(9, (int)($in['pax'] ?? 1)));
if (!$legs || count($legs) > 2) {
  exit('{"ok":false,"error":"No flight selected"}');
}

$pdo->beginTransaction(); 
$total = 0;
foreach ($legs as $id) {
  $s = $pdo->prepare('SELECT price,seats FROM flights WHERE id=? FOR UPDATE'); 
  $s->execute([$id]); 
  $f = $s->fetch();
  if (!$f || $f['seats'] < $pax) { 
    $pdo->rollBack(); 
    exit('{"ok":false,"error":"Not enough seats left"}'); 
  }
  $total += $f['price'] * $pax;
}

$phone = trim($in['contact_phone'] ?? '');
$email = trim($in['contact_email'] ?? '');
$idType = trim($in['kyc_id_type'] ?? '');
$idNum = trim($in['kyc_id_number'] ?? '');

$ref = 'PH-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));
$pdo->prepare('INSERT INTO flight_bookings(ref,user_id,flight_id,return_flight_id,pax,contact_phone,contact_email,kyc_id_type,kyc_id_number,total) VALUES(?,?,?,?,?,?,?,?,?,?)')
    ->execute([$ref, user()['id'], $legs[0], $legs[1] ?? null, $pax, $phone, $email, $idType, $idNum, $total]);

foreach ($legs as $id) {
  $pdo->prepare('UPDATE flights SET seats=seats-? WHERE id=?')->execute([$pax, $id]);
}

if (!empty($idNum)) {
  $pdo->prepare('UPDATE users SET phone=?, id_type=?, id_number=?, kyc_verified=1 WHERE id=?')
      ->execute([$phone, $idType, $idNum, user()['id']]);
}

$pdo->commit(); 
echo json_encode(['ok' => true, 'ref' => $ref]);
