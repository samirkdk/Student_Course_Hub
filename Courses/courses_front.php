<?php
require 'courses.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Courses - Student Course Hub</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Explore Our Courses</h1>
    </header>

    <nav role="navigation" aria-label="Main navigation">
        <ul>
            <li><a href="../registration/register_front.php" tabindex="0">Register Interest</a></li>
            <li><a href="../registration/unregister_front.php" tabindex="0">Unregister Interest</a></li>
            <li><a href="../registration/mailing_list.php" tabindex="0">Mailing List</a></li>
            <li><a href="../staff/staff.php" tabindex="0">Staff</a></li>
          
        </ul>
    </nav>

    <main class="container">
        <section class="programme-section" aria-labelledby="ug-heading">
            <h2 id="ug-heading">Undergraduate Programmes</h2>
            <?php foreach ($ug_programmes as $prog): ?>
                <article class="programme-card">
                    <h3><?php echo htmlspecialchars($prog['ProgrammeName']); ?></h3>
                    <p><?php echo htmlspecialchars($prog['Description']); ?></p>
                    <p><strong>Programme Leader:</strong> <a href="/Student_Course_Hub-1/staff/staff_details.php?staff_id=<?php echo $prog['ProgrammeLeaderID']; ?>" tabindex="0"><?php echo htmlspecialchars($prog['ProgrammeLeader']); ?></a></p>

                    <div class="highlights">
                        <h4>Programme Highlights</h4>
                        <ul>
                            <?php
                            $highlights = explode('; ', $prog['Highlights']);
                            foreach ($highlights as $highlight) {
                                echo "<li>" . htmlspecialchars($highlight) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="requirements">
                        <h4>Entry Requirements</h4>
                        <ul>
                            <?php
                            $requirements = explode('; ', $prog['EntryRequirements']);
                            foreach ($requirements as $req) {
                                echo "<li>" . htmlspecialchars($req) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="careers">
                        <h4>Career Prospects</h4>
                        <ul>
                            <?php
                            $careers = explode('; ', $prog['CareerProspects']);
                            foreach ($careers as $career) {
                                echo "<li>" . htmlspecialchars($career) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="modules">
                        <?php
                        $modules = getModulesByProgramme($pdo, $prog['ProgrammeID']);
                        $years = [1, 2, 3];
                        foreach ($years as $year):
                        ?>
                            <div class="year">
                                <h4>Year <?php echo $year; ?></h4>
                                <ul>
                                    <?php
                                    $has_modules = false;
                                    foreach ($modules as $module) {
                                        if ($module['Year'] == $year) {
                                            $has_modules = true;
                                            echo "<li>" . htmlspecialchars($module['ModuleName']) . " - " . htmlspecialchars($module['Description']) . "<br><strong>Module Leader:</strong> <a href='/Student_Course_Hub-1/staff/staff_details.php?staff_id=" . $module['ModuleLeaderID'] . "' tabindex='0'>" . htmlspecialchars($module['ModuleLeader']) . "</a></li>";
                                        }
                                    }
                                    if (!$has_modules) {
                                        echo "<li>No modules available for this year.</li>";
                                    }
                                    ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="action-buttons">
                        <a href="../registration/register_front.php?programme_id=<?php echo $prog['ProgrammeID']; ?>" class="register-btn" tabindex="0">Register Interest</a>
                        <a href="../registration/unregister_front.php?programme_id=<?php echo $prog['ProgrammeID']; ?>" class="unregister-btn" tabindex="0">Unregister Interest</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="programme-section" aria-labelledby="pg-heading">
            <h2 id="pg-heading">Postgraduate Programmes</h2>
            <?php foreach ($pg_programmes as $prog): ?>
                <article class="programme-card">
                    <h3><?php echo htmlspecialchars($prog['ProgrammeName']); ?></h3>
                    <p><?php echo htmlspecialchars($prog['Description']); ?></p>
                    <p><strong>Programme Leader:</strong> <a href="/Student_Course_Hub-1/staff/staff_details.php?staff_id=<?php echo $prog['ProgrammeLeaderID']; ?>" tabindex="0"><?php echo htmlspecialchars($prog['ProgrammeLeader']); ?></a></p>

                    <div class="highlights">
                        <h4>Programme Highlights</h4>
                        <ul>
                            <?php
                            $highlights = explode('; ', $prog['Highlights']);
                            foreach ($highlights as $highlight) {
                                echo "<li>" . htmlspecialchars($highlight) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="requirements">
                        <h4>Entry Requirements</h4>
                        <ul>
                            <?php
                            $requirements = explode('; ', $prog['EntryRequirements']);
                            foreach ($requirements as $req) {
                                echo "<li>" . htmlspecialchars($req) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="careers">
                        <h4>Career Prospects</h4>
                        <ul>
                            <?php
                            $careers = explode('; ', $prog['CareerProspects']);
                            foreach ($careers as $career) {
                                echo "<li>" . htmlspecialchars($career) . "</li>";
                            }
                            ?>
                        </ul>
                    </div>

                    <div class="modules">
                        <div class="year">
                            <h4>Year 1</h4>
                            <ul>
                                <?php
                                $modules = getModulesByProgramme($pdo, $prog['ProgrammeID']);
                                $has_modules = false;
                                foreach ($modules as $module) {
                                    if ($module['Year'] == 1) {
                                        $has_modules = true;
                                        echo "<li>" . htmlspecialchars($module['ModuleName']) . " - " . htmlspecialchars($module['Description']) . "<br><strong>Module Leader:</strong> <a href='/Student_Course_Hub-1/staff/staff_details.php?staff_id=" . $module['ModuleLeaderID'] . "' tabindex='0'>" . htmlspecialchars($module['ModuleLeader']) . "</a></li>";
                                    }
                                }
                                if (!$has_modules) {
                                    echo "<li>No modules available for this year.</li>";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <a href="../registration/register_front.php?programme_id=<?php echo $prog['ProgrammeID']; ?>" class="register-btn" tabindex="0">Register Interest</a>
                        <a href="../registration/unregister_front.php?programme_id=<?php echo $prog['ProgrammeID']; ?>" class="unregister-btn" tabindex="0">Unregister Interest</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>
</body>
</html>