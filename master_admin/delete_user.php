<?php
// Assuming you have established a database connection
include '../database.php';  // Include your database connection script

// Check if the user ID is received from the AJAX request
if (isset($_POST['userId'])) {
    // Sanitize the user ID to prevent SQL injection
    $userId = mysqli_real_escape_string($connection, $_POST['userId']);

    // SQL query to delete the user with the provided ID
    $query = "DELETE FROM users WHERE id = '$userId'";

    // Execute the query
    if (mysqli_query($connection, $query)) {
        // User deleted successfully
        echo json_encode(['success' => true]);
    } else {
        // Error occurred while deleting user
        echo json_encode(['success' => false, 'error' => mysqli_error($connection)]);
    }
} else {
    // User ID not provided in the request
    echo json_encode(['success' => false, 'error' => 'User ID not provided']);
}
?>
