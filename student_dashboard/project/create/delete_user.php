<?php
// Include your database connection file
include '../../../database.php';

// Initialize response array
$response = array();

// Check if studentId is provided in the POST request
if(isset($_POST['studentId'])) {
    $studentId = $_POST['studentId'];
    $group_number = $_POST['group_number'];

    // Delete user from the database
    $query = "DELETE FROM project_students WHERE student_id = '$studentId' ";
    $result = mysqli_query($connection, $query);

    if ($result) {
        // If deletion is successful, set success key to true
        $response['success'] = true;
        // Set message key to indicate success
        $response['message'] = "User with ID $studentId has been deleted successfully.";
    } else {
        // If deletion fails, set success key to false
        $response['success'] = false;
        // Set message key to indicate failure
        $response['message'] = "Error deleting user with ID $studentId.";
    }
} else {
    // If studentId is not provided in the POST request, set success key to false
    $response['success'] = false;
    // Set message key to indicate missing student ID
    $response['message'] = "Student ID not provided.";
}

// Return JSON response
echo json_encode($response);
?>
