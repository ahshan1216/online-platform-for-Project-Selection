<?php
// Start session
include '../../../database.php';
session_start();



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

//////////// number of active project name///////////////////
$query_active_p = "SELECT * FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty = '0' AND  approved_by_faculty REGEXP '^[0-9]+$' ORDER BY id DESC ";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);



 $faculty_n= $session . 'faculty';

$num_approved_projects=0;

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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css



" />


<link href="../../assets/css/nucleo-svg.css" rel="stylesheet" />

<link id="pagestyle" href="../../assets/css/soft-ui-dashboard.min.css?v=1.0.7" rel="stylesheet" />
<style>
        .text-success1 {
    color: #FFBF00 !important;
}

.btn-sm {
        padding: 0.25rem 0.5rem; /* Adjust padding to make buttons smaller */
        font-size: 0.75rem; /* Decrease font size to make buttons smaller */
    }
        </style>



<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/orccd5z7nttpvptq1wacy2kglnlsea2e0401kzegdw17lu25/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<style>
    /* CSS */
.readonly {
    background-color: #f8f9fa; /* Light grey background */
    border: 1px solid #ced4da; /* Grey border */
    color: #6c757d; /* Grey text color */
    cursor: not-allowed; /* Change cursor to indicate not editable */
}

    </style>
    <style>
    .project-row:hover {
        background-color: #f2f2f2; /* Change background color on hover */
    }

    .project-row:hover td {
        cursor: pointer; /* Change cursor to pointer on hover */
    }
   

</style>
<!-- Place the first <script> tag in your HTML's <head> -->

<script>
    tinymce.init({
        selector: '#projectDescription',
        height: 300,
        plugins: 'link image code',
        branding:false,
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image | code'
        
    });
</script>
</head>
<body class="g-sidenav-show  bg-gray-100">

<?php
include 'nev.php';
?>





<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
<div class="container-fluid py-1 px-3">
<nav aria-label="breadcrumb">

<h6 class="font-weight-bolder mb-0">Pending Project</h6>
</nav>
<div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
<div class="ms-md-auto pe-md-3 d-flex align-items-center">

  

</div>
<ul class="navbar-nav  justify-content-end">


<?php
include '../../extention/profile_thumbnail.php';
?>


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
<h6><?php echo $groupCount1 ?> Pending Projects</h6>

</div>

</div>
</div>
<div class="card-body px-0 pb-2">
    <div class="table-responsive">
        <table class="table align-items-center mb-0">
            <thead>
                <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
                    <th class="align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    <th class="align-middle text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Creator</th>
                    
                </tr>
            </thead>
            <tbody>
    <?php
    // Check if query is successful
    if ($result_active_p && mysqli_num_rows($result_active_p) > 0) {
        // Loop through each row of the result
        while ($row = mysqli_fetch_assoc($result_active_p)) {
            $projectName = $row['project_name'];
            $progressPercentage = $row['progress']; // Assuming this represents progress percentage
            $approved_by_faculty = $row['approved_by_faculty'];
            $projectDescription = $row['project_description'];
            $project_id = $row['id'];
            $student_project_submit_id=$row['student_id'];
            $head_selected=$row["op_head"];
            $faculty_name=$row["approved_by_faculty"];
            
// Extract the first and last letters of the project name
$firstLetter = substr($projectName, 0, 1);
$lastLetter = substr($projectName, -1);
    ?>

            <tr class="project-row" data-bs-toggle="modal" data-bs-target="#projectModal<?php echo $project_id ?>">
                <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                        <span class="avatar avatar-sm me-1 text-dark">
                        <i class="fa-solid fa-<?php echo strtolower($firstLetter); ?>" style="background-color: pink;"></i>

                        
            </span>
                            
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $projectName ?></h6>
                        </div>
                    </div>
                </td>
                <td class="align-middle">
                    <h6> PENDING </h6>
                </td>
                </td>
                <td class="align-middle">
                    <h6><?php echo $student_project_submit_id ?> </h6>
                </td>
            </tr>

            <!-- Modal -->
<div class="modal fade" id="projectModal<?php echo $project_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Project: <?php echo $projectName ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="overflow-y: auto;">
                <form method="POST" action="../../dassubmit.php">
                    <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                    <div class="mb-3">
                        <label for="projectName" class="form-label">Project Name</label>
                        <input type="text" class="form-control" id="projectName" name="projectName" value="<?php echo $projectName ?>">
                        
                    </div>
                    <div class="mb-3">
                        <label for="projectDescription" class="form-label">Project Description</label>
                        <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3"><?php echo $projectDescription ?></textarea>
                    </div>
                    
                    <input type="hidden" name="progressPercentage" value="0">
                    
                    <div class="form-group">
                            <label for="approvedBy<?php echo $project_id ?>">Approved By Faculty:</label>
                            <input type="text" class="form-control readonly" id="approvedBy<?php echo $project_id ?>" name="approvedBy" value="<?php echo $approved_by_faculty; ?>" readonly>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo $project_id ?>)">Delete</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<span> Approved By- 
                        
                        <?php 
                        
                        if($head_selected)
                        {
                                echo $head_selected ;
    
                        }
                        else if($faculty_name)
                        {
                            echo  $faculty_name ;
                        }
                        else 
                        {
                            echo 'No one <br>';
                            echo 'OR Already  Approve Other Project ';
                        }
                        
                        
                        
                        
                        
                        
                        ?>
    
    
    
                        </span>
    <?php
        }
    } else {
    ?>
        <tr>
            <td colspan="2" class="text-center">No Active Projects Found</td>
        </tr>
    <?php
    }
    ?>
