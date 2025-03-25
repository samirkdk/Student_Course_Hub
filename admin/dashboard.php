<?php


require_once __DIR__ . '/../database/db.php'; // Include DB connection

// Fetch stats
$totalPrograms = $conn->query("SELECT COUNT(*) as total FROM Programmes")->fetch_assoc()['total'];
$activeModules = $conn->query("SELECT COUNT(*) as total FROM Modules")->fetch_assoc()['total'];
$totalStudents = $conn->query("SELECT COUNT(*) as total FROM InterestedStudents WHERE active = TRUE")->fetch_assoc()['total'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
   
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
   <link rel="stylesheet" href="assets/css/dash2.css">
</head>
<body>
    <div class="sidebar">
        <div class="logo">University Admin</div>
        <div class="menu">
            <div class="menu-item active">
                
                <span>Dashboard</span>
            </div>
            
            <div class="menu-item">
                <a href="programme.php">
                <span>Programme</span>
            </a>
            </div>
            <div class="menu-item">
                <a href="module.php">
                <span>Modules</span>
            </a>
            </div>
           
            <div class="menu-item">
                <span>Students</span>
            </div>
            <div class="menu-item">
                <span>Reports</span>
            </div>
        </div>
    </div>
    
    <div class="content-container">
        <div class="header">
            <input type="text" class="search-bar" placeholder="Search...">
            <span>Admin Portal</span>
        </div>
        
        <div class="card">
        <h3>Program Management</h3>
            <a href="add_programmes.php"><div class="card-header">
                
                <button class="btn btn-primary">+ Add Program</button></a>
            </div>
            <div class="card-content">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Program Name</th>
                            <th>Level</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>P001</td>
                            <td>BSc Computer Science</td>
                            <td>undergraduate</td>
                            <td></td>
                            <td>
                                <button class="btn">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>P002</td>
                            <td>BA English Literature</td>
                            <td>Humanities</td>
                            <td><span class="status status-active">Active</span></td>
                            <td>
                                <button class="btn">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>P003</td>
                            <td>MSc Data Science</td>
                            <td>Computing</td>
                            <td><span class="status status-pending">Pending</span></td>
                            <td>
                                <button class="btn">Edit</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Module Management</h3>
                <a href="add_modules.php"><button class="btn btn-primary">+ Add Module</button></a>
            </div>
            <div class="card-content">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Module Name</th>
                            <th>Credits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>CS101</td>
                            <td>Introduction to Programming</td>
                            <td>15</td>
                            <td>
                                <button class="btn">Edit</button>
                            </td>
                        </tr>
                        <tr>
                            <td>CS205</td>
                            <td>Database Systems</td>
                            <td>20</td>
                            <td>
                                <button class="btn">Edit</button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <h3>Quick Stats</h3>
            </div>
            <div class="card-content">
                <div class="stats-container">
                    <div class="stat-box">
                        <h4>Total Programs</h4>
                        <span class="stat-number"><?php echo $totalPrograms; ?></span>
                    </div>
                    <div class="stat-box">
                        <h4>Active Modules</h4>
                        <span class="stat-number"><?php echo $activeModules; ?></span>
                    </div>
                    <div class="stat-box">
                        <h4>Total Students</h4>
                        <span class="stat-number"><?php echo $totalStudents; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
