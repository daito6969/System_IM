<?php require '../includes/auth.php'; require_role(['traveler']); include '../includes/header.php'; ?>
<h1>My bookings (live)</h1>
<table data-live="bookings" data-api="../api/poll.php" data-cols="id,destination,travel_date,pax,total,status">
  <thead><tr><th>ID</th><th>Destination</th><th>Date</th><th>Pax</th><th>Total</th><th>Status</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
