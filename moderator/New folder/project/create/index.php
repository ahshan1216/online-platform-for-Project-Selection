<?php
include '../../../database.php';

// Start session
session_start();


$group_number = ''; 
$user_group_number= '';
$user_listening = 0;
$student_id_rex='';


//$student_id = 41220100054;
//$student_id = 1290;

$role=$_SESSION['role'] ;
if (!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])) {
    // Redirect the user to the login page
    header("Location: ../../../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
}

if($role=='student')
{
     $student_id = $_SESSION['student_id'];
}
   else
   {
    header("Location: ../../../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
   }

 include '../../extention/header_database.php';

$status_user_project = '0';
$listening ='';
$listening_user = '';
////////////// Fatching USer Information///////////////////
$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $student_name = $row['name'];
    $student_id_rex=1;
   
}
////////////// Fatching USer Information END///////////////////

////////////// Fatching Group Leader Information///////////////////
$query = "SELECT * FROM project_students WHERE student_id = '$student_id' AND status = 1 AND group_leader=1";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $group_number = $row['group_number'];
    $status = $row['status'];
    
    $project_approve= $row['project_approval'];
    
    
}
else
{
    //echo 'create group';
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
    $user_group_number=0;
    
}


///////////header section////////////

      //////////// number of active project name///////////////////
$query_active_p = "SELECT * FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty = '0' AND  approved_by_faculty REGEXP '^[0-9]+$' ORDER BY id DESC ";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);





$num_approved_projects=0;
  


////// header section end////




////////////// Fatching Group Leader Information END///////////////////

//////////////////Header Initialize Start ////////////////////////////

$num_approved_projects=0;
$num_complete_projects=0;
$num_active_projects=0;
$num_pending_projects=0;
$approved_by_faculty= 'NULL';
/////////////////Header Initialize  END ////////////////////////////

