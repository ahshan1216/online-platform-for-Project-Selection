<?php
// Assuming you have already established a database connection
include '../database.php';
// Check if the role parameter is set and not empty
if (isset($_GET['role']) && !empty($_GET['role'])) {
    $role = $_GET['role'];


    // Prepare SQL query based on the selected role
    if ($role == "all") {
        $query = "SELECT * FROM users role NOT IN ('admin', 'super_admin') ORDER BY id DESC";
    } else {
        $query = "SELECT * FROM users WHERE role = '$role' ORDER BY id DESC";
    }
    // Execute SQL query
    $result = $connection->query($query);

    // Initialize an array to store fetched data
    $data = array();

    // Fetch data from the result set
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close database connection
    $connection->close();

    // Return fetched data as JSON response
    echo json_encode($data);
} else {
    // If role parameter is not set or empty, return an empty JSON response
    echo json_encode(array());
}
?>
