<?php require '../includes/auth.php'; require_role(['traveler']); include '../includes/header.php'; ?>
<h1>My Trips & Budgets (Live)</h1>

<p style="color:var(--muted);margin-bottom:20px;">
  Add a quick trip below, or use the <a href="travel.php" style="color:var(--primary);font-weight:700;">Smart Trip Planner</a> to select specific attractions (like Tops Lookout in Cebu or Bohol day tours) with live budget tracking!
</p>

<form method="post" action="../actions/trip_process.php">
  <label>Trip Title
    <input name="title" placeholder="e.g. 5-Day Cebu & Bohol Adventure" required>
  </label>
  <label>Destination City
    <input name="destination" placeholder="e.g. Cebu, Bohol, Palawan, Boracay..." required>
  </label>
  <label>Trip Target Budget (₱)
    <input type="number" name="budget" placeholder="100000" step="1000" min="0" value="100000" required>
  </label>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
    <label>Start Date
      <input type="date" name="start_date">
    </label>
    <label>End Date
      <input type="date" name="end_date">
    </label>
  </div>
  <button>+ Add Trip Plan</button>
</form>

<table data-live="trips" data-delete="../actions/trip_process.php" data-api="../api/poll.php" data-cols="id,title,destination,budget,start_date,end_date">
  <thead>
    <tr>
      <th>ID</th>
      <th>Trip Title</th>
      <th>Destination</th>
      <th>Budget (₱)</th>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<?php include '../includes/footer.php'; ?>
