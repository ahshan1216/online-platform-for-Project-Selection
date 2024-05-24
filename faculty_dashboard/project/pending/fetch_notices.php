<?php
include '../database.php';
session_start();

$teacher_id = $_SESSION['teacher_id'];

$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name= $row['name'];
  
}


// Collect the name parameter
$name = $_GET['name'];

// Query to fetch notices
$sql = "SELECT * FROM notice WHERE name='$name' and session= '$session'";
$result = $connection->query($sql);

$notices = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
} else {
    echo "No notices found.";
}

// Close connection
$connection->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($notices);
?>