<?php

// Include the database connection file
include '../database.php';

// Check if the table name, ID, and data are provided in the POST request
if (isset($_POST['table']) && isset($_POST['id']) && !empty($_POST)) {
    // Sanitize the inputs to prevent SQL injection
    $table = mysqli_real_escape_string($connection, $_POST['table']);
    $id = mysqli_real_escape_string($connection, $_POST['id']);

    // Construct the SET part of the UPDATE query
    $set_values = "";
    foreach ($_POST as $field_name => $value) {
        if ($field_name !== 'table' && $field_name !== 'id') {
            $field_value = mysqli_real_escape_string($connection, $value);
            $set_values .= "$field_name = '$field_value', ";
        }
    }
    // Remove the trailing comma and space
    $set_values = rtrim($set_values, ', ');

    // Construct the UPDATE query
    $update_query = "UPDATE $table SET $set_values WHERE id = $id";

    // Execute the UPDATE query
    if (mysqli_query($connection, $update_query)) {
        echo "Record updated successfully";
        echo '<script>window.location.href = "index.php";</script>';
    } else {
        echo "Error updating record: " . mysqli_error($connection);
    }
} else {
    echo "Table name, ID, or data not provided";
}

// Close connection
mysqli_close($connection);

?>
