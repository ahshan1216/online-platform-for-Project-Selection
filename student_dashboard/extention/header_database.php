<?php




 $student_id= $_SESSION['student_id'];


$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
}




/////////Finding project_students information///////////




$queryi = "SELECT * FROM project_students WHERE student_id = '$student_id'";
$resulti = mysqli_query($connection, $queryi);

if ($resulti && mysqli_num_rows($resulti) > 0) {
    $row = mysqli_fetch_assoc($resulti);
   
    $status_user_project = $row['status'];
    $listening_user = $row['listening'];
    $user_group_number=  $row['group_number'];
    $is_user_group_leader =  $row['group_leader'];
    $user_listening = $row['listening'];
    $user_request = $row['request'];
    
   
}
else
{
    $is_user_group_leader= '';
    $user_group_number = '';
    $approved_by_faculty = '';
}



//////////// number of pending project///////////////////

$query = "SELECT COUNT(*) AS group_count1 FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty = '0' AND approved_by_faculty REGEXP '^[0-9]+$'";
// Perform the query
$result = mysqli_query($connection, $query);
if ($result) {
  // Fetch the result row
    $row = mysqli_fetch_assoc($result);
    // Extract the group count
    $groupCount1 = $row['group_count1'];
   
} else {
    // Handle query error
    $groupCount1=0;

    }


//////////// number of complete project///////////////////

$query = "SELECT COUNT(*) AS status_count2 FROM $session WHERE group_number = '$user_group_number' AND status='complete' AND approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' ";

// Perform the query
$result = mysqli_query($connection, $query);
if ($result) {
  // Fetch the result row
    $row = mysqli_fetch_assoc($result);
    // Extract the group count
    $statusCount = $row['status_count2'];
   
} else {
    // Handle query error
    $statusCount=0;

    }

    //////////// number of active project///////////////////

    $query_active = "SELECT COUNT(*) AS group_count2 FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status='approved'";

    // Perform the query
    $result_active = mysqli_query($connection, $query_active);
    if ($result_active) {
      // Fetch the result row
        $row = mysqli_fetch_assoc($result_active);
        // Extract the group count
        $groupCount2 = $row['group_count2'];
       
    } else {
        // Handle query error
        $groupCount2=0;
    
        }


?>