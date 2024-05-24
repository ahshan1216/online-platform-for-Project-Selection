<?php
// Include database connection file
include '../../../database.php';
session_start();

$teacher_id = $_SESSION['teacher_id'];

////////////// Fetching Teacher Information///////////////////
$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name = $row['name'];
}

// Map class time to numeric value
$classTimeMapping = array(
    'Monday' => 1,
    'Tuesday' => 2,
    'Wednesday' => 3,
    'Thursday' => 4,
    'Friday' => 5,
    'Saturday' => 6,
    'Sunday' => 7
);

// Check if the startingDate, endingDate, and classTime parameters are set
if (isset($_POST['startingDate'], $_POST['endingDate'], $_POST['classTime'])) {
    // Retrieve the starting date, ending date, and class time from the POST data
    $startingDate = $_POST['startingDate'];
    $endingDate = $_POST['endingDate'];
    $classTime = $_POST['classTime'];
   

    // Validate if the provided class time is within the mapping array
    if (isset($classTimeMapping[$classTime])) {
        // If it exists, retrieve its corresponding numeric value
        $classTimeNumeric = $classTimeMapping[$classTime];
        
        // Check if the record ID is provided for updating
        if (isset($_POST['recordID'])) {
            // Update existing record
            $recordID = $_POST['recordID'];
            $sql = "UPDATE time SET starting_date='$startingDate', ending_date='$endingDate', class_date='$classTimeNumeric', teacher_name='$name' ,session='$session' WHERE id='$recordID'";
        } else {
            // Insert new record
           $sql = "INSERT INTO time (starting_date, ending_date, class_date, teacher_name,session) VALUES ('$startingDate', '$endingDate', '$classTimeNumeric', '$name','$session')";
        }

        // Execute the query
        if ($connection->query($sql) === TRUE) {
            
        } else {
            echo "Error: " . $recordID;
        }

    } else {
        // Handle the case where the provided class time is not found in the mapping array
        echo "Invalid class time provided";
    }
















    $query = "SELECT * FROM time WHERE teacher_name = '$name' AND session= '$session'";
    $result = mysqli_query($connection, $query);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    
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
        echo '<tr class="edit-date date-cell">';
        echo '<td>' . $y . '</td>'; // Display day number
        echo '<td class="date date-cell">' . $currentDate->format('d-m-Y') . '</td>';
        echo '</tr>';
        $y = $y + 1;
    }
}
$duration=$y-1;
$queryyyyyy = "SELECT * FROM project_management WHERE session = '$session'";
$resultyyyyy = mysqli_query($connection, $queryyyyyy);

if ($resultyyyyy && mysqli_num_rows($resultyyyyy) > 0) {
    $queryUpdate = "UPDATE project_management SET duration = '$duration' WHERE session = '$session'";
   $resultupdate= mysqli_query($connection, $queryUpdate);
   if($resultupdate)
   {}
   else{}
}

$querytp = "SELECT project_id, SUM(perday) AS total_perday FROM project_management GROUP BY project_id";
$resulttp = mysqli_query($connection, $querytp);

if ($resulttp && mysqli_num_rows($resulttp) > 0) {
    while ($row = mysqli_fetch_assoc($resulttp)) {
        $projectid = $row['project_id'];
        $totalPerday = $row['total_perday'];
        
        // Update the '$session' table with the calculated sum for each project_id
        $queryUpdate = "UPDATE $session SET progress = '$totalPerday' WHERE id = '$projectid'";
        mysqli_query($connection, $queryUpdate);
    }
}



} else {
    // Handle the case where startingDate, endingDate, or classTime parameters are not set
    echo "Starting date, ending date, or class time not provided";
}

// Close database connection
$connection->close();
?>

