<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']); 
include '../includes/header.php';

$s = $pdo->prepare('SELECT id,title FROM trips WHERE user_id=? ORDER BY id DESC'); 
$s->execute([user()['id']]); 
$trips = $s->fetchAll();
$tid = (int)($_GET['trip'] ?? ($trips[0]['id'] ?? 0)); 
?>
<h1>Expenses (live)</h1>
<?php if (!$trips): ?>
  <p>Add a trip first in <a href="my_trips.php">My trips</a> or use the <a href="travel.php">Trip Planner</a>.</p>
<?php else: ?>
  <form method="get">
    <label>Select Trip:
      <select name="trip" onchange="this.form.submit()">
        <?php foreach ($trips as $t): ?>
          <option value="<?= $t['id'] ?>" <?= $t['id'] == $tid ? 'selected' : '' ?>><?= e($t['title']) ?></option>
        <?php endforeach; ?>
      </select>
    </label>
  </form>

  <form method="post" action="../actions/expense_process.php">
    <input type="hidden" name="trip_id" value="<?= $tid ?>">
    <label>Category
      <input name="category" placeholder="e.g. Food, Fuel, Accommodation, Flights..." required>
    </label>
    <label>Amount (₱)
      <input type="number" step="0.01" name="amount" placeholder="e.g. 1500" required>
    </label>
    <label>Note / Description
      <input name="note" placeholder="Optional details...">
    </label>
    <button type="submit">+ Add Expense</button>
  </form>

  <table data-live="expenses" data-delete="../actions/expense_process.php" data-query="&trip=<?= $tid ?>" data-api="../api/poll.php" data-cols="title,category,amount,note">
    <thead>
      <tr>
        <th>Trip</th>
        <th>Category</th>
        <th>Amount</th>
        <th>Note</th>
        <th style="width:90px;">Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
<?php endif; 
include '../includes/footer.php'; ?>
