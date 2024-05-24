<?php
// Assuming you have already established a database connection
include '../database.php';
// Fetch image URLs based on the studentId and teacherId passed via GET parameters
$studentId = $_GET['studentId'];
$teacherId = $_GET['teacherId'];

// Query to fetch image URLs from the database based on studentId and teacherId
// Replace 'users' with your actual table name where the image URLs are stored
if($studentId=='0')
{
$sql = "SELECT * FROM users WHERE teacher_id = $teacherId";
$result = mysqli_query($connection, $sql);
}
else
{
    $sql = "SELECT * FROM users WHERE student_id = $studentId";
$result = mysqli_query($connection, $sql);
}
$response = [];
// Check if the query was successful
// Check if the query was successful
if ($result) {
    // Fetch the row
    $row = mysqli_fetch_assoc($result);
    // Prepare response data as JSON
    if($studentId=='0')
{
    $response = [
        'profilePictureUrl' => '/uploads/teachers/' . $row['profile_picture'],
        'idCardPictureUrl' => '/uploads/teachers/' . $row['id_photo'],
        'session' =>'Session: '. $row['session'],
        'name' =>'Name: '. $row['name'],
        'id' =>$row['id']
    ];
}
else
{
    $response = [
        'profilePictureUrl' => '/uploads/students/' . $row['profile_picture'],
        'idCardPictureUrl' => '/uploads/students/' . $row['id_photo'],
        'session' =>'Session: '. $row['session'],
        'name' =>'Name: '. $row['name'],
        'id' =>$row['id']
       
    ]; 
}
} else {
    // If the query fails, add an error message to the response
    $response['error'] = 'Failed to fetch image URLs';
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);

// Close the database connection
mysqli_close($connection);
?>
