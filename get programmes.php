<?php
require 'config.php';

$sql = "SELECT * FROM programmes WHERE published = 1";
$result = $conn->query($sql);

$programmes = [];
while ($row = $result->fetch_assoc()) {
    $programmes[] = $row;
}

echo json_encode($programmes);
?>