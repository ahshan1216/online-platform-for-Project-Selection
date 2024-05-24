<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();
$teacher_id=$_SESSION['teacher_id'];

$queryn = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$resultn = mysqli_query($connection, $queryn);

if ($resultn && mysqli_num_rows($resultn) > 0) {
    $rown = mysqli_fetch_assoc($resultn);
    //$session = $rown['session'];
    $name= $rown['name'];
    $session= $rown['session'];

    
   
}

$sessioncomplete = $session . 'complete';
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve data from the AJAX request
    $groupNumber = $_POST['groupNumber'];
    $status = $_POST['status'];
    $comment = $_POST['comment'];
   // $studentPresent = $_POST['studentPresent'];
    $date = $_POST['date'];
    $projectid = $_POST['projectid'];
    $session = $_POST['session'];
  
    $query = "SELECT * FROM $sessioncomplete WHERE project_id = '$projectid'";
    $result = mysqli_query($connection, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        //$session = $rown['session'];
        $des= $row['description'];
        
    
        
       
    }

    $queryt = "SELECT * FROM $sessioncomplete WHERE project_id = '$projectid' AND who_c='Automated' ";
    $resultt = mysqli_query($connection, $queryt);
    if ($resultt && mysqli_num_rows($resultt) > 0) {
   
 
         // Update the project status in the project_management table
         $query = "UPDATE $sessioncomplete SET comment = '$comment',who_c='$name' WHERE project_id = '$projectid' ";
         $result = mysqli_query($connection, $query);
 
 
 
 }
 else
 {
     $queryyy = "INSERT INTO $sessioncomplete (who_c,comment, project_id,description) VALUES ('$name' ,'$comment','$projectid','$des')";
     $resultyy = mysqli_query($connection, $queryyy);
 
 }




  
    
} else {
    // Return error response if request method is not POST
    echo 'Error: Invalid request method.';
}
?>
