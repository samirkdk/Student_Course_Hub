<?php
require 'db_connect.php';

function getProgrammes($pdo, $level_id) {
    $stmt = $pdo->prepare("
        SELECT p.ProgrammeID, p.ProgrammeName, p.Description, p.Highlights, p.EntryRequirements, p.CareerProspects, p.ProgrammeLeaderID, s.Name AS ProgrammeLeader
        FROM Programmes p
        JOIN Staff s ON p.ProgrammeLeaderID = s.StaffID
        WHERE p.LevelID = :level_id
    ");
    $stmt->execute(['level_id' => $level_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getModulesByProgramme($pdo, $programme_id) {
    $stmt = $pdo->prepare("
        SELECT m.ModuleName, m.Description, m.ModuleLeaderID, s.Name AS ModuleLeader, pm.Year
        FROM ProgrammeModules pm
        JOIN Modules m ON pm.ModuleID = m.ModuleID
        JOIN Staff s ON m.ModuleLeaderID = s.StaffID
        WHERE pm.ProgrammeID = :programme_id
        ORDER BY pm.Year
    ");
    $stmt->execute(['programme_id' => $programme_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$ug_programmes = getProgrammes($pdo, 1);
$pg_programmes = getProgrammes($pdo, 2);
?>