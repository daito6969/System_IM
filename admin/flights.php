<?php 
require '../includes/auth.php'; 
require_role(['admin']); 
include '../includes/header.php'; 
?>
<h1>Flights Management (live)</h1>

<div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
  <form method="post" action="../actions/flight_process.php" style="margin:0;">
    <input type="hidden" name="action" value="generate">
    <button type="submit">⚡ Generate 30 Days of Sample Flights</button>
  </form>
</div>

<h2>Add Custom Flight</h2>
<form method="post" action="../actions/flight_process.php">
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
    <label>Origin Airport (3-letter IATA)
      <input name="origin" maxlength="3" placeholder="e.g. MNL" required style="text-transform:uppercase;">
    </label>
    <label>Destination Airport (3-letter IATA)
      <input name="dest" maxlength="3" placeholder="e.g. CEB" required style="text-transform:uppercase;">
    </label>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
    <label>Departure Date & Time
      <input type="datetime-local" name="depart_at" required>
    </label>
    <label>Flight Duration (Minutes)
      <input type="number" name="duration_min" placeholder="e.g. 75" required>
    </label>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
    <label>Airline Name
      <input name="airline" placeholder="e.g. Philippine Airlines" required>
    </label>
    <label>Flight Number
      <input name="flight_no" placeholder="e.g. PR 1845" required>
    </label>
  </div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;">
    <label>Fare Price (₱)
      <input type="number" step="0.01" name="price" placeholder="3200" required>
    </label>
    <label>Available Seats
      <input type="number" name="seats" value="150" required>
    </label>
  </div>
  <button type="submit">+ Add Flight</button>
</form>

<h2>Current Flights Inventory (Next 100 Departures)</h2>
<table data-live="flights" data-delete="../actions/flight_process.php" data-api="../api/poll.php" data-cols="id,origin,dest,depart_at,airline,flight_no,price,seats">
  <thead>
    <tr>
      <th>ID</th>
      <th>From</th>
      <th>To</th>
      <th>Departs</th>
      <th>Airline</th>
      <th>No.</th>
      <th>Price</th>
      <th>Seats</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<?php include '../includes/footer.php'; ?>
