<?php require '../includes/auth.php'; require_role(['admin']); include '../includes/header.php'; ?>
<h1>Destinations</h1>
<form method="post" action="../actions/destination_process.php">
  <input name="name" placeholder="Name" required><input name="region" placeholder="Region" required>
  <textarea name="description" placeholder="Description"></textarea>
  <input name="price" type="number" step="0.01" min="0" placeholder="Price (PHP)" required><button>Add destination</button>
</form>
<table data-live="destinations" data-delete="../actions/destination_process.php" data-api="../api/poll.php" data-cols="id,name,region,price">
  <thead><tr><th>ID</th><th>Name</th><th>Region</th><th>Price</th><th></th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
