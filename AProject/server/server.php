<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// initial variables
$username ="";
$email = "";
$errors = array();

// connection to sql database
$db = mysqli_connect("localhost","root","","aproject");

// CSRF token handling
include_once("csrf.php");
if (!isset($_SESSION["csrf_token"])) {
    $_SESSION['csrf_token'] = generateCSRFToken();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (validateCSRFToken($submittedToken)) {
        error_log('CSRF token validated. Form submission successful.');
    } else {
        error_log('CSRF token validation failed. Request rejected.');
    }
}
// register users
if (isset($_POST["reg_user"])) {
    // input values from form
    $username = mysqli_real_escape_string($db, $_POST["username"]);
    $email = mysqli_real_escape_string($db, $_POST["email"]);
    $password = mysqli_real_escape_string($db, $_POST["password"]);
    $password2 = mysqli_real_escape_string($db, $_POST["password2"]);

    // Form validation
    // error handling
    if (empty($username)) {
        array_push($errors,"Username is required");
    }
    if (empty($email)) {
        array_push($errors,"Eamil is required");
    }
    if (empty($password)) {
        array_push($errors,"Password is required");
    }
    if ($password != $password2) {
        array_push( $errors,"Passwords must match ");
    }

    // check database if current user exists or not (duplication check)
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user["email"] === $email) {
            array_push($errors,"Email already exists");
        }
    }

    // if no errors are caught then add user info to database
    if (count($errors) == 0) {
        $password = md5($password); // encryption for password before is saved

        $query = "INSERT INTO users (username, email, password)
                    VALUES('$username', '$email', '$password')";
        mysqli_query($db, $query);
        // logging user into a session of website after register
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You have been logged in";
        header('location: index.php');
    }
}

// Login Code
if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors,"Username is required");
    }

    if (empty($password)) {
        array_push($errors,"Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = mysqli_query($db, $query);
        if (mysqli_num_rows($result) == 1) {
            $_SESSION['username'] = $username;
            $_SESSION['success'] = 'You have successfully logged in';
            header('location: index.php');
        }else {
        array_push($errors,'Wrong username/password combination');
        }
    }
}