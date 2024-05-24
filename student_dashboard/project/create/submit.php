<?php
// Start session
session_start();

// Check if project name, description, and session data are received
if(isset($_POST['projectName']) && isset($_POST['projectDescription']) && isset($_POST['studentId']) && isset($_POST['session']) && isset($_POST['group_number'])) {
    // Retrieve project name, description, and session data from AJAX request
    $projectName = $_POST['projectName'];
    $projectDescription = $_POST['projectDescription'];
    $student_id = $_POST['studentId'];
    $session = $_POST['session'];
    $group_number = $_POST['group_number'];

    include '../../../database.php';

       

        // Insert data into database
        $query = "INSERT INTO $session (student_id, project_name, project_description,session,group_number) VALUES ('$student_id', '$projectName', '$projectDescription','$session','$group_number')";
        $result = mysqli_query($connection, $query);

        // Check if insert was successful
        if($result) {
            echo "Project submitted successfully.";
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        // Close connection
        mysqli_close($connection);
   
} else {
    echo "Error: Project data or session data not received.";
}
?>
