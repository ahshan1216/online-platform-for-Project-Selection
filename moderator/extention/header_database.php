<?php




 $student_id= $_SESSION['super_admin'];


$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
}






//////////// number of pending project///////////////////

$query = "SELECT COUNT(*) AS group_count1 FROM users WHERE verify = '0' AND role NOT IN ('admin', 'super_admin','master_admin')";

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




    //////////// number of active project///////////////////

    $query_active = "SELECT COUNT(*) AS group_count2 FROM users WHERE verify = '1' AND role NOT IN ('admin', 'super_admin','master_admin') ";

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