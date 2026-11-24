<?php 
require '../includes/auth.php'; 
require_role(['staff', 'admin']); 
include '../includes/header.php'; 
?>
<h1>All Planned Trips (Live)</h1>
<p style="color:var(--muted);margin-bottom:20px;">Staff oversight of all Philippine trips created across the platform.</p>

<table data-live="trips" data-delete="../actions/trip_process.php" data-api="../api/poll.php" data-cols="id,traveler,title,destination,budget,start_date,end_date">
  <thead>
    <tr>
      <th>ID</th>
      <th>Traveler</th>
      <th>Trip Title</th>
      <th>Destination</th>
      <th>Budget (₱)</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th style="width:90px;">Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
<?php include '../includes/footer.php'; ?>
