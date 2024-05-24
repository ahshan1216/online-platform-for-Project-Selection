<?php

// Include necessary files and start session if needed
include '../../../database.php';

session_start();
$teacher_id = $_SESSION['teacher_id'];


$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);


if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name = $row['name'];
}
    else {
        // Handle case where user data is not found
        $html .= '<tr><td colspan="3">User data not found</td></tr>';

    }
$present_table= $session . 'present';

// Check if studentId is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if studentId, date, and student_name are set
    if (isset($_POST["studentId"]) && isset($_POST["date"]) && isset($_POST["status"])) {
       
    // Get the studentId from POST
    $studentId = $_POST['studentId'];
    $date = $_POST['date'];
    $student_name = $_POST['onlyName'];
    $status = $_POST["status"];

    if($status=='present')
    {
        $sql2 = "SELECT * FROM $present_table where roll='$studentId' and date='$date'";
        $result2 = $connection->query($sql2);
        if($connection->affected_rows > 0)
        {
            $sql1 = "UPDATE $present_table SET status = 'present' WHERE roll = '$studentId' AND date = '$date' AND status = 'absent'";
            $result1 = $connection->query($sql1);
        }
else
{
    
    $sql1 = "INSERT INTO $present_table (roll,name,date,status) VALUES ('$studentId','$student_name','$date','present')";
    $result1 = $connection->query($sql1);
}
     //$sql1 = "INSERT INTO $present_table (roll,name,date,status) VALUES ('$studentId','$student_name','$date','present')";
   // $result1 = $connection->query($sql1);
    }
    else{

        $sql2 = "SELECT * FROM $present_table where roll='$studentId' and date='$date'";
        $result2 = $connection->query($sql2);
        if($connection->affected_rows > 0)
        {
echo 'if' ;
$sql1 = "UPDATE $present_table SET status = 'absent' WHERE roll = '$studentId' AND date = '$date' AND status = 'present'";
$result1 = $connection->query($sql1);
        }
else
{



        $sql1 = "INSERT INTO $present_table (roll,name,date,status) VALUES ('$studentId','$student_name','$date','absent')";
        $result1 = $connection->query($sql1);


}



    }



} else {
    // If studentId is not set, return an error message
    echo "Error: Student ID not provided.";
}

}
?>