</tbody>
        </table>
    </div>
</div>

</div>
</div>
<div class="col-lg-4 col-md-6">
<div class="card h-100">
<div class="card-header pb-0">
<h6>Available Faculty Members</h6>
</div>


<div class="card-body p-3">



<div class="timeline timeline-one-side">


<?php

$query = "SELECT name FROM users as u , $faculty_n as f  WHERE u.teacher_id=f.teacher_id AND f.selected_by_head	=1";
$result = mysqli_query($connection, $query);

// Output the results
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="timeline-block mb-3">';
    echo '<span class="timeline-step"> <i class="ni ni-bulb-61 text-success1 "></i> </span>';
    echo '<div class="timeline-content">';
    echo '<h6 class="text-dark text-sm font-weight-bold mb-0">Faculty Teacher: ' . htmlspecialchars($row['name']) . '</h6>';
    echo '</div>';
    echo '</div>';
}


mysqli_free_result($result);
?>


</div>
<span> Note: This Faculty Member are Selected By Department Head to observation your project. One of Faculty teacher Selected Your Group.</span><br>

<span>Who Approve My group?</span><br>
<span>Go to dashboard, Right Corner If you see the faculty teacher name that means this faculty teacher approve your project.Any problem please contact this faculty teacher
    if not seen any teacher that means your group is now pending to approve
</span>

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
<a href="../../../contact_us/" class="font-weight-bold" target="_blank">Group 1,4</a>
for a better web.
</div>
</div>

</div>
</div>
</footer>
</div>
</main>



<script src="../../assets/js/core/popper.min.js"></script>
<script src="../../assets/js/core/bootstrap.min.js"></script>
<script src="../../assets/js/plugins/perfect-scrollbar.min.js"></script>



<script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../../assets/js/soft-ui-dashboard.min.js?v=1.0.7"></script>

<script>
   function confirmDelete(projectId) {
    // Show confirmation prompt
    var confirmation = prompt("Please type CONFIRM to proceed with deletion:");
    
    if (confirmation === "CONFIRM") {
        // Perform delete operation using AJAX
        $.ajax({
            url: '../../dadelete.php', // Assuming this is the URL for the delete operation
            type: 'POST',
            data: { projectId: projectId }, // Send the project ID
            success: function(response) {
                // Handle the response as needed
                alert(response); // Assuming your delete_project.php file returns a message
                // Reload the page or update UI as needed
                window.location.reload(); 
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
}
    
</script>
</body>
</html>