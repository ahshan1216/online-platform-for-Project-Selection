<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the task ID is provided in the POST request
if(isset($_POST['taskId'])) {
    // Get the task ID from the POST request
    $taskId = $_POST['taskId'];

    // Delete the task from the database
    $query = "DELETE FROM tasks WHERE id = $taskId";
    $result = mysqli_query($connection, $query);

    // Check if the deletion was successful
    if ($result) {
        // Return a success response
        echo 'Task deleted successfully';
    } else {
        // Return an error response
        echo 'Error deleting task: ' . mysqli_error($connection);
    }
} else {
    // If the task ID is not provided in the POST request, display an error message
    echo 'Error: Task ID not provided';
}
?>
