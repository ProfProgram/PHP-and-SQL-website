<?php include('../server/server.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
    <link rel="stylesheet" type="text/css" href="/css/stylesheet.css">
</head>
<body>
    <?php include("../components/navbar.php") ?>
    <div id="reg_content">
        <div id="users-log-reg">
            <h1>SignUp</h1>
        </div>
        <form method="post" action="register.php">
            <?php include('../server/errors.php'); ?>
            <div class="input-group">
                <label>Username: </label>
                <input type="text" name="username" id='uname' value="<?php echo $username; ?>">
            </div>
            <div class="input-group">
                <label>Email: </label>
                <input type="email" name="email" value="<?php echo $email; ?>">
            </div>
            <div class="input-group">
                <label>Password: </label>
                <input type="password" name="password">
            </div>
            <div class="input-group">
                <label>Confirm password: </label>
                <input type="password" name="password2">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="reg_user" id='regBtn'>Register</button>
            </div>
            <p id="alrMem">
                Already a member? <a href="login.php">LogIn</a>
            </p>
        </form>
    </div>
    
</body>
</html>