<?php
// Include your database connection file
include '../../../database.php';
session_start();
$teacher_id = $_SESSION['teacher_id'];
$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    //$name = $row['name'];
}
$sessioncomplete = $session . 'complete';
// Initialize an array to store comments
$comments = array();

// Check if the project_id parameter is set and is numeric
if(isset($_GET['projectid']) && is_numeric($_GET['projectid'])) {
    $project_id = $_GET['projectid'];

    // Query to fetch comments for the specified project_id from the database
    $query = "SELECT * FROM $sessioncomplete WHERE project_id = $project_id ORDER BY id DESC";

    // Perform the query
    $result = mysqli_query($connection, $query);

    // Check if the query was successful
    if($result) {
        // Fetch each row from the result set
        while($row = mysqli_fetch_assoc($result)) {
            $comments[] = array(
            // Add the comment to the comments array
            'commentId' => $row['id'],
            'name' => $row['who_c'],
            'comment' => $row['comment']
        );
        }

        // Close the result set
        mysqli_free_result($result);
    } else {
        // Query failed
        $comments[] = 'Failed to fetch comments.';
    }
} else {
    // Invalid or missing project_id parameter
    $comments[] = 'Invalid or missing project_id parameter.';
}

// Return comments as JSON
echo json_encode(array('comments' => $comments));
?>
