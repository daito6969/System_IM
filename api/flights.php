<?php 
require '../includes/auth.php'; 
header('Content-Type: application/json'); 
require_role(['traveler', 'admin', 'staff']);

$origin = strtoupper(trim($_GET['o'] ?? ''));
$dest   = strtoupper(trim($_GET['d'] ?? ''));
$date   = trim($_GET['date'] ?? '');

$s = $pdo->prepare('SELECT id,origin,dest,DATE(depart_at) AS d,HOUR(depart_at)*60+MINUTE(depart_at) AS dep,duration_min,airline,flight_no,price,seats
                    FROM flights WHERE origin=? AND dest=? AND DATE(depart_at)=? AND seats>0 AND depart_at>NOW() ORDER BY depart_at');
$s->execute([$origin, $dest, $date]);

echo json_encode(array_map(fn($f) => [
  'id' => (string)$f['id'], 
  'o' => $f['origin'], 
  'd' => $f['dest'], 
  'date' => $f['d'], 
  'dep' => (int)$f['dep'],
  'dur' => (int)$f['duration_min'], 
  'airline' => $f['airline'], 
  'no' => $f['flight_no'], 
  'price' => (float)$f['price'], 
  'seats' => (int)$f['seats']
], $s->fetchAll()));
