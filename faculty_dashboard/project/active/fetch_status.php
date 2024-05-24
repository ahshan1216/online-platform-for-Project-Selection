<?php
include '../../../database.php';
session_start();
$teacher_id = $_SESSION['teacher_id'];


$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name = $row['name'];
}
    else {
        // Handle case where user data is not found
        $html .= '<tr><td colspan="3">User data not found</td></tr>';

    }
$present_table= $session . 'present';
// Fetch status of each student from the database
$sql = "SELECT roll, status FROM $present_table"; // Replace 'present_table' with your actual table name
$result = $connection->query($sql);

$statusData = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Store the status of each student in an associative array
        $statusData[$row["roll"]] = $row["status"];
    }
} else {
    echo "0 results";
}

// Close the database connection
$connection->close();

// Output the status data in JSON format
header('Content-Type: application/json');
echo json_encode($statusData);
?>
