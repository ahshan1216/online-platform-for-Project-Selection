<?php
include '../../../database.php';

// Start session
session_start();




//$teacher_id = 41220100054;
//$teacher_id = 1290;

 $teacher_id=$_SESSION['teacher_id'];
 include '../../extention/header_database.php';

 


////////////// Fatching Group Leader Information END///////////////////

//////////////////Header Initialize Start ////////////////////////////

$num_approved_projects=0;
$num_complete_projects=0;
$num_active_projects=0;
$num_pending_projects=0;
$approved_by_faculty= 'NULL';
/////////////////Header Initialize  END ////////////////////////////



////////////// Fatching Teacher Information///////////////////
$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name= $row['name'];

    
   
}
////////////// Fatching Teacher Information END///////////////////


///////////header section////////////

      //////////// number of active project name///////////////////
      $query_active_p = "SELECT * FROM $session WHERE  approved_by_faculty = '0' AND  approved_by_faculty REGEXP '^[0-9]+$' ORDER BY id DESC ";
      // Perform the query
      $result_active_p = mysqli_query($connection, $query_active_p);


      ////// header section end////




////////////// Fatching Approval By HEAD ///////////////////
$sessionfaculty = $session . 'faculty';
$sql = "SELECT u.name
        FROM users u
        INNER JOIN $sessionfaculty sf ON u.teacher_id = sf.teacher_id
        WHERE sf.teacher_id = '$teacher_id' AND sf.selected_by_head = 1";
$result = mysqli_query($connection, $sql);
if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $teacher_name = $row['name']; // Access the 'name' field
    // Additional processing if needed
    
}
else{
    $teacher_name='' ;
}

////////////// Fatching Approval By HEAD END ///////////////////
//echo "Teacher ID: " . $teacher_name; // Debugging statement

////Check If any group ar avilabe then Show the  denger buttion
// Query to fetch data where the name contains 'mahadi'
$sql2 = "SELECT * FROM project_students WHERE group_approval LIKE '%$teacher_name%'";
$result2 = $connection->query($sql2);
if ($result2->num_rows > 0) {
$group_app=1;
}
else{
    $group_app=0;
}

//////////////////////////Group by Group

// Fetch group numbers and associated projects
// Step 1: Fetch group numbers from project_students where group_approval is 0
$sql_group_approval = "SELECT DISTINCT group_number FROM project_students WHERE group_approval = '$teacher_name' AND session= '$session'";
$result_group_approval = $connection->query($sql_group_approval);

// Step 2: Store group numbers in an array
$group_numbers = [];
while ($row_group_approval = $result_group_approval->fetch_assoc()) {
    $group_numbers[] = $row_group_approval['group_number'];
}

// Step 3: Check if $group_numbers is empty
if (!empty($group_numbers)) {
    // Step 4: Build SQL query to select projects for the retrieved group numbers
    $sql3 = "SELECT * FROM $session WHERE group_number IN (" . implode(",", $group_numbers) . ") ORDER BY group_number, id DESC";
    $result3 = $connection->query($sql3);
   // echo   ;
} else {
   // $result3='';
   
    // Handle the case when $group_numbers is empty
    //echo "No group numbers found with group_approval equal to 0.";
}


