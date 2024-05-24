<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();

$student_id=$_SESSION['student_id'];
$date = $_GET['date'];

include '../../extention/header_database.php';

$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name = $row['name'];
}
    else {
      
    }
$present_table= $session . 'present';
$statusData = array();


$sql3 = "SELECT * FROM project_students where session='$session' AND group_number='$user_group_number' "; // Replace 'present_table' with your actual table name
$result3 = $connection->query($sql3);


    // Loop through the group members and generate HTML for checkboxes
    while ($row = mysqli_fetch_assoc($result3)) {
        $studentId = $row['student_id'];
   




// Fetch ID and status data from the database
$sql1 = "SELECT roll, status FROM $present_table where roll='$studentId' AND date='$date' "; // Replace 'present_table' with your actual table name
$result1 = $connection->query($sql1);



if ($result1->num_rows > 0) {
    // Output data of each row
    while ($row1 = $result1->fetch_assoc()) {
        // Store the ID and status of each student in an associative array
        $statusData[$row1["roll"]] = $row1["status"];
    }
} else {
   // echo "0 results";
   $statusData = 0;
}
}


// Close the database connection
$connection->close();

// Output the status data in JSON format
header('Content-Type: application/json');
//echo json_encode($statusData);
echo json_encode($statusData);
?>


