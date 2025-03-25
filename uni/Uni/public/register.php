<?php
require_once __DIR__ . "/../config/database.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $program_id = $_POST['program_id'];

    // Check if the user exists
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ? AND role = 'student'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify password
        if (password_verify($password, $user['password'])) {
            $student_id = $user['id'];

            // Check if already registered for this program
            $stmt = $pdo->prepare("SELECT * FROM interests WHERE student_id = ? AND program_id = ?");
            $stmt->execute([$student_id, $program_id]);

            if ($stmt->rowCount() > 0) {
                $message = "You are already registered for this program.";
            } else {
                // Register interest
                $stmt = $pdo->prepare("INSERT INTO interests (student_id, program_id) VALUES (?, ?)");
                $stmt->execute([$student_id, $program_id]);
                $message = "Successfully registered interest!";
            }
        } else {
            $message = "Incorrect password. Please try again.";
        }
    } else {
        $message = "No account found with this email.";
    }
}

if (!isset($_GET['program_id'])) {
    die("Program not found!");
}

$program_id = (int) $_GET['program_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register Interest</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            height: 100vh;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }
        input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        p {
            text-align: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <h1>Register Interest</h1>

        <?php if (!empty($message)) : ?>
            <p style="color: <?= ($message === 'Successfully registered interest!') ? 'green' : 'red'; ?>;">
                <?= htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="program_id" value="<?= $program_id; ?>">
            <label>Email: <input type="email" name="email" required></label>
            <label>Password: <input type="password" name="password" required></label>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
