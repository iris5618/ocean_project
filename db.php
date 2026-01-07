<?php
$host = 'localhost';
$dbname = 'newd_db';
$user = 'root';
$pass = ''; // XAMPP 預設密碼為空

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("連線失敗: " . $e->getMessage());
}
session_start();
?>