<?php 
require '../includes/auth.php'; 
require_role(['admin']); 
include '../includes/header.php';

$all = $pdo->query('SELECT id,name,email,role FROM users ORDER BY name')->fetchAll(); 
?>
<h1>User Accounts Management (live)</h1>

<?php if (!empty($_GET['temp'])): ?>
  <div style="background:var(--accent-light);color:var(--accent-ink);border:1px solid rgba(245,158,11,0.4);padding:14px 18px;border-radius:var(--radius-sm);margin-bottom:24px;font-size:13.5px;">
    🔑 Temporary password generated: <b style="font-family:monospace;font-size:15px;background:rgba(0,0,0,0.06);padding:2px 8px;border-radius:4px;"><?= e($_GET['temp']) ?></b>
    <span style="display:block;margin-top:4px;font-size:12px;color:var(--muted);">Provide this password to the user. They can sign in and change it in their Account settings.</span>
  </div>
<?php endif; ?>

<div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(320px, 1fr));gap:20px;margin-bottom:28px;">
  <!-- Reset Password Form -->
  <form method="post" action="../actions/user_process.php" style="margin:0;">
    <input type="hidden" name="action" value="reset">
    <h3 style="margin-top:0;font-size:16px;">🔑 Reset User Password</h3>
    <label>Select User
      <select name="id" required>
        <?php foreach ($all as $a): ?>
          <option value="<?= $a['id'] ?>"><?= e($a['name']) ?> (<?= e($a['email']) ?>)</option>
        <?php endforeach; ?>
      </select>
    </label>
    <button type="submit">Generate Temporary Password</button>
  </form>

  <!-- Change Role Form -->
  <form method="post" action="../actions/user_process.php" style="margin:0;">
    <h3 style="margin-top:0;font-size:16px;">👤 Modify User Access Role</h3>
    <label>Select User
      <select name="id" required>
        <?php foreach ($all as $a): ?>
          <option value="<?= $a['id'] ?>"><?= e($a['name']) ?> (Role: <?= e($a['role']) ?>)</option>
        <?php endforeach; ?>
      </select>
    </label>
    <label>New Role
      <select name="role">
        <option value="traveler">Traveler</option>
        <option value="staff">Staff</option>
        <option value="admin">Administrator</option>
      </select>
    </label>
    <button type="submit">Update Role</button>
  </form>
</div>

<h2>All Registered Users (Live)</h2>
<table data-live="users" data-delete="../actions/user_process.php" data-api="../api/poll.php" data-cols="id,name,email,role,created_at">
  <thead>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Joined</th>
      <th style="width:90px;">Actions</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>

<?php include '../includes/footer.php'; ?>
