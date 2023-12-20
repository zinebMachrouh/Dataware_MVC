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
            <a href="#myTeams"><i class="fa-solid fa-user-group"></i>Teams</a>
            <a href="#myProjects"><i class="fa-solid fa-bars-progress"></i>Projects</a>
            <a href="#" onclick="openMyPopup()"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="<?php echo URLROOT; ?>/users/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> LogOut</a>
        </nav>
    </header>
    <div id="myPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <?php
                echo "
                        <h2>{$data['profile']->fname} {$data['profile']->lname}</h2>";
                ?>
                <span class="close" onclick="closeMyPopup()">&times;</span>
            </div>
            <div class="popup-body">
                <?php
                echo "
                    <h3>Personal information:</h3> <p>Birthdate : ";
                echo ($data['profile']->birthdate === NULL) ? 'empty' : '' . $data['profile']->birthdate . '';
                echo "</p><p>Phone Number : {$data['profile']->tel}</p>
                    <p>Adress : ";
                echo ($data['profile']->adress === NULL) ? 'empty' : '' . $data['profile']->adress . '';
                echo "
                    </p><h3 class=pro>Professional information:</h3>
                    <p>Email : {$data['profile']->email}</p>
                    <p>Service : {$data['profile']->service}</p>
                    <p>Role : 
                ";
                echo ($data['profile']->role === 0) ? "Member" : (($data['profile']->role === 1) ? "Product Owner" : (($data['profile']->role === 2) ? "Scrum Master" : "Admin"));
                echo "</p>";
                ?>
                <div class="popup-footer">
                    <a href="<?php echo URLROOT; ?>/users/deleteUser" style="background-color: #E33535;">Delete</a>
                    <a href="<?php echo URLROOT; ?>/users/modificationPage/<?php echo $data['profile']->id; ?>">Modify</a>
                </div>
            </div>
        </div>
    </div>

    <main>
        <div class="hero">
            <?php
            echo '<h2 class=title>Hello ' . ucfirst($data['profile']->fname) . ' ' . ucfirst($data['profile']->lname) . '</h2>';
            if (empty($data['user'])) {
                echo '<div class=fullPage><h4>No Teams <br>No Projects</h4></div>';
            } else {
                echo "<h4 class=sub-title id=myTeams>Teams</h4> <div class='fullPage'>";
                echo "<table class='teamTable'>
                    <tr>
                        <th>Team Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Project Name</th>
                        <th>Scrum Master</th>
                    </tr>";


                foreach ($data['teamDetails'] as $userTeam) {
                    echo "
                        <tr>
                            <td>{$userTeam['team']->name}</td>
                            <td>{$userTeam['team']->description}</td>
                            <td>{$userTeam['team']->created_at}</td>";

                    if ($userTeam['team']->projectId === NULL) {
                        echo "<td>-</td>";
                    } else {
                        echo "<td>{$userTeam['project']->name}</td>";
                    }

                    if ($userTeam['team']->scrumMaster === NULL) {
                        echo "<td>-</td>
                            </tr>";
                    } else {
                        echo "<td>{$userTeam['scrumMaster']->fname} {$userTeam['scrumMaster']->lname}</td>
                            </tr>";
                    }
                }

                echo "</table>
                    <h4 class=sub-title id=myProjects>Projects</h4>
                    <table class='teamTable'>
                    <tr>
                        <th>Project Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Product Owner</th>
                    </tr>";
                foreach ($data['projects'] as $project) {
                    echo "
                        <tr>
                            <td>{$project->name}</td>
                            <td>{$project->date_start}</td>
                            <td>{$project->date_end}</td>
                            <td>{$project->description}</td>
                            <td>";
                    echo ($project->status === 0) ? '<p  class=active>● Active</p>' : '<p class=done>✔ Done</p></td>';
                    if ($data['productOwner'] === NULL) {
                        echo "<td>-</td>
                            </tr>";
                    } else {
                        echo "
                                <td>{$data['productOwner']->fname} {$data['productOwner']->lname}</td>
                            </tr>";
                    }
                }
                echo "</div>";
            }
            ?>
        </div>
    </main>


</body>

</html>