<?php
// Include your database connection file
include '../../../database.php';
// Start session
session_start();




//$teacher_id = 41220100054;
//$teacher_id = 1290;

 $teacher_id=$_SESSION['teacher_id'];
 ////////////// Fatching Teacher Information///////////////////
$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name=  $row['name'];

    
   
}
// Check if the request contains project name and status
if(isset($_POST['project']) && isset($_POST['status'])) {
    $projectName = $_POST['project'];
    $status = $_POST['status'];
    $group = $_POST['group'];
    
    // Update the status in the database
    $sql1 = "UPDATE $session SET status = '$status' WHERE project_name = '$projectName'";
    $result1 = $connection->query($sql1);
    
    if($result1) {
                        if( $status == 'approved')
                           {
                            $sql2 = "UPDATE $session SET approved_by_faculty = '$name' WHERE project_name = '$projectName'";
                            $result2 = $connection->query($sql2);
                            $sql3 = "UPDATE project_students SET project_approval = 1 WHERE group_number = '$group'";
                            $result3 = $connection->query($sql3);
                           } 

                           else{
                            $sql2 = "UPDATE $session SET approved_by_faculty = '0' WHERE project_name = '$projectName'";
                            $result2 = $connection->query($sql2);
                            $sql3 = "UPDATE project_students SET project_approval = '0' WHERE group_number = '$group'";
                            $result3 = $connection->query($sql3);
                           }










        // Status updated successfully
        echo json_encode(array("status" => "success"));
    } else {
        // Failed to update status
        echo json_encode(array("status" => "error"));
    }
} else {
    // Invalid request
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}
?>
