<?php require '../includes/auth.php'; require_role(['traveler']);
if (($_POST['action'] ?? '') === 'delete') { $pdo->prepare('DELETE e FROM expenses e JOIN trips t ON t.id=e.trip_id WHERE e.id=? AND t.user_id=?')->execute([(int)$_POST['id'], user()['id']]); exit; }
$tid = (int)$_POST['trip_id'];
$own = $pdo->prepare('SELECT id FROM trips WHERE id=? AND user_id=?'); $own->execute([$tid, user()['id']]);
if ($own->fetch()) $pdo->prepare('INSERT INTO expenses(trip_id,category,amount,note) VALUES(?,?,?,?)')->execute([$tid, trim($_POST['category']), (float)$_POST['amount'], trim($_POST['note'])]);
header('Location: ' . BASE . '/traveler/expenses.php?trip=' . $tid);
