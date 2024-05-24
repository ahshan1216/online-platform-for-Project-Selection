<?php
include '../database.php';

// Start session
session_start();


$role=$_SESSION['role'] ;
$verify=$_SESSION['verify'];
if (!isset($_SESSION['master_admin']) || empty($_SESSION['master_admin'])) {
    // Redirect the user to the login page
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
}

if($role=='master_admin')
{
    if($verify)
    {
        $student_id = $_SESSION['master_admin'];
        

   

    }
    else
    {
    $student_id = $_SESSION['master_admin'];
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




    


$num_approved_projects=0;
$num_complete_projects=0;
$num_active_projects=0;



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
                                        <h6> <?php echo $groupCount1 ?> Pending Accounts</h6>
                                    </div>
                                    <div class="col-lg-6 col-5">
                                <!-- Dropdown menu to select role -->
                                <select id="roleSelect" class="form-select" aria-label="Select Role">
                                <option value="all">All</option>
                                    <option value="student">Student</option>
                                    <option value="faculty">Faculty</option>
                                </select>
                            </div>
                                </div>
                            </div>
                            <div class="card">
    <div class="card-body px-0 pb-2">
        <div class="table-responsive">
            <table id="accountTableBody" class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Account ID</th>
                        
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Assuming you have already established a database connection

                    // Query to select data from the users table
                    $query = "SELECT * FROM users where verify='0'AND role NOT IN ('admin', 'super_admin') ORDER BY id DESC"; // Update "your_table" with your actual table name
                    $result = mysqli_query($connection, $query);

                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<tr>';
                            echo '<td>';
                            // Check if student_id is zero
                            if ($row['student_id'] == 0) {
                                // If student_id is zero, display teacher_id as Account ID
                                echo $row['teacher_id'];
                            } else {
                                // Otherwise, display student_id as Account ID
                                echo $row['student_id'];
                            }
                            echo '</td>';
                            
                            echo '<td>' . $row['role'] . '</td>';
                            echo '<td><button class="btn btn-primary action-button" data-student-id="' . $row['student_id'] . '" data-teacher-id="' . $row['teacher_id'] . '">Action</button></td>';
                            echo '<td><input type="checkbox" name="select[]" value="' . $row['id'] . '"></td>';
                            echo '</tr>';
                        }
                        
                    } else {
                        // If no rows are returned, display a message within a single table row
                        echo '<tr><td colspan="5" class="text-center">No data found.</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    <style>

.image-container {
    display: flex;
    justify-content: center;
}

.image-wrapper {
    text-align: center;
    margin: 0 5px; /* Set margin to 5px */
}

.small-image {
    width: 150px; /* Adjust width as needed */
    height: auto;
    cursor: pointer; /* Add pointer cursor to indicate clickable */
}

.large-image {
    width: 800px; /* Adjust width for enlarged image */
    height: auto;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000; /* Ensure the enlarged image appears above other content */
}
.close-button {
    display: none; /* Initially hide close button */
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
}
    </style>
<!-- Bootstrap Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div class="image-container">
                <div class="image-wrapper" onclick="toggleImageSize('profile-picture')">
                    <p>Profile Picture</p>
                    <img id="profile-picture" src=" " alt="Profile Picture" class="small-image">
                </div>
                <div class="image-wrapper" onclick="toggleImageSize('id-card-picture')">
                    <p>ID Card</p>
                    <img id="id-card-picture" src=" " alt="ID Card Picture" class="small-image">
                </div>
            </div>
            <!-- Close button for enlarged image -->
<button id="close-button" class="close-button" onclick="closeEnlargedImage()">Close</button>

<br>
                <p id="user-id"></p>
                <p id="user-name"></p>
                <p id="id1" style="display: none;"></p>

                <p id="session"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button id="confirm-button" type="button" class="btn btn-primary">Confirm</button>
                <button id="delete-button" type="button" class="btn btn-danger">Delete</button>
            </div>

        </div>
    </div>
</div>

<script>
    var id;
   document.addEventListener('DOMContentLoaded', function() {
    // Get the modal element
    var myModal = new bootstrap.Modal(document.getElementById('myModal'));

    // Get all action buttons
    var actionButtons = document.querySelectorAll('.action-button');

    // Function to handle action button click
    function handleActionButtonClick(event) {
        var studentId = event.target.getAttribute('data-student-id');
        var teacherId = event.target.getAttribute('data-teacher-id');
        
        // Make an AJAX request to fetch the image URLs from the database
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the response JSON
                    var response = JSON.parse(xhr.responseText);
                    // Update the src attributes of the img elements
                    document.getElementById("profile-picture").src = response.profilePictureUrl;
                    document.getElementById("id-card-picture").src = response.idCardPictureUrl;
                    document.getElementById("session").innerHTML = response.session ; 
                    document.getElementById("user-name").innerHTML = response.name ;
                    document.getElementById("id1").innerHTML = response.id ; 
                    
                } else {
                    console.error('Failed to fetch image URLs');
                }
            }
        };
        // Send the AJAX request
        xhr.open('GET', 'fetch_images.php?studentId=' + studentId + '&teacherId=' + teacherId, true);
        xhr.send();
        
        // Update the user ID
        if (studentId === '0') {
            document.getElementById("user-id").innerHTML = "NUB ID: " + teacherId;
        } else {
            document.getElementById("user-id").innerHTML = "NUB ID: " + studentId;
        }
       
        myModal.show(); // Show the modal
    }

    // Attach event listeners to action buttons
    actionButtons.forEach(function(button) {
        button.addEventListener('click', handleActionButtonClick);
    });

    // Function to handle modal close
    document.querySelector('.btn-close').addEventListener('click', function() {
        myModal.hide(); // Hide the modal
    });

    // Function to handle modal dismiss on outside click
    myModal._element.addEventListener('hidden.bs.modal', function(event) {
        var relatedTarget = event.relatedTarget;
        if (relatedTarget && relatedTarget.classList.contains('action-button')) {
            // If another action button was clicked, prevent modal closing
            event.preventDefault();
        }
    });

    // Implement functionality for confirm and delete buttons as needed


    // Function to fetch data based on role
    function fetchDataByRole(role) {
        // Make an AJAX request to fetch data based on selected role
        var url = 'fetch_data.php?role=' + role;
        fetch(url)
            .then(response => response.json())
            .then(data => {
                var tableBody = document.getElementById('accountTableBody');
                // Clear existing table rows
                tableBody.innerHTML = '';

                // Loop through fetched data and populate table rows
                data.forEach(row => {
                    var idColumn = row.student_id === '0' ? row.teacher_id : row.student_id;
                    id=  row.id;
                    var tr = '<tr>' +
                        '<td>' + idColumn + '</td>' +
                        '<td>' + row.role + '</td>' +
                        '<td><button class="btn btn-primary action-button" data-student-id="' + row.student_id + '" data-teacher-id="' + row.teacher_id + '">Action</button></td>' +
                        '<td><input type="checkbox" name="select[]" value="' + row.id + '"></td>' +
                        '</tr>';
                    tableBody.innerHTML += tr;
                });

                // Re-attach event listeners to action buttons
                var actionButtons = document.querySelectorAll('.action-button');
                actionButtons.forEach(function(button) {
                    button.addEventListener('click', handleActionButtonClick);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    // Event listener for role dropdown change
    document.getElementById('roleSelect').addEventListener('change', function() {
        var selectedRole = this.value;
        fetchDataByRole(selectedRole);
    });

    // Initial data fetch based on default selected role
    var defaultRole = document.getElementById('roleSelect').value;
    fetchDataByRole(defaultRole);

   
// Get references to the confirm and delete buttons
var confirmButton = document.getElementById('confirm-button');
    var deleteButton = document.getElementById('delete-button');

    // Add event listener for the confirm button
    confirmButton.addEventListener('click', function() {
        // Make an AJAX request to update the user's verification status
        var userId = document.getElementById('id1').textContent; // Get the user ID from the modal
        //var userId1 = userId.replace('NUB ID: ', '');
        console.log(userId);
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Update successful, you can handle this as needed
                    console.log('User verification status updated successfully.');
                } else {
                    // Handle errors
                    console.error('Failed to update user verification status.');
                }
            }
        };
        // Update the URL with your server-side script that handles the update operation
        xhr.open('POST', 'update_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        // Send user ID or any other necessary data to the server-side script
        xhr.send('userId=' + userId); // Send the user ID to the server-side script
    });

    // Add event listener for the delete button
    deleteButton.addEventListener('click', function() {
        // Make an AJAX request to delete the user
        var userId = document.getElementById('id1').textContent; // Get the user ID from the modal
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Deletion successful, you can handle this as needed
                    console.log('User deleted successfully.');
                } else {
                    // Handle errors
                    console.error('Failed to delete user.');
                }
            }
        };
        // Update the URL with your server-side script that handles the deletion operation
        xhr.open('POST', 'delete_user.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        // Send user ID or any other necessary data to the server-side script
        xhr.send('userId=' + userId); // Send the user ID to the server-side script
    });

});
function toggleImageSize(imageId) {
    var image = document.getElementById(imageId);
    image.classList.toggle('large-image');
    document.getElementById('close-button').style.display = 'block';
}

