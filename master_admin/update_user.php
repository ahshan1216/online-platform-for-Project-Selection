<?php
// Assuming you have established a database connection
include '../database.php'; // Include your database connection script

// Check if the user ID is received from the AJAX request
if (isset($_POST['userId'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = mysqli_real_escape_string($connection, $_POST['userId']);

    // SQL query to update the user's verification status
    $query = "UPDATE users SET verify = 1 WHERE id = '$userId'";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // User verification status updated successfully
        echo json_encode(['success' => true]);
    } else {
        // Error occurred while updating user verification status
        echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
    }
} else {
    // User ID not provided in the request
    echo json_encode(['success' => false, 'error' => 'User ID not provided']);
}
?>
