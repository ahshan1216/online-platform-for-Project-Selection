<?php
// Assuming you have established a database connection
include '../../../database.php';
// Check if studentId and request data are received via POST
if(isset($_POST['studentId']) && isset($_POST['request'])) {
    // Sanitize input to prevent SQL injection
    $studentId = mysqli_real_escape_string($connection, $_POST['studentId']);
    $request = mysqli_real_escape_string($connection, $_POST['request']);

    // Query to delete student record based on studentId and request
    $deleteQuery = "DELETE FROM project_students WHERE student_id = '$studentId' AND request = '$request'";

    // Execute the delete query
    if(mysqli_query($connection, $deleteQuery)) {
        // Deletion successful
        echo "Student deleted successfully.";
    } else {
        // Error occurred while deleting
        echo "Error deleting student: " . mysqli_error($connection);
    }
} else {
    // Error: Missing studentId or request data
    echo "Error: Missing data.";
}
?>
