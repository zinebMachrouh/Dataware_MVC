<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify</title>
    <link rel="shortcut icon" href="<?php echo URLROOT; ?>/assets/brand.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins';
        }

        .login-body {
            width: 100%;
            height: 100vh;
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #00a6e8;
        }

        .create-form {
            width: 600px;
            height: 730px;
            background-color: #fafafa;
            border-radius: 20px;
            box-shadow: rgba(17, 17, 26, 0.1) 0px 0px 16px;
            overflow: hidden;
        }

        .create-form h2 {
            display: flex;
            align-items: center;
            color: #1e1e1e;
            font-size: 30px;
            justify-content: center;
            padding: 20px;
        }

        .create-form form {
            padding: 0px 30px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .back {
            position: absolute;
            top: 50px;
            left: 50px;
            background-color: #fafafa;
            border-radius: 200px;
            width: 50px;
            height: 50px;
            color: #00a6e8;
            padding: 10px 12px;
            letter-spacing: 2px;
            font-size: 24px;
        }

        .labels {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: #1e1e1e;
        }

        .labels:not(.x-lg) label {
            width: 47%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        label h4 {
            font-size: 20px;
            color: #1e1e1e;
        }

        .labels:not(.x-lg) label input {
            padding: 10px 5px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #1e1e1e;
            outline: none;
        }

        .sm {
            display: flex;
            flex-direction: column;
            gap: 5px;
            width: 100%;
        }

        .sm input {
            padding: 10px 5px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #1e1e1e;
            outline: none;
        }

        .labels:not(.x-lg) label input:focus {
            box-shadow: #00a6e83f 0px 2px 8px 0px;
            border: #00a6e8 1px solid;
            transition: all ease 0.3s;
        }

        label input:focus,
        label select:focus {
            box-shadow: #00a6e83f 0px 2px 8px 0px;
            border: #00a6e8 1px solid;
            transition: all ease 0.3s;
        }

        .x-lg label {
            width: 30%;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .x-lg input {
            padding: 10px 5px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #1e1e1e;
            outline: none;
        }

        .x-lg select {
            padding: 10px 5px;
            width: 100%;
            border-radius: 5px;
            border: 1px solid #1e1e1e;
            outline: none;
        }

        .btns {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 10px;
        }

        .btns button {
            font-size: 18px;
            padding: 10px 15px;
            outline: none;
            border: none;
            cursor: pointer;
            font-weight: 500;
            width: 180px;
        }

        .btns button:first-child {
            border: #00a6e8 2px solid;
            background-color: transparent;
            color: #00a6e8;
            border-radius: 5px;
        }

        .btns button:last-child {
            border: #00a6e8 2px solid;
            background-color: #00a6e8;
            color: #fafafa;
            border-radius: 5px;
        }

        .btns button:first-child:hover,
        .btns button:last-child:hover {
            box-shadow: #00a6e83f 0px 2px 8px 0px;
            transition: all ease 0.3s;
        }
    </style>
</head>

<body class="login-body">
    <a href="<?php echo URLROOT; ?>/users/dashboard" class="bi bi-arrow-left back">Go Back</a>
    <div class="create-form">
        <h2>Data<img src="<?php echo URLROOT; ?>/assets/brand.png" alt=brand />are</h2>
        <form action="<?php echo URLROOT; ?>/users/modifyUser/<?php echo $data['user']->id; ?>" method="POST">
            <?php
            echo '
        <div class="labels med">
            <label for="fname">
                <h4>First Name</h4>
                <input type="text" name="fname" id="fname" required placeholder="Enter First Name" value=' . $data['user']->fname . '>
            </label>
            <label for="lname">
                <h4>Last Name</h4>
                <input type="text" name="lname" id="lname" required placeholder="Enter Last Name" value=' . $data['user']->lname . '>
            </label>
        </div>
        <label for="email"  class="sm">
            <h4>Email</h4>
            <input type="email" name="email" id="email" placeholder="example@gmail.com" value=' . $data['user']->email . '>
        </label>
        <div class="labels med">
            <label for="birthdate">
                <h4>Birthdate</h4>
                <input type="date" name="birthdate" id="birthdate" value=' . $data['user']->birthdate . '>
            </label>
            <label for="tel">
                <h4>Phone Number</h4>
                <input type="tel" name="tel" id="tel" placeholder="07XXXXXXXX" value=' . $data['user']->tel . '>
            </label>
        </div>
        <label for="adress" class="sm">
            <h4>adress</h4>
            <input type="text" name="adress" id="adress" placeholder="1220 Dream Street Fantasyland, FL 54321 United Imaginary States" value="' . $data['user']->adress . '">
        </label>
            <label for="service" class="sm">
                <h4>Service</h4>
                <input type="text" name="service" id="service" placeholder="Full-Stack Dev" value=' . $data['user']->service . '>
            </label>
                    <label for="pswd" class="sm">
                <h4>Password</h4>
                <input type="text" name="pswd" id="pswd" placeholder="XXXXXXXX" value=' . base64_decode($data['user']->password) . '>
            </label>
    ';
            ?>

            <div class="btns">
                <button type="reset">Cancel</button>
                <button type="submit">Submit</button>
            </div>
        </form>
    </div>

</body>

</html>