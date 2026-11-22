<?php require '../includes/auth.php'; require_role(['staff']); include '../includes/header.php'; ?>
<h1>Staff dashboard (live)</h1><h2>Flight bookings</h2>
<table data-live="flight_bookings" data-actions="../actions/flight_status_process.php" data-api="../api/poll.php" data-cols="ref,traveler,outbound,inbound,pax,total,status"><thead><tr><th>Ref</th><th>Traveler</th><th>Outbound</th><th>Return</th><th>Pax</th><th>Total</th><th>Status</th><th>Update</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
