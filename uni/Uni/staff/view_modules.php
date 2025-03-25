<?php
require_once __DIR__ . "/../config/Database.php";

if (!isset($_GET['staff_id'])) {
    die("Invalid access!");
}

$staff_id = (int) $_GET['staff_id'];

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
    <title>My Modules</title>
</head>
<body>
    <h2>Modules I Teach</h2>
    <table border="1">
        <tr><th>Module</th><th>Program</th></tr>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= htmlspecialchars($module['title']); ?></td>
                <td><?= htmlspecialchars($module['program']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
