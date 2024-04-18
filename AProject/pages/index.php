<?php
include("../server/server.php");
// log out functionality
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
$loggedIn = isset($_SESSION['username']);
// using this as well as changing header in below .php stopped add button refresh/repeating error (after adding something to the table and then refreshing it would be repeated)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
    <link rel="stylesheet" href="../css/stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script rel="script" src="../js/script.js"></script>
</head>
<body>
    <?php include("../components/navbar.php") ?>
    <section id="Wlc_msg">
        <!-- content if logged in -->
        <?php if($loggedIn) : ?>
            <h1 id="welcome_msg">Welcome, <?php echo $_SESSION['username']; ?></h1>
        <?php endif?>
        <!-- content if not logged in -->
        <?php if(!$loggedIn) : ?>
            <h1 id="welcome_msg">Public View</h1>
        <?php endif ?>
    </section>
    <!-- content for all viewers (logged in or otherwise) -->
    <!-- section database is a table that will show contents of sql database to be seen by all viewers -->
    <section id="database_table">
        <div id="table_container">
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>Short Description</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include('../server/server.php');
                    // search bar functionality
                    $sqlGet = "SELECT * FROM projects JOIN users ON projects.uid = users.uid";
                    if(isset($_POST['submit'])) {
                        $search = mysqli_real_escape_string($db, $_POST['search']);
                        $sqlGet = "Select * from `projects` join `users` on projects.uid = users.uid where title like '%$search%' or start_date like '%$search%'";
                    }
                    $sqlData = mysqli_query($db, $sqlGet) or die('error getting data from table');
                    //
                    while ($row = mysqli_fetch_array($sqlData)) {
                        echo "<tr class='data-row'>";
                        echo "<td>" . $row['title'] . "</td>";
                        echo "<td>" . $row['start_date'] . "</td>";
                        $descBigger100 = strlen($row['description']) > 100;
                        $description = $descBigger100 ? substr($row['description'], 0, 100) . '...' : $row['description'];
                        echo "<td>" . $description . "</td>";
                        echo "</tr>";
                        // drop down for more info
                        $descOptional = $descBigger100 ? "<th>Long Description</th>" : null;
                        $descDataOptional = $descBigger100 ? "<td>".$row['description']."</td>" : null;
                        $dropDown = "
                        <tr class='more-info'>
                        <td colspan='3'>
                        <div id='dropDown_container'>
                        <table>
                        <tr>
                        <th>End Date</th>
                        <th>Phase</th>
                        <th>User Email</th>
                        ".$descOptional."
                        </tr>
                        
                        <tr>
                        <td>
                        ".$row['end_date']."
                        </td>
                        <td>
                        ".$row['phase']."
                        </td>
                        <td>
                        ".$row['email']."
                        </td>
                        ".$descDataOptional."
                        </tr>
                        </table>
                        </div>
                        </td>
                        </tr>";
                        echo $dropDown;
                    }
                    // for more columns test (checking if scroll bar activates correctly for when table is larger than 500px in height)
                    // for ( $i = 0; $i < 100; $i++ ) {
                    //     echo "<tr>";
                    //     echo "<td>". $i ."</td>";
                    //     echo "</tr>";
                    // }
                    ?>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>