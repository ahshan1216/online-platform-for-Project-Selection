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




$notice = $_POST['notice'];
$subject = $_POST['name'];
$sql8 = "INSERT INTO notice (name, notice,session,subject, date) VALUES ('$name', '$notice','$session','$subject', NOW())";
if ($connection->query($sql8) === TRUE) {
    echo "New notice saved successfully";
} else {
    echo "Error: " . $sql8 . "<br>" . $connection->error;
}




$data = array(
    'title' => $name . " Sir:- " . $subject,
    'body'  => $notice
);


notify($topic,$data);
echo "Notification Sent";



// Close connection
$connection->close();

?>