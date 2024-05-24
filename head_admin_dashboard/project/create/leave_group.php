<?php

// Check if student_id parameter is provided in the URL
if(isset($_GET['student_id'])) {
    // Retrieve the student_id from the URL parameter
    $studentId = $_GET['student_id'];

    include '../../../database.php';


    // SQL query to delete the student's record from project_students table
    $deleteQuery = "DELETE FROM project_students WHERE student_id = '$studentId' AND status = 1 AND request = 0";

    // Execute the query
    if (mysqli_query($connection, $deleteQuery)) {
        // Return a success message
        echo "Student record deleted successfully";
    } else {
        // Return an error message
        echo "Error deleting student record: " . mysqli_error($conn);
    }

    // Close connection
    mysqli_close($connection);
} else {
    // Return an error message if student_id parameter is not provided
    echo "Error: student_id parameter is missing";
}

?>
