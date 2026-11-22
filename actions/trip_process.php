<?php require '../includes/auth.php'; require_role(['traveler']);
if (($_POST['action'] ?? '') === 'delete') { $pdo->prepare('DELETE FROM trips WHERE id=? AND user_id=?')->execute([(int)$_POST['id'], user()['id']]); exit; }
$pdo->prepare('INSERT INTO trips(user_id,title,destination,budget,start_date,end_date) VALUES(?,?,?,?,?,?)')
    ->execute([user()['id'], trim($_POST['title']), trim($_POST['destination'] ?? ''), (float)($_POST['budget'] ?? 0), $_POST['start_date'] ?: null, $_POST['end_date'] ?: null]);
header('Location: ' . BASE . '/traveler/my_trips.php');
