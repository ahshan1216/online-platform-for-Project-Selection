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
        

    }
$present_table= $session . 'present';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && !empty($_POST['action'])) {
        $action = $_POST['action'];
        $studentId = $_POST['studentId'];
        $date = $_POST['date'];
        $studentName = $_POST['onlyName'];

        // Handle 'insert' action
        if ($action === 'insert') {
            $sql1 = "INSERT INTO $present_table (roll,name,date,status) VALUES ('$studentId','$studentName','$date','present')";
            $result1 = $connection->query($sql1);
            echo 'Data inserted successfully.';
        }
        // Handle 'delete' action
        elseif ($action === 'delete') {
            // Perform database deletion here
             $sql1="DELETE FROM $present_table WHERE roll = '$studentId' AND date='$date'";
             $result1 = $connection->query($sql1);
            echo 'Data deleted successfully.';
        }
    } else {
        echo 'Error: Action not specified.';
    }
} else {
    echo 'Error: Invalid request.';
}
?>
