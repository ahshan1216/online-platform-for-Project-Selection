<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the group number is provided in the POST request
if(isset($_POST['groupNumber'])) {
    // Get the group number from the POST request
    $groupNumber = $_POST['groupNumber'];

    // Query to fetch group members (student names) based on the group number
    $query = "SELECT * FROM project_students AS ps
              INNER JOIN users AS u ON ps.student_id = u.student_id
              WHERE ps.group_number = '$groupNumber'";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';

    // Check if there are any group members
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the group members and generate HTML for checkboxes
        while ($row = mysqli_fetch_assoc($result)) {
            $studentName = $row['name'];
            $studentId = $row['student_id'];
            $html .= '<div class="form-check">';
            $html .= '<input class="form-check-input" type="checkbox" id="' . $studentId . '" name="groupMembers[]" value="' . $studentId . '">';
            $html .= '<label class="form-check-label" for="' . $studentId . '">' . $studentId . ' - ' . $studentName . '</label>';
            $html .= '</div>';
        }
    } else {
        // If no group members found, display a message
        $html .= '<p>No group members found</p>';
    }

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>

