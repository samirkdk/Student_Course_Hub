<?php
require_once __DIR__ . "/../config/Database.php";

// Check if the level is set and filter programs accordingly
$level = isset($_GET['level']) ? $_GET['level'] : '';

// Modify SQL query to filter by level if selected
$query = "SELECT * FROM programs WHERE published = 1";
if ($level) {
    $query .= " AND level = :level";
}

$stmt = $pdo->prepare($query);

if ($level) {
    $stmt->bindParam(':level', $level, PDO::PARAM_STR);
}

$stmt->execute();
$programs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Course Hub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Student Course Hub</h1>

    <h2>Available Programs</h2>

    <!-- Program Level Filter -->
    <form method="get" action="">
        <label for="level">Filter by Level:</label>
        <select name="level" id="level">
            <option value="">--Select Level--</option>
            <option value="Undergraduate" <?= ($level == 'Undergraduate') ? 'selected' : ''; ?>>Undergraduate</option>
            <option value="Postgraduate" <?= ($level == 'Postgraduate') ? 'selected' : ''; ?>>Postgraduate</option>
        </select>
        <button type="submit">Filter</button>
    </form>

    <ul>
        <?php foreach ($programs as $program) : ?>
            <li>
                <h3><?= htmlspecialchars($program['title']); ?></h3>
                <p><?= htmlspecialchars($program['description']); ?></p>
                <a href="program.php?id=<?= $program['id']; ?>">View Details</a> |
                <a href="register.php?program_id=<?= $program['id']; ?>">Register Interest</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h2>Portal Access</h2>
    <ul>
        <li><a href="../admin/login.php">Admin Login</a></li>
        <li><a href="../staff/login.php">Staff Login</a></li>
        <li><a href="../student/login.php">Student Login</a></li> 
    </ul>
</body>
</html>