<?php
require 'db_connect.php';

$staffID = isset($_GET['staff_id']) ? (int)$_GET['staff_id'] : 0;

$sql = "SELECT Name, JobTitle, Photo, Email, Phone, Biography 
        FROM Staff WHERE StaffID = :staff_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['staff_id' => $staffID]);
$staff = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$staff) {
    echo "Error: Staff member with ID $staffID not found.";
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
        .contact-info a:hover, .contact-info a:focus { color: #0056b3; outline: 2px solid #000; outline-offset: 2px; }
        .back-button {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-button:hover, .back-button:focus {
            background-color: #0056b3;
            outline: 2px solid #000;
            outline-offset: 2px;
        }
    </style>
</head>
<body>
    <div class="profile-card">
        <img src="staff_photo/<?php echo htmlspecialchars($staff['Photo'] ?: 'default.jpg'); ?>" alt="Photo of <?php echo htmlspecialchars($staff['Name']); ?>">
        <h2><?php echo htmlspecialchars($staff['Name']); ?></h2>
        <p><strong><?php echo htmlspecialchars($staff['JobTitle']); ?></strong></p>
        <p><strong>Biography:</strong> <?php echo htmlspecialchars($staff['Biography'] ?: 'No biography available.'); ?></p>
        
        <div class="contact-info">
            <p><strong>Email:</strong> <a href="mailto:<?php echo htmlspecialchars($staff['Email']); ?>"><?php echo htmlspecialchars($staff['Email']); ?></a></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($staff['Phone']); ?></p>
        </div>
        
        <a href="staff.php" class="back-button" tabindex="0">Back to Staff List</a>
    </div>
</body>
</html>
