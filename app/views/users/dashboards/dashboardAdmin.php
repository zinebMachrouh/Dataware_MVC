<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/brand.png" type="image/x-icon">
    <!-- <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css" type="text/css"> -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/dashboard.css" type="text/css">
    <script src="https://kit.fontawesome.com/6e1faf1eda.js" crossorigin="anonymous"></script>
    <script src="<?php echo URLROOT; ?>/js/script.js" defer></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

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
            <a href="<?php echo URLROOT; ?>/projects/projects"><i class="fa-solid fa-bars-progress"></i>Projects</a>
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
            echo '<h4 class=sub-title>All Users : </h4>';
            echo '<div class=cards>';
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
                                    <a href=#><i class='fa-solid fa-location-dot' style='margin-right:5px;'></i>" . $user->service . "</a>";
                echo ($user->role === 0) ? "<a onclick='openPopup(" . $user->id . ")'>Member <i class='fa-solid fa-pencil'></i></a>" : (($user->role === 1) ? "<a onclick='openPopup(" . $user->id . ")'>Product Owner <i class='fa-solid fa-pencil'></i></a>" : (($user->role === 2) ? "<a onclick='openPopup(" . $user->id . ")'>Scrum Master <i class='fa-solid fa-pencil'></i></a>" : ""));
                echo "</div>
                            </div>";
            }
            echo '</div>';

            ?>
        </div>
        <div id="popup" class="popup">
            <div class="popup-content">
                <div class="popup-header">
                    <h2>Modify User Role</h2>
                    <span class="close" onclick="closePopup()">&times;</span>
                </div>
                <div class="popup-body">
                    <form action="<?php echo URLROOT; ?>/users/updateRole" method="post">
                        <label for="userID">User ID:</label>
                        <input type="text" id="userID" name="userID" id="userId" required readonly>
                        <label for="newRole">New Role:</label>
                        <select name="newRole" id="newRole" required>
                            <option value="0">Member</option>
                            <option value="1">Product Owner</option>
                            <option value="2">Scrum Master</option>
                        </select>
                        <div class="popup-footer">
                            <button type="submit" class="btn btn-primary">Modify Role</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>