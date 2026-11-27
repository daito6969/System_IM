<?php
require '../includes/auth.php';
require_role(['admin']);

$action = $_POST['action'] ?? '';

if ($action === 'delete') {
  try {
    $pdo->prepare('DELETE FROM flights WHERE id=?')->execute([(int)($_POST['id'] ?? 0)]);
  } catch (PDOException $e) {}
  header('Location: ' . BASE . '/admin/flights.php');
  exit;
}

if ($action === 'generate') {
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
  header('Location: ' . BASE . '/admin/flights.php');
  exit;
}

$origin = strtoupper(substr(trim($_POST['origin'] ?? ''), 0, 3));
$dest = strtoupper(substr(trim($_POST['dest'] ?? ''), 0, 3));
$departAt = str_replace('T', ' ', trim($_POST['depart_at'] ?? ''));
$dur = max(15, (int)($_POST['duration_min'] ?? 60));
$airline = trim($_POST['airline'] ?? '');
$flightNo = strtoupper(trim($_POST['flight_no'] ?? ''));
$price = max(0, (float)($_POST['price'] ?? 0));
$seats = max(1, (int)($_POST['seats'] ?? 150));

if (strlen($origin) === 3 && strlen($dest) === 3 && $departAt && $airline && $flightNo) {
  if (strlen($departAt) === 16) $departAt .= ':00';
  $pdo->prepare('INSERT IGNORE INTO flights(origin,dest,depart_at,duration_min,airline,flight_no,price,seats) VALUES(?,?,?,?,?,?,?,?)')
      ->execute([$origin, $dest, $departAt, $dur, $airline, $flightNo, $price, $seats]);
}

header('Location: ' . BASE . '/admin/flights.php');
