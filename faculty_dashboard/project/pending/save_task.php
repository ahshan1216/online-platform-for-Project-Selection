<?php
// Include the database connection file
include '../../../database.php';

// Check if the request is made using POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if comment and group number are set
    if (isset($_POST['comment']) && isset($_POST['groupNumber'])) {
        // Sanitize input data
        $comment = mysqli_real_escape_string($connection, $_POST['comment']);
        $groupNumber = mysqli_real_escape_string($connection, $_POST['groupNumber']);

        // Prepare SQL statement to insert task into the database
        $sql = "INSERT INTO tasks (task_name, group_number) VALUES ('$comment', '$groupNumber')";

        // Execute SQL statement
        if (mysqli_query($connection, $sql)) {
            // Task saved successfully
            $response = array('success' => true, 'message' => 'Task saved successfully');
            echo json_encode($response);
        } else {
            // Error occurred while saving task
            $response = array('success' => false, 'message' => 'Error: ' . mysqli_error($connection));
            echo json_encode($response);
        }
    } else {
        // Required parameters missing
        $response = array('success' => false, 'message' => 'Comment and group number are required');
        echo json_encode($response);
    }
} else {
    // Request method is not POST
    $response = array('success' => false, 'message' => 'Invalid request method');
    echo json_encode($response);
}
?>
