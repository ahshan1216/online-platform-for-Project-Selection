<?php
// Include your database connection file
include '../../../database.php';

// Check if studentId is provided in the GET request
if(isset($_GET['studentId'])) {
    $studentId = $_GET['studentId'];

    // Query to fetch user information based on studentId
    $query = "SELECT * FROM users WHERE student_id = '$studentId'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Fetch user data
        $userData = mysqli_fetch_assoc($result);

        // Display user information
        echo "<p>Name: " . $userData['name'] . "</p>";
        echo "<p>Email: " . $userData['email'] . "</p>";
        // Add more fields as needed

        // You can fetch and display more user information as needed
    } else {
        echo "User information not found.";
    }
} else {
    echo "Student ID not provided.";
}
?>