// Initialize variable to keep track of current group
$currentGroup = "";
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

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/fontawesome.min.css" />


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
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Group</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
                </tr>
            </thead>
            <tbody>

    <?php
    $i=0;
    if (@$result3->num_rows > 0) {
        while($row = @$result3->fetch_assoc()) {
            $group = $row["group_number"];
            $project = $row["project_name"];
            $description = $row["project_description"];
            $status = $row["status"]; // Assuming status field name
            $project_id=$row["id"];
            $head_selected=$row["op_head"];
            $faculty_name=$row["approved_by_faculty"];
            
            
            $i=$i+1;
            // Check if we've moved to a new group
            if ($group != $currentGroup) {
                $i=1;
                // Output the group heading
                ?>
                <tr>
                    <td colspan="2">
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm"><?php echo "Group $group:"; ?></h6>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php
                
                // Set the current group
                $currentGroup = $group;
            }             
            
            
            // Output the project for the group
            ?>
            <tr>
                <td><?php echo "Project $i:"; ?></td>
                <td>
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-<?php echo ($status == 'approved' ? 'success' : ($status == 'rejected' ? 'danger' : 'warning')); ?>" data-bs-toggle="modal" data-bs-target="#projectModal<?php echo $project_id; ?>">
                        <?php echo $project; ?>
                    </button>

                    <!-- Modal -->
<div class="modal fade" id="projectModal<?php echo $project_id; ?>" tabindex="-1" aria-labelledby="projectModalLabel<?php echo $project_id; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="projectModalLabel<?php echo $project_id; ?>"><?php echo $project; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                <p><?php echo $description; ?></p>
                <?php if (strlen($description) > 200): ?>
                <a href="project_description.php?project_id=<?php echo $project_id; ?>" target="_blank">See more description</a>
                <?php endif; ?>
                <!-- Approve, Modify, Reject buttons -->
                <div class="mb-3">

                    <?php
                    $query = "SELECT * FROM $session WHERE id = '$project_id'";
                    $result = mysqli_query($connection, $query);
                    
                    if ($result && mysqli_num_rows($result) > 0) {
                        $row = mysqli_fetch_assoc($result);
                        
                        $status= $row['status'];

                    
                        
                       
                    }
                    else
                    {
                        $status='';  
                    }

                    if($status != 'complete')
                    {
                    ?>

                    <button type="button" class="btn btn-success me-2" onclick="updateStatus('<?php echo $project; ?>', 'approved',<?php echo $group; ?>)">Approve</button>
                    <button type="button" class="btn btn-warning me-2" onclick="updateStatus('<?php echo $project; ?>', 'modified',<?php echo $group; ?>)">Modify Needed</button>
                    <button type="button" class="btn btn-danger me-2" onclick="updateStatus('<?php echo $project; ?>', 'rejected',<?php echo $group; ?>)">Reject</button>
                    <?php
                    } 
                    else
                    {

                    
                    ?>
                    <h3> This project Is Complete <h3>
                        <?php
                        }
                        ?>
                </div>
                <!-- Comment section -->
                <div class="mb-3">
                    <textarea class="form-control" placeholder="Enter your comment" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
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

                </td>
            </tr>
            <?php
           
        }
    } else {
        ?>
        <tr>
            <td colspan="2" class="text-center">No data available</td>
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
<h6>Class Time </h6>
</div>
<?php
$classTimeMappingReverse = array(
    1 => 'Monday',
    2 => 'Tuesday',
    3 => 'Wednesday',
    4 => 'Thursday',
    5 => 'Friday',
    6 => 'Saturday',
    7 => 'Sunday'
);

    $query5 = "SELECT * FROM time WHERE teacher_name= '$name'";
    $result5 = mysqli_query($connection, $query5);
    
    if ($result && mysqli_num_rows($result5) > 0) {
        $row = mysqli_fetch_assoc($result5);
        $stime = $row['starting_date'];
        $etime = $row['ending_date'];
        $ctime = $row['class_date'];
        $t_n= $row['teacher_name'];
        $recordID = $row['id'];
    
        // Get the day of the week based on the numeric value of $ctime
if(isset($classTimeMappingReverse[$ctime])) {
    $dayOfWeek = $classTimeMappingReverse[$ctime];
}
    }   
    else{
        $stime = '';
        $etime = '';
        $ctime = '';
        $dayOfWeek='';
        $t_n='';
       // echo $name;
    } 
    
    ?>

<div class="card-body p-3">



<div class="timeline timeline-one-side">





<div class="timeline-block mb-3">
<span class="timeline-step"> 
<i class="ni ni-bulb-61 text-success1 "></i>
</span>
<div class="timeline-content">
<h6 class="text-dark text-sm font-weight-bold mb-0">Starting Date :<?php echo $stime  ?></h6>
<h6 class="text-dark text-sm font-weight-bold mb-0">Ending Date :<?php echo $etime  ?></h6>
<p class="text-secondary font-weight-bold text-xs mt-1 mb-0">Class Time :<?php echo $dayOfWeek  ?></p>
</div>
</div>




<?php
if(!$t_n)
{
?>

</div>
<!-- Button to trigger modal -->
<button type="button" class="btn btn-primary" id="openModalBtn">Select Your Time Scheduling</button>
</div>
<?php
}
else
{
   
?>
</div>
<button type="button"  class="btn btn-primary edit-btn" data-record-id="<?php echo $recordID ?>">Edit</button>
</div>
<?php
}
?>
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

<!-- Modal -->
<div class="modal fade" id="timeModal" tabindex="-1" role="dialog" aria-labelledby="timeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="timeModalLabel">Time Scheduling</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
        <form id="timeForm">
        <input type="hidden" id="RecordID" data-record-id="<?php echo $recordID ?>">
          <div class="form-group">
            <label for="startingDate">Starting Date:</label>
            <input type="date" class="form-control" id="startingDate" required>
          </div>
          <div class="form-group">
            <label for="endingDate">Ending Date:</label>
            <input type="date" class="form-control" id="endingDate" required>
          </div>
          <div class="form-group">
    <label for="classTime">Class Time</label>
    <select class="form-control" id="classTime" required>
        <option value="">Select Day of the Week</option>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
        <option value="Saturday">Saturday</option>
        <option value="Sunday">Sunday</option>
    </select>
</div>
        </form>
      </div>
      

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?php
if(!$t_n)
{
?>
        <button type="button" class="btn btn-primary" id="submitBtn">Submit</button>
        <?php
}
else
{
   
?>
        <button type="button" class="btn btn-primary" id="saveBtn">Edit</button>
        <?php
}
?>
</div>
      </div>
    </div>
  </div>
</div>

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


<script>
    function updateStatus(projectName, status,group) {
        // Make an AJAX request to update status
        // Example using jQuery:
        console.log(group);
        $.post("update_status.php", { project: projectName, status: status , group: group }, function(responseData, textStatus) {
            // Update button color
            var button = $("button:contains('" + projectName + "')");
            if (textStatus == 'success') {
                if (status == 'approved') {
                    button.removeClass("btn-warning btn-danger").addClass("btn-success");
                    
                } else if (status == 'modified') {
                    button.removeClass("btn-success btn-danger").addClass("btn-warning");
                } else {
                    button.removeClass("btn-success btn-warning").addClass("btn-danger");
                }
                // Update status in modal
                $("#projectModal<?php echo $project_id; ?> .modal-body p:contains('Status:')").text("Status: " + status.charAt(0).toUpperCase() + status.slice(1));
                $("#projectModal<?php echo $project_id; ?>").modal("hide");
            } else {
                alert("Failed to update status.");
            }
            
        });
        $('#timeModal').modal('hide');
    }



    $(document).ready(function() {
    // Open modal when button is clicked
    $('#openModalBtn').click(function() {
        $('#timeModal').modal('show');
    });

    // Handle submit button click inside modal
    $('#submitBtn').click(function() {
        // Get values from input fields
        var startingDate = $('#startingDate').val();
        var endingDate = $('#endingDate').val();
        var classTime = $('#classTime').val(); // Get selected class time

        // Send AJAX request to save data to the database
        $.ajax({
            url: 'save_to_database.php', // Adjust the URL according to your setup
            method: 'POST',
            data: {
                startingDate: startingDate,
                endingDate: endingDate,
                classTime: classTime // Include class time in the data
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                alert('Data saved successfully!');
                $('#timeModal').modal('hide');
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                alert('Error saving data!');
            }
        });
    });

    // Open modal when timeline block is clicked
    $('.edit-btn').click(function() {
       
        // Get record ID, starting date, ending date, and class time from the clicked block
        var recordID = $(this).data('record-id'); // Assuming record ID is stored as a data attribute
        var startingDate = $(this).find('.starting-date').text();
        var endingDate = $(this).find('.ending-date').text();
        var classTime = $(this).find('.class-time').text();

        // Set modal content with block details
        $('#recordID').val(recordID); // Set record ID in a hidden input field
        $('#startingDate').val(startingDate);
        $('#endingDate').val(endingDate);
        $('#classTime').val(classTime);

        // Show the modal
        $('#timeModal').modal('show');
        
        console.log('upore'+ recordID);
   
    // Handle submit button click inside modal
    $('#saveBtn').click(function() {
        // Get values from input fields
       
        var startingDate = $('#startingDate').val();
        var endingDate = $('#endingDate').val();
        var classTime = $('#classTime').val();
       
        console.log('vitore '+ recordID);
        // Send AJAX request to update data in the database
        $.ajax({
            url: 'save_to_database.php', // Adjust the URL according to your setup
            method: 'POST',
            data: {
                recordID: recordID, // Include record ID in the data
                startingDate: startingDate,
                endingDate: endingDate,
                classTime: classTime
                
            },
            success: function(response) {
                // Handle success response
                console.log(response);
                
                alert('Data updated successfully!');
                $('#editModal').modal('hide');
                location.reload(); // Reload the page
            },
            error: function(xhr, status, error) {
                // Handle error response
                console.error(xhr.responseText);
                alert('Error updating data!');
            }
        });
    });
});
});


// Function to handle clicking the close button within the modal's footer
$('#timeModal .modal-footer button[data-dismiss="modal"]').click(function() {
            $('#timeModal').modal('hide');
        });
        // Function to handle clicking the close button within the modal's header
        $('#timeModal .modal-header .close').click(function() {
            $('#timeModal').modal('hide');
        });
</script>

</body>
</html>