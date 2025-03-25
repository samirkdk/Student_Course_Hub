<?php
session_start();
require_once __DIR__ . "/../config/Database.php";

if (!isset($_GET['module_id'])) {
    header("Location: dashboard.php");
    exit;
}

$module_id = (int) $_GET['module_id'];

// Fetch available staff
$stmt = $pdo->query("SELECT * FROM staff");
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['staff_id'];

    // Check if staff is already assigned to this module
    $stmt_check = $pdo->prepare("SELECT * FROM module_staff WHERE module_id = ? AND staff_id = ?");
    $stmt_check->execute([$module_id, $staff_id]);
    
    if ($stmt_check->rowCount() > 0) {
        $error = "This teacher is already assigned to this module!";
    } else {
        $stmt = $pdo->prepare("INSERT INTO module_staff (module_id, staff_id) VALUES (?, ?)");
        $stmt->execute([$module_id, $staff_id]);
        header("Location: manage_modules.php?program_id=" . $_GET['program_id']);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Assign Staff</title>
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
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Assign Staff to Module</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="POST">
        <label>Choose Staff:
            <select name="staff_id">
                <?php foreach ($staff as $s): ?>
                    <option value="<?= $s['id']; ?>"><?= htmlspecialchars($s['name']); ?></option>
                <?php endforeach; ?>
            </select>
        </label><br>
        <button type="submit">Assign</button>
    </form>
</body>
</html>