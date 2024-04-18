<?php
include("server.php");
// log out functionality
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AProject</title>
    <link rel="stylesheet" href="/css/stylesheet.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script rel="script" src="/js/script.js"></script>
</head>
<body>
    <nav class="topnav">
        <a class="active" href="/index.php">Database</a>
        <?php if(!isset($_SESSION['username'])) : ?>
            <a href="/login.php">LogIn</a>
            <a href="/register.php">Register</a>
        <?php endif ?>
        <?php if(isset($_SESSION['username'])) : ?>
            <a href="index.php?logout='1'">LogOut</a>
        <?php endif ?>
        <!-- search container should only show on index.php so that users don't get confused by it being on other pages as well -->
        <div class="search-container">
            <form action="index.php" method="post">
                <input type="text" placeholder="Search..." name="search">
                <button name="submit"><i class="fa">&#x1F50E;&#xFE0E;</i></button>
            </form>
        </div>
        <!-- search result query -->
        <section id="search">
            <div class="search_table_container">
                <table>
                    <?php
                    if(isset($_POST['submit'])) {
                        $search=$_POST['search'];

                        $sql="Select * from `projects` join `users` on projects.uid = users.uid where title like '%$search%' or start_date like '%$search%'";
                        $result = mysqli_query($db, $sql);
                        if($result) {
                            if(mysqli_num_rows($result) > 0) {
                                echo "
                                <thead>
                                <tr>
                                <th>Title</th>
                                <th>Start date</th>
                                <th>Short Description</th>
                                </tr>
                                </thead>";
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tbody>
                                    <tr>
                                    <td>".$row['title']."</td>
                                    <td>".$row['start_date']."</td>
                                    <td>".$row['description']."</td>
                                    </tr>
                                    </tbody>";
                                }
                            } else {
                                echo "data not found.";
                            }
                        }
                    }
                    ?>
                </table>
            </div>





            <?php
            // include('server.php');

            // if (isset($_GET['search'])) {
            //     $search = mysqli_real_escape_string($db, $_GET['search']);
            //     $sqlSearch = "SELECT * FROM projects JOIN users ON projects.uid = users.uid WHERE title LIKE '%$search%' OR start_date LIKE '%$search%'";
            //     // echo $sqlSearch;
            //     $searchOutput = mysqli_query($db, $sqlSearch);

            //     if (!$searchOutput) {
            //         die(mysqli_error($db));
            //     }

            //     if (mysqli_num_rows($searchOutput) > 0) {
            //         echo "<div id='table_container>";
            //         echo "<table>";
            //         echo "<thead><tr><th>Title</th><th>Start Date</th><th>Short Description</th></tr></thead>";
            //         echo "<tbody>";
                    
            //         while ($row = mysqli_fetch_array($searchOutput)) {
            //             echo "<tr class='data-row'>";
            //             echo "<td>" . $row['title'] . "</td>";
            //             echo "<td>" . $row['start_date'] . "</td>";
            //             echo "<td>" . $row['description'] . "</td>";
            //             echo "</tr>";
            //             echo "<tr class='more-info'>";
            //             echo "<td colspan='3'>End Date: " . $row['end_date'] . " || Phase: " . $row['phase'] . " || Student Email: ". $row['email'] . "</td>";
            //             echo"</tr>";
            //         }

            //         echo "</tbody>";
            //         echo "</div>";
            //         echo"</table>";
            //     } else {
            //         echo "No results found.";
            //     }
            // }
            ?>
        </section> 
    </nav>
    <!-- content if logged in -->
    <?php if(isset($_SESSION['username'])) : ?>
        <h1 id="welcome_msg">Welcome, <?php echo $_SESSION['username']; ?></h1>
    <?php endif?>
    <!-- content if not logged in -->
    <?php if(!isset($_SESSION['username'])) : ?>
        <h1 id="welcome_msg">Public View</h1>
    <?php endif ?>
    <!-- content for all viewers (logged in or otherwise) -->
    <!-- section database is a table that will show contents of sql database to be seen by all viewers -->
    <section id="database">
        <?php
        include('server.php');
        $sqlGet = "SELECT * FROM projects JOIN users ON projects.uid = users.uid";
        $sqlData = mysqli_query($db, $sqlGet) or die('error getting data from table');
        
        // headers
        echo "<div id='table_container'>";
        echo "<table>";
        echo "<thead><tr><th>Title</th><th>Start Date</th><th>Short Description</th></tr></thead>";
        echo "<tbody>";
        
        // row data
        while ($row = mysqli_fetch_array($sqlData)) {
            echo "<tr class='data-row'>";
            echo "<td>" . $row['title'] . "</td>";
            echo "<td>" . $row['start_date'] . "</td>";
            // echo "<td class='info'>". $row['end_date']."</td>";
            // echo "<td class='info'>". $row['phase']."</td>";
            echo "<td>" . $row['description'] . "</td>";
            // echo "<td class='info'>". $row['uid']."</td>";
            echo "</tr>";
            // drop down for more info
            echo "<tr class='more-info'>";
            echo "<td colspan='3'>End Date: " . $row['end_date'] . " || Phase: " . $row['phase'] . " || Student Email: ". $row['email'] . "</td>";
            echo"</tr>";
        }
        // for more columns test (checking if scroll bar activates correctly for when table is larger than 500px in height)
        for ( $i = 0; $i < 100; $i++ ) {
            echo "<tr>";
            echo "<td>". $i ."</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
        echo "</div>";
        ?>
    </section>
</body>
</html>