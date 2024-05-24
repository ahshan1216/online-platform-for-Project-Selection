<?php

// Database configuration
$servername = "localhost";
$username = "etisparl_versity";
$password = "etisparl_versity";
$database = "etisparl_versity";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    if (empty($_POST['username']) || empty($_POST['password'])) {
        //http_response_code(400);
        echo json_encode(array("message" => "Username and password are required."));
        exit;
    }

    // Sanitize input
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query database for user
    $sql = "SELECT * FROM users WHERE email = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $data_pass=$row['password'];
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Verify password
        if ($password===$data_pass) {
            // Authentication successful
           // http_response_code(200);
            echo json_encode(array("message" => "Login successful"));
        } else {
            // Invalid password
           // http_response_code(405);
            echo json_encode(array("message" => "Invalid Password"));
        }
    } else {
        // User not found
       // http_response_code(401);
        echo json_encode(array("message" => "User not found"));
    }
}

// Close connection
$conn->close();

?>
