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
                    <a href="<?php echo URLROOT; ?>/users/deleteUser" style="background-color: #E33535;">Delete</a>
                    <a href="<?php echo URLROOT; ?>/users/modificationPage/<?php echo $data['user']->id; ?>">Modify</a>
                </div>
            </div>
        </div>
    </div>
    <main>
        <div class="hero">
            <?php
            echo '<h2 class=title>Hello ' . ucfirst($data['user']->fname) . ' ' . ucfirst($data['user']->lname) . '</h2>';
            echo '<div class="add">
                    <h4 class=sub-title>All Teams : </h4>
                    <a onclick="openTeamPopup(' . $data['user']->id . ')">+ New Team</a>
                </div>';
            echo "<div class=fullPage><table class='teamTable'>
                        <tr>
                            <th>Team Name</th>
                            <th>Created At</th>
                            <th>Description</th>
                            <th>Project Name</th>
                            <th>Actions</th>
                        </tr>";
            foreach ($data['teams'] as $team) {

                echo "
                        <tr>
                            <td>{$team->name}</td>
                            <td>{$team->created_at}</td>
                            <td>{$team->description}</td>";
                if ($team->projectId === NULL) {
                    echo "<td>-</td>";
                } else {
                    echo "<td>{$team->projectName}</td>";
                }
                echo "<td><a href='" . URLROOT . "/teams/modifyTeam/" . $team->id . "'>Modify</a> <a href='" . URLROOT . "/teams/members/" . $team->id . "'>Members</a> <a href='" . URLROOT . "/teams/deleteTeam/". $team->id."'>Delete</a></td>";
            }

            ?>
        </div>
        <div id="teamPopup" class="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Add Team</h2>
                    <span class="close" onclick="closeTeamPopup()">&times;</span>
                </div>
                <div class="popup-body">
                    <form action="<?php echo URLROOT; ?>/teams/createTeam" method="post">
                        <label for="name" style="color: #008fd4; font-size: 16px; font-weight: 600;">Team Name:</label><br>
                        <input type="text" id="name" name="name" required placeholder="Enter Team Name" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"> <br>
                        <label for="description" style="color: #008fd4; font-size: 16px; font-weight: 600;">Team Description:</label><br>
                        <textarea id="description" name="description" required placeholder="Tell us about your team <3" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;"></textarea> <br>
                        <label for="newP" style="color: #008fd4; font-size: 16px; font-weight: 600;">Project:</label><br>
                        <select name="newP" id="newP" required style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;">
                            <option value="" hidden>Select Project</option>
                            <?php

                            foreach ($data['projects'] as $proj) {
                                echo "<option value={$proj->id}>{$proj->name}</option>";
                            }
                            ?>
                        </select>
                        <label for="scrumMaster" style="color: #008fd4; font-size: 16px; font-weight: 600;">Scrum Master:</label><br>
                        <input type="number" id="scrumMaster" name="scrumMaster" required style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;" readonly> <br>

                        <div class="popup-footer">
                            <button type="submit" class="btn btn-primary" name="setTeam">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>