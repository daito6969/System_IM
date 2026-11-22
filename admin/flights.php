<?php require '../includes/auth.php'; require_role(['admin']); include '../includes/header.php'; ?>
<h1>Flights (live)</h1>
<form method="post" action="../actions/flight_process.php"><input type="hidden" name="action" value="generate"><button>Generate 30 days of sample flights</button></form>
<form method="post" action="../actions/flight_process.php">
  <input name="origin" maxlength="3" placeholder="From (MNL)" required><input name="dest" maxlength="3" placeholder="To (CEB)" required>
  <input type="datetime-local" name="depart_at" required><input type="number" name="duration_min" placeholder="Minutes" required>
  <input name="airline" placeholder="Airline" required><input name="flight_no" placeholder="Flight no." required>
  <input type="number" step="0.01" name="price" placeholder="Price" required><input type="number" name="seats" value="150" required><button>Add flight</button>
</form>
<table data-live="flights" data-api="../api/poll.php" data-cols="id,origin,dest,depart_at,airline,flight_no,price,seats">
  <thead><tr><th>ID</th><th>From</th><th>To</th><th>Departs</th><th>Airline</th><th>No.</th><th>Price</th><th>Seats</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
