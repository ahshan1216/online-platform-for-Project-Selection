<?php
// update_name.php

// Check if the teacher name is received from the client-side
if (isset($_POST['teacher_name'])) {
    // Sanitize and assign the received teacher name to a PHP variable
    $name1 = $_POST['teacher_name']; // This is the selected teacher name
    
    // Now you can use $name1 as needed
    // For example, you might want to use it in a SQL query or perform other actions
    
    // If you need to use $name1 in the original PHP script, you can store it in a session variable
    session_start();
    $_SESSION['selected_teacher'] = $name1;
    
    // You can also echo back the selected teacher name as a response if needed
    echo "Selected teacher name: " . $name1;
} else {
    // Handle the case when the teacher name is not received
    echo "Error: Teacher name not received.";
}
?>
