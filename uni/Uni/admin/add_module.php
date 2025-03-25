<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (!isset($_GET['program_id'])) {
    header("Location: dashboard.php");
    exit;
}

$program_id = (int) $_GET['program_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $year = $_POST['year'];

    $stmt = $pdo->prepare("INSERT INTO modules (program_id, title, year) VALUES (?, ?, ?)");
    $stmt->execute([$program_id, $title, $year]);

    header("Location: manage_modules.php?program_id=$program_id");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Module</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }
        h2 {
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Add Module</h2>
    <form method="POST">
        <input type="hidden" name="program_id" value="<?= $program_id; ?>">
        <label>Module Title: <input type="text" name="title" required></label>
        <label>Year: <input type="number" name="year" required></label>
        <button type="submit">Add Module</button>
    </form>
</body>
</html>
