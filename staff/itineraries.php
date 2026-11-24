<?php 
require '../includes/auth.php'; 
require_role(['staff', 'admin']); 
include '../includes/header.php'; 
?>
<h1>All Scheduled Itineraries (Live)</h1>
<p style="color:var(--muted);margin-bottom:20px;">Staff view of day-by-day scheduled activities and tour plans.</p>

<table data-live="itineraries" data-delete="../actions/itinerary_process.php" data-api="../api/poll.php" data-cols="title,day_no,activity">
  <thead>
    <tr>
      <th>Trip</th>
      <th>Day</th>
      <th>Activity</th>
      <th style="width:90px;">Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
<?php include '../includes/footer.php'; ?>
