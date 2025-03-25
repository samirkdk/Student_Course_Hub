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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $programName = $_POST['program_name'];
    $levelId = $_POST['level_id'];
    $description = $_POST['description'];

    $sql = "UPDATE Programmes SET ProgrammeName = ?, LevelID = ?, Description = ? WHERE ProgrammeID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $programName, $levelId, $description, $programId);
    
    if ($stmt->execute()) {
        echo "<p>Program updated successfully!</p>";
    } else {
        echo "<p>Error updating program: " . $conn->error . "</p>";
    }
    $stmt->close();
}

// Fetch current program data
$sql = "SELECT p.ProgrammeID, p.ProgrammeName, p.LevelID, p.Description, l.LevelName 
        FROM Programmes p 
        JOIN Levels l ON p.LevelID = l.LevelID 
        WHERE p.ProgrammeID = ?";
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
    <title>Edit Program</title>
    <style>
       
    </style>
    <link rel="stylesheet" href="assets/css/edit.css">
</head>
<body>
    <h2>Edit Program: <?php echo htmlspecialchars($program['ProgrammeName']); ?></h2>
    <form method="POST">
        <div class="form-group">
            <label for="program_name">Program Name</label>
            <input type="text" id="program_name" name="program_name" value="<?php echo htmlspecialchars($program['ProgrammeName']); ?>" required>
        </div>
        <div class="form-group">
            <label for="level_id">Level</label>
            <select id="level_id" name="level_id" required>
                <option value="1" <?php echo $program['LevelID'] == 1 ? 'selected' : ''; ?>>Undergraduate</option>
                <option value="2" <?php echo $program['LevelID'] == 2 ? 'selected' : ''; ?>>Postgraduate</option>
            </select>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($program['Description']); ?></textarea>
        </div>
        <button type="submit">Update Program</button>
    </form>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>