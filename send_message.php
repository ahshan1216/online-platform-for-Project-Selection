<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the database connection file
    include 'database.php';

    // Get the message data from the request body
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract the message data
    $senderId = $data['sender_id'];
    $recipientId = $data['recipient_id'];
    $content = $data['content'];

    // Build the SQL query
    $sql = "INSERT INTO messages (sender_id, recipient_id, content) VALUES ('$senderId', '$recipientId', '$content')";

    // Execute the query
    if ($connection->query($sql) === TRUE) {
        // Send a success response
        echo json_encode(array("message" => "Message sent successfully"));
    } else {
        // Send an error response if the query fails
        echo json_encode(array("error" => "Error sending message: " . $connection->error));
    }

    // Close the database connection
    $connection->close();
} else {
    // Send an error response if the request method is not POST
    http_response_code(405); // Method Not Allowed
    echo json_encode(array("error" => "Only POST requests are allowed"));
}
?>
