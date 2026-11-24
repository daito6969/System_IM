<?php 
require '../includes/auth.php'; 
require_role(['traveler', 'admin']); 
include '../includes/header.php';

$list = $pdo->query('SELECT * FROM destinations ORDER BY name')->fetchAll(); 
?>
<h1>Book a Destination Package</h1>
<form method="post" action="../actions/booking_process.php">
  <label>Choose Destination Tour
    <select name="destination_id" required>
      <?php foreach ($list as $d): ?>
        <option value="<?= $d['id'] ?>"><?= e($d['name']) ?> (<?= e($d['region']) ?>) – ₱<?= number_format($d['price']) ?> / pax</option>
      <?php endforeach; ?>
    </select>
  </label>
  <label>Travel Date
    <input type="date" name="travel_date" min="<?= date('Y-m-d') ?>" required>
  </label>
  <label>Number of Travelers (Pax)
    <input type="number" name="pax" min="1" max="9" value="1" required>
  </label>
  <button type="submit">Book Tour Package</button>
</form>

<h2 style="margin-top:32px;">Destination Packages Available</h2>
<div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(280px, 1fr));gap:16px;">
  <?php foreach ($list as $d): ?>
    <div style="background:var(--surface);border:1px solid var(--line);border-radius:var(--radius-md);padding:18px;display:flex;flex-direction:column;justify-content:space-between;">
      <div>
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
          <h3 style="margin:0;font-size:16px;"><?= e($d['name']) ?></h3>
          <span style="background:rgba(2,132,199,0.1);color:var(--primary);padding:2px 8px;border-radius:var(--radius-full);font-size:11px;font-weight:700;">
            <?= e($d['region']) ?>
          </span>
        </div>
        <p style="color:var(--muted);font-size:13px;margin:0 0 12px;"><?= e($d['description']) ?></p>
      </div>
      <div style="display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--line);padding-top:10px;">
        <span style="font-size:14px;font-weight:800;color:var(--ink);">₱<?= number_format($d['price']) ?></span>
        <span style="font-size:11.5px;color:var(--muted);">per person</span>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<?php include '../includes/footer.php'; ?>
