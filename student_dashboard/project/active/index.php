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
$query_active_p = "SELECT * FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status = 0 ORDER BY id DESC";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);

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
<!-- Include Bootstrap CSS and JavaScript -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<style>
        .text-success1 {
    color: #FFBF00 !important;
}

.btn-sm {
        padding: 0.25rem 0.5rem; /* Adjust padding to make buttons smaller */
        font-size: 0.75rem; /* Decrease font size to make buttons smaller */
    }
        </style>



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
<style>
    /* Style for table */
    .table {
        width: 100%;
        border-collapse: collapse;
        border-radius: 8px;
        overflow: hidden;
    }

    .table th,
    .table td {
        padding: 16px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }

    /* Hover effect */
    .table tbody tr:hover {
        background-color: #f0f0f0;
    }
    
</style>

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
                        <h6>Project Task Management: </h6>
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="table-responsive">
            


            <div class="table-responsive">
    <table class="table align-items-center mb-0">
    <div id="projectManagementContainer" class="mt-4"></div>



    </table>
</div>


</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
    <div class="card h-auto"> <!-- Adjusted height -->
    <div class="card-header pb-0">
        <h6>Project Name</h6>
    </div>
    <div class="card-body p-3">
        <div class=" ">
        <?php
// Check if there are any active projects
$projectCount = 0; // Counter for limiting to two projects
if (mysqli_num_rows($result_active_p) > 0) {
    // Start select dropdown
    echo '<select id="projectSelect" class="form-select">
            <option value="">Select a project</option>';
    
    $firstProjectAdded = false; // Flag to track if the first project is added
    
    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result_active_p)) {
        // Print the project name and its associated project ID
        echo '<div class="timeline-block mb-3">
                  <span class="timeline-step"> 
                      <i class="ni ni-bulb-61 text-success1 "></i>
                  </span>
                  <div class="timeline-content">
                      <h6 class="text-dark text-sm font-weight-bold mb-0 project-name" data-project-id="' . $row['id'] . '">' . $row['project_name'] . '</h6>
                      <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">' . $row['project_name'] . '</p>
                  </div>
              </div>';
        
        // Add option to select dropdown
        echo '<option value="' . $row['id'] . '"';
        
        // Check if it's the first project and it hasn't been added yet
        if (!$firstProjectAdded) {
            echo ' selected'; // Add selected attribute for the first project
            $firstProjectAdded = true; // Set the flag to true after the first project is added
        }
        
        echo '>' . $row['project_name'] . '</option>';
    }
    
    // Close select dropdown
    echo '</select>';
} else {
    // No active projects found
    echo '<p>No active projects found.</p>';
}

?>

        </div>
        
    </div>
</div>
        <br>

        <div class="card h-auto">
        <div class="card-header pb-0">
        <h6>Task</h6>
        </div>
        <div class="card-body p-3">

        <?php
// Include your database connection file


// Perform a query to fetch tasks with their comments
$sql12 = "SELECT * FROM tasks where group_number='$user_group_number' ";
$result12 = mysqli_query($connection, $sql12);

// Check if the query was successful
if ($result12) {
    // Fetch each row from the result set
    while ($row = mysqli_fetch_assoc($result12)) {
       
        echo '<div class="mb-3">';
        echo '<strong>Task No:<span style="color: black;">' . $row['task_no'] . '</span></strong>';
      
        if ($row['task_name']) {
            echo '<p><span style="color: black;">' . $row['task_name'] . '</span></p>';
        } else {
            echo '<p>No Task Found</p>';
        }
        echo '</div>';

    }
    // Free result set
    mysqli_free_result($result);
} else {
    // Handle database query errors
    $errorMessage = 'Error fetching tasks: ' . mysqli_error($connection);
    // You can log or display this error message as needed
}
// Close database connection
mysqli_close($connection);
?>
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
$(document).ready(function() {
    // Function to handle change event on the project select dropdown
    $('#projectSelect').change(function() {
        // Get the selected project ID
        var projectId = $(this).val();
        
        // Log the selected project ID to console
        console.log('Selected Project ID:', projectId);
        
        // Check if a project is selected
        if (projectId) {
            // Make an AJAX request to fetch project management for the selected project
            $.ajax({
                url: 'fetch.php', // URL to fetch project management
                method: 'POST',
                data: { project_id: projectId }, // Send selected project ID to the server
                success: function(response) {
                    console.log(response);
                    // Update the project management container with the fetched content
                    $('#projectManagementContainer').html(response);
                    
                },
                error: function(xhr, status, error) {
                    // Handle errors if any
                    console.error(error);
                }
            });
        } else {
            // Clear the project management container if no project is selected
            $('#projectManagementContainer').html('');
        }
    });
    
    // Trigger change event on page load to fetch data for the initially selected project
    $('#projectSelect').change();
});


</script>

</body>
</html>