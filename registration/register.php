<?php
require 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $programme_id = (int)$_POST['programme_id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);

    // Debugging: Log the values
    error_log("Name: $name, Email: $email, ProgrammeID: $programme_id");

    try {
        // Check if the email is already registered for this programme
        $stmt = $pdo->prepare("SELECT * FROM InterestedStudents WHERE Email = ? AND ProgrammeID = ?");
        $stmt->execute([$email, $programme_id]);
        $existing = $stmt->fetch();

        if ($existing) {
            if ($existing['active']) {
                echo "You are already registered for this programme.";
                exit;
            } else {
                // Reactivate the existing record
                $stmt = $pdo->prepare("UPDATE InterestedStudents SET active = TRUE WHERE Email = ? AND ProgrammeID = ?");
                $stmt->execute([$email, $programme_id]);
                echo "Your registration has been reactivated.";
                exit;
            }
        }

        // Insert new registration
        $stmt = $pdo->prepare("INSERT INTO InterestedStudents (StudentName, Email, ProgrammeID, active) VALUES (?, ?, ?, TRUE)");
        $stmt->execute([$name, $email, $programme_id]);
        echo "Registration successful!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>