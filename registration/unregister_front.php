<?php
require 'db_connect.php';

// Fetch all programmes for the dropdown
$stmt = $pdo->query("SELECT ProgrammeID, ProgrammeName FROM Programmes");
$programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the programme_id from the query parameter, if provided
$selected_programme_id = isset($_GET['programme_id']) ? (int)$_GET['programme_id'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unregister Interest - Student Course Hub</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        header {
            background-color: #003087;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        nav {
            background-color: #005bb5;
            padding: 10px;
            text-align: center;
        }

        nav a {
            color: white;
            margin: 0 15px;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 0 20px;
        }

        form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        select, input[type="email"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            background-color: #dc3545;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #c82333;
        }

        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Unregister Interest</h1>
    </header>

    <nav>
        
        <a href="../Courses/courses_front.php">View Courses</a>
        <a href="register_front.php">Register Interest</a>
       
    </nav>

    <div class="container">
        <form action="unregister.php" method="POST">
            <label for="programme">Select Programme:</label>
            <select name="programme_id" id="programme" required>
                <option value="">-- Select a Programme --</option>
                <?php foreach ($programmes as $prog): ?>
                    <option value="<?php echo $prog['ProgrammeID']; ?>" 
                            <?php echo $selected_programme_id == $prog['ProgrammeID'] ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($prog['ProgrammeName']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

        

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <button type="submit">Unregister</button>
        </form>
    </div>
</body>
</html>