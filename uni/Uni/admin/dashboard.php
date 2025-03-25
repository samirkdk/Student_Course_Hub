<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

// Fetch programs
$stmt = $pdo->query("SELECT * FROM programs");
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h2, h3 {
            color: #333;
        }
        a {
            text-decoration: none;
            color: #007BFF;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions a {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <h2>Admin Dashboard</h2>
    <a href="logout.php">Logout</a>
    <h3>Manage Programs</h3>
    <a href="add_program.php">Add New Program</a>
    <table>
        <tr><th>Title</th><th>Level</th><th>Actions</th></tr>
        <?php foreach ($programs as $p): ?>
            <tr>
                <td><?= htmlspecialchars($p['title']); ?></td>
                <td><?= htmlspecialchars($p['level']); ?></td>
                <td class="actions">
                    <a href="edit_program.php?id=<?= $p['id']; ?>">Edit</a>
                    <a href="delete_program.php?id=<?= $p['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="manage_modules.php?program_id=<?= $p['id']; ?>">Manage Modules</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h3>Student Interest</h3>
    <a href="view_interest.php">View Student Interest</a>

    <h3>Register Teacher</h3>
    <a href="register_teacher.php">Register Teacher</a>
</body>
</html></tr></table>
