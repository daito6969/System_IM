<?php require '../includes/auth.php'; require_role(['traveler']); include '../includes/header.php';
$s = $pdo->prepare('SELECT id,title FROM trips WHERE user_id=? ORDER BY id DESC'); $s->execute([user()['id']]); $trips = $s->fetchAll();
$tid = (int)($_GET['trip'] ?? ($trips[0]['id'] ?? 0)); ?>
<h1>Itinerary (live)</h1>
<?php if (!$trips): ?><p>Add a trip first in <a href="my_trips.php">My trips</a>.</p><?php else: ?>
<form method="get"><select name="trip" onchange="this.form.submit()"><?php foreach ($trips as $t): ?><option value="<?= $t['id'] ?>" <?= $t['id'] == $tid ? 'selected' : '' ?>><?= e($t['title']) ?></option><?php endforeach; ?></select></form>
<form method="post" action="../actions/itinerary_process.php"><input type="hidden" name="trip_id" value="<?= $tid ?>"><input type="number" name="day_no" min="1" value="1" required><input name="activity" placeholder="Activity" required><button>Add</button></form>
<table data-live="itineraries" data-delete="../actions/itinerary_process.php" data-query="&trip=<?= $tid ?>" data-api="../api/poll.php" data-cols="title,day_no,activity"><thead><tr><th>Trip</th><th>Day</th><th>Activity</th><th></th></tr></thead><tbody></tbody></table>
<?php endif; include '../includes/footer.php'; ?>
