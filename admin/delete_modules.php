<?php
// Database connection
require_once __DIR__ . '/../database/db.php'; // Include DB connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Module ID");
}

$moduleId = $_GET['id'];

// Handle deletion
if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
    $sql = "DELETE FROM Modules WHERE ModuleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $moduleId);
    
    if ($stmt->execute()) {
        echo "<p>Module deleted successfully!</p>";
        echo '<a href="dashboard.php">Back to Dashboard</a>';
        exit;
    } else {
        echo "<p>Error deleting module: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch module name for confirmation
$sql = "SELECT ModuleName FROM Modules WHERE ModuleID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $moduleId);
$stmt->execute();
$result = $stmt->get_result();
$module = $result->fetch_assoc();

if (!$module) {
    die("Module not found");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Module</title>
    
    <link rel="stylesheet" href="assets/css/delete.css">
</head>
<body>
    <h2>Delete Module: <?php echo htmlspecialchars($module['ModuleName']); ?></h2>
    <p>Are you sure you want to delete this module? This action cannot be undone.</p>
    <form method="POST">
        <input type="hidden" name="confirm" value="yes">
        <button type="submit" class="btn-yes">Yes, Delete</button>
        <a href="dashboard.php"><button type="button" class="btn-no">No, Cancel</button></a>
    </form>
</body>
</html>