<?php
require_once __DIR__ .'/../database/db.php'; // Include database connection

$query = "SELECT * FROM modules";
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
    
        <h3><?php echo $row['ModuleName']; ?></h3>
        
    </div>
    <hr>
<?php } ?>

</body>
</html>