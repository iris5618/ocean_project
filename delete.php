<?php
include 'db.php';
if (!isset($_SESSION['user'])) header("Location: login.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM sensors WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>