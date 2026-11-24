<?php require '../includes/auth.php'; require_role(['traveler', 'admin']); include '../includes/header.php';
function n($pdo, $sql, $params = []) {
  $s = $pdo->prepare($sql);
  $s->execute($params);
  return $s->fetchColumn() ?: 0;
}
$uid = user()['id'];
$flightsCount = n($pdo, "SELECT COUNT(*) FROM flight_bookings WHERE user_id=? AND status IN ('confirmed', 'delayed')", [$uid]);
$destCount = n($pdo, "SELECT COUNT(*) FROM bookings WHERE user_id=? AND status IN ('pending', 'confirmed', 'delayed')", [$uid]);
$tripsCount = n($pdo, 'SELECT COUNT(*) FROM trips WHERE user_id=?', [$uid]);
$totalBudget = n($pdo, 'SELECT SUM(budget) FROM trips WHERE user_id=?', [$uid]);

// Retrieve the most recent active trip for the Live Tracker & Plan Summary
$sTrip = $pdo->prepare('SELECT * FROM trips WHERE user_id=? ORDER BY id DESC LIMIT 1');
$sTrip->execute([$uid]);
$latestTrip = $sTrip->fetch();

$tripActivities = [];
$tripExpenses = [];
$spentTotal = 0;
$flightSpend = 0;
$actSpend = 0;
$staySpend = 0;

if ($latestTrip) {
  $sAct = $pdo->prepare('SELECT * FROM itineraries WHERE trip_id=? ORDER BY day_no');
  $sAct->execute([$latestTrip['id']]);
  $tripActivities = $sAct->fetchAll();

  $sExp = $pdo->prepare('SELECT * FROM expenses WHERE trip_id=?');
  $sExp->execute([$latestTrip['id']]);
  $tripExpenses = $sExp->fetchAll();

  foreach ($tripExpenses as $exp) {
    $spentTotal += (float)$exp['amount'];
    if ($exp['category'] === 'Flights') $flightSpend += (float)$exp['amount'];
    elseif ($exp['category'] === 'Activities & Tours') $actSpend += (float)$exp['amount'];
    elseif (strpos($exp['category'], 'Accommodation') !== false) $staySpend += (float)$exp['amount'];
  }
}
$targetBudget = $latestTrip ? (float)$latestTrip['budget'] : 100000;
$remainingBudget = $targetBudget - $spentTotal;
$budgetPct = $targetBudget > 0 ? min(100, round(($spentTotal / $targetBudget) * 100)) : 0;
$isOver = $remainingBudget < 0;
$statusText = $isOver ? 'Over Budget' : ($budgetPct > 80 ? 'Nearing Limit' : 'Healthy');
$statusClass = $isOver ? 'danger' : ($budgetPct > 80 ? 'warning' : '');
?>

<h1>Welcome back, <?= e(user()['name']) ?> 👋</h1>

<!-- Smart Plan CTA Banner -->
<div class="plan-cta-banner">
  <div>
    <h2>Ready to plan your next Philippine getaway?</h2>
    <p>Set your whole trip budget (e.g. ₱100,000), choose must-see spots (like Tops Lookout or Bohol in Cebu), select accommodation, and book flights all in one place.</p>
  </div>
  <a href="travel.php" class="plan-cta-btn">
    <span>🧭 Open Smart Trip Planner</span> ➔
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
    <div class="kpi-title">Active Flights</div>
    <div class="kpi-val"><?= number_format($flightsCount) ?></div>
    <div class="kpi-sub"><a href="bookings.php" style="color:var(--primary);font-weight:700;text-decoration:none;">View in Bookings ➔</a></div>
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

