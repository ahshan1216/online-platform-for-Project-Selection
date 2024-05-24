<?php
// Assuming you have a database connection established
// Replace the database credentials with your own
include '../database.php';

// Check if the student_id parameter is provided and not empty
if (isset($_POST['student_id']) && !empty($_POST['student_id'])) {
    // Escape the student_id to prevent SQL injection
    $student_id = $connection->real_escape_string($_POST['student_id']);


$targetDir = "../uploads/students/"; // Change this to your desired upload directory
$file_name = pathinfo($student_id, PATHINFO_FILENAME); // Extract the filename without extension
$webpFile = $targetDir . $file_name . '_profile.webp'; // Construct the target filename with .webp extension

$targetDir1 = "../uploads/students/"; // Change this to your desired upload directory
$file_name1 = pathinfo($student_id, PATHINFO_FILENAME); // Extract the filename without extension
$webpFile1 = $targetDir . $file_name1 . '_id_photo.webp'; // Construct the target filename with .webp extension



// Send JSON-encoded response

// Check if file exists before attempting to delete
if (file_exists($webpFile)) {
    // Attempt to delete the file
    if (unlink($webpFile)) {
        echo "Existing file deleted. ";
    } else {
        echo "Failed to delete the file. ";
    }
} else {
    echo $webpFile;
}
if (file_exists($webpFile1)) {
    // Attempt to delete the file
    if (unlink($webpFile1)) {
        echo "Existing file deleted. ";
    } else {
        echo "Failed to delete the file. ";
    }
} else {
    echo $webpFile1;
}



    // Prepare and execute the SQL statement to delete the user account
    $sql = "DELETE FROM users WHERE student_id = '$student_id'";
   if ($connection->query($sql) === TRUE) {
        // Account deleted successfully
        echo "User account deleted successfully";
    } else {
        // Error occurred while deleting the account
       echo "Error deleting user account: " . $connection->error;
    }
} else {
    // No student_id provided
    echo "Error: No student_id provided";
}

// Close the database connection
$connection->close();
?>
