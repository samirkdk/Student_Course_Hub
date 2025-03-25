<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION['student'])) {
    header("Location: login.php");
    exit;
}

$student_id = $_SESSION['student'];

// Fetch registered modules
$stmt = $pdo->prepare("
    SELECT modules.id, modules.title, programs.title AS program, programs.id AS program_id
    FROM interests
    JOIN modules ON interests.program_id = modules.program_id
    JOIN programs ON modules.program_id = programs.id
    WHERE interests.student_id = ?
");
$stmt->execute([$student_id]);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Group modules by program
$groupedModules = [];
foreach ($modules as $module) {
    $groupedModules[$module['program']]['program_id'] = $module['program_id'];
    $groupedModules[$module['program']]['modules'][] = $module;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h2,
        h3 {
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ccc;
        }

        th,
        td {
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
            color: #007BFF;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        .logout {
            margin-top: 10px;
            display: inline-block;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .logout:hover {
            background-color: #c82333;
        }

        .remove-program {
            margin-top: 10px;
            display: inline-block;
            padding: 5px 10px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .remove-program:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>
    <h2>Welcome, Student</h2>
    <a href="logout.php" class="logout">Logout</a>

    <h3>Your Registered Modules</h3>
    <?php foreach ($groupedModules as $program => $data): ?>
        <h4><?= htmlspecialchars($program); ?></h4>
        <table>
            <tr>
                <th>Module</th>
            </tr>
            <?php foreach ($data['modules'] as $module): ?>
                <tr>
                    <td><?= htmlspecialchars($module['title']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="remove_module.php?module_id=<?= $data['program_id']; ?>" class="remove-program" onclick="return confirm('Are you sure you want to remove this program and all its modules?')">Remove Program</a>
    <?php endforeach; ?>
</body>

</html>