function closeEnlargedImage() {
    var largeImages = document.querySelectorAll('.large-image');
    largeImages.forEach(function(image) {
        image.classList.remove('large-image');
    });
    document.getElementById('close-button').style.display = 'none';
}

</script>


                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                        <div class="card-header pb-0">
    <h6>Accepted Id</h6>
</div>
<div class="card-body p-3">
    <table class="table">
        <thead>
            <tr>
                <th>Account ID</th>
                <th>Name</th>
                
                <!-- Add more table headers for additional fields -->
            </tr>
        </thead>
        <tbody>
            <?php
            // Assuming you have already established a database connection

            // Query to select data from the users table where verify is 1
            $query = "SELECT * FROM users WHERE verify = 1 AND role NOT IN ('admin', 'super_admin') ORDER BY id DESC";
            $result = mysqli_query($connection, $query);

            // Check if there are any rows returned
            if (mysqli_num_rows($result) > 0) {
                // Loop through each row
                while ($row = mysqli_fetch_assoc($result)) {
                    // Display the data for each row as table rows
                    echo '<tr>';
                    // Check if student_id is zero
                    if ($row['student_id'] == 0) {
                        // If student_id is zero, display teacher_id as Account ID
                        echo '<td>' . $row['teacher_id'] . '</td>';
                    } else {
                        // Otherwise, display student_id as Account ID
                        echo '<td>' . $row['student_id'] . '</td>';
                    }
                    echo '<td>' . $row['name'] . '</td>';
                    // Add more table cells for additional fields
                    echo '</tr>';
                }
            } else {
                // If no rows are returned, display a message within a single table row
                echo '<tr><td colspan="2">No accepted IDs found.</td></tr>';
            }
            ?>
        </tbody>
    </table>
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







</body>

</html>
