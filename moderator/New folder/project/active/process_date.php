<?php
include '../../../database.php';
// Check if the date variable is received
if(isset($_POST['date'])) {
    // Get the date value
    $date = $_POST['date'];
    $projectId = $_POST['projectId'];
    
    // Use the date value as desired
   

    $query = "SELECT * FROM project_management WHERE project_id = '$projectId' AND time='$date'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $status = $row['status'];
        $title = $row['title'];
        $description = $row['description'];
        
    } else {
        $status = 0;
        $title = '';
        $description = '';
       
    }
// Initialize $html variable
$html = '';

if($status == 0 || $status== 'Pending' )
{

    $html .= '<button type="button" class="btn btn-primary" onclick="submitEdit()" >Save changes </button';

}
echo $html;
////echo $date;
//echo $projectId;



















} else {
    echo "Date not received";
}
?>