//////////////////GROUP MEMBER ADDING LOGIC ////////////////////////////
if (isset($_POST['groupMember']) && !in_array($student_id, $_POST['groupMember'])) {

   
    $groupMemberExist = false; // Initialize variable to track if a group member exists
    $sql0 = "SET foreign_key_checks = 0";
    $result0 = mysqli_query($connection, $sql0);

    // Check if any group member already exists
    foreach ($_POST['groupMember'] as $groupMember) {
        
        $checkQuery = "SELECT * FROM project_students WHERE student_id = '$groupMember' AND status = 1 ";
        $checkResult = mysqli_query($connection, $checkQuery);
        if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // Group member already exists
            $groupMemberExist = true;
            break; // Stop checking further
        }
        else 
        {
//////Already Send  A Request//////////
           // $groupMemberExist = false;
           $checkQuery = "SELECT * FROM project_students WHERE student_id = '$groupMember' AND status = 0  AND request = '$group_number'";

           $checkResult = mysqli_query($connection, $checkQuery);
           if ($checkResult && mysqli_num_rows($checkResult) > 0) {
            // Group member already exists
           // $groupMemberExist = true;
            $groupMember_req = true;
            break; // Stop checking further
        }
        else
        {
$groupMemberExist = false;
        }


        }


    }

    // If a group member exists, show the popup
    if ($groupMemberExist || $groupMember_req ) {
        
        
    } 
    
    else if ( !$group_number && $groupMember != $student_id ) {
        $insertGroupMemberQuery1 = "INSERT INTO project_students (student_id,session,status,group_leader,request) VALUES ('$student_id','$session',1,1,-1)";
         $insertResult1 = mysqli_query($connection, $insertGroupMemberQuery1);
         

    $query12 = "SELECT * FROM project_students WHERE student_id = '$student_id' AND status = 1 ";
    $result12 = mysqli_query($connection, $query12);

if ($result12 && mysqli_num_rows($result12) > 0) {
    $row = mysqli_fetch_assoc($result12);
    $group_number1 = $row['group_number'];
    
    
}

        // Insert group members into the database
        foreach ($_POST['groupMember'] as $groupMember) {
            $insertGroupMemberQuery = "INSERT INTO project_students (student_id,group_number,session,request) VALUES ('$groupMember',0,'$session','$group_number1')";
            $insertResult = mysqli_query($connection, $insertGroupMemberQuery);
            if (!$insertResult) {
                echo "Error: " . mysqli_error($connection);
                exit(); // Exit if insertion fails
            }
        }
        $sql11= "UPDATE project_students  SET listening = '$group_number1' WHERE student_id = '$student_id'";
                $sql11result = mysqli_query($connection,  $sql11);


        // Redirect to the same page after successful submission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    else 
    {
        // Insert group members into the database
        foreach ($_POST['groupMember'] as $groupMember) {
            $insertGroupMemberQuery = "INSERT INTO project_students (student_id, group_number,session,request) VALUES ('$groupMember', 0,'$session','$group_number')";
            $insertResult = mysqli_query($connection, $insertGroupMemberQuery);
            if (!$insertResult) {
                echo "Error: " . mysqli_error($connection);
                exit(); // Exit if insertion fails
            }
        }
        // Redirect to the same page after successful submission
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
    

}

else if (isset($_POST['groupMember'])  == $student_id) {
    // Output JavaScript to show Bootstrap modal
    $ownid=1;
}
else{
    $ownid=0;
}
//////////////////GROUP MEMBER ADDING LOGIC END ////////////////////////////


/////////////////Group Leader info/////

$query55 = "SELECT * FROM project_students WHERE group_number= '$group_number' AND !group_number= 0";
$result55 = mysqli_query($connection, $query55);

$query56 = "SELECT * FROM project_students WHERE group_number= '$user_group_number' AND group_leader = 1";
$result56 = mysqli_query($connection, $query56);

if ($result55 && mysqli_num_rows($result55) > 0) {
    $row = mysqli_fetch_assoc($result55);
    
    $group_leader_name= $row['student_id'];
    $project_approve = $row['project_approval'];
    
}
else if ($result56 && mysqli_num_rows($result56) > 0)
{
    $row = mysqli_fetch_assoc($result56);
     $group_leader_name= $row['student_id'];
     $group_number = $user_group_number;
     $project_approve = $row['project_approval'];

     $student_id_rex= 0;
}

else{
    $group_leader_name= null;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
    <title>
        Project Selection
    </title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="../../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="../../assets/js/fontawesome.js" crossorigin="anonymous"></script>
    <link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="../../assets/css/soft-ui-dashboard.min.css?v=1.0.7" rel="stylesheet" />
    <!--link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"-->
    <style>
    .group_number {
        padding-left: 20px !important;
    }

    .btn-primary,
    .btn-danger {
        margin-right: 5px; /* Adjust margin between buttons */
    }
</style>
<script src="https://cdn.tiny.cloud/1/orccd5z7nttpvptq1wacy2kglnlsea2e0401kzegdw17lu25/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#projectDescription',
            plugins: 'lists', // Enable lists plugin for bullet points
            toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent',
            menubar: false,
            branding: false
        });
    </script>
</head>

