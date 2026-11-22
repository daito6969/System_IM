<?php require '../includes/auth.php'; header('Content-Type: application/json'); require_role(['traveler']);
$s = $pdo->prepare('SELECT id,origin,dest,DATE(depart_at) AS d,HOUR(depart_at)*60+MINUTE(depart_at) AS dep,duration_min,airline,flight_no,price,seats
                    FROM flights WHERE origin=? AND dest=? AND DATE(depart_at)=? AND seats>0 AND depart_at>NOW() ORDER BY depart_at');
$s->execute([$_GET['o'] ?? '', $_GET['d'] ?? '', $_GET['date'] ?? '']);
echo json_encode(array_map(fn($f) => ['id' => (string)$f['id'], 'o' => $f['origin'], 'd' => $f['dest'], 'date' => $f['d'], 'dep' => (int)$f['dep'],
  'dur' => (int)$f['duration_min'], 'airline' => $f['airline'], 'no' => $f['flight_no'], 'price' => (float)$f['price'], 'seats' => (int)$f['seats']], $s->fetchAll()));
