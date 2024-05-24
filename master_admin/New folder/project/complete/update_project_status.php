<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();
$student_id = $_SESSION['student_id'];

$queryn = "SELECT * FROM users WHERE student_id = '$student_id'";
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
    $description = $_POST['description'];
  
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
         $query = "UPDATE $sessioncomplete SET comment = '$comment',who_c='$name', description='$description' WHERE project_id = '$projectid' ";
         $result = mysqli_query($connection, $query);
 
         $delete= "DELETE t1 FROM summer24complete t1
         INNER JOIN summer24complete t2 ON 
             t1.project_id = t2.project_id AND 
             t1.description = t2.description AND 
             t1.comment = t2.comment AND 
             t1.who_c = t2.who_c
         WHERE 
             t1.id > t2.id OR 
             (t1.comment = '' AND t2.comment = '');
         " ;
         $delete_result=  mysqli_query($connection, $delete);
 
 }
 else
 {
     $queryyy = "INSERT INTO $sessioncomplete (who_c,comment, project_id,description) VALUES ('$name' ,'$comment','$projectid','$description')";
     $resultyy = mysqli_query($connection, $queryyy);

     $query = "UPDATE $sessioncomplete SET description='$description' WHERE project_id = '$projectid' ";
     $result = mysqli_query($connection, $query);

     $delete= "DELETE t1 FROM summer24complete t1
     INNER JOIN summer24complete t2 ON 
         t1.project_id = t2.project_id AND 
         t1.description = t2.description AND 
         t1.comment = t2.comment AND 
         t1.who_c = t2.who_c
     WHERE 
         t1.id > t2.id OR 
         (t1.comment = '' AND t2.comment = '');
     " ;
     $delete_result=  mysqli_query($connection, $delete);
 
 }




  
    
} else {
    // Return error response if request method is not POST
    echo 'Error: Invalid request method.';
}
?>
