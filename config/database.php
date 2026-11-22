<?php
$production = getenv('APP_ENV') === 'production';
$environment = [
  'DB_HOST' => getenv('DB_HOST'),
  'DB_NAME' => getenv('DB_NAME'),
  'DB_USER' => getenv('DB_USER'),
  'DB_PASSWORD' => getenv('DB_PASSWORD'),
];

if ($production) {
  $missing = [];
  foreach ($environment as $key => $value) {
    if ($value === false || $value === '') $missing[] = $key;
  }
  if ($missing) {
    throw new RuntimeException('Missing required database environment variables: ' . implode(', ', $missing));
  }
}

$host = $environment['DB_HOST'] ?: 'localhost';
$name = $environment['DB_NAME'] ?: 'roadtrip_db';
$user = $environment['DB_USER'] !== false ? $environment['DB_USER'] : 'root';
$password = $environment['DB_PASSWORD'] !== false ? $environment['DB_PASSWORD'] : '';
$port = getenv('DB_PORT') ?: ($production ? '3306' : '3307');

$pdo = new PDO(
  "mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4",
  $user,
  $password,
  [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  ]
);
