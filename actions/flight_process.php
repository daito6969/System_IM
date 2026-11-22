<?php require '../includes/auth.php'; require_role(['admin']);
if (($_POST['action'] ?? '') === 'generate') {          // fills the next 30 days with sample flights
  $routes = [['MNL','CEB',570],['MNL','DVO',950],['MNL','KLO',300],['MNL','PPS',590],['MNL','ILO',470],['MNL','CGY',800],['CEB','DVO',520]];
  $air = [['PR','Philippine Airlines',1.35],['5J','Cebu Pacific',1],['Z2','AirAsia Philippines',.93],['2P','PAL Express',1.12]];
  $slots = [[6,0],[9,30],[13,15],[18,0]];
  $ins = $pdo->prepare('INSERT IGNORE INTO flights(origin,dest,depart_at,duration_min,airline,flight_no,price) VALUES(?,?,?,?,?,?,?)');
  $pdo->beginTransaction();
  foreach ($routes as $ri => [$a, $b, $km]) foreach ([[$a,$b],[$b,$a]] as [$o, $d]) for ($day = 1; $day <= 30; $day++) foreach ($slots as $si => [$h, $m]) {
    [$code, $name, $f] = $air[($day + $si + $ri) % 4];
    $when = (new DateTime("+$day day"))->setTime($h, $m);
    $ins->execute([$o, $d, $when->format('Y-m-d H:i:s'), round((35 + $km / 12.5) / 5) * 5, $name, $code . (100 + $ri * 11 + $si * 7), round((900 + $km * 2.4) * $f / 10) * 10]);
  }
  $pdo->commit();
} else {
  $pdo->prepare('INSERT INTO flights(origin,dest,depart_at,duration_min,airline,flight_no,price,seats) VALUES(?,?,?,?,?,?,?,?)')
      ->execute([strtoupper($_POST['origin']), strtoupper($_POST['dest']), $_POST['depart_at'], (int)$_POST['duration_min'], trim($_POST['airline']), trim($_POST['flight_no']), (float)$_POST['price'], (int)$_POST['seats']]);
}
header('Location: ' . BASE . '/admin/flights.php');
