<?php include("../server/server.php") ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
</head>
<body>
    <?php include("../components/navbar.php") ?>
    <div id='login_content'>
        <div id="users-log-reg">
            <h1>LogIn</h1>
        </div>
        <form method="post" action="login.php">
            <?php include("../server/errors.php"); ?>
            <div class="input-group">
                <label>Username: </label>
                <input type="text" name="username" id="uname">
            </div>
            <div class="input-group">
                <label>Password: </label>
                <input type="password" name="password">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user" id='logBtn'>LogIn</button>
            </div>
            <div>
            <p id="signUp">
                Not Registered Yet? <a href="register.php">Sign Up</a>
            </p>
        </form>
    </div>
</body>
</html>