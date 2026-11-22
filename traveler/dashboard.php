<?php require '../includes/auth.php'; require_role(['traveler']); include '../includes/header.php';
function n($pdo, $sql, $params = []) {
  $s = $pdo->prepare($sql);
  $s->execute($params);
  return $s->fetchColumn() ?: 0;
}
$uid = user()['id'];
$flightsCount = n($pdo, "SELECT COUNT(*) FROM flight_bookings WHERE user_id=? AND status='confirmed'", [$uid]);
$destCount = n($pdo, 'SELECT COUNT(*) FROM bookings WHERE user_id=?', [$uid]);
$tripsCount = n($pdo, 'SELECT COUNT(*) FROM trips WHERE user_id=?', [$uid]);
$totalBudget = n($pdo, 'SELECT SUM(budget) FROM trips WHERE user_id=?', [$uid]);
?>

<h1>Welcome back, <?= e(user()['name']) ?> 👋</h1>

<!-- Smart Plan CTA Banner -->
<div class="plan-cta-banner">
  <div>
    <h2>Ready to plan your next Philippine getaway?</h2>
    <p>Set your target budget (e.g. ₱100,000), choose must-see spots like Tops Lookout in Cebu or a day tour to Bohol, and book flights all in one place.</p>
  </div>
  <a href="travel.php" class="plan-cta-btn">
    <span>🧭 Plan New Trip & Budget</span> ➔
  </a>
</div>

<!-- Modern KPI Cards -->
<div class="metrics-row">
  <div class="kpi-card emerald">
    <div class="kpi-title">Planned Trips</div>
    <div class="kpi-val"><?= number_format($tripsCount) ?></div>
    <div class="kpi-sub">Custom itineraries organized</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-title">Confirmed Flights</div>
    <div class="kpi-val"><?= number_format($flightsCount) ?></div>
    <div class="kpi-sub">Domestic airline reservations</div>
  </div>

  <div class="kpi-card gold">
    <div class="kpi-title">Total Budget Tracked</div>
    <div class="kpi-val">₱<?= number_format($totalBudget) ?></div>
    <div class="kpi-sub">Across all saved trips</div>
  </div>

  <div class="kpi-card">
    <div class="kpi-title">Destination Bookings</div>
    <div class="kpi-val"><?= number_format($destCount) ?></div>
    <div class="kpi-sub">Tours and packages booked</div>
  </div>
</div>

<h2>My Flight Bookings (Live)</h2>
<table data-live="flight_bookings" data-api="../api/poll.php" data-cols="ref,outbound,inbound,pax,total,status">
  <thead>
    <tr>
      <th>Booking Ref</th>
      <th>Outbound Leg</th>
      <th>Return Leg</th>
      <th>Passengers</th>
      <th>Total Cost</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<h2>My Saved Trips & Budgets (Live)</h2>
<table data-live="trips" data-delete="../actions/trip_process.php" data-api="../api/poll.php" data-cols="id,title,destination,budget,start_date,end_date">
  <thead>
    <tr>
      <th>ID</th>
      <th>Trip Title</th>
      <th>Destination</th>
      <th>Budget (₱)</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<?php include '../includes/footer.php'; ?>
