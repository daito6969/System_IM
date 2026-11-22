<?php require '../includes/auth.php'; require_role(['admin', 'staff']); include '../includes/header.php'; ?>
<h1>All bookings (live)</h1>
<table data-live="bookings" data-api="../api/poll.php" data-actions="../actions/booking_process.php"
       data-cols="id,traveler,destination,travel_date,pax,total,status">
  <thead><tr><th>ID</th><th>Traveler</th><th>Destination</th><th>Date</th><th>Pax</th><th>Total</th><th>Status</th><th>Update</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
