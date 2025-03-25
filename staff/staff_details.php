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

// Get staff ID from URL
$staffID = isset($_GET['staff_id']) ? (int) $_GET['staff_id'] : 0;

$sql = "SELECT Name, JobTitle, Photo, Email, Phone, Biography 
        FROM Staff WHERE StaffID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $staffID);
$stmt->execute();
$result = $stmt->get_result();
$staff = $result->fetch_assoc();

// If staff ID is invalid, redirect back to staff list
if (!$staff) {
    header("Location: staff.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($staff['Name']); ?> - Staff Profile</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin: 20px; background-color: #f4f4f4; }
        .profile-card { 
            max-width: 500px; 
            margin: auto; 
            padding: 20px; 
            border: 1px solid #ddd; 
            border-radius: 10px; 
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-card img { 
            width: 150px; 
            height: 150px; 
            border-radius: 50%; 
            object-fit: cover; 
            margin-bottom: 15px; 
            border: 4px solid #ddd;
        }
        h2 { color: #333; margin-bottom: 5px; }
        p { color: #555; margin: 5px 0; }
        .contact-info a { color: #007bff; text-decoration: none; font-weight: bold; }
        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="profile-card">
        <img src="staff_photo/<?php echo htmlspecialchars($staff['Photo']); ?>" alt="<?php echo htmlspecialchars($staff['Name']); ?>">
        <h2><?php echo htmlspecialchars($staff['Name']); ?></h2>
        <p><strong><?php echo htmlspecialchars($staff['JobTitle']); ?></strong></p>
        <p><strong>Biography:</strong> <?php echo htmlspecialchars($staff['Biography'] ?: 'No biography available.'); ?></p>
        
        <div class="contact-info">
            <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($staff['Email']); ?>"><?php echo htmlspecialchars($staff['Email']); ?></a></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($staff['Phone']); ?></p>
        </div>
        
        <a href="../staff/staff.php" class="back-button">Back to Staff List</a>
    </div>

</body>
</html>
