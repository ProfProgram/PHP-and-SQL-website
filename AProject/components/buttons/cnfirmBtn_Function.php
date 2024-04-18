<?php 
if(isset($_POST['cnfimBtn-add'])) {
    // Validate required fields
    $requiredFields = ['title', 'start', 'end', 'phase', 'description'];
    foreach($requiredFields as $field) {
        if(!isset($_POST[$field]) || empty($_POST[$field])) {
            $errors[] = "The '$field' field is required.";
        }
    }

    // If there are validation errors, push them into the $errors array
    if(!empty($errors)) {
        foreach($errors as $error) {
            // Push each error message into the $errors array
            array_push($errors, $error);
        }
    } else {
        // Sanitize user inputs
        $title = mysqli_real_escape_string($db, $_POST['title']);
        $start_date = mysqli_real_escape_string($db, $_POST['start']);
        $end_date = mysqli_real_escape_string($db, $_POST['end']);
        $phase = mysqli_real_escape_string($db, $_POST['phase']);
        $description = mysqli_real_escape_string($db, $_POST['description']);

        // Get the user's ID from the session
        $uname = $_SESSION['username'];
        $uidGet = "SELECT uid FROM users WHERE username = '$uname'";
        $result = mysqli_query($db, $uidGet);
        $row = mysqli_fetch_assoc($result);
        $uid = $row['uid'];

        // Insert project data into the database using prepared statement
        $sqlAdd = "INSERT INTO projects (title, start_date, end_date, phase, description, uid) 
                   VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $sqlAdd);
        mysqli_stmt_bind_param($stmt, 'ssssss', $title, $start_date, $end_date, $phase, $description, $uid);

        if(mysqli_stmt_execute($stmt)) {
            header('Location: index.php');
            exit();
        } else {
            // Push the database error message into the $errors array
            array_push($errors, "Error: " . mysqli_error($db));
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
} elseif(isset($_POST['cnfimBtn-update'])) {
    // Validate required fields
    if(isset($_POST['title']) && $_POST['title'] !== "") {
        $uname = $_SESSION['username'];
        $uidGet = "SELECT uid FROM users WHERE username = ?";
        $stmt = mysqli_prepare($db, $uidGet);
        mysqli_stmt_bind_param($stmt, "s", $uname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if($result) {
            $row = mysqli_fetch_assoc($result);
            $uid = $row['uid'];

            $title = $_POST['title'];
            $selectedProjectUid = "SELECT uid FROM projects WHERE title = ?";
            $stmt = mysqli_prepare($db, $selectedProjectUid);
            mysqli_stmt_bind_param($stmt, "s", $title);
            mysqli_stmt_execute($stmt);
            $titleResult = mysqli_stmt_get_result($stmt);

            if ($titleResult) {
                if (mysqli_num_rows($titleResult) > 0) {
                    $row = mysqli_fetch_assoc($titleResult);
                    $projectOwnerUID = $row['uid'];

                    if ($uid == $projectOwnerUID) {

                        $title = $_POST['title'];
                        $start_date = $_POST['start'];
                        $end_date = $_POST['end'];
                        $phase = $_POST['phase'];
                        $description = $_POST['description'];

                        if (!mysqli_connect_errno()) {
                            $sqlUpdate = "UPDATE projects 
                                          JOIN users ON projects.uid = users.uid 
                                          SET ";
                            $updates = array();

                            if (!empty($title)) {
                                $updates[] = "title = ?";
                            }
                            if (!empty($start_date)) {
                                $updates[] = "start_date = ?";
                            }
                            if (!empty($end_date)) {
                                $updates[] = "end_date = ?";
                            }
                            if(!empty($phase)) {
                                $updates[] = "phase = ?";
                            }
                            if (!empty($description)) {
                                $updates[] = "description = ?";
                            }

                            if (!empty($updates)) {
                                $sqlUpdate .= implode(", ", $updates);
                                $sqlUpdate .= " WHERE projects.uid = ? AND users.uid = ? AND projects.title = ?";
                                
                                $stmt = mysqli_prepare($db, $sqlUpdate);
                                mysqli_stmt_bind_param($stmt, 'ssssss', $title, $start_date, $end_date, $phase, $description, $projectOwnerUID, $uid, $title);
                                mysqli_stmt_execute($stmt);

                                if (mysqli_stmt_affected_rows($stmt) > 0) {
                                    header('Location: index.php');
                                    exit();
                                } else {
                                    array_push($errors, 'Error updating record: ' . mysqli_error($db));
                                }

                                mysqli_stmt_close($stmt);
                            } else {
                                array_push($errors, 'No fields to update.');
                            }
                        } else {
                            array_push($errors, 'Failed to connect to MySQL: ' . mysqli_connect_error());
                        }
                    } else {
                        array_push($errors, 'You do not have permission to update this project.');
                    }
                } else {
                    array_push($errors,'A project by that title does not exist in the database.');
                }
            } else {
                array_push($errors, 'Error: ' . mysqli_error($db));
            }

            mysqli_close($db);
        } else {
            array_push($errors, 'Error: ' . mysqli_error($db));
        }
    } else {
        array_push($errors, 'Title field is empty.');
    }
}