<body class="g-sidenav-show  bg-gray-100">

    <?php include 'nev.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Create Project</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                        <?php include '../../extention/profile_thumbnail.php'; ?>
                        <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid py-4">
            <div class="row">
            <?php include '../../extention/header.php'; ?>

                <div class="row my-4">
                    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-7">  
                                    <?php
                            if(!$user_group_number)
                            {
                            ?>                     
                                        <h6>Create Group First</h6>
                                        <?php
                            }
                            else{
                                
                            ?>
                            <h6>Project Information</h6>
                            <?php
                            }
                            ?>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="card-body px-0 pb-2 ">
                            <?php
                            if($user_group_number)
                            {
                            ?>
                                                        <div class="table-responsive card-header " >
                                                        <form id="projectForm">
        <div class="mb-3">
            <label for="projectName" class="form-label">Project Name</label>
            <input type="text" class="form-control" id="projectName" name="projectName">
        </div>
        <div class="mb-3">
            <label for="projectDescription" class="form-label">Project Description</label>
            <!-- Textarea for project description -->
            <textarea id="projectDescription" name="projectDescription"></textarea>
        </div>
        <button type="button" class="btn btn-success" onclick="submitProject()">Submit</button>
    </form>
                                                        </div>
                                                        <?php
                                                            }
                                                        ?>

                                                        
                                                        <div class="table-responsive card-header">
                                                        <?php
                                                            if( $student_id_rex )
                                                            {
                                                        ?>
                                                            <form id="projectForm" method="post" action=" ">
                                                            <div class="mb-3 ">
                                                                    <p >Group Members Adding Section:</p>
                                                                    <div id="groupMembers">
                                                                        <!-- Group Leader input -->
                                                                        <div class="mb-2">
                                                                           <label for="groupLeader" class="form-label">Your ID: <?php echo $student_id ?>, <?php echo $student_name ?></label>
                                                                        </div>
                                                                    </div>
                                                                    <button type="button" class="btn btn-primary" id="addGroupMember">Add Group Member</button>
                                                                </div>
                                                                <button type="submit" class="btn btn-success">Submit</button>
                                                            </form>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                            </div>
                            </div>
                                                    
                   <br>
                        <div class="card">
                            <div class="card-header pb-0">
                                
                                    <div class="col-lg-6 col-7">
                                       Group Leader Request: 
                                    </div>
                                    <div class="card-body px-0 pb-2 ">
                                    <div class="table-responsive card-header " >
                                    
                                    <?php

// Assuming $student_id and $status are already defined
$queryy = "SELECT student_id, status, request FROM project_students WHERE status = 1 AND group_leader = 1 AND student_id = '$student_id'";
$resultt = mysqli_query($connection, $queryy);


    // Check if any rows are returned
    if ($resultt && mysqli_num_rows($resultt) > 0) {
        // Iterate through each row
        while ($row = mysqli_fetch_assoc($resultt)) {
            $student_id_check = $row['student_id'];
           // $status = $row['status'];
           // $request = $row['request'];

            // Perform operations with fetched data
            //echo "Student ID: $student_id, Status: $status, Request: $request <br>";
        }
    }

else
{
    $student_id_check = $student_id;
}

// Query to retrieve student IDs and other relevant data from project_students table
$query = "SELECT student_id, status, request FROM project_students WHERE student_id = '$student_id_check' AND status = 0 AND group_leader= 0 ";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    echo '<div class="table-responsive card-header">';
    echo '<table class="table">';
    echo '<thead>';
    echo '<tr>';
    
    echo '<th >Request Group Number</th>';
    echo '<th>Action</th>'; // New column for action buttons
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    // Display each row of data
    while ($row = mysqli_fetch_assoc($result)) {
        $studentId = $row['student_id'];
        $request = $row['request'];

        // Output the data in table rows
        echo '<tr>';
       
        echo '<td style="padding-left: 100px;">' . $request . '</td>';

        echo '<td>';
        // Action buttons
        echo "<button class='btn btn-primary mr-1' onclick=\"showAcceptModal('$studentId','$request')\">Accept</button>"; // Added margin
        echo "<button class='btn btn-danger' onclick=\"showDeclineModal('$studentId', '$request')\">Decline</button>";
        echo '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
    // After displaying the data, delete records where student_id=$student_id AND status = 0
    $queryyy = "SELECT * FROM project_students WHERE student_id = '$student_id_check' AND status = 1 AND request = -1 ";
    $resultyy = mysqli_query($connection, $queryyy);
    
    if ($resultyy && mysqli_num_rows($resultyy) > 0) {



   $delete_query = "DELETE FROM project_students WHERE student_id = '$student_id' AND status = 0 ";
   mysqli_query($connection, $delete_query);
    // If no matching records found
    echo 'No records found.';

    echo "<script>window.location.reload();</script>";

    }
    else
    {
        //echo 'hoi kina';
        
    }
    

} else {
  

    echo 'No records found.';


}

?>

<!-- Modal for Accept -->
<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="acceptModalLabel">Join Group Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to join this group?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-primary" id="joinGroupBtn" >Yes</button>
            </div>
        </div>
    </div>
</div>








<!-- Modal for Decline -->
<div class="modal fade" id="declineModal" tabindex="-1" role="dialog" aria-labelledby="declineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="declineModalLabel">Decline Group Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to decline this group?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" onclick="deleteStudent()">Yes</button>
            </div>
        </div>
    </div>
</div>



<script>
    // Function to show the Accept modal
    function showAcceptModal(studentId, request) {
        // Show the modal
        $('#acceptModal').modal('show');

        // Add event listener to the Yes button
        $('#joinGroupBtn').off().click(function() {
            var confirmation = prompt("Please type CONFIRM to proceed with joining:");

            if (confirmation && confirmation.toUpperCase() === "CONFIRM") {
                // If user confirms with "CONFIRM", proceed with joining the group
                $.ajax({
                    url: 'join_group.php',
                    type: 'POST',
                    data: { studentId: studentId, request: request },
                    success: function(response) {
                        // Handle success response as needed
                       // alert(response.message);
                        $('#acceptModal').modal('hide');
                        window.location.reload(); // Reload the page
                    },
                    error: function(xhr, status, error) {
                        // Handle error response as needed
                        //alert("An error occurred: " + error);
                    }
                });
            } else {
                // If user cancels or enters incorrect confirmation, do nothing
                alert("Joining canceled.");
            }
        });
    }
</script>


<script>
    // Function to show the Decline modal
    function showDeclineModal(studentId, request) {
        $('#declineModal').modal('show');
        // Store studentId and request in data attributes of the modal for use in delete function
        $('#declineModal').data('studentId', studentId);
        $('#declineModal').data('request', request);
    }

    // Function to delete student record
    function deleteStudent() {
        var studentId = $('#declineModal').data('studentId');
        var request = $('#declineModal').data('request');
        $.ajax({
            url: 'delete_student.php',
            method: 'POST',
            data: {studentId: studentId, request: request},
            success: function(response) {
                // Handle success response if needed
                console.log('Student deleted successfully.');
                window.location.reload();
                // Close the modal after successful deletion
                $('#declineModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle error response if needed
                console.error('Error deleting student:', error);
            }
        });
    }
</script>


                                   
                                   
                                    </div>
                                    </div>
                                    </div>
                                    
                                    </div>
                    </div>
                   

                    



                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                        <div class="card-header pb-0">
                            <?php
                            if($approved_by_faculty == 'NULL')
                            {

                            ?>



                            <?php
                            if(!$group_number)
                            {
                            ?>
                                
                            <?php
                            }
                            else

                            {

                            ?>
<h6>Please Create a New Project</h6>

<?php
                            }
                            ?>





                            <?php
                            
                            
                            }
                            else if($approved_by_faculty == '1')
                            {

                            
                            ?>
                            <h6>Project Approval Pending</h6>

                            <?php
                            }

                            
                            else
                            {
                            ?>
                            <h6>Your Project Approved By <?php echo $approved_by_faculty ?> </h6>

                            <?php
                            }

                            ?>
                            





                            </div>
                            <div class="card-header pb-0">
                                <h6>My Group Members: </h6>
                                <span>Group Number :<?php   echo $group_number ?> <span><br>
                                <span>Group Leader :<?php   echo $group_leader_name ?> <span>
                            </div>
                            <div class="card-body p-3">
                                <div class=" timeline-one-side">
                                    <div class="  mb-3">
                                        <span class=" ">
                                            <i class="ni  text-success text-gradient"></i>
                                        </span>
                                        <div class=" ">
                                            <?php
                                            if($user_group_number)
                                            {

                                            ?>
                                        <!-- My group member section goes here -->
                                        <?php

//////////////Ami jokhon Group ke accept korbo tokhon Group ar sob list show korbe and niche leave thakbe//////////////
//echo 'bbb';
$requestQuery2 = "SELECT * FROM project_students WHERE  request= '$group_number' || (group_number='$group_number' AND group_leader=0 AND request=0)";
$requestResult2 = mysqli_query($connection, $requestQuery2);
$totalRows = mysqli_num_rows($requestResult2);

if ($requestResult2 && mysqli_num_rows($requestResult2) > 0) 
{

    // Initialize a variable to count the total rows
    


    // Display each student ID
    while ($row = mysqli_fetch_assoc($requestResult2)) {
        $studentId = $row['student_id'];
        $status = $row['status'];
        $project_approve  = $row['project_approval'];
//echo'h';
        // Check if the status is pending or accepted
        $statusLabel = $status == 0 ? "Pending" : "Accepted";
        echo "<p>Student ID: $studentId - Status: $statusLabel <br>";
        echo "<button class='btn btn-primary' onclick='showUserInfo($studentId, $status,$group_number,$project_approve,$is_user_group_leader)'>View Details</button></p>";
    }


// Debugging: Check the acceptedStudents array before the second loop
//echo 'ggdffdgdfgdfgg';
if ($status_user_project ==  1 && $is_user_group_leader ==0 && $project_approve == 0) {
    // Output note
 echo "<p>Note: Once you accept the group request, all functions will be turned off for you. Only the group leader can control you. Before project approval, you may leave the group or join others.</p>";
 
 // Output "Leave Group" button
 echo "<button class='btn btn-primary' onclick='leaveGroup($student_id)'>Leave Group</button>";
 
 // JavaScript function to handle leaving the group
 echo "<script>
 function leaveGroup(studentId) {
     if (confirm('Are you sure you want to leave the group?')) {
         // Send AJAX request to delete the student's record
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
             if (this.readyState == 4 && this.status == 200) {
                 // Reload the page after successful deletion
                 window.location.reload();
             }
         };
         xhttp.open('GET', 'leave_group.php?student_id=' + studentId, true);
         xhttp.send();
     }
 }
 </script>";
 
 
 }


}
else
{
    
    $deleteQuery = "DELETE FROM project_students WHERE student_id = '$group_leader_name' AND group_number = '$group_number'";
    if(mysqli_query($connection, $deleteQuery)) {
        $affectedRows = mysqli_affected_rows($connection);
            if ($affectedRows > 0) {
                // If deletion is successful, refresh the window
                echo "<script>window.location.reload();</script>";
            }
        

    }

}

//////////////Ami jokhon Group ke accept korbo tokhon Group ar sob list show korbe and niche leave thakbe ENDDDDDDDD//////////////


?>

<?php
                                            }
                                            else{
                                                echo 'No Request Found';
                                            }
?>


<!-- Modal -->
<div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="userInfoBody">
        <!-- User information will be displayed here -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="deleteUserBtn">Delete</button>
      </div>
    </div>
  </div>
</div>






                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="footer pt-3  ">
                    <div class="container-fluid">
                        <div class="row align-items-center justify-content-lg-between">
                            <div class="col-lg-6 mb-lg-0 mb-4">
                                <div class="copyright text-center text-sm text-muted text-lg-start">
                                    made with <i class="fa fa-heart"></i> by
                                    <a href="../contact_us/" class="font-weight-bold" target="_blank">Group 1,4</a>
                                    for a better web.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>

    </main>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <script src="assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
    const addGroupMemberBtn = document.getElementById('addGroupMember');
    const groupMembersContainer = document.getElementById('groupMembers');

    addGroupMemberBtn.addEventListener('click', function() {
        // Create input fields for new group member
        const newGroupMemberInput = document.createElement('div');
        newGroupMemberInput.classList.add('mb-2');
        newGroupMemberInput.innerHTML = `
            <input type="number" class="form-control" name="groupMember[]" placeholder="Enter Student ID " required >
            <button type="button" class="btn btn-danger remove-group-member">Remove</button>
            
        `;
        groupMembersContainer.appendChild(newGroupMemberInput);
    });

    // Remove group member input field
    groupMembersContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-group-member')) {
            event.target.parentElement.remove();
        }
    });
});

