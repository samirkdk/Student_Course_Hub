<?php
require 'config.php';
$id = intval($_GET['id']);

$sql = "SELECT * FROM programmes WHERE id = $id";
$programme = $conn->query($sql)->fetch_assoc();

$sql = "SELECT * FROM modules WHERE programme_id = $id";
$modules = $conn->query($sql);

$sql = "SELECT * FROM staff WHERE id IN (SELECT staff_id FROM staff_programme WHERE programme_id = $id)";
$staff = $conn->query($sql);
?>
<html>
<head><title><?php echo $programme['name']; ?></title></head>
<body>
    <h1><?php echo $programme['name']; ?></h1>
    <p><?php echo $programme['description']; ?></p>
    <h2>Modules</h2>
    <ul>
        <?php while ($module = $modules->fetch_assoc()) { echo "<li>{$module['name']}</li>"; } ?>
    </ul>
    <h2>Staff</h2>
    <ul>
        <?php while ($member = $staff->fetch_assoc()) { echo "<li>{$member['name']} - {$member['title']}</li>"; } ?>
    </ul>
    <a href="register-interest.php?programme_id=<?php echo $id; ?>">Register Interest</a>
</body>
</html>