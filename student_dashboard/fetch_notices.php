<?php
include '../database.php';
session_start();

$teacher_name = $_SESSION['teacher_name'];



// Collect the name parameter
$name = $teacher_name;

// Query to fetch notices
$sql = "SELECT subject,id,notice, session, DATE_FORMAT(date, '%d %b %h:%i %p') as formatted_date FROM notice WHERE name='$name'  order by id DESC";
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