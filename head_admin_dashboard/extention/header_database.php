<?php




 $teacher_id= $_SESSION['admin'];


$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name=$row['name'];
}





//////////// number of pending project///////////////////

$query = "SELECT COUNT(*) AS group_count1 FROM $session WHERE approved_by_faculty = '0' AND approved_by_faculty REGEXP '^[0-9]+$'";
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

$query = "SELECT COUNT(*) AS status_count2 FROM $session WHERE status='complete' ";

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

    $query_active = "SELECT COUNT(*) AS group_count2 FROM $session WHERE  approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status='approved'";

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