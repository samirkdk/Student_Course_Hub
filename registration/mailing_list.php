<?php
require 'db_connect.php'; // Adjusted path since mailing_list.php is in the registration folder

try {
    // Fetch active students with their programme names
    $stmt = $pdo->prepare("
        SELECT i.StudentName, i.Email, p.ProgrammeName 
        FROM InterestedStudents i
        JOIN Programmes p ON i.ProgrammeID = p.ProgrammeID
        WHERE i.active = TRUE
        ORDER BY i.StudentName
    ");
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mailing List - Student Course Hub</title>
    <style>
        /* General styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        /* Header styling */
        header {
            background-color: #003087; /* University blue */
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 2.5em;
        }

        /* Navigation */
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

        /* Main content */
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        /* Table styling */
        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #005bb5;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .container {
                padding: 0 10px;
            }

            table, th, td {
                font-size: 0.9em;
            }

            th, td {
                padding: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <h1>Mailing List</h1>
    </header>

    <!-- Navigation -->
    <nav>
       <a href="../Courses/courses_front.php">View Courses</a>
        <a href="../registration/register_front.php">Register Interest</a>
        <a href="../registration/unregister_front.php">Unregister Interest</a>
       </nav>

    <!-- Main content -->
    <div class="container">
        <?php if (empty($results)): ?>
            <p>No active registrations found.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Programme</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['StudentName'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['Email']); ?></td> <!-- This is where the line belongs -->
                            <td><?php echo htmlspecialchars($row['ProgrammeName']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>