<?php 
require 'includes/auth.php'; 
require_role(['admin', 'staff', 'traveler']); 
include 'includes/header.php'; 

$uStmt = $pdo->prepare('SELECT * FROM users WHERE id=?');
$uStmt->execute([user()['id']]);
$userProfile = $uStmt->fetch() ?: user();
?>

<h1>My Account & Profile</h1>

<!-- Profile Info Card -->
<div style="background:var(--surface);border:1px solid var(--line);border-radius:var(--radius-md);padding:24px;margin-bottom:28px;max-width:560px;box-shadow:var(--shadow-sm);">
  <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:16px;">
    <div style="display:flex;align-items:center;gap:12px;">
      <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#0284c7,#0369a1);color:#fff;display:flex;align-items:center;justify-content:center;font-size:20px;font-weight:800;">
        <?= strtoupper(substr($userProfile['name'] ?? 'U', 0, 1)) ?>
      </div>
      <div>
        <h3 style="margin:0;font-size:18px;color:var(--ink);"><?= e($userProfile['name']) ?></h3>
        <span style="font-size:13px;color:var(--muted);"><?= e($userProfile['email']) ?></span>
      </div>
    </div>
    <span style="background:rgba(2,132,199,0.12);color:var(--primary);padding:4px 12px;border-radius:var(--radius-full);font-size:12px;font-weight:700;text-transform:uppercase;">
      <?= e($userProfile['role']) ?>
    </span>
  </div>

  <div style="border-top:1px solid var(--line);padding-top:14px;display:grid;grid-template-columns:1fr 1fr;gap:12px;font-size:13px;">
    <div>
      <span style="color:var(--muted);display:block;">Contact Phone:</span>
      <b style="color:var(--ink);"><?= e($userProfile['phone'] ?: 'None on file') ?></b>
    </div>
    <div>
      <span style="color:var(--muted);display:block;">KYC Identity Status:</span>
      <?php if (!empty($userProfile['kyc_verified'])): ?>
        <span style="color:var(--emerald);font-weight:700;">✓ Verified ID (<?= e($userProfile['id_type'] ?: 'National ID') ?>)</span>
      <?php else: ?>
        <span style="color:var(--muted);">Standard Profile</span>
      <?php endif; ?>
    </div>
  </div>
</div>

<h2>Security & Password</h2>
<?php if (!empty($_GET['ok'])): ?>
  <div style="background:var(--emerald-light);color:var(--emerald);padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:18px;font-weight:600;max-width:560px;">
    ✓ Your password has been changed successfully!
  </div>
<?php elseif (!empty($_GET['msg'])): ?>
  <p class="err" style="max-width:560px;"><?= e($_GET['msg']) ?></p>
<?php endif; ?>

<form method="post" action="actions/password_process.php">
  <label>Current Password
    <input type="password" name="current" placeholder="••••••••" required>
  </label>
  <label>New Password (min 6 characters)
    <input type="password" name="new" minlength="6" placeholder="••••••••" required>
  </label>
  <button type="submit">Update Password</button>
</form>

<?php include 'includes/footer.php'; ?>
