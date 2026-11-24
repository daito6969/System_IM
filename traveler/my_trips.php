<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']); 
include '../includes/header.php'; 

$uid = user()['id'];
$sTrips = $pdo->prepare('SELECT * FROM trips WHERE user_id=? ORDER BY id DESC');
$sTrips->execute([$uid]);
$userTrips = $sTrips->fetchAll();

$sAllItins = $pdo->prepare('SELECT i.*, t.title FROM itineraries i JOIN trips t ON t.id=i.trip_id WHERE t.user_id=? ORDER BY i.trip_id, i.day_no');
$sAllItins->execute([$uid]);
$tripItins = [];
foreach ($sAllItins->fetchAll() as $it) {
  $tripItins[$it['trip_id']][] = $it;
}
?>

<h1>My Planned Trips & Itineraries</h1>

<p style="color:var(--muted);margin-bottom:24px;">
  View and manage your organized Philippine trips, day-by-day itineraries, and budget allocations.
</p>

<!-- Interactive Trip Cards with Inline Itineraries -->
<?php if ($userTrips): ?>
<div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(360px, 1fr));gap:20px;margin-bottom:36px;">
  <?php foreach ($userTrips as $tr): ?>
    <?php 
      $itins = $tripItins[$tr['id']] ?? []; 
      $isRelative = ($tr['stay_type'] ?? '') === 'relative';
    ?>
    <div style="background:var(--surface);border:1px solid var(--line);border-radius:var(--radius-md);padding:22px;box-shadow:var(--shadow-sm);display:flex;flex-direction:column;justify-content:space-between;">
      <div>
        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:10px;margin-bottom:10px;">
          <h3 style="margin:0;font-size:18px;color:var(--ink);"><?= e($tr['title']) ?></h3>
          <span style="background:rgba(2,132,199,0.1);color:var(--primary);font-weight:800;font-size:12px;padding:3px 8px;border-radius:var(--radius-full);white-space:nowrap;">
            ₱<?= number_format($tr['budget']) ?>
          </span>
        </div>

        <div style="font-size:13px;color:var(--muted);margin-bottom:12px;display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
          <span>🏝️ <b><?= e($tr['destination'] ?: 'Philippines') ?></b></span>
          <?php if ($tr['start_date']): ?>
            <span>📅 <?= date('M j', strtotime($tr['start_date'])) ?><?= $tr['end_date'] ? ' – ' . date('M j, Y', strtotime($tr['end_date'])) : '' ?></span>
          <?php endif; ?>
        </div>

        <?php if ($isRelative): ?>
          <div style="margin-bottom:12px;">
            <span class="stay-free-badge">🏠 Relatives' Place (Free Stay)</span>
          </div>
        <?php endif; ?>

        <!-- Day-by-Day Itinerary Inside Trip Card -->
        <div style="background:var(--surface-2);border:1px solid var(--line);border-radius:var(--radius-sm);padding:14px;margin:12px 0;">
          <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
            <b style="font-size:12.5px;text-transform:uppercase;color:var(--muted);letter-spacing:0.04em;">📋 Planned Itinerary (<?= count($itins) ?> spots):</b>
            <a href="itinerary.php?trip=<?= $tr['id'] ?>" style="font-size:11.5px;color:var(--primary);font-weight:700;text-decoration:none;">Manage ➔</a>
          </div>

          <?php if ($itins): ?>
            <div style="display:grid;gap:6px;max-height:180px;overflow-y:auto;">
              <?php foreach ($itins as $act): ?>
                <div style="font-size:13px;padding:4px 0;border-bottom:1px dashed var(--line);display:flex;justify-content:space-between;gap:8px;">
                  <span><b>Day <?= $act['day_no'] ?>:</b> <?= e($act['activity']) ?></span>
                </div>
              <?php endforeach; ?>
            </div>
          <?php else: ?>
            <p style="font-size:12.5px;color:var(--muted);margin:4px 0;">No itinerary items added yet.</p>
          <?php endif; ?>

          <!-- Inline Quick Add Itinerary Activity Form -->
          <form method="post" action="../actions/itinerary_process.php" style="margin:10px 0 0;padding:8px 0 0;border-top:1px solid var(--line);display:flex;gap:6px;background:transparent;border-radius:0;box-shadow:none;">
            <input type="hidden" name="trip_id" value="<?= $tr['id'] ?>">
            <input type="number" name="day_no" min="1" value="<?= count($itins) + 1 ?>" style="width:65px;padding:6px 8px;font-size:12px;" title="Day #">
            <input type="text" name="activity" placeholder="+ Add spot/activity..." required style="padding:6px 10px;font-size:12px;flex:1;">
            <button type="submit" style="padding:6px 12px;font-size:12px;">Add</button>
          </form>
        </div>
      </div>

      <div style="display:flex;justify-content:space-between;align-items:center;padding-top:12px;border-top:1px solid var(--line);margin-top:12px;">
        <a href="expenses.php?trip=<?= $tr['id'] ?>" style="font-size:12.5px;color:var(--primary);font-weight:700;text-decoration:none;">💰 View Expenses</a>
        <form method="post" action="../actions/trip_process.php" style="margin:0;padding:0;background:transparent;border:none;box-shadow:none;display:inline;" onsubmit="return confirm('Delete this trip and all its itineraries?');">
          <input type="hidden" name="action" value="delete">
          <input type="hidden" name="id" value="<?= $tr['id'] ?>">
          <button type="submit" class="del" style="padding:4px 10px;font-size:11.5px;">Delete</button>
        </form>
      </div>
    </div>
  <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- Quick Add Trip Form -->
<h2>➕ Quick Add Trip</h2>
<form method="post" action="../actions/trip_process.php">
  <label>Trip Title
    <input name="title" placeholder="e.g. 5-Day Cebu & Bohol Adventure" required>
  </label>
  <label>Destination City
    <input name="destination" placeholder="e.g. Cebu, Bohol, Palawan, Boracay..." required>
  </label>
  <label>Trip Target Budget (₱)
    <input type="number" name="budget" placeholder="100000" step="1000" min="0" value="100000" required>
  </label>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
    <label>Start Date
      <input type="date" name="start_date">
    </label>
    <label>End Date
      <input type="date" name="end_date">
    </label>
  </div>
  <button type="submit">+ Save Trip</button>
</form>

<h2>Live Saved Trips Table</h2>
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
