<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the group number is provided in the POST request
if(isset($_POST['projectid'])) {
    // Get the group number from the POST request
    $projectid = $_POST['projectid'];
    $date = $_POST['date'];

    // Query to fetch group members (student names) based on the group number
    $query = "SELECT * FROM activity where project_id = '$projectid' AND time='$date'";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';

    // Check if there are any group members
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the group members and generate HTML for checkboxes
        while ($row = mysqli_fetch_assoc($result)) {
            $comment = $row['comment'];
            
            
            $html .=  $comment ;

            
            
        }
    } else {
        // If no group members found, display a message
        //$html .= 'No comment Found.';
    }

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>

