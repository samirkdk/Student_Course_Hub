<?php 
require_once __DIR__ . '/../database/db.php'; // Include DB connection

// SQL query to fetch all programmes
$programme_sql = "SELECT ProgrammeID, ProgrammeName FROM programmes";
$programme_result = $conn->query($programme_sql);

if (!$programme_result) {
    die("Query failed: " . $conn->error);
}

// SQL query to fetch all staff members
$staff_sql = "SELECT StaffID, Name FROM staff";
$staff_result = $conn->query($staff_sql);

if (!$staff_result) { // Fixed typo: was checking $programme_result again
    die("Query failed: " . $conn->error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Module Form</title>
    <link rel="stylesheet" href="assets/css/addmod.css">
</head>
<body>
    <div class="form-container">
        <h2>Add New Modules</h2>
        <form action="save_modules.php" method="post">
            <div class="form-group">
                <label for="module">Module Name:</label>
                <input type="text" id="module" name="module" required>
            </div>

           

            <div class="form-group">
                <label for="staff">Module Leader:</label> <!-- Adjusted label text -->
                <select name="staff" id="staff" required>
                    <option value="">Select a leader</option>
                    <?php 
                    if ($staff_result->num_rows > 0) {
                        while ($row = $staff_result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row["StaffID"]) . '">' . htmlspecialchars($row["Name"]) . '</option>';
                        }
                    } else {
                        echo '<option value="">No leaders available</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Module Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>


            <div class="form-group">
                <input type="submit" value="Add Module">
            </div>
        </form>
    </div>
</body>
</html>