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



$query = "SELECT * FROM users WHERE student_id = '$student_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name= $row['name'];

    
   
}
$sessionfaculty = $session . 'faculty';

$sqltime = "UPDATE t SET time = CURRENT_TIMESTAMP WHERE id = 1";
$resulttime = mysqli_query($connection, $sqltime);
if ($resulttime) {
    // If the update was successful, fetch the updated timestamp
    $sqlSelect = "SELECT DATE(time) AS date FROM t WHERE id = 1";
    $resultSelect = mysqli_query($connection, $sqlSelect);
    if ($resultSelect && mysqli_num_rows($resultSelect) > 0) {
        $row = mysqli_fetch_assoc($resultSelect);
        $dateValue = $row['date']; // Assuming 'date' is a datetime column
        $tt = date('d-m-Y', strtotime($dateValue)); // Extracting only the date portion
    } else {
        // Handle if no rows are returned or any other errors
    }
} else {
    // Handle if the update query fails
}




//////////// number of active project name///////////////////
$query_active_p = "SELECT * FROM $session WHERE approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status = 0 ORDER BY id DESC";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);

$num_approved_projects=0;
// Default value of $name
$name1 = @$_SESSION['selected_teacher'] ;

$query = "SELECT * FROM time WHERE teacher_name = '$name1' AND session= '$session'";
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


    @keyframes blink {
        50% {
            background-color: pink;
        }
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
                        <h6>Complete Project </h6>
                        
                    </div>
                </div>
            </div>
            <div class="card-body px-0 pb-2">
            <div class="table-responsive">
            


<div class="table-responsive">
    <table class="table align-items-center mb-0" id="projectManagementTable">
       
    </table>
</div>


</div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-6">
        <div class="card h-auto"> <!-- Adjusted height -->
            <div class="card-header pb-0">
                <h6>Task</h6>
            </div>

            <div class="card-body p-3">

<p> Please Click The Action And  Fill The Total Project Description And Other Link. This is the Final Project Summary. Department Head and Faculty Teacher Only See this Final Overwall Project </p>

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
    
   
        fetchData(0);
   
});


function fetchData(date) {
    
    // Make an AJAX request to fetch data based on the selected date
    $.ajax({
        type: 'POST',
        url: 'fetch_project_management.php', // Update the URL to your PHP script
        data: {
            date: date // Send the selected date to the server
        },
        success: function(response) {
            // Handle the response from the server
            $('#projectManagementTable').html(response); // Update the table body with fetched data
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
    });
}



$(document).ready(function() {
        $('.date-cell').click(function() {
            // Remove background color from all date cells
            $('.date-cell').css('background-color', '');
            
            // Change background color of clicked date cell to light yellow
            $(this).css('background-color', '#f7cb73');
        });

        // Fetch today's date from your database (replace this with your actual database retrieval code)
        var todayDateFromDatabase = '<?php echo $tt; ?>';

        // Iterate through each date cell
        $('.date-cell').each(function() {
            var cellDate = $(this).text().trim();
            
            // Check if the date matches today's date
            if (cellDate === todayDateFromDatabase) {
                // Apply CSS animation to blink the background color
                $(this).css('animation', 'blink 1s infinite');
            }
        });
    });
    
</script>




<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Project Details</h5>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <!-- Modal Body -->
      <div class="modal-body">
      
        <p><strong>Group Number:</strong> <span id="groupNumber"></span></p>
        <p><strong>Project Name:</strong> <span id="projectName"></span></p>
        <span style="display: none;" id="projectid"></span>


        <div class="form-group">
        <label for="projectdes"><strong>Full Project Description</strong></label>
        <textarea id="projectdes" class="form-control" rows="5"></textarea>
        </div>

       <!-- Comment history section -->
       <div class="form-group">
          <strong>Comment History:</strong>
          <ul id="commentHistory" class="list-group">
            <!-- Previous comments will be displayed here -->
          </ul>
        </div>
      


        <!-- Comment section -->
        <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea class="form-control" id="comment" value="comment" rows="3"></textarea>
        </div>
      </div>

      
      <!-- Modal Footer -->
      <div class="modal-footer">
        <!-- Submit button -->
        <button type="button" class="btn btn-success action-btn1" data-status="complete" >Submit</button>
        
        <!-- Close button -->
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <!-- Additional buttons -->
        
      </div>
    </div>
  </div>
</div>











</body>
</html>


