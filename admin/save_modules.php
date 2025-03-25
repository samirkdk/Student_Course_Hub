<?php


require_once __DIR__ . '/../database/db.php'; // Include DB connection
include'module.php';




if ($_SERVER["REQUEST_METHOD"] == "POST") {

 $module_Name = $_POST['module'];
 $moduleLeader = $_POST['staff'];
 $description = $_POST['description'];
 


 $sql = "INSERT INTO modules (ModuleName, ModuleLeaderId,Description ) VALUES 
 ('$module_Name', '$moduleLeader','$description')";

 if($conn->query($sql)===True){
    header("Location: module.php");
 }


}






?>