<?php
include '../database.php';

// Start session
session_start();


//$teacher_id = 41220100054;
//$teacher_id = 1290;
//$teacher_id = 11;
$role=$_SESSION['role'] ;
$verify=$_SESSION['verify'];
if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    // Redirect the user to the login page
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
}

if($role=='admin')
{
    if($verify)
    {
             $teacher_id = $_SESSION['admin'];
    }
    else
    {
        echo 'Your ID is Not Verified. Please Contact with Modarator';
        exit(); // Make sure to stop the script execution after redirection
    }

}
   else
   {
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
   }


include 'extention/header_database.php';


//////////// number of active project name///////////////////
$query_active_p = "SELECT * FROM $session WHERE approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status = 0 ORDER BY id DESC";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);

    


$num_approved_projects=0;
$num_complete_projects=0;
$num_active_projects=0;


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
    <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <script src="assets/js/fontawesome.js" crossorigin="anonymous"></script>
    <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
    <link id="pagestyle" href="assets/css/soft-ui-dashboard.min.css?v=1.0.7" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
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
    .progress1 {
    height: 3px; /* Adjust the height of the progress container */
    width: 120px; /* Adjust the width of the progress container */
    background-color: #f0f0f0; /* Background color of the progress bar container */
    border-radius: 5px; /* Adjust border radius for rounded edges */
    overflow: hidden; /* Hide overflowing content */
    position: relative; /* Positioning for progress bars */
}

.progress-container1 {
  width: 100%;
  background-color: #f0f0f0;
}

.progress-bar1 {
  width: 0%;
  height: 30px;
  background-color: #4caf50;
  text-align: center;
  line-height: 30px;
  color: white;
}

</style>
<!-- Place the first <script> tag in your HTML's <head> -->
<script src="https://cdn.tiny.cloud/1/orccd5z7nttpvptq1wacy2kglnlsea2e0401kzegdw17lu25/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#projectDescription',
        height: 300,
        plugins: 'link image code',
        branding:false,
        readonly: true,
        toolbar: 'undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | link image | code'
    });
</script>
</head>

<body class="g-sidenav-show  bg-gray-100">

    <?php include 'extention/nev.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Dashboard</h6>
                </nav>
                <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">


                        <?php include 'extention/profile_thumbnail.php'; ?>


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
            <?php include 'extention/header.php'; ?>
            

                <div class="row my-4">
                    <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="row">
                                    <div class="col-lg-6 col-7">
                                        <h6> <?php echo $groupCount2 ?> Active Projects</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-0 pb-2">
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
                                                <th class=" text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Completion</th>
                                                
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
    ?>

            <tr class="project-row" data-bs-toggle="modal" data-bs-target="#projectModal<?php echo $project_id ?>">
                <td>
                    <div class="d-flex px-2 py-1">
                        <div>
                            <img src="../assets/img/small-logos/logo-xd.svg" class="avatar avatar-sm me-3" alt="xd">
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm"><?php echo $projectName ?></h6>
                        </div>
                    </div>
                </td>
                <td class="align-middle">
                    <div class="progress-wrapper w-75 mx-auto">
                        <div class="progress-info">
                            <div class="progress-percentage">
                                <span class="text-xs font-weight-bold"><?php echo $progressPercentage ?>%</span>
                            </div>
                        </div>
                        <div class="progress1">

<div class="progress-container1">
<div class="progress-bar1" id="myProgressBar<?php echo $project_id ?>"></div>
</div>
</div>
</div>
</td>
</tr>
<script>
// Define the progress bar element
var progressBar = document.getElementById("myProgressBar<?php echo $project_id ?>");

// Retrieve the progress percentage from PHP variable
var progressPercentage = <?php echo $progressPercentage ?>;

// Ensure progress percentage is within the valid range (0 to 100)
progressPercentage = Math.max(0, Math.min(progressPercentage, 100));

// Update the width of the progress bar
progressBar.style.width = progressPercentage + "%";
</script>
            <!-- Modal -->
<div class="modal fade" id="projectModal<?php echo $project_id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Project: <?php echo $projectName ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="dassubmit.php">
                    <input type="hidden" name="project_id" value="<?php echo $project_id ?>">
                    <div class="mb-3">
                            <label for="projectName" class="form-label">Project Name</label>
                            <input type="text" class="form-control" id="projectName" name="projectName" value="<?php echo $projectName ?>" readonly>
                        </div>

                    <div class="mb-3">
    <label for="projectDescription" class="form-label">Project Description</label>
    <textarea class="form-control" id="projectDescription" name="projectDescription" rows="3" readonly><?php echo $projectDescription ?></textarea>
</div>

                    <div class="mb-3">
                        <label for="progressPercentage" class="form-label">Progress (%)</label>
                        <input type="number" class="form-control" id="progressPercentage" name="progressPercentage" min="0" max="100" value="<?php echo $progressPercentage ?>">
                    </div>
                    <div class="form-group">
                            <label for="approvedBy<?php echo $project_id ?>">Approved By Faculty:</label>
                            <input type="text" class="form-control readonly" id="approvedBy<?php echo $project_id ?>" name="approvedBy" value="<?php echo $approved_by_faculty; ?>" readonly>
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <?php
        }
    } else {
        $approved_by_faculty='Pending';
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
                                <!--h6>Approved By <?php echo $approved_by_faculty ?> </h6>
                            </div>
                            <div class="card-header pb-0">
                                <h6>Latest Comment</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="timeline timeline-one-side">
                                    <div class="timeline-block mb-3">
                                        <span class="timeline-step">
                                            <i class="ni ni-bell-55 text-success text-gradient"></i>
                                        </span>
                                        <div class="timeline-content">
                                            <h6 class="text-dark text-sm font-weight-bold mb-0">আরেকটু ভাবো -Rabbi </h6>
                                            <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">22 DEC 7:20 PM</p>
                                        </div>
                                    </div-->
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

    </script>






</body>

</html>
