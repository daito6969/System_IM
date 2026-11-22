<?php
// One shared PDO connection. XAMPP defaults: user root, empty password.
$pdo = new PDO('mysql:host=localhost;port=3307;dbname=roadtrip_db;charset=utf8mb4', 'root', '', [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
]);
