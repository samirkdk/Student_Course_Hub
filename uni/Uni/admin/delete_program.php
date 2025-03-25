<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM programs WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php");
exit;
?>
