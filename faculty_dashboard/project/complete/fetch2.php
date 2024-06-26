<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();
$teacher_id = $_SESSION['teacher_id'];
$name= $_SESSION['selected_teacher'] ;

$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    //$name = $row['name'];
}




$sessioncomplete = $session . 'complete';
// Check if the group number is provided in the POST request
if(isset($_POST['projectid'])) {
    // Get the group number from the POST request
    $projectid = $_POST['projectid'];
    $date = $_POST['date'];

    // Query to fetch group members (student names) based on the group number
    $query = "SELECT description FROM $sessioncomplete WHERE project_id = '$projectid' LIMIT 1";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';

    // Check if there are any group members
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the group members and generate HTML for checkboxes
        while ($row = mysqli_fetch_assoc($result)) {
            $des = $row['description'];
            
            
            $html .= '<textarea class="form-control">' . $des . '</textarea>';

            
            
        }
    } else {
        // If no group members found, display a message
        $html .= '<p>No Activity Found</p>';
    }

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>

