<?php
session_start();
require_once __DIR__ . '/../config/database.php';

if (!defined('BASE')) {
  $uri = $_SERVER['REQUEST_URI'] ?? '';
  if (strpos($uri, '/roadtrip_project_structure/roadtrip') !== false) {
    define('BASE', '/roadtrip_project_structure/roadtrip');
  } else {
    $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
    $subfolders = ['/actions', '/admin', '/api', '/traveler', '/staff', '/includes', '/html'];
    $base = $scriptDir;
    foreach ($subfolders as $sub) {
      if (substr($base, -strlen($sub)) === $sub) {
        $base = substr($base, 0, -strlen($sub));
        break;
      }
    }
    define('BASE', $base ? rtrim($base, '/') : '');
  }
}

function user() { return $_SESSION['user'] ?? null; }
function e($s) { return htmlspecialchars((string)$s, ENT_QUOTES); }
function require_role(array $roles) {
  if (!user() || !in_array(user()['role'], $roles)) { header('Location: ' . BASE . '/login.php'); exit; }
}
function home_for($role) { return BASE . '/' . $role . '/dashboard.php'; }