</script>


<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Bootstrap JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Modal HTML structure -->
<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Group Member Exists</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                One or more group members are already in a group.
            </div>
            <div class="modal-body">
           Note: If You Create a Problem , Please Add Single By Single
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to show modal -->


<!-- Bootstrap modal OWN ID -->
<div class="modal fade" id="ownid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Error</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                Own ID cannot send a request. Please try another ID.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Success Modal success -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Success!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Your project has been submitted successfully.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap dup Modal  -->
<!-- Bootstrap Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="errorModalBody">
                This Project Is Already Exist
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal HTML structure -->
<div id="myModalreq" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Already Send a Request</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            You have already sent a request. Please be patient while waiting for your request to be accepted
            </div>

            <div class="modal-body">
           Note: If You Create a Problem , Please Add Single By Single
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to show modal -->

<script>
    $(document).ready(function(){
        <?php if ($ownid): ?>
            $('#ownid').modal('show');
        <?php endif; ?>
    });
    
</script>



<script>
    $(document).ready(function(){
        <?php if ($groupMemberExist): ?>
            $('#myModal').modal('show');
        <?php endif; ?>
    });
</script>

<script>
    $(document).ready(function(){
        <?php if ($groupMember_req): ?>
            $('#myModalreq').modal('show');
        <?php endif; ?>
    });
