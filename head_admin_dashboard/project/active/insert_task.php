<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the task text and group number are provided in the POST request
if(isset($_POST['taskText']) && isset($_POST['groupNumber'])) {
    // Get the task text and group number from the POST request
    $taskText = $_POST['taskText'];
    $groupNumber = $_POST['groupNumber'];

    // Insert the task into the database
    $query = "INSERT INTO tasks (task_name, group_number) VALUES ('$taskText', '$groupNumber')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // If insertion is successful, return success message
        echo 'Task inserted successfully';
    } else {
        // If insertion fails, return error message
        echo 'Error inserting task';
    }
} else {
    // If the task text or group number is not provided in the POST request, return an error message
    echo 'Error: Task text or group number not provided';
}
?>
