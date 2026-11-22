<?php require '../includes/auth.php'; require_role(['staff', 'admin']); include '../includes/header.php'; ?>
<h1>All itineraries (live)</h1>
<table data-live="itineraries" data-api="../api/poll.php" data-cols="title,day_no,activity"><thead><tr><th>Trip</th><th>Day</th><th>Activity</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
