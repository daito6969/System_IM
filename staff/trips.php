<?php require '../includes/auth.php'; require_role(['staff', 'admin']); include '../includes/header.php'; ?>
<h1>All trips (live)</h1>
<table data-live="trips" data-api="../api/poll.php" data-cols="id,traveler,title,destination,budget,start_date,end_date">
  <thead>
    <tr>
      <th>ID</th>
      <th>Traveler</th>
      <th>Trip Title</th>
      <th>Destination</th>
      <th>Budget (₱)</th>
      <th>Start Date</th>
      <th>End Date</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
<?php include '../includes/footer.php'; ?>
