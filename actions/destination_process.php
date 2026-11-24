<?php 
require '../includes/auth.php'; 
require_role(['admin']);

if (($_POST['action'] ?? '') === 'delete') { 
  $pdo->prepare('DELETE FROM destinations WHERE id=?')->execute([(int)$_POST['id']]); 
  header('Location: ' . BASE . '/admin/destinations.php');
  exit; 
}

$name = trim($_POST['name'] ?? '');
$region = trim($_POST['region'] ?? '');
$price = (float)($_POST['price'] ?? 0);
if ($name !== '' && $region !== '' && $price >= 0) {
  $pdo->prepare('INSERT INTO destinations(name,region,description,price) VALUES(?,?,?,?)')
      ->execute([$name, $region, trim($_POST['description'] ?? ''), $price]);
}
header('Location: ' . BASE . '/admin/destinations.php');
