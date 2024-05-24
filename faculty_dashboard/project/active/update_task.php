<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the task ID and new task text are provided in the POST request
if(isset($_POST['taskId']) && isset($_POST['newTaskText'])) {
    // Get the task ID and new task text from the POST request
    $taskId = $_POST['taskId'];
    $newTaskText = $_POST['newTaskText'];

    // Update the task in the database
    $query = "UPDATE tasks SET task_name = '$newTaskText' WHERE id = $taskId";
    $result = mysqli_query($connection, $query);

    // Check if the update was successful
    if ($result) {
        // Return a success response
        echo 'Task updated successfully';
    } else {
        // Return an error response
        echo 'Error updating task: ' . mysqli_error($connection);
    }
} else {
    // If the task ID or new task text is not provided in the POST request, display an error message
    echo 'Error: Task ID or new task text not provided';
}
?>
