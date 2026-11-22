<?php require '../includes/auth.php'; require_role(['traveler']);
if (($_POST['action'] ?? '') === 'delete') { $pdo->prepare('DELETE i FROM itineraries i JOIN trips t ON t.id=i.trip_id WHERE i.id=? AND t.user_id=?')->execute([(int)$_POST['id'], user()['id']]); exit; }
$tid = (int)$_POST['trip_id'];
$own = $pdo->prepare('SELECT id FROM trips WHERE id=? AND user_id=?'); $own->execute([$tid, user()['id']]);   // only your own trips
if ($own->fetch()) $pdo->prepare('INSERT INTO itineraries(trip_id,day_no,activity) VALUES(?,?,?)')->execute([$tid, max(1, (int)$_POST['day_no']), trim($_POST['activity'])]);
header('Location: ' . BASE . '/traveler/itinerary.php?trip=' . $tid);