<!-- Active Trip Budget Tracker & Plan Summary Section -->
<div class="dash-overview-grid">
  <!-- 1. Live Budget Tracker Card -->
  <div class="dash-card">
    <div class="dash-card-header">
      <div>
        <h3>💰 Trip Budget Tracker</h3>
        <small style="color:var(--muted);"><?= $latestTrip ? 'Active Trip: ' . e($latestTrip['title']) : 'No active trip yet' ?></small>
      </div>
      <span class="budget-status-pill <?= $statusClass ?>"><?= $statusText ?></span>
    </div>

    <div class="dash-gauge-wrap">
      <div class="dash-gauge-track">
        <div class="dash-gauge-fill <?= $isOver ? 'over' : '' ?>" style="width: <?= $budgetPct ?>%;"></div>
      </div>
      <div class="dash-gauge-labels">
        <span>₱<?= number_format($spentTotal) ?> (<?= $budgetPct ?>%) used</span>
        <span>Target: ₱<?= number_format($targetBudget) ?></span>
      </div>
    </div>

    <div class="dash-breakdown-grid">
      <div class="dash-breakdown-item">
        <span>✈️ Flights:</span>
        <b>₱<?= number_format($flightSpend) ?></b>
      </div>
      <div class="dash-breakdown-item">
        <span>🏝️ Activities & Tours:</span>
        <b>₱<?= number_format($actSpend) ?></b>
      </div>
      <div class="dash-breakdown-item">
        <span>🏨 Stays & Meals:</span>
        <b>₱<?= number_format($staySpend) ?></b>
        <?php if ($latestTrip && ($latestTrip['stay_type'] ?? '') === 'relative'): ?>
          <small style="color:var(--emerald);font-size:11px;font-weight:700;">🏠 Relative's House (₱0 Stay)</small>
        <?php endif; ?>
      </div>
      <div class="dash-breakdown-item" style="border-left: 3px solid <?= $isOver ? 'var(--danger)' : 'var(--emerald)' ?>;">
        <span>Remaining Balance:</span>
        <b style="color: <?= $isOver ? 'var(--danger)' : 'var(--emerald)' ?>;">₱<?= number_format($remainingBudget) ?></b>
      </div>
    </div>
  </div>

  <!-- 2. Active Trip Plan Summary Card -->
  <div class="dash-card">
    <div class="dash-card-header">
      <h3>📋 Trip Plan Summary</h3>
      <?php if ($latestTrip): ?>
        <a href="travel.php" style="font-size:12px;color:var(--primary);font-weight:700;text-decoration:none;">Edit in Planner ➔</a>
      <?php endif; ?>
    </div>

    <?php if ($latestTrip): ?>
      <div class="dash-plan-badge">
        🏝️ <?= e($latestTrip['destination'] ?: 'Philippines') ?> 
        <?= $latestTrip['start_date'] ? '· ' . date('M j', strtotime($latestTrip['start_date'])) : '' ?>
        <?= $latestTrip['end_date'] ? '–' . date('M j, Y', strtotime($latestTrip['end_date'])) : '' ?>
      </div>

      <?php if (($latestTrip['stay_type'] ?? '') === 'relative'): ?>
        <div style="margin-bottom:10px;">
          <span class="stay-free-badge">🏠 Staying at Relatives/Friends (Free Accommodation)</span>
        </div>
      <?php endif; ?>

      <h4 style="font-size:13px;color:var(--muted);text-transform:uppercase;margin:12px 0 6px;">Planned Spots & Itinerary:</h4>
      <div class="dash-plan-items">
        <?php if ($tripActivities): ?>
          <?php foreach ($tripActivities as $act): ?>
            <div class="dash-plan-item">
              <span><b>Day <?= $act['day_no'] ?>:</b> <?= e($act['activity']) ?></span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p style="color:var(--muted);font-size:13px;padding:8px 0;">No activities added yet to this trip.</p>
        <?php endif; ?>
      </div>

      <div style="display:flex;gap:10px;margin-top:16px;">
        <a href="itinerary.php?trip=<?= $latestTrip['id'] ?>" class="btn" style="font-size:12px;padding:8px 14px;text-decoration:none;">View Full Itinerary</a>
        <a href="expenses.php?trip=<?= $latestTrip['id'] ?>" class="btn" style="font-size:12px;padding:8px 14px;background:var(--surface-2);color:var(--ink);border:1px solid var(--line);text-decoration:none;">Track Expenses</a>
      </div>
    <?php else: ?>
      <div style="padding:28px 12px;text-align:center;color:var(--muted);">
        <p>No trip plan created yet.</p>
        <a href="travel.php" class="btn" style="margin-top:10px;text-decoration:none;display:inline-block;">🧭 Plan Your First Trip</a>
      </div>
    <?php endif; ?>
  </div>
</div>

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
