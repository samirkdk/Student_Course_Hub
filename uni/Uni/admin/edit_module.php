<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM modules WHERE id = ?");
$stmt->execute([$id]);
$module = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $year = $_POST['year'];

    $stmt = $pdo->prepare("UPDATE modules SET title=?, year=? WHERE id=?");
    $stmt->execute([$title, $year, $id]);

    header("Location: manage_modules.php?program_id=" . $module['program_id']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Module</title>
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
            border: 1px solid #ccc;
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
    <h2>Edit Module</h2>
    <form method="POST">
        <label>Module Title: <input type="text" name="title" value="<?= htmlspecialchars($module['title']); ?>" required></label>
        <label>Year: <input type="number" name="year" value="<?= $module['year']; ?>" required></label>
        <button type="submit">Update</button>
    </form>
</body>
</html></form>
