<?php

$servername = 'localhost:3388';
$username = 'root';
$password = '';
$dbname = 'student_course_hub';


// Create connection
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
//echo "Connected successfully";
?>