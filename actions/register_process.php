<?php
require_once __DIR__ . '/../includes/auth.php';

$first  = trim($_POST['first_name'] ?? '');
$last   = trim($_POST['last_name'] ?? '');
$mi     = trim($_POST['middle_initial'] ?? '');
$suffix = trim($_POST['suffix'] ?? '');
$email  = trim($_POST['email'] ?? '');
$pw     = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

$_SESSION['register_old'] = [
  'first_name' => $first,
  'middle_initial' => $mi,
  'last_name' => $last,
  'suffix' => $suffix,
  'email' => $email,
];

function register_redirect($message) {
  header('Location: ' . BASE . '/register.php?error=' . urlencode($message));
  exit;
}

if (!$first || !$last) {
  register_redirect('First Name and Last Name are required.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  register_redirect('Please enter a valid email address.');
}

if (strlen($pw) < 8) {
  register_redirect('Password must be at least 8 characters long.');
}

if (!hash_equals($pw, $confirm)) {
  register_redirect('Passwords do not match.');
}

// Format full name
$miFormatted = $mi ? (rtrim(strtoupper($mi), '.') . '.') : '';
$parts = array_filter([$first, $miFormatted, $last, $suffix]);
$fullName = implode(' ', $parts);

try {
  $email = strtolower($email);
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
  unset($_SESSION['register_old']);
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
