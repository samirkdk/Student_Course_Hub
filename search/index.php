<?php
// Database connection
$host = "localhost";
$user = "root";  // Change if needed
$pass = "";      // Change if needed
$db = "student_course_hub"; // Ensure this matches your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Default values
$search = "";
$level = "";
$results = [];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search = isset($_POST['searchInput']) ? $_POST['searchInput'] : '';
    $level = isset($_POST['levelFilter']) ? $_POST['levelFilter'] : '';

    // SQL Query with Joins
    $sql = "SELECT 
        Programmes.ProgrammeID, 
        Programmes.ProgrammeName, 
        Programmes.Description, 
        Levels.LevelName, 
        Staff.Name AS ProgrammeLeader, 
        Programmes.ProgrammeLeaderID
    FROM Programmes
    LEFT JOIN Levels ON Programmes.LevelID = Levels.LevelID
    LEFT JOIN Staff ON Programmes.ProgrammeLeaderID = Staff.StaffID
    WHERE Programmes.ProgrammeName LIKE ?";

    if (!empty($level)) {
        $sql .= " AND Levels.LevelName = ?";
    }

    // Prepared Statement (Security)
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$search%";

    if (!empty($level)) {
        $stmt->bind_param("ss", $searchTerm, $level);
    } else {
        $stmt->bind_param("s", $searchTerm);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Programmes</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        input, select, button {
            padding: 10px;
            margin: 5px;
        }
        #results div {
            border: 1px solid #ddd;
            padding: 10px;
            margin: 5px 0;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h2>Search for a Programme</h2>

    <form method="POST" action="index.php">
        <input type="text" name="searchInput" placeholder="Enter programme name..." value="<?php echo htmlspecialchars($search); ?>" />
        <select name="levelFilter">
            <option value="">All Levels</option>
            <option value="Undergraduate" <?php if ($level == "Undergraduate") echo "selected"; ?>>Undergraduate</option>
            <option value="Postgraduate" <?php if ($level == "Postgraduate") echo "selected"; ?>>Postgraduate</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <div id="results">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (empty($results)) {
                echo "<p>No results found</p>";
            } else {
                foreach ($results as $programme) {
                    echo "<div>";
                    echo "<h3>" . htmlspecialchars($programme['ProgrammeName']) . "</h3>";
                    echo "<p>" . htmlspecialchars($programme['Description']) . "</p>";
                    echo "<small><strong>Level:</strong> " . htmlspecialchars($programme['LevelName']) . "</small><br>";

                    // Fix Programme Leader Link
                    if (isset($programme['ProgrammeLeaderID']) && !empty($programme['ProgrammeLeaderID'])) {
                        echo "<small><strong>Programme Leader:</strong> 
                        <a href='../staff/staff_details.php?staff_id=" . htmlspecialchars($programme['ProgrammeLeaderID']) . "'>" . htmlspecialchars($programme['ProgrammeLeader']) . "</a></small>";
                    } else {
                        echo "<small><strong>Programme Leader:</strong> Not Assigned</small>";
                    }

                    echo "</div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>
