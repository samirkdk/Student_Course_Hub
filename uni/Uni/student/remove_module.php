<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION['student']) || !isset($_GET['module_id'])) {
    header("Location: dashboard.php");
    exit;
}

$student_id = $_SESSION['student'];
$module_id = (int) $_GET['module_id'];

// Remove the student’s interest
$stmt = $pdo->prepare("DELETE FROM interests WHERE student_id = ? AND program_id = (SELECT program_id FROM modules WHERE id = ?)");
$stmt->execute([$student_id, $module_id]);

header("Location: dashboard.php");
exit;
?>
