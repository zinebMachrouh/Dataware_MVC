<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/brand.png" type="image/x-icon">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/members.css" type="text/css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <style>
        main {
            margin-top: 9vh;
            background: url(../../assets/bg.png) no-repeat;
            background-position: center;
            background-size: cover;
            height: fit-content;
            width: 100%;
            padding: 20px 50px;
        }
    </style>
</head>

<body>
    <header>
        <h2>Data<img src="<?php echo URLROOT; ?>/assets/brand.png" alt=brand />are</h2>
        <nav>
            <a href="<?php echo URLROOT; ?>/users/dashboard"><i class="fa-solid fa-house"></i> Home</a>
            <a href="#" onclick="openMyPopup()"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="#" onclick="openAddPopup()"><i class="fa-solid fa-plus"></i> Add Member</a>

            <a href="<?php echo URLROOT; ?>/users/logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> LogOut</a>
        </nav>
    </header>

    <div id="myPopup" class="popup">
        <div class="popup-content">
            <div class="popup-header">
                <?php
                echo "
                        <h2>{$user['fname']} {$user['lname']}</h2>";
                ?>
                <span class="close" onclick="closeMyPopup()">&times;</span>
            </div>
            <div class="popup-body">
                <?php
                echo "
                    <h3>Personal information:</h3> <p>Birthdate : ";
                echo ($user['birthdate'] === NULL) ? 'empty' : '' . $user['birthdate'] . '';
                echo "</p><p>Phone Number : {$user['tel']}</p>
                    <p>Adress : ";
                echo ($user['adress'] === NULL) ? 'empty' : '' . $user['adress'] . '';
                echo "
                    </p><h3 class=pro>Professional information:</h3>
                    <p>Email : {$user['email']}</p>
                    <p>Service : {$user['service']}</p>
                    <p>Role : 
                ";
                echo ($user['role'] === 0) ? "Member" : (($user['role'] === 1) ? "Product Owner" : (($user['role'] === 2) ? "Scrum Master" : "Admin"));
                echo "</p>";
                ?>
                <div class="popup-footer">
                    <a class="delete" href="./deleteUser.php?deleteOne=<?php echo $user['id']; ?>">Delete</a>
                    <a href="./modify.php?modifyOne=<?php echo $user['id']; ?>">Modify</a>
                </div>
            </div>
        </div>
    </div>

    <main>
        <?php
        echo '<h4 class=sub-title>All Users : </h4>';
        echo '<div class="fullPage">';
        if (count($data['users']) === 0) {
            echo "<h4 class='sub-title'>No members found</h4>";
        } else {
            echo "<div class='cards'>";
            foreach ($data['users'] as $user) {
                echo "<div class=card>
                                <div class=card-top>
                                    <h4>" . substr($user->fname, 0, 1) . "" . substr($user->lname, 0, 1) . "</h4>
                                    <h2>" . $user->fname . " " . $user->lname . "</h2>
                                </div>
                                <div class=card-body>
                                    <p>" . $user->email . "</p>
                                    <p>Tel: " . $user->tel . "</p>
                                </div>
                                <div class=card-btm>
                                    <a href=#><i class='fa-solid fa-location-dot' style='margin-right:5px;'></i>" . $user->service . "</a>
                                    <a href='" . URLROOT . "/teams/deleteTeamUser/" . $user->id . "/" . $data['team']->id . "'>Delete User <i class='fa-solid fa-trash-can'></i></a>
                                    </div>
                            </div>";
            }
            echo "</div>";
        }
        echo '</div>';
        ?>
        <div id="addPopup" class="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Add Member</h2>
                    <span class="close" onclick="closeAddPopup()">&times;</span>
                </div>
                <div class="popup-body">
                    <form action="<?php echo URLROOT; ?>/teams/insertTeamUser/<?php echo $data['team']->id; ?>" method="post">
                        <label for="name" style="color: #008fd4; font-size: 16px; font-weight: 600;">Team Name:</label><br>
                        <input type="text" id="teamName" name="teamName" required placeholder="Enter Team Name" style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;" readonly value="<?php echo $data['team']->name; ?>"> <br>
                        <label for="member" style="color: #008fd4; font-size: 16px; font-weight: 600;">Members:</label><br>
                        <select name="member" id="member" required style="width: 100%; padding: 10px 7px; font-size: 16px; border-radius: 5px; outline: none; border: #1e1e1e4c 1px solid; margin-bottom: 15px;">
                            <option value="" hidden>Select Member</option>
                            <?php
                            foreach ($data['members'] as $member) {
                                echo "<option value={$member->id}>{$member->fname} {$member->lname}</option>";
                            }
                            ?>
                        </select>
                        <div class="popup-footer">
                            <button type="submit" class="btn btn-primary" name="addUser">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        function openMyPopup() {
            document.getElementById('myPopup').style.display = 'flex';
        }

        function closeMyPopup() {
            document.getElementById('myPopup').style.display = 'none';
        }

        function openAddPopup() {
            document.getElementById('addPopup').style.display = 'flex';
        }

        function closeAddPopup() {
            document.getElementById('addPopup').style.display = 'none';
        }
    </script>
</body>

</html>