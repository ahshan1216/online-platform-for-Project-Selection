<?php
// Include the database connection file
include 'database.php';

// Check if sender_id and recipient_id are provided in the request
if (isset($_GET['sender_id']) && isset($_GET['recipient_id'])) {
    // Get the sender_id and recipient_id from the request
    $senderId = $_GET['sender_id'];
    $recipientId = $_GET['recipient_id'];

    // Sanitize the input
    $senderId = intval($senderId);
    $recipientId = intval($recipientId);

    // Fetch messages between the sender and recipient from the database
// Fetch messages between the sender and recipient from the database
$sql = "SELECT messages.*, users.name AS sender_name FROM messages 
INNER JOIN users ON messages.sender_id = users.id
WHERE (sender_id = $senderId AND recipient_id = $recipientId) 
OR (sender_id = $recipientId AND recipient_id = $senderId) 
ORDER BY timestamp";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        $messages = array();
        // Fetch each row as an associative array
        while ($row = $result->fetch_assoc()) {
            // Add each message to the $messages array
            $messages[] = $row;
        }
        // Encode the $messages array as JSON and output it
        echo json_encode($messages);
    } else {
        // If no messages are found, output an empty array
        echo json_encode(array());
    }
} else {
    // If sender_id and recipient_id are not provided, output an error message
    echo json_encode(array("error" => "Sender ID and Recipient ID are required"));
}

// Close the database connection
$connection->close();
?>
