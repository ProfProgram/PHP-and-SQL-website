<?php $loggedIn = isset($_SESSION['username']); ?>
<nav class="topnav">
    <a <?php if(basename($_SERVER['REQUEST_URI']) == "index.php") echo 'class="active"'; ?> href="../pages/index.php">Database</a>
    <?php if(!$loggedIn) : ?>
        <a <?php if(basename($_SERVER['REQUEST_URI']) == "login.php") echo 'class="active"'; ?> href="../pages/login.php">LogIn</a>
        <a <?php if(basename($_SERVER['REQUEST_URI']) == "register.php") echo 'class="active"'; ?> href="../pages/register.php">Register</a>
    <?php endif ?>
    <?php if($loggedIn) : ?>
        <a href="index.php?logout='1'">LogOut</a>
        <a <?php if(basename($_SERVER['REQUEST_URI']) == "addProject.php") echo 'class="active"'; ?> href="../pages/addProject.php">Add Project</a>
        <a <?php if(basename($_SERVER['REQUEST_URI']) == "updateProject.php") echo 'class="active"'; ?> href="../pages/updateProject.php">Update Project</a>
    <?php endif ?>
    <!-- search container should only show on index.php so that users don't get confused by it being on other pages as well -->
    <?php if(basename($_SERVER['REQUEST_URI']) == "index.php") : ?>
        <div class="search-container">
            <form action="../pages/index.php" method="post">
                <input type="text" placeholder="Search..." name="search">
                <button name="submit"><i class="fa">&#x1F50E;&#xFE0E;</i></button>
            </form>
        </div>
    <?php endif ?>
</nav>
