<?php
header("Content-Type: application/json");

$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "student_course_hub";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$query = $_GET['q'] ?? '';
$level = $_GET['level'] ?? '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5;
$offset = ($page - 1) * $limit;

if (!empty($query)) {
    $logSql = "INSERT INTO SearchAnalytics (SearchTerm) VALUES (?)";
    $logStmt = $conn->prepare($logSql);
    $logStmt->bind_param("s", $query);
    $logStmt->execute();
}

$sql = "SELECT p.ProgrammeID, p.ProgrammeName, p.Description, l.LevelName, s.Name AS ProgrammeLeader
        FROM Programmes p
        JOIN Levels l ON p.LevelID = l.LevelID
        JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
        WHERE 1=1";

$params = [];
$bindTypes = "";

if (!empty($query)) {
    $sql .= " AND p.ProgrammeName LIKE ?";
    $query = "%" . $query . "%";
    $params[] = &$query;
    $bindTypes .= "s";
}

if (!empty($level)) {
    $sql .= " AND l.LevelName = ?";
    $params[] = &$level;
    $bindTypes .= "s";
}

$sql .= " LIMIT ? OFFSET ?";
$params[] = &$limit;
$params[] = &$offset;
$bindTypes .= "ii";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($bindTypes, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$programmes = [];
while ($row = $result->fetch_assoc()) {
    $programmes[] = $row;
}

$countSql = "SELECT COUNT(*) AS total FROM Programmes p JOIN Levels l ON p.LevelID = l.LevelID WHERE 1=1";
if (!empty($query)) $countSql .= " AND p.ProgrammeName LIKE '%$query%'";
if (!empty($level)) $countSql .= " AND l.LevelName = '$level'";

$totalResult = $conn->query($countSql);
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

echo json_encode(["programmes" => $programmes, "totalPages" => $totalPages]);

$conn->close();
?>