</script>

<script>
    // Function to handle delete button click event
    function handleDeleteButtonClick(studentId, groupNumber) {
    console.log("Delete button clicked for student ID: ", studentId);
    console.log("Group number: ", groupNumber);
    
    // Show confirmation dialog
    if (confirm("Are you sure you want to delete this student?")) {
        var confirmation = prompt("Please type CONFIRM to proceed with deletion:");
        if (confirmation === "CONFIRM") {
            // Send AJAX request to delete student
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState === 4 && this.status === 200) {
                    // Reload the page after successful deletion
                    location.reload();
                }
            };
            // Pass both student ID and group number as query parameters
            xhttp.open("GET", "delete_student.php?student_id=" + studentId + "&group_number=" + groupNumber, true);
            xhttp.send();
        } else {
            alert("Deletion canceled.");
        }
    }
}


</script>
<?php


?>
<script>
function showUserInfo(studentId, status,group_number,project_approve,is_user_group_leader) {
    // Fetch user information from the database using AJAX
    $.ajax({
        url: 'fetch_user_info.php',
        type: 'GET',
        data: { studentId: studentId },
        success: function(response) {
            // Display user information in the modal body
            $('#userInfoBody').html(response);

            // Determine whether to show the delete button
            if (project_approve == 0 && is_user_group_leader == 1) {
                $('#deleteUserBtn').show();
                // Add click event listener to the delete button
                $('#deleteUserBtn').click(function() {
                    // Show confirmation prompt
                    var confirmation = prompt("Please type CONFIRM to proceed with deletion:");
                    if (confirmation === "CONFIRM") {
                        // Perform delete operation using AJAX
                        $.ajax({
    url: 'delete_user.php',
    type: 'POST',
    data: { studentId: studentId, group_number: group_number },
    success: function(response) {
        // Parse JSON response
        var jsonResponse = JSON.parse(response);
        
        // Check if deletion was successful
        if (jsonResponse.success) {
            // If deletion is successful, display success message
            alert(jsonResponse.message);
            // Close the modal or update UI as needed
            $('#userInfoModal').modal('hide');
            // Reload the page or update UI as needed
             window.location.reload(); 
        } else {
            // If deletion failed, display error message
            alert(jsonResponse.message);
        }
    },
    error: function(xhr, status, error) {
        // Handle AJAX error
        console.error("AJAX Error: " + status + " - " + error);
    }
});
                    } else {
                        // User canceled deletion
                        alert("Deletion canceled.");
                    }
                });
            } else {
                $('#deleteUserBtn').hide();
            }

            // Show the modal
            $('#userInfoModal').modal('show');
        }
       
    });
}
</script>


