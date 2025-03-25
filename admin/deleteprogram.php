<?php
// Database connection
require_once __DIR__ . '/../database/db.php'; // Include DB connection

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if ID is provided
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Program ID");
}

$programId = $_GET['id'];

// Handle deletion
if (isset($_POST['confirm']) && $_POST['confirm'] == 'yes') {
    $sql = "DELETE FROM Programmes WHERE ProgrammeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $programId);
    
    if ($stmt->execute()) {
        echo "<p>Program deleted successfully!</p>";
        echo '<a href="dashboard.php">Back to Dashboard</a>';
        exit;
    } else {
        echo "<p>Error deleting program: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch program name for confirmation
$sql = "SELECT ProgrammeName FROM Programmes WHERE ProgrammeID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $programId);
$stmt->execute();
$result = $stmt->get_result();
$program = $result->fetch_assoc();

if (!$program) {
    die("Program not found");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Program</title>
    <link rel="stylesheet" href="assets/css/delete.css">
</head>
<body>
    <h2>Delete Program: <?php echo htmlspecialchars($program['ProgrammeName']); ?></h2>
    <p>Are you sure you want to delete this program? This action cannot be undone.</p>
    <form method="POST">
        <input type="hidden" name="confirm" value="yes">
        <button type="submit" class="btn-yes">Yes, Delete</button>
        <a href="dashboard.php"><button type="button" class="btn-no">No, Cancel</button></a>
    </form>
</body>
</html>