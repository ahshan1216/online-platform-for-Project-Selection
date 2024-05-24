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



$querym = "SELECT * FROM time WHERE teacher_name = '$name' AND session= '$session'";
$resultm = mysqli_query($connection, $querym);

if ($resultm && mysqli_num_rows($resultm) > 0) {
    $row = mysqli_fetch_assoc($resultm);

    $startDate = $row['starting_date']; // Example start date
    $endDate = $row['ending_date']; // Example end date
    $day= $row['class_date'];
   
}
else
{
    $startDate =  ' '; // Example start date
    $endDate =  ' '; // Example end date
    $day= ' ';
}



// Calculate duration based on start and end dates
// Calculate duration based on start and end dates
$startDateTime = new DateTime($startDate);
$endDateTime = new DateTime($endDate);
$interval = $startDateTime->diff($endDateTime);
$duration = $interval->days + 1; // Add 1 to include the end date



$y = 1;
for ($i = 1; $i <= $duration; $i++) {
    $currentDate = clone $startDateTime;
    $currentDate->modify('+' . ($i - 1) . ' days');
    
    // Check if the current day is a Friday
    if ($currentDate->format('N') == $day) { // 5 corresponds to Friday
       
        $y = $y + 1;
    }
}
$duration=$y-1;






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
  


    $queryt = "SELECT * FROM activity WHERE project_id = '$projectid' AND time= '$date' ";
    $resultt = mysqli_query($connection, $queryt);
    if ($resultt && mysqli_num_rows($resultt) > 0) {
   
 
         // Update the project status in the project_management table
         $query = "UPDATE activity SET comment = '$comment' WHERE project_id = '$projectid' AND time= '$date' ";
         $result = mysqli_query($connection, $query);
 
 
 
 }
 else
 {
     $queryyy = "INSERT INTO activity (group_number,teacher_name,comment, project_id,time, session) VALUES ('$groupNumber','$name' ,'$comment','$projectid','$date','$session')";
     $resultyy = mysqli_query($connection, $queryyy);
 
 }









   // Update the project status in the project_management table
   $queryt = "SELECT * FROM project_management WHERE status = '$status' AND project_id = '$projectid' AND time= '$date' ";
   $resultt = mysqli_query($connection, $queryt);
   if ($resultt && mysqli_num_rows($resultt) > 0) {
  

    echo $status;



}
else {

    // Update the project status in the project_management table
    $query = "UPDATE project_management SET status = '$status' WHERE project_id = '$projectid' AND time= '$date' ";
    $result = mysqli_query($connection, $query);

   // Update the project status in the project_management table
  

    if ($result) {
        // Check if any rows were affected by the update operation
        if (mysqli_affected_rows($connection) > 0) {
            // Return success response
            echo $status;
        } else {
            $query = "INSERT INTO project_management (group_number, time, status,project_id,session) VALUES ('$groupNumber', '$date', '$status','$projectid','$session')";
            $result = mysqli_query($connection, $query);
            // No rows were updated
            

            echo $status ;
            
        }
    }
    // Introduce a 2-second delay
    //sleep(2);

    $queryyyyyy = "SELECT * FROM project_management WHERE session = '$session'";
    $resultyyyyy = mysqli_query($connection, $queryyyyyy);
    
    if ($resultyyyyy && mysqli_num_rows($resultyyyyy) > 0) {
        $queryUpdatey = "UPDATE project_management SET duration = '$duration' WHERE session = '$session'";
        mysqli_query($connection, $queryUpdatey);
    }

    $querytp = "SELECT * FROM project_management WHERE project_id = '$projectid'";
    $resulttp = mysqli_query($connection, $querytp);
    if ($resulttp && mysqli_num_rows($resulttp) > 0) {
   
           $querySum = "SELECT SUM(perday) AS total_perday FROM project_management WHERE project_id = '$projectid'";
            $resultSum = mysqli_query($connection, $querySum);
            $rowSum = mysqli_fetch_assoc($resultSum);
            $totalPerday = $rowSum['total_perday'];
            
            // Update the '$session' table with the calculated sum
            $queryUpdate = "UPDATE $session SET progress = '$totalPerday' WHERE id = '$projectid'";
            mysqli_query($connection, $queryUpdate);
           // echo 'total'.$totalPerday;
    }


  
     
}





       
        
        
    
} else {
    // Return error response if request method is not POST
    echo 'Error: Invalid request method.';
}
?>
