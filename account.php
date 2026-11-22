<?php require 'includes/auth.php'; require_role(['admin', 'staff', 'traveler']); include 'includes/header.php'; ?>
<h1>Account</h1>
<?php if (!empty($_GET['msg'])): ?><p class="err"><?= e($_GET['msg']) ?></p><?php endif; ?>
<form method="post" action="actions/password_process.php">
  <label>Current password<input type="password" name="current" required></label>
  <label>New password (min 6)<input type="password" name="new" minlength="6" required></label>
  <button>Change password</button>
</form>
<?php include 'includes/footer.php'; ?>