<script>
    function submitProject() {
        // Get project name and description from the form
        var projectName = $("#projectName").val();
        var projectDescription = tinymce.get('projectDescription').getContent(); // Retrieve content from TinyMCE
        // Check if project name and description are not empty
        if (projectName.trim() == "" || projectDescription.trim() == "") {
            alert("Please fill in all fields.");
            return;
        }

        // Get session data
        var studentId = "<?php echo $_SESSION['student_id']; ?>";
        var session = "<?php echo $session ?>";
        var group_number = "<?php echo $group_number ?>";

        // You can include more session data as needed

        // AJAX request to submit.php
        $.ajax({
            url: "submit.php",
            method: "POST",
            data: {
                projectName: projectName,
                projectDescription: projectDescription,
                studentId: studentId,
                session:  session,
                group_number: group_number// Include session data
                // You can include more session data as needed
            },
            success: function(response) {
            // Check if response contains 'success' message
            if (response.indexOf('success') !== -1) {
                // Show success modal
                $('#successModal').modal('show');
                // Reload the page after a short delay
                setTimeout(function() {
                    window.location.reload();
                }, 2000); // Reload after 2 seconds (adjust as needed)
            } else {
                // Show error modal with extracted error message
                var errorMessage = response.match(/Duplicate entry '(.*)' for key 'project_name'/)[1];
                $('#errorModalBody').text("The project '" + errorMessage + "' already exists."); // Update modal body text
                $('#errorModal').modal('show'); // Show error modal
            }
        },
        error: function(xhr, status, error) {
            // Display error modal with error message
            var errorMessage = xhr.responseText;
            $('#errorModalBody').text(errorMessage); // Update modal body text
            $('#errorModal').modal('show'); // Show error modal
        }
        });
    }
</script>




</body>

</html>
