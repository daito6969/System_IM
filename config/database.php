<?php
// Database configuration with automatic cloud detection (Railway, Render, etc.)
$dbHost = getenv('DB_HOST') ?: (getenv('MYSQLHOST') ?: '127.0.0.1');
$dbPort = getenv('DB_PORT') ?: (getenv('MYSQLPORT') ?: '3307');
$dbName = getenv('DB_NAME') ?: (getenv('MYSQLDATABASE') ?: 'roadtrip_db');
$dbUser = getenv('DB_USER') ?: (getenv('MYSQLUSER') ?: 'root');
$dbPass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : (getenv('MYSQLPASSWORD') !== false ? getenv('MYSQLPASSWORD') : '');

// Support connection string URL (e.g. DATABASE_URL / MYSQL_URL provided by Railway/Render)
$connUrl = getenv('DATABASE_URL') ?: (getenv('MYSQL_URL') ?: (getenv('MYSQL_PRIVATE_URL') ?: getenv('MYSQL_PUBLIC_URL')));
if ($connUrl) {
  $parsed = parse_url($connUrl);
  if ($parsed) {
    if (!empty($parsed['host'])) $dbHost = $parsed['host'];
    if (!empty($parsed['port'])) $dbPort = $parsed['port'];
    if (!empty($parsed['user'])) $dbUser = $parsed['user'];
    if (isset($parsed['pass']))  $dbPass = $parsed['pass'];
    if (!empty($parsed['path'])) $dbName = ltrim($parsed['path'], '/');
  }
}

// On Linux containers, 'localhost' triggers a Unix socket look-up. Use TCP/IP instead.
if ($dbHost === 'localhost') {
  $dbHost = '127.0.0.1';
}

$pdo = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::MYSQL_ATTR_MULTI_STATEMENTS => true,
]);

// Auto-initialize tables if empty (Zero-click cloud deployment: no copy-pasting required!)
try {
  $tableExists = $pdo->query("SHOW TABLES LIKE 'users'")->fetch();
  if (!$tableExists) {
    $schemaFile = __DIR__ . '/../database/schema.sql';
    if (file_exists($schemaFile)) {
      $sql = file_get_contents($schemaFile);
      $sql = preg_replace('/CREATE DATABASE[^;]+;/i', '', $sql);
      $sql = preg_replace('/USE [^;]+;/i', '', $sql);
      $pdo->exec($sql);
    }

    // Auto-generate 30 days of sample flight inventory
    $fCheck = $pdo->query("SELECT COUNT(*) FROM flights")->fetchColumn();
    if (!$fCheck) {
      $routes = [['MNL','CEB',570],['MNL','DVO',950],['MNL','KLO',300],['MNL','PPS',590],['MNL','ILO',470],['MNL','CGY',800],['CEB','DVO',520]];
      $air = [['PR','Philippine Airlines',1.35],['5J','Cebu Pacific',1],['Z2','AirAsia Philippines',.93],['2P','PAL Express',1.12]];
      $slots = [[6,0],[9,30],[13,15],[18,0]];
      $ins = $pdo->prepare('INSERT IGNORE INTO flights(origin,dest,depart_at,duration_min,airline,flight_no,price) VALUES(?,?,?,?,?,?,?)');
      foreach ($routes as $ri => [$a, $b, $km]) {
        foreach ([[$a,$b],[$b,$a]] as [$o, $d]) {
          for ($day = 1; $day <= 30; $day++) {
            foreach ($slots as $si => [$h, $m]) {
              [$code, $name, $f] = $air[($day + $si + $ri) % 4];
              $when = (new DateTime("+$day day"))->setTime($h, $m);
              $ins->execute([$o, $d, $when->format('Y-m-d H:i:s'), round((35 + $km / 12.5) / 5) * 5, $name, $code . (100 + $ri * 11 + $si * 7), round((900 + $km * 2.4) * $f / 10) * 10]);
            }
          }
        }
      }
    }
  }
} catch (Throwable $e) {}

// Auto-migrate status columns to support 'delayed'
try {
  if (!file_exists(__DIR__ . '/.migrated_delayed_v1')) {
    $pdo->exec("ALTER TABLE flight_bookings MODIFY COLUMN status ENUM('confirmed','delayed','cancelled') DEFAULT 'confirmed'");
    $pdo->exec("ALTER TABLE bookings MODIFY COLUMN status ENUM('pending','confirmed','delayed','cancelled') DEFAULT 'pending'");
    @touch(__DIR__ . '/.migrated_delayed_v1');
  }
} catch (Throwable $e) {}
