<?php
session_start();
require_once __DIR__ . "/../config/database.php";

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$id]);
$program = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $level = $_POST['level'];

    $stmt = $pdo->prepare("UPDATE programs SET title=?, description=?, level=? WHERE id=?");
    $stmt->execute([$title, $description, $level, $id]);

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Program</title>
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
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h2>Edit Program</h2>
    <form method="POST">
        <label>Title: <input type="text" name="title" value="<?= htmlspecialchars($program['title']); ?>" required></label>
        <label>Description: <textarea name="description"><?= htmlspecialchars($program['description']); ?></textarea></label>
        <label>Level:
            <select name="level">
                <option value="Undergraduate" <?= ($program['level'] == 'Undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
                <option value="Postgraduate" <?= ($program['level'] == 'Postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
            </select>
        </label>
        <button type="submit">Update</button>
    </form>
</body>
</html>
