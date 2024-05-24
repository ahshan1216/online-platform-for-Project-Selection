<?php
session_start();

include '../../database.php';
$student_id = $_SESSION['admin'];
// Get the data from the POST request
$fullName = $_POST['fullName'];
$pass=$_POST['password'];
$email = $_POST['email'];
// Handle profile photo upload if needed

// Update the user's table
$query = "UPDATE users SET name='$fullName', email='$email' , password='$pass' WHERE teacher_id='$student_id'";
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
