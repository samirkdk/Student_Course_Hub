<?php 
require_once __DIR__ . '/../database/db.php'; // Include DB connection

// SQL query to fetch all staff members
$sql = "SELECT StaffID, Name FROM Staff";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error); // Check for query error
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Programme Form</title>
    <link rel="stylesheet" href="assets/css/addpro.css">
</head>
<body>
    
    <div class="form-container">
        <h2>Add New Programme</h2>
        <form action="save_programmes.php" method="post">
            <div class="form-group">
                <label for="programme">Programme Name:</label>
                <input type="text" id="programme" name="programme" required>
            </div>

            <div class="form-group">
                <label for="level">Programme Level:</label>
                <select id="level" name="level" required>
                    <option value="">Select a level</option>
                    <option value="1">Undergraduate</option>
                    <option value="2">Postgraduate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="staff">Programme Leader:</label>
                <select name="staff" id="staff" required>
                    <option value="">Select a leader</option>
                    <?php 
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<option value="' . htmlspecialchars($row["StaffID"]) . '">' . htmlspecialchars($row["Name"]) . '</option>';
                        }
                    } else {
                        echo '<option value="">No leaders available</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Programme Description:</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="form-group">
                <input type="submit" value="Add Programme">
            </div>
        </form>
    </div>

</body>
</html>
