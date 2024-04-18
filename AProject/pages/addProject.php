<?php include("../server/server.php"); 
include("../components/buttons/cnfirmBtn_Function.php");
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
    <div id="add-content">
        <form id="addData" method="post">
            <!-- title, start date, end date, phase, description, uid <- info to get -->
            <?php include("../server/errors.php"); ?>
            <label for="title">Title: </label>
            <input type="text" name="title" id="title" maxlength="100">
            <label for="start_date">Start Date: </label>
            <input type="date" name="start" id="start_date">
            <label for="end_date">End Date: </label>
            <input type="date" name="end" id="end_date">
            <label for="phase">Phase: </label>
            <select name="phase" id="phase">
                <option value="Design">Design</option>
                <option value="Development">Development</option>
                <option value="Testing">Testing</option>
                <option value="Deployment">Deployment</option>
            </select>
            <label for="description">Description: </label>
            <textarea name="description" id="description" cols="30" rows="3" placeholder="Description of project..." maxlength="500"></textarea>
            <button name="cnfimBtn-add" id="cnfimBtn-add">Confirm</button>
        </form>
    </div>
</body>
</html>