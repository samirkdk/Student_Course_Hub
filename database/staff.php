<?php
include 'db.php'; // Include database connection

$query = "SELECT * FROM staff";
$result = $conn->query($query);
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
while ($row = $result->fetch_assoc()) { ?>
    <div>
    <?php echo '<img src="data:image;base64,'.base64_encode($row['image']).'" alt="image" style="width:100px; height:100px;">'; ?>
        <h3><?php echo $row['Name']; ?></h3>
        <!-- <p>Job Title: <?php echo $row['job_title']; ?></p> -->
    </div>
    <hr>
<?php } ?>

</body>
</html>