<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();

// Retrieve data from the POST request
$projectId = $_POST['project_id'];
$title = $_POST['title'];
$description = $_POST['description'];
$time = $_POST['time'];
$group_number = $_POST['group_number'];
$session = $_POST['session'];

// Check if a record with the same project ID and date already exists in the database
$query = "SELECT * FROM project_management WHERE project_id = '$projectId' AND time = '$time'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // If a record exists, perform an update operation
    $updateQuery = "UPDATE project_management SET title = '$title', description = '$description' WHERE project_id = '$projectId' AND time = '$time'";
    $updateResult = mysqli_query($connection, $updateQuery);

    if ($updateResult) {
        // Update successful
        echo 'success';
    } else {
        // Update failed
        echo 'error';
    }
} else {
    // If no record exists, perform an insert operation
    $insertQuery = "INSERT INTO project_management (project_id, title, description, time, group_number, session) VALUES ('$projectId', '$title', '$description', '$time', '$group_number', '$session')";
    $insertResult = mysqli_query($connection, $insertQuery);

    if ($insertResult) {
        // Insert successful
        echo 'success';
    } else {
        // Insert failed
        echo 'error';
    }
}

?>
