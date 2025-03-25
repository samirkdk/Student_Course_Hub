<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_GET['module_id']) || !isset($_GET['staff_id'])) {
    header("Location: dashboard.php");
    exit;
}

$module_id = (int) $_GET['module_id'];
$staff_id = (int) $_GET['staff_id'];

$stmt = $pdo->prepare("DELETE FROM module_staff WHERE module_id = ? AND staff_id = ?");
$stmt->execute([$module_id, $staff_id]);

header("Location: manage_modules.php?program_id=" . $_GET['program_id']);
exit;
?>
