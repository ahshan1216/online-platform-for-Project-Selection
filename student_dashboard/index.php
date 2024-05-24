<?php
include '../database.php';

// Start session
session_start();


//$student_id = 41220100057;
//$student_id = 1290;
//$student_id = 412201000558;
//$_SESSION['student_id']= $student_id;
// Check if the session variable is not set or empty
$role=$_SESSION['role'] ;
$verify=$_SESSION['verify'];
if (!isset($_SESSION['student_id']) || empty($_SESSION['student_id'])) {
    // Redirect the user to the login page
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
}

if($role=='student')
{
    if($verify)
    {
        $student_id = $_SESSION['student_id'];
        

   

    }
    else
    {
    $student_id = $_SESSION['student_id'];
        $queryi = "SELECT * FROM users WHERE student_id = '$student_id'";
$resulti = mysqli_query($connection, $queryi);

if ($resulti && mysqli_num_rows($resulti) > 0) {
    $row = mysqli_fetch_assoc($resulti);
    $profile_photo= $row['profile_picture'];
    $id_card = $row['id_photo'];
}
echo '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">';
echo '<div class="verification-container">';
echo 'Verification Pending. Please Contact with Moderator';
echo '<br>';
echo '<br>';
echo '<div class="images-container">';
echo '<div class="image-container">';
echo '<p>Id Card</p>';
echo '<img src="/uploads/students/' .  $id_card . '" alt="User ID Card" class="user-image">';
echo '</div>';
echo '<div class="image-container">';
echo '<p>Profile Photo</p>';
echo '<img src="/uploads/students/' .  $profile_photo . '" alt="Profile Photo" class="user-image">';
echo '</div>';
echo '</div>';
echo '<br>';
echo '<br>';
echo 'If you think you uploaded a wrong picture, please press the Delete button before verification.';
echo '<br>';
echo '<br>';
echo '<button onclick="logout()">Logout</button>';
echo '<button onclick="deleteAccount()">Delete</button>';
echo '</div>';
echo '<style> 
.verification-container {
    text-align: center;
}

.images-container {
    display: flex;
    justify-content: center;
    margin-bottom: 20px; /* Adjust the gap between images */
}

.image-container {
    margin: 0 5px; /* Adjust the gap between images */
    text-align: center;
}

.user-image {
    width: 200px;
    height: auto;
    border: 2px solid #000; /* Hard border around images */
}

.user-image:hover {
    border-color: #ff0000; /* Change border color on hover */
}
button {
    padding: 10px 20px;
    background-color: #007bff; /* Blue background color */
    color: #fff; /* Text color */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin: 0 5px;
}

button:hover {
    background-color: #0056b3; /* Darker blue background color on hover */
}
/* Media query for smaller screens */
@media (max-width: 600px) {
    .image-container {
        flex: 1 0 calc(50% - 10px); /* Adjust width for smaller screens */
        margin: 5px; /* Add margin to create space between images */
    }
}
</style>';
        echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>';
        echo '<script>
        function logout() {
            // Redirect to logout.php
            window.location.href = "../logout.php";
        }

        function deleteAccount() {
            if (confirm("Are you sure you want to delete your account?")) {
                $.ajax({
                    type: "POST",
                    url: "delete_account.php",
                    data: { student_id:' . $student_id . ' },
                   
                    success: function(response) {
                        console.log("Success:", response);
                        logout();
                    },
                    error: function(xhr, status, error) {
                        console.error("Request failed:", status, error);
                    }
                });
            }
        }
        


        </script>';
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
$query_active_p = "SELECT * FROM $session WHERE group_number = '$user_group_number' AND approved_by_faculty <> '0' AND NOT approved_by_faculty REGEXP '^[0-9]+$' AND status = 0 ORDER BY id DESC";
// Perform the query
$result_active_p = mysqli_query($connection, $query_active_p);

    


$num_approved_projects=0;
$num_complete_projects=0;
$num_active_projects=0;

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
    $group_number='';
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

////////////// Fatching Group Leader Information///////////////////
$query55 = "SELECT * FROM project_students WHERE group_number= '$group_number' AND !group_number= 0";
$result55 = mysqli_query($connection, $query55);

$query56 = "SELECT * FROM project_students WHERE group_number= '$user_group_number' AND group_leader = 1";
$result56 = mysqli_query($connection, $query56);

if ($result55 && mysqli_num_rows($result55) > 0) {
    $row = mysqli_fetch_assoc($result55);
    
    $group_leader_name= $row['student_id'];
    $project_approve = $row['project_approval'];
    $group_approve = $row['group_approval'];
    
}
else if ($result56 && mysqli_num_rows($result56) > 0)
{
    $row = mysqli_fetch_assoc($result56);
     $group_leader_name= $row['student_id'];
     $group_number = $user_group_number;
     $project_approve = $row['project_approval'];
     $group_approve = $row['group_approval'];

     $student_id_rex= 0;
}

else{
    $group_leader_name= null;
    $group_approve =NULL;
   
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
   /* Custom Progress Bar Container CSS */
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
            $_SESSION['teacher_name'] = $approved_by_faculty;
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
                        <span class="text-xs font-weight-bold"><?php echo $progressPercentage ?>%</span>
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
                                <h6>Group Approved By <?php echo $group_approve; ?> </h6>
                            </div>
                            <div class="card-header pb-0">
                                <h6>Latest Comment</h6>
                            </div>
                            <div class="card-body p-3">
                                <?php
                                if (!empty($user_group_number)) {
                                ?>
                                <div class="timeline timeline-one-side">
                                    <?php
                                }
                                    ?>
                                    
<?php
// Query the database
if (!empty($user_group_number)) {
$query = "SELECT comment, time FROM activity WHERE group_number = $user_group_number";
$result = $connection->query($query);
if ($result->num_rows > 0) {
// Output the results
while ($row = $result->fetch_assoc()) {
    echo '<div class="timeline-block mb-3">';

    echo '<span class="timeline-step">';
    echo '<i class="ni ni-bell-55 text-success text-gradient"></i>';
    echo ' </span>';



    echo '<div class="timeline-content">';
    echo '<h6 class="text-dark text-sm font-weight-bold mb-0">' . htmlspecialchars($row['comment']) . '</h6>';
    echo '<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">' . htmlspecialchars($row['time']) . '</p>';
    echo '</div>';
    echo '</div>';
}
}
else{
    echo "No Comment";
}
}
else
{
    echo "No Comment";  
}

?>
                                    
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                    
                </div>
                <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                        <div class="card-header pb-0">
                                <h6>Notice Board</h6>
                            </div>
                            
                            <div class="card-header pb-0">

                            
                                <h6>Latest Notice</h6>
                            </div>
                            <div class="card-body p-3">
                                <div class="timeline timeline-one-side" id="noticeTimeline">
                                    
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
    function deleteAccount() {
    if (confirm("Are you sure you want to delete your account?")) {
        // Send AJAX request to delete account
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_account.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        console.log("Success:", response.message);
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                    }
                } else {
                    console.error("Request failed with status:", xhr.status);
                }
            }
        };
        xhr.send("student_id=<?php echo $student_id; ?>");
    }
}


    </script>



<script>
        $(document).ready(function() {
            var name = '<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>'; // Ensure the name is properly escaped

            // Fetch notices
            $.ajax({
                url: 'fetch_notices.php',
                type: 'GET',
                data: {
                    name: name
                },
                success: function(response) {
                    console.log(response);
                    var timeline = $('#noticeTimeline');

                    response.forEach(function(notice) {
                        var noticeHTML = `
                            <div class="timeline-block mb-3" data-id="${notice.id}" data-subject="${notice.subject}" data-notice="${notice.notice}">
                                <span class="timeline-step">
                                    <i class="ni ni-bell-55 text-success text-gradient"></i>
                                </span>
                                <div class="timeline-content">
                                    <h6 class="text-dark text-sm font-weight-bold mb-0"> ${notice.subject}:- ${notice.notice} </h6>
                                    <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">${notice.formatted_date}</p>

                                </div>
                            </div>
                        `;
                        timeline.append(noticeHTML);
                    });
               // Attach delete event handler
            
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching notices:', status, error);
                        console.error('Response:', xhr.responseText);
                    }    
                });
            

           
        });
    </script>




</body>

</html>
