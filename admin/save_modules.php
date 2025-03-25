<?php


require_once __DIR__ . '/../database/db.php'; // Include DB connection
include'module.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {

 $programme_Name = $_POST['programme'];
 $levelID = $_POST['level'];
 $moduleLeader = $_POST['staff'];
 $description = $_POST['description'];
 


 $sql = "INSERT INTO programmes (ProgrammeName, LevelID, ProgrammeLeaderId,Description ) VALUES 
 ('$programme_Name', '$levelID', '$moduleLeader','$description')";

 if($conn->query($sql)===True){
    header("Location: programme.php");
 }


}






?>