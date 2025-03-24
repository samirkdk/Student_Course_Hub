<?php
include 'db.php'; // Include database connection

// Fetch staff data
$query = "SELECT StaffID, Name FROM staff";
$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic User Data</title>
</head>
<body>

<h2>User Information</h2>

<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) { ?>
        <div>
            <h3>ID: <?php echo htmlspecialchars($row['StaffID']); ?></h3>
            <h3>Name: <?php echo htmlspecialchars($row['Name']); ?></h3>
        </div>
        <hr>
    <?php } 
} else {
    echo "<p>No staff found.</p>";
}

// Close database connection
$conn->close();
?>

</body>
</html>
