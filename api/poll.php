<?php require '../includes/auth.php'; header('Content-Type: application/json');
$u = user(); if (!$u) { http_response_code(401); exit('{}'); }
$isT = $u['role'] === 'traveler'; $uid = $isT ? $u['id'] : null;   // null = see everything (staff/admin)
$trip = (int)($_GET['trip'] ?? 0); $t = $_GET['t'] ?? '';
if ($isT && in_array($t, ['flights', 'report', 'flight_report', 'users'])) { http_response_code(403); exit('{}'); }
if ($t === 'users' && $u['role'] !== 'admin') { http_response_code(403); exit('{}'); }
function run($sql, $p = []) { global $pdo; $s = $pdo->prepare($sql); $s->execute($p); return $s->fetchAll(); }
$leg = "CONCAT(%s.origin,' → ',%s.dest,' · ',DATE_FORMAT(%s.depart_at,'%%b %%e %%H:%%i'),' · ',%s.flight_no)";
switch ($t) {
  case 'destinations': $rows = run('SELECT id,name,region,price FROM destinations ORDER BY id DESC'); break;
  case 'bookings': $rows = run('SELECT b.id,u.name AS traveler,d.name AS destination,b.travel_date,b.pax,b.total,b.status FROM bookings b JOIN users u ON u.id=b.user_id JOIN destinations d ON d.id=b.destination_id WHERE (? IS NULL OR b.user_id=?) ORDER BY b.id DESC', [$uid, $uid]); break;
  case 'flight_bookings': $rows = run('SELECT fb.id,fb.ref,u.name AS traveler,' . sprintf($leg, 'f', 'f', 'f', 'f') . ' AS outbound,IFNULL(' . sprintf($leg, 'r', 'r', 'r', 'r') . ',\'\') AS inbound,fb.pax,fb.total,fb.status,IFNULL(fb.contact_phone,"") AS contact_phone,IFNULL(fb.contact_email,"") AS contact_email,IFNULL(fb.kyc_id_type,"") AS kyc_id_type,IFNULL(fb.kyc_id_number,"") AS kyc_id_number,DATE_FORMAT(fb.created_at, "%Y-%m-%d %H:%i") AS created_at FROM flight_bookings fb JOIN users u ON u.id=fb.user_id JOIN flights f ON f.id=fb.flight_id LEFT JOIN flights r ON r.id=fb.return_flight_id WHERE (? IS NULL OR fb.user_id=?) ORDER BY fb.id DESC', [$uid, $uid]); break;
  case 'trips': $rows = run('SELECT t.id,u.name AS traveler,t.title,IFNULL(t.destination,"N/A") AS destination,IFNULL(t.budget,0) AS budget,IFNULL(t.stay_type,"hotel") AS stay_type,IFNULL(t.stay_cost,0) AS stay_cost,t.start_date,t.end_date FROM trips t JOIN users u ON u.id=t.user_id WHERE (? IS NULL OR t.user_id=?) ORDER BY t.id DESC', [$uid, $uid]); break;
  case 'itineraries': $rows = run('SELECT i.id,i.trip_id,t.title,i.day_no,i.activity FROM itineraries i JOIN trips t ON t.id=i.trip_id WHERE (? IS NULL OR t.user_id=?) AND (?=0 OR i.trip_id=?) ORDER BY i.trip_id,i.day_no', [$uid, $uid, $trip, $trip]); break;
  case 'expenses': $rows = run('SELECT e.id,t.title,e.category,e.amount,e.note FROM expenses e JOIN trips t ON t.id=e.trip_id WHERE (? IS NULL OR t.user_id=?) AND (?=0 OR e.trip_id=?) ORDER BY e.id DESC', [$uid, $uid, $trip, $trip]); break;
  case 'flights': $rows = run("SELECT id,origin,dest,DATE_FORMAT(depart_at,'%Y-%m-%d %H:%i') AS depart_at,airline,flight_no,price,seats FROM flights WHERE depart_at>=NOW() ORDER BY depart_at LIMIT 100"); break;
  case 'users': $rows = run('SELECT id,name,email,role,created_at FROM users ORDER BY id'); break;
  case 'report': $rows = run("SELECT d.name AS destination,COUNT(b.id) AS bookings,COALESCE(SUM(b.total),0) AS revenue FROM destinations d LEFT JOIN bookings b ON b.destination_id=d.id AND b.status<>'cancelled' GROUP BY d.id,d.name"); break;
  case 'flight_report': $rows = run("SELECT CONCAT(f.origin,' → ',f.dest) AS route,COUNT(fb.id) AS bookings,COALESCE(SUM(fb.total),0) AS revenue FROM flight_bookings fb JOIN flights f ON f.id=fb.flight_id WHERE fb.status<>'cancelled' GROUP BY f.origin,f.dest"); break;
  default: http_response_code(400); exit('{}');
}
echo json_encode(['v' => md5(json_encode($rows)), 'rows' => $rows]);
