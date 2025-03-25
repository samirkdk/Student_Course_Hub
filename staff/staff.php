<?php
// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "student_course_hub";

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get search & filter inputs
$search = isset($_GET['search']) ? $_GET['search'] : '';
$jobFilter = isset($_GET['jobFilter']) ? $_GET['jobFilter'] : '';

// SQL Query with search & filter
$sql = "SELECT StaffID, Name, JobTitle, Photo, Email, Phone FROM Staff WHERE Name LIKE ?";

if (!empty($jobFilter)) {
    $sql .= " AND JobTitle = ?";
}

// Prepared Statement
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";

if (!empty($jobFilter)) {
    $stmt->bind_param("ss", $searchTerm, $jobFilter);
} else {
    $stmt->bind_param("s", $searchTerm);
}

$stmt->execute();
$result = $stmt->get_result();

$staffMembers = [];
while ($row = $result->fetch_assoc()) {
    $staffMembers[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .staff-container { display: flex; flex-wrap: wrap; gap: 15px; }
        .staff-card { border: 1px solid #ddd; padding: 15px; margin: 10px; width: 280px; background-color: #f9f9f9; border-radius: 8px; text-align: center; }
        .staff-card img { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; }
        .staff-card h3 { margin: 0 0 5px; }
        .staff-card p { margin: 5px 0; }
    </style>
</head>
<body>
    <h2>Meet Our Staff</h2>

    <!-- Search and Filter Form -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by name..." value="<?php echo htmlspecialchars($search); ?>">
        <select name="jobFilter">
            <option value="">All Job Titles</option>
            <option value="Professor" <?php if ($jobFilter == "Professor") echo "selected"; ?>>Professor</option>
            <option value="Senior Lecturer" <?php if ($jobFilter == "Senior Lecturer") echo "selected"; ?>>Senior Lecturer</option>
            <option value="Associate Professor" <?php if ($jobFilter == "Associate Professor") echo "selected"; ?>>Associate Professor</option>
            <option value="Assistant Professor" <?php if ($jobFilter == "Assistant Professor") echo "selected"; ?>>Assistant Professor</option>
        </select>
        <button type="submit">Search</button>
    </form>

    <div class="staff-container">
        <?php foreach ($staffMembers as $staff) { ?>
            <div class="staff-card">
                <img src="staff_photo/<?php echo htmlspecialchars($staff['Photo']); ?>" alt="<?php echo htmlspecialchars($staff['Name']); ?>">
                <h3><?php echo htmlspecialchars($staff['Name']); ?></h3>
                <p><strong><?php echo htmlspecialchars($staff['JobTitle']); ?></strong></p>
                <p>Email: <a href="mailto:<?php echo htmlspecialchars($staff['Email']); ?>"><?php echo htmlspecialchars($staff['Email']); ?></a></p>
                <p>Phone: <?php echo htmlspecialchars($staff['Phone']); ?></p>
                <a href="staff_details.php?staff_id=<?php echo $staff['StaffID']; ?>">View Profile</a>
            </div>
        <?php } ?>
    </div>
</body>
</html>
