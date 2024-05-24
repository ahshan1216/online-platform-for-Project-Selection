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
    // Get the selected group numbers from the AJAX request
    $groupNumbers = json_decode($_POST['groupNumbers']);

  

    // Update the database for each selected group number
    foreach ($groupNumbers as $groupNumber) {
        // Example query to insert a new record into project_students table
        $insertQuery = "INSERT INTO $sessionfaculty (teacher_id, selected_by_head) VALUES ('$groupNumber', '1')";
        
        // Execute the insert query
        mysqli_query($connection, $insertQuery);
    
        // You can add error handling here if needed
    }
    

    // Respond with a success message or any other response if needed
    echo 'Database updated successfully';
} else {
    // Handle other request methods if needed
    echo 'Invalid request method';
}
?>
