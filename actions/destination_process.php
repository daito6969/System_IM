<?php require '../includes/auth.php'; require_role(['admin']);
if (($_POST['action'] ?? '') === 'delete') { $pdo->prepare('DELETE FROM destinations WHERE id=?')->execute([(int)$_POST['id']]); exit; }
$pdo->prepare('INSERT INTO destinations(name,region,description,price) VALUES(?,?,?,?)')
    ->execute([trim($_POST['name']), trim($_POST['region']), trim($_POST['description']), (float)$_POST['price']]);
header('Location: ' . BASE . '/admin/destinations.php');
