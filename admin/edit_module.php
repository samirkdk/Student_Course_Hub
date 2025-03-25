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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $moduleName = $_POST['module_name'];
    $description = $_POST['description'];

    $sql = "UPDATE Modules SET ModuleName = ?, Description = ? WHERE ModuleID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $moduleName, $description, $moduleId);
    
    if ($stmt->execute()) {
        echo "<p>Module updated successfully!</p>";
    } else {
        echo "<p>Error updating module: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch current module data
$sql = "SELECT ModuleID, ModuleName, Description FROM Modules WHERE ModuleID = ?";
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
    <title>Edit Module</title>
    <style>
    </style>
    <link rel="stylesheet" href="assets/css/editM.css">
</head>
<body>
    <h2>Edit Module: <?php echo htmlspecialchars($module['ModuleName']); ?></h2>
    <form method="POST">
        <div class="form-group">
            <label for="module_name">Module Name</label>
            <input type="text" id="module_name" name="module_name" value="<?php echo htmlspecialchars($module['ModuleName']); ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($module['Description']); ?></textarea>
        </div>
        <button type="submit">Update Module</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>