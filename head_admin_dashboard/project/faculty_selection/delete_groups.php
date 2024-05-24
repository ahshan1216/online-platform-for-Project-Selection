<?php
// Start session
session_start();
// Include your database connection file

include '../../../database.php';

$teacher_id = $_SESSION['admin'];

$query1 = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result1 = mysqli_query($connection, $query1);

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    $name = $row['name'];
    $session=$row['session'];
}
$sessionfaculty = $session . 'faculty';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['groups'])) {
   

  

    // Loop through each group number and construct the DELETE query
    foreach($_POST['groups'] as $group_number) {
        $group_number = mysqli_real_escape_string($connection, $group_number);
        // Example query to update the group_approval field with the logged-in user's name
        $updateQuery = "DELETE FROM $sessionfaculty WHERE teacher_id = '$group_number'";
        
        // Execute the update query
        $result = mysqli_query($connection, $updateQuery);

        // You can add error handling here if needed
    }
    if (!$result) {
        // An error occurred
        $error = mysqli_error($connection);
        // Handle the error (e.g., log it, display a message to the user)
        echo "Error updating group number $group_number: $error";
    } else {
        // Check if any rows were affected
        $rowsAffected = mysqli_affected_rows($connection);
        if ($rowsAffected == 0) {
            // No rows were updated (result not found)
            echo "In This Group $group_number You Already Approve the project. Thats Why You an not Remove";
        } else {
            // Rows were updated successfully
            echo "Faculty Teacher Remove successfully";
        }
    }
    // Respond with a success message or any other response if needed
   // echo 'Database updated successfully';
} 
 else {
    // Send an error response if groups data is not set
    echo "Error: No groups selected.";
        }



}
else {
    // Handle other request methods if needed
    echo 'Invalid request method';
}
?>




