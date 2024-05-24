<?php
include '../database.php';
session_start();



// Collect the id parameter
if (!isset($_POST['id'])) {
    http_response_code(400);
    echo json_encode(["error" => "ID parameter is required"]);
    exit();
}

$id = $connection->real_escape_string($_POST['id']);

// Query to delete the notice
$sql = "DELETE FROM notice WHERE id='$id'";
if ($connection->query($sql) === TRUE) {
    echo $id;
} else {
    http_response_code(500);
    echo json_encode(["error" => "Error deleting notice: " . $connection->error]);
}

// Close connection
$connection->close();
?>