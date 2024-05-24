<?php
include '../database.php';
include 'notify.php';
session_start();
$teacher_id = $_SESSION['teacher_id'];

$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name= $row['name'];
  
}

// Fetch parameters
$id = $_POST['id'] ?? null;
$subject = $_POST['subject'] ?? null;
$notice = $_POST['notice'] ?? null;

if ($id === null || $subject === null || $notice === null) {
    http_response_code(400);
    echo json_encode(["error" => "Missing parameters"]);
    exit();
}

// Here you would add your logic to send the push notification
// For example, using a push notification service or API
$data = array(
    'title' => $name . " Sir:- " . $subject,
    'body'  => $notice
);


notify($topic,$data);
echo "Notification Sent";

// For demonstration purposes, we'll just return a success response
echo json_encode(["success" => "Push notification sent"]);
?>
