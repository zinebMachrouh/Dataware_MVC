<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/brand.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css" type="text/css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css" type="text/css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT; ?>/js/script.js" defer></script>
    <style>
        main {
            margin-top: 9vh;
            /* background: url('../assets/bg.png') no-repeat; */
            background-position: center;
            background-size: cover;
            height: fit-content;
            width: 100%;
            padding: 20px 50px;
            background-color: #008fd4;
        }
    </style>
</head>

<body>
    <header>
        <h2>Data<img src="<?php echo URLROOT; ?>/assets/brand.png" alt=brand />are</h2>
        <nav>
            <a href="#"><i class="fa-solid fa-house"></i> Home</a>
            <a href="#" onclick="openMyPopup()"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="<?php echo URLROOT; ?>/users/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> LogOut</a>
        </nav>
    </header>
    <div id="myPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <?php
                echo "
                        <h2>{$data['user']->fname} {$data['user']->lname}</h2>";
                ?>
                <span class="close" onclick="closeMyPopup()">&times;</span>
            </div>
            <div class="popup-body">
                <?php
                echo "
                    <h3>Personal information:</h3> <p>Birthdate : ";
                echo ($data['user']->birthdate === NULL) ? 'empty' : '' . $data['user']->birthdate . '';
                echo "</p><p>Phone Number : {$data['user']->tel}</p>
                    <p>Adress : ";
                echo ($data['user']->adress === NULL) ? 'empty' : '' . $data['user']->adress . '';
                echo "
                    </p><h3 class=pro>Professional information:</h3>
                    <p>Email : {$data['user']->email}</p>
                    <p>Service : {$data['user']->service}</p>
                    <p>Role : 
                ";
                echo ($data['user']->role === 0) ? "Member" : (($data['user']->role === 1) ? "Product Owner" : (($data['user']->role === 2) ? "Scrum Master" : "Admin"));
                echo "</p>";
                ?>
                <div class="popup-footer">
                    <a href="#" style="background-color: #E33535;">Delete</a>
                    <a href="#">Modify</a>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="hero">
            <?php
            echo '<div class="add">
                    <h4 class=sub-title>All Projects : </h4>
                    <a href="./addProject.php?productOwner=' . $user['id'] . '">+ New Project</a>
                </div>';

            $query = "SELECT * from projects WHERE productOwner = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':id', $user['id'], PDO::PARAM_STR);
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "<div class=fullPage><table class='teamTable'>
                        <tr>
                            <th>Project Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>";
            foreach ($projects as $project) {
                echo "
                        <tr>
                            <td>{$project['name']}</td>
                            <td>{$project['date_start']}</td>
                            <td>{$project['date_end']}</td>
                            <td>{$project['description']}</td>
                            <td>";
                echo ($project['status'] === 0) ? '<p  class=active>● Active</p>' : '<p class=done>✔ Done</p></td>';
                echo "<td class='actions'><a href='./modifyProject.php?projectId=" . $project['id'] . "'>Modify</a> <a href='./deleteProject.php?deleteOne=" . $project['id'] . "'>Delete</a></td>";
            }

            echo "</table><h4 class=sub-title id=myTeams>Teams</h4> <div class='fullPage'>
                <table class='teamTable'>
                    <tr>
                        <th>Team Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Project Name</th>
                        <th>Action</th>
                    </tr>";
            $query1 = "SELECT teams.*
                    FROM teams
                    JOIN projects ON teams.projectId = projects.id
                    JOIN users ON projects.productOwner = users.id
                    WHERE teams.scrumMaster IS NULL
                    AND users.id = :id";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bindParam(':id', $user['id'], PDO::PARAM_INT);
            $stmt1->execute();
            $teams = $stmt1->fetchAll(PDO::FETCH_ASSOC);
            foreach ($teams as $team) {
                $query2 = "SELECT * from projects WHERE id = :id";
                $stmt2 = $conn->prepare($query2);
                $stmt2->bindParam(':id', $team['projectId'], PDO::PARAM_INT);

                $stmt2->execute();
                $teamP = $stmt2->fetch(PDO::FETCH_ASSOC);

                echo "
                        <tr>
                            <td>{$team['name']}</td>
                            <td>{$team['description']}</td>
                            <td>{$team['created_at']}</td>
                            <td>{$teamP['name']}</td>
                            <td><a href=# onclick='openSMPopup(" . $team["id"] . ")'>Set Scrum Master</a></td>
                        </tr>";
            }

            ?>
        </div>

    </main>
</body>

</html>