<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    
    // Get program_id before deleting
    $stmt = $pdo->prepare("SELECT program_id FROM modules WHERE id = ?");
    $stmt->execute([$id]);
    $module = $stmt->fetch(PDO::FETCH_ASSOC);
    
    $stmt = $pdo->prepare("DELETE FROM modules WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: manage_modules.php?program_id=" . $module['program_id']);
    exit;
}
?>
