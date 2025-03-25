<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (!isset($_GET['program_id'])) {
    header("Location: dashboard.php");
    exit;
}

$program_id = (int) $_GET['program_id'];

// Fetch modules
$stmt = $pdo->prepare("SELECT * FROM modules WHERE program_id = ?");
$stmt->execute([$program_id]);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Manage Modules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }

        h2 {
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
            background-color: #fff;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            margin-bottom: 5px;
        }

        .actions a {
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h2>Manage Modules</h2>
    <a href="add_module.php?program_id=<?= $program_id; ?>">Add New Module</a>
    <table>
        <tr>
            <th>Title</th>
            <th>Year</th>
            <th>Actions</th>
            <th>Assigned Staff</th>
        </tr>
        <?php foreach ($modules as $module): ?>
            <tr>
                <td><?= htmlspecialchars($module['title']); ?></td>
                <td><?= $module['year']; ?></td>
                <td class="actions">
                    <a href="edit_module.php?id=<?= $module['id']; ?>">Edit</a>
                    <a href="delete_module.php?id=<?= $module['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    <a href="assign_staff.php?module_id=<?= $module['id']; ?>&program_id=<?= $program_id; ?>">Assign Staff</a>
                </td>
                <td>
                    <?php
                    $stmt_staff = $pdo->prepare("SELECT staff.id, staff.name FROM module_staff JOIN staff ON module_staff.staff_id = staff.id WHERE module_staff.module_id = ?");
                    $stmt_staff->execute([$module['id']]);
                    $assigned_staff = $stmt_staff->fetchAll(PDO::FETCH_ASSOC);

                    if ($assigned_staff) {
                        echo "<strong>Assigned Staff:</strong><ul>";
                        foreach ($assigned_staff as $staff) {
                            echo "<li>" . htmlspecialchars($staff['name']) . " 
                            <a href='remove_staff.php?module_id=" . $module['id'] . "&staff_id=" . $staff['id'] . "&program_id=" . $program_id . "'>Remove</a></li>";
                        }
                        echo "</ul>";
                    } else {
                        echo "No staff assigned";
                    }
                    ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>

</html>