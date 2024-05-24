<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Chat System</title>
    <style>
        /* Style for chat icon */
        .chat-icon {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 50px;
            height: 50px;
            background-color: #007bff;
            border-radius: 50%;
            color: #fff;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
        }
        
        /* Style for chat popup */
        .chat-popup {
            display: none;
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 300px;
            height: auto; /* Set height to auto */
            max-height: 80%; /* Limit maximum height */
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            overflow: hidden;
        }

        .chat-content {
            height: calc(100% - 70px); /* Adjust height */
            padding: 10px;
            overflow-y: auto;
        }

        .chat-input {
            width: calc(100% - 20px);
            padding: 10px;
            border: none;
            outline: none;
            resize: none;
            border-top: 1px solid #ccc;
        }

        .chat-input-button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .scrollable-content {
            overflow-y: auto;
            scroll-behavior: smooth; /* Smooth scrolling */
            max-height: 300px; /* Adjust the maximum height as needed */
        }
    </style>
</head>
<body>
    <!-- Chat icon -->
    <div class="chat-icon" onclick="toggleChatPopup()">Chat</div>

    <!-- Chat popup -->
    <div class="chat-popup" id="chatPopup">
        <div class="chat-content scrollable-content" id="chatContent">
            <div id="chat"></div>
        </div>
        <textarea class="chat-input" id="messageInput" placeholder="Type your message..."></textarea>
        <button onclick="sendMessage()">Send</button>
    </div>


    <script>
         // Function to toggle the visibility of the chat popup
         function toggleChatPopup() {
            var chatPopup = document.getElementById('chatPopup');
            if (chatPopup.style.display === 'block') {
                chatPopup.style.display = 'none';
            } else {
                chatPopup.style.display = 'block';
                scrollToBottom(); // Scroll to bottom when chat popup is opened
            }
        }
        
        const senderId = 9; // Example: Replace with actual sender ID
        const recipientId = 8; // Example: Replace with actual recipient ID


        function displayMessage(sender, content) {
            const chatDiv = document.getElementById('chat');
            const messageDiv = document.createElement('div');
            messageDiv.textContent = `${sender}: ${content}`;
            chatDiv.appendChild(messageDiv);
            scrollToBottom();
        }
        fetchMessages();



        function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const message = messageInput.value.trim(); // Trim whitespace from the message

    // Assuming you have a way to determine the sender and recipient IDs
    // Check if the message is not empty
    if (message === "") {
        // Alert the user or perform other actions to handle empty message
        console.error('Error: Message cannot be empty');
        return; // Exit the function if the message is empty
    }

    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'send_message.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onload = function () {
        if (xhr.status >= 200 && xhr.status < 300) {
            // If message sent successfully, display it in the UI
            displayMessage('You', message);
            messageInput.value = ''; // Clear input field
        } else {
            console.error('Error sending message:', xhr.statusText);
        }
    };
    xhr.onerror = function () {
        console.error('Error sending message:', xhr.statusText);
    };
    xhr.send(JSON.stringify({ sender_id: senderId, recipient_id: recipientId, content: message }));
}


function scrollToBottom() {
            var chatContent = document.getElementById('chatContent');
            chatContent.scrollTop = chatContent.scrollHeight;
        }

        // Check the number of messages and scroll to bottom if more than 10 messages
        function checkAndScroll() {
            var chatContent = document.getElementById('chatContent');
            var messageCount = chatContent.children.length;
            if (messageCount > 10) {
                scrollToBottom();
            }
        }

        // Call the checkAndScroll function when the page is loaded
        window.onload = function() {
            scrollToBottom();
            checkAndScroll();
            
        };



        // Function to periodically fetch and display received messages
        function fetchMessages() {
            
            const xhr = new XMLHttpRequest();
            const url = `get_messages.php?sender_id=${senderId}&recipient_id=${recipientId}`;
            xhr.open('GET', url, true); // Assuming you have a PHP script to fetch messages
            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    const messages = JSON.parse(xhr.responseText);
                    // Loop through the messages array and display each message
                    messages.forEach(message => {
                        // Determine whether the message is sent by the current user or received
                        const sender = message.sender_id == 9 ? 'You' : message.sender_name;
                        displayMessage(sender, message.content);
                    });
                } else {
                    console.error('Error fetching messages:', xhr.statusText);
                }
            };
            xhr.onerror = function () {
                console.error('Error fetching messages:', xhr.statusText);
            };
            xhr.send();
        }


        // Call fetchMessages function periodically
        //setInterval(fetchMessages, 3000); // Fetch messages every 3 seconds
    </script>
</body>
</html>
