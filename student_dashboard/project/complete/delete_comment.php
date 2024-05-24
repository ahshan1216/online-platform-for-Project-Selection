<?php
// Include your database connection file
include '../../../database.php';
session_start();
$student_id = $_SESSION['student_id'];
$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
}

$sessioncomplete = $session . 'complete';

// Check if the comment_id parameter is set and is numeric
if(isset($_GET['commentid']) && is_numeric($_GET['commentid'])) {
    $comment_id = $_GET['commentid'];

    // Query to delete the comment with the specified comment_id from the database
    $query = "DELETE FROM $sessioncomplete WHERE id = $comment_id";

    // Perform the query
    $result = mysqli_query($connection, $query);

    if($result) {
        // Comment deleted successfully
        echo json_encode(array('success' => true));
    } else {
        // Failed to delete comment
        echo json_encode(array('success' => false, 'message' => 'Failed to delete comment.'));
    }
} else {
    // Invalid or missing comment_id parameter
    echo json_encode(array('success' => false, 'message' => 'Invalid or missing comment_id parameter.'));
}
?>
