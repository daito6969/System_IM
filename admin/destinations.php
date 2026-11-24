<?php 
require '../includes/auth.php'; 
require_role(['admin']); 
include '../includes/header.php'; 
?>
<h1>Destinations Management (live)</h1>

<h2>Add New Destination Tour</h2>
<form method="post" action="../actions/destination_process.php">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
    <label>Destination Name
      <input name="name" placeholder="e.g. Boracay Island Package" required>
    </label>
    <label>Region
      <input name="region" placeholder="e.g. Western Visayas" required>
    </label>
  </div>
  <label>Description &amp; Inclusions
    <textarea name="description" placeholder="Highlights, activities, beach tours..."></textarea>
  </label>
  <label>Package Price per Traveler (₱)
    <input name="price" type="number" step="0.01" min="0" placeholder="e.g. 4500" required>
  </label>
  <button type="submit">+ Add Destination</button>
</form>

<h2>Current Destinations (Live)</h2>
<table data-live="destinations" data-delete="../actions/destination_process.php" data-api="../api/poll.php" data-cols="id,name,region,price">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Region</th>
      <th>Price</th>
      <th style="width:90px;">Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<?php include '../includes/footer.php'; ?>
