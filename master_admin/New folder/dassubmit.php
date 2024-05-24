<?php
// Include the database connection file
include '../database.php';

// Start the session
session_start();




$student_id= $_SESSION['student_id'];


$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
}



// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $projectName = $_POST['projectName'];
    $projectDescription = $_POST['projectDescription'];
    $progress = $_POST['progressPercentage'];

    $project_id  = $_POST['project_id'];
    

    // Perform database update
    $update_query = "UPDATE $session SET project_description = '$projectDescription', progress = $progress,project_name = '$projectName' WHERE id = '$project_id'";
    $result = mysqli_query($connection, $update_query);

    // Check if the update was successful
    if ($result) {
        // Update successful
        // Return a success response
        echo "success";
    } else {
        // Update failed
        // Return an error response
        echo "error";
    }
}
if(isset($_POST['projectId'])) {
    // Get the project ID from the POST parameters
    $projectId = $_POST['projectId'];

    // Include your database connection configuration here
    // Example using mysqli:
    

    // Prepare the SQL statement to delete the project
    $sql = "DELETE FROM projects WHERE id = '$projectId'";

    // Execute the SQL query
    if ($connection->query($sql) === TRUE) {
        echo "Project deleted successfully";
    } else {
        echo "Error deleting project: " . $conn->error;
    }

    // Close the database connection
    $connection->close();
} else {
    // Project ID not provided
    echo "Project ID not provided";
}
?>
