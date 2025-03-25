<?php
require_once __DIR__ . "/../config/Database.php";


if (!isset($_GET['id'])) {
    die("Program not found!");
}

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM programs WHERE id = ?");
$stmt->execute([$id]);
$program = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$program) {
    die("Program not found!");
}

$stmt = $pdo->prepare("
    SELECT modules.*, staff.name AS teacher_name
    FROM modules
    LEFT JOIN module_staff ON modules.id = module_staff.module_id
    LEFT JOIN staff ON module_staff.staff_id = staff.id
    WHERE modules.program_id = ?
");
$stmt->execute([$id]);
$modules = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= htmlspecialchars($program['title']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?= htmlspecialchars($program['title']); ?></h1>
    <p><?= htmlspecialchars($program['description']); ?></p>

    <h2>Modules</h2>
    <ul>
    <?php foreach ($modules as $module) : ?>
        <li>
            <?= htmlspecialchars($module['title']); ?> (Year <?= $module['year']; ?>)
            <?php if (!empty($module['teacher_name'])): ?>
                - Taught by <strong><?= htmlspecialchars($module['teacher_name']); ?></strong>
            <?php else: ?>
                - <em>No teacher assigned</em>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>


    <a href="register.php?program_id=<?= $program['id']; ?>">Register Interest</a>
</body>
</html>
