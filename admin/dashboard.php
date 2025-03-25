<?php


require_once __DIR__ . '/../database/db.php'; // Include DB connection

// Fetch stats
$totalPrograms = $conn->query("SELECT COUNT(*) as total FROM Programmes")->fetch_assoc()['total'];
$activeModules = $conn->query("SELECT COUNT(*) as total FROM Modules")->fetch_assoc()['total'];
$totalStudents = $conn->query("SELECT COUNT(*) as total FROM InterestedStudents WHERE active = TRUE")->fetch_assoc()['total'];
// Fetch Programs
$programsQuery = "SELECT p.ProgrammeID, p.ProgrammeName, l.LevelName, p.Description 
                  FROM Programmes p 
                  JOIN Levels l ON p.LevelID = l.LevelID";
$programsResult = $conn->query($programsQuery);

// Fetch Modules
$modulesQuery = "SELECT ModuleID, ModuleName, Description 
                 FROM Modules";
$modulesResult = $conn->query($modulesQuery);
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
            <!-- Programs Card -->
    <div class="card">
        <div class="card-header">
            <h3>Program Management</h3>
        </div>
        <div class="card-content">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Program Name</th>
                        <th>Level</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $programsResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ProgrammeID']); ?></td>
                            <td><?php echo htmlspecialchars($row['ProgrammeName']); ?></td>
                            <td><?php echo htmlspecialchars($row['LevelName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Description'] ?? ''); ?></td>
                            <td>
                            <td>
                            <a href="edit_programme.php?id=<?php echo $row['ProgrammeID']; ?>"><button class="btn">Edit</button></a>
                            <a href="delete_programme.php?id=<?php echo $row['ProgrammeID']; ?>"><button class="btn btn-danger">Delete</button></a>

                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modules Card -->
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
                        
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $modulesResult->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ModuleID']); ?></td>
                            <td><?php echo htmlspecialchars($row['ModuleName']); ?></td>
                            
                            <td>
    <a href="edit_module.php?id=<?php echo $row['ModuleID']; ?>"><button class="btn">Edit</button></a>
    <a href="delete_module.php?id=<?php echo $row['ModuleID']; ?>"><button class="btn btn-danger">Delete</button></a>
                          </td>                   
                        </tr>
                    <?php } ?>
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
