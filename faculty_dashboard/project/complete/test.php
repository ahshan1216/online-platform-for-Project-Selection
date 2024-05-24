<?php
// Start session
include '../../../database.php';
session_start();

 $student_id=$_SESSION['student_id'];


include '../../extention/header_database.php';

//////////// number of active project name///////////////////
$query_active_p = "SELECT * FROM $session WHERE  approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status = 0 ORDER BY id DESC";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);

$num_approved_projects=0;







// Define start and end dates
$startDate = '2024-03-20'; // Example start date
$endDate = '2024-04-03'; // Example end date

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
<!-- Modal for editing content -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Content</h5>
                
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form for editing content -->
                <form id="editForm">
                    <div class="form-group">
                        <label for="editTitle">Title:</label>
                        <input type="text" class="form-control" id="editTitle">
                    </div>
                    <div class="form-group">
                        <label for="editDescription">Description:</label>
                        <textarea class="form-control" id="editDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="submitEdit()">Save changes</button>
            </div>
        </div>
    </div>
</div>

<style>
    .pink-color {
        background-color: pink;
    }
</style>

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
        echo '<option value="' . $row['id'] . '">' . $row['project_name'] . '</option>';
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
        <div class="card h-auto"> <!-- Adjusted height -->
            <div class="card-header pb-0">
                <h6>Another Project Name</h6>
            </div>
            <div class="card-body p-3">
                <!-- Add your content for the second card here -->
                <!-- Example content -->
                <p>This is another project card.</p>
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
    // Function to handle click event on date cells
   // Function to handle click event on date cells
   $(document).ready(function() {
        $('.edit-date').click(function() {
            // Get the date associated with the clicked cell
            var date = $(this).find('.date').text();
            // Set the date in the modal header
            $('#editModalLabel').text(date);
            // Open the edit modal
            $('#editModal').modal('show');
        });

        // Function to handle closing the modal
        $('#editModal').on('hidden.bs.modal', function () {
            // Clear the form fields when the modal is closed
            $('#editTitle').val('');
            $('#editDescription').val('');
        });

        // Function to handle clicking the close button within the modal's footer
        $('#editModal .modal-footer button[data-dismiss="modal"]').click(function() {
            $('#editModal').modal('hide');
        });
        // Function to handle clicking the close button within the modal's header
        $('#editModal .modal-header .close').click(function() {
            $('#editModal').modal('hide');
        });
    });

    // Function to handle submission of the edit form
    function submitEdit() {
        // Get the edited data from the form
        var editedTitle = $('#editTitle').val();
        var editedDescription = $('#editDescription').val();
        // Perform further processing (e.g., submit to server)
        // For demonstration, just closing the modal
        $('#editModal').modal('hide');
    }
</script>





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
});

</script>





</body>
</html>