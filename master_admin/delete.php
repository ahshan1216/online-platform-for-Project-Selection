<?php

// Include the database connection file
include '../database.php';

// Check if the table name and ID are provided in the URL
if (isset($_GET['table']) && isset($_GET['id'])) {
    // Sanitize the inputs to prevent SQL injection
    $table = mysqli_real_escape_string($connection, $_GET['table']);
    $id = mysqli_real_escape_string($connection, $_GET['id']);

    // Construct the DELETE query
    $delete_query = "DELETE FROM $table WHERE id = $id";

    // Execute the DELETE query
    if (mysqli_query($connection, $delete_query)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($connection);
    }
} else {
    echo "Table name and ID not provided";
}

// Close connection
mysqli_close($connection);

?>
