<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

// Ensure only admins can access
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch student interests
$stmt = $pdo->query("
    SELECT users.name, users.email, programs.title 
    FROM interests 
    JOIN users ON interests.student_id = users.id
    JOIN programs ON interests.program_id = programs.id
");

$interests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Interest List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h2 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <h2>Registered Students</h2>
    <table>
        <tr><th>Name</th><th>Email</th><th>Program</th></tr>
        <?php foreach ($interests as $interest): ?>
            <tr>
                <td><?= htmlspecialchars($interest['name']); ?></td>
                <td><?= htmlspecialchars($interest['email']); ?></td>
                <td><?= htmlspecialchars($interest['title']); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html></table>
