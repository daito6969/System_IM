<?php require '../includes/auth.php'; require_role(['admin']); include '../includes/header.php';
$all = $pdo->query('SELECT id,name,role FROM users ORDER BY name')->fetchAll(); ?>
<h1>Users (live)</h1>
<?php if (!empty($_GET['temp'])): ?><p class="err">Temporary password: <b><?= e($_GET['temp']) ?></b> (give it to the user, who should change it in Account)</p><?php endif; ?>
<form method="post" action="../actions/user_process.php"><input type="hidden" name="action" value="reset">
  <select name="id"><?php foreach ($all as $a): ?><option value="<?= $a['id'] ?>"><?= e($a['name']) ?></option><?php endforeach; ?></select><button>Reset password</button></form>
<form method="post" action="../actions/user_process.php">
  <select name="id"><?php foreach ($all as $a): ?><option value="<?= $a['id'] ?>"><?= e($a['name']) ?> (<?= e($a['role']) ?>)</option><?php endforeach; ?></select>
  <select name="role"><option>traveler</option><option>staff</option><option>admin</option></select><button>Change role</button>
</form>
<table data-live="users" data-api="../api/poll.php" data-cols="id,name,email,role,created_at">
  <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody></tbody></table>
<?php include '../includes/footer.php'; ?>
