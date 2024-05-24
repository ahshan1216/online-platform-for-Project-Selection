<?php

// Start session
session_start();

// Include your database connection file
include '../../../database.php';


//$teacher_id = 41220100054;
//$teacher_id = 1290;

 $teacher_id=$_SESSION['teacher_id'];
 ////////////// Fatching Teacher Information///////////////////
$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];

    
   
}
// Retrieve project ID from the URL parameter
if(isset($_GET['project_id'])) {
    $project_id = $_GET['project_id'];
    

    $sql1 = "SELECT * FROM $session WHERE id = $project_id";
    $result1 = mysqli_query($connection,  $sql1);
    if ($result1 && mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $description = $row['project_description'];
    
        $project = $row['project_name'];
       
    }
    // Placeholder description for demonstration
   
} else {
    // If project ID parameter is not provided, redirect to an error page or homepage
    header("Location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Description</title>
</head>
<body>
    <h1><?php echo $project; ?></h1>
    <p><?php echo $description; ?></p>
</body>
</html>
