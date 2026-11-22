<?php
require_once __DIR__ . '/../includes/auth.php';

$first  = trim($_POST['first_name'] ?? '');
$last   = trim($_POST['last_name'] ?? '');
$mi     = trim($_POST['middle_initial'] ?? '');
$suffix = trim($_POST['suffix'] ?? '');
$email  = trim($_POST['email'] ?? '');
$pw     = $_POST['password'] ?? '';

if (!$first || !$last) {
  header('Location: ' . BASE . '/register.php?error=' . urlencode('First Name and Last Name are required.'));
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header('Location: ' . BASE . '/register.php?error=' . urlencode('Please enter a valid email address.'));
  exit;
}

if (strlen($pw) < 6) {
  header('Location: ' . BASE . '/register.php?error=' . urlencode('Password must be at least 6 characters long.'));
  exit;
}

// Format full name
$miFormatted = $mi ? (rtrim(strtoupper($mi), '.') . '.') : '';
$parts = array_filter([$first, $miFormatted, $last, $suffix]);
$fullName = implode(' ', $parts);

try {
  $stmt = $pdo->prepare(
    "INSERT INTO users(name, first_name, last_name, middle_initial, suffix, email, password_hash, role) 
     VALUES(?, ?, ?, ?, ?, ?, ?, 'traveler')"
  );
  $stmt->execute([
    $fullName,
    $first,
    $last,
    $miFormatted ?: null,
    $suffix ?: null,
    $email,
    password_hash($pw, PASSWORD_DEFAULT)
  ]);

  // Log the user in immediately after registering
  $newId = $pdo->lastInsertId();
  session_regenerate_id(true);
  $_SESSION['user'] = [
    'id'   => $newId,
    'name' => $fullName,
    'role' => 'traveler'
  ];

  header('Location: ' . BASE . '/traveler/travel.php');
  exit;
} catch (PDOException $ex) {
  header('Location: ' . BASE . '/register.php?error=' . urlencode('An account with this email address already exists.'));
  exit;
}
