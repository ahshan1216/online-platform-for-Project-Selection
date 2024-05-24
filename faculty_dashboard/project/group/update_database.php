<?php
// Start session
session_start();
// Include your database connection file

include '../../../database.php';

$teacher_id = $_SESSION['teacher_id'];

$query1 = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result1 = mysqli_query($connection, $query1);

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    $name = $row['name'];
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected group numbers from the AJAX request
    $groupNumbers = json_decode($_POST['groupNumbers']);

  

    // Update the database for each selected group number
    foreach ($groupNumbers as $groupNumber) {
        // Example query to update the group_approval field with the logged-in user's name
        $updateQuery = "UPDATE project_students SET group_approval = '$name' WHERE group_number = '$groupNumber'";
        
        // Execute the update query
        mysqli_query($connection, $updateQuery);

        // You can add error handling here if needed
    }

    // Respond with a success message or any other response if needed
    echo 'Database updated successfully';
} else {
    // Handle other request methods if needed
    echo 'Invalid request method';
}
?>
