<?php require '../includes/auth.php'; require_role(['traveler']); include '../includes/header.php';
$list = $pdo->query('SELECT * FROM destinations ORDER BY name')->fetchAll(); ?>
<h1>Book a trip</h1>
<form method="post" action="../actions/booking_process.php">
  <select name="destination_id" required>
    <?php foreach ($list as $d): ?><option value="<?= $d['id'] ?>"><?= e($d['name']) ?> – ₱<?= number_format($d['price']) ?></option><?php endforeach; ?>
  </select>
  <input type="date" name="travel_date" min="<?= date('Y-m-d') ?>" required>
  <input type="number" name="pax" min="1" value="1" required><button>Book now</button>
</form>
<?php include '../includes/footer.php'; ?>
