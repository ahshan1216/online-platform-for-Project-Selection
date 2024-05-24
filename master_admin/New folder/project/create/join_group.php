<?php
include '../../../database.php';
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if studentId and request parameters are set
    if (isset($_POST['studentId']) && isset($_POST['request'])) {
        // Retrieve studentId and request values from POST data
        $studentId = $_POST['studentId'];
        $request = $_POST['request'];

        // Perform necessary input validation and sanitization if needed

        // Your database connection code (assuming $connection is already established)

        // Perform the update operation
        $updateQuery = "UPDATE project_students 
                        SET group_number = '$request', status = 1, listening = '$request',request=0 
                        WHERE student_id = '$studentId' AND request = '$request'";
        $updateQueryResult = mysqli_query($connection, $updateQuery);

        if ($updateQueryResult) {


            $delete_query = "DELETE FROM project_students WHERE student_id = '$studentId' AND group_number = 0 ";
            $delete_query_result= mysqli_query($connection, $delete_query);




            // Return success message
            echo json_encode(array('success' => true, 'message' => 'Update successful.'));
        } else {
            // Return error message
            echo json_encode(array('success' => false, 'message' => 'Error updating record: ' . mysqli_error($connection)));
        }
    } else {
        // Return error message if required parameters are not set
        echo json_encode(array('success' => false, 'message' => 'Missing studentId or request parameters.'));
    }
} else {
    // Return error message if the request method is not POST
    echo json_encode(array('success' => false, 'message' => 'Invalid request method.'));
}

?>
