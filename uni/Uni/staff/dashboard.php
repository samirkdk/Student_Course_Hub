<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION['staff'])) {
    header("Location: login.php");
    exit;
}

$staff_id = $_SESSION['staff'];

$stmt = $pdo->prepare("
    SELECT modules.title, programs.title AS program 
    FROM module_staff 
    JOIN modules ON module_staff.module_id = modules.id
    JOIN programs ON modules.program_id = programs.id
    WHERE module_staff.staff_id = ?
");
$stmt->execute([$staff_id]);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Staff Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h2, h3 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Welcome, Staff Member</h2>
    <h3>Modules Assigned to You</h3>
    <table>
        <tr><th>Module</th><th>Program</th></tr>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= htmlspecialchars($module['title']); ?></td>
                <td><?= htmlspecialchars($module['program']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="logout.php">Logout</a>
</body>
</html></tr>
