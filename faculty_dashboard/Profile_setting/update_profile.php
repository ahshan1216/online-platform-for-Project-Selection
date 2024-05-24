<?php
session_start();

include '../../database.php';
$teacher_id = $_SESSION['teacher_id'];
// Get the data from the POST request
$fullName = $_POST['fullName'];
$pass=$_POST['password'];
$email = $_POST['email'];
// Handle profile photo upload if needed

// Update the user's table
$query = "UPDATE users SET name='$fullName', email='$email' , password='$pass' WHERE teacher_id='$teacher_id'";
$result = mysqli_query($connection, $query);

// Check if the update was successful
if ($result) {
    echo "Profile updated successfully";
} else {
    echo "Error updating profile: " . mysqli_error($connection);
}

// Close the database connection
mysqli_close($connection);
?>
