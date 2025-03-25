<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $programme_id = $_POST['programme_id'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    try {
        $stmt = $pdo->prepare("UPDATE InterestedStudents SET active = FALSE WHERE Email = :email AND ProgrammeID = :programme_id");
        $stmt->execute(['email' => $email, 'programme_id' => $programme_id]);

        if ($stmt->rowCount() > 0) {
            echo "You have successfully unregistered from this programme.";
        } else {
            echo "No registration found for this email and programme.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>