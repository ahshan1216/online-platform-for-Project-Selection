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
    .table-container {
        max-height: 400px; /* Set the maximum height */
        overflow-y: auto; /* Enable vertical scrollbar */
    }
</style>
<!--script src="https://cdn.tiny.cloud/1/orccd5z7nttpvptq1wacy2kglnlsea2e0401kzegdw17lu25/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
        // Initialize TinyMCE
        tinymce.init({
            selector: '#projectDescription',
            plugins: 'lists', // Enable lists plugin for bullet points
            toolbar: 'undo redo | formatselect | bold italic underline | bullist numlist | alignleft aligncenter alignright alignjustify | outdent indent',
            menubar: false,
            branding: false
        });
    </script-->
</head>

<body class="g-sidenav-show  bg-gray-100">

    <?php include 'nev.php'; ?>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <h6 class="font-weight-bolder mb-0">Group Manager</h6>
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
                                            if( $teacher_name)
                                            {
                                         ?>
                                        <h6>Select Your Group</h6>
                                        <?php
                                        } else {
                                        ?>
                                        <h6> Your Are Not Eligible For Group Selection .Please Contact Department HeadTeacher </h6>
                                        <?php
                                        }
                                        ?>
                            
                           
                                    </div>
                                </div>
                            </div>
                           
                            <div class="card-body px-0 pb-2 ">
                                          <?php
                                            if( $teacher_name)
                                            {
                                         ?>
                           
                                                        <div class="table-responsive card-header " >
                                                        <form id="searchForm">
                                                    <div class="mb-3">
                                                        <label for="searchText" class="form-label">Search Group</label>
                                                        <input type="text" class="form-control" id="searchText" name="searchText">
                                                    </div>
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="startGroup" class="form-label">Start Group Number</label>
                                                                    <input type="text" class="form-control" id="startGroup" name="startGroup">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <label for="endGroup" class="form-label">End Group Number</label>
                                                                    <input type="text" class="form-control" id="endGroup" name="endGroup">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                <button type="button" class="btn btn-success" id="selectMine">This group is Mine</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                </form>


                                                       
                                                        <?php
                                                        
                                                         ////////////// Fatching All Information///////////////////
                                                         $query1 = "SELECT ps.*, u.* 
                                                         FROM project_students ps
                                                         
                                                         INNER JOIN users u ON ps.student_id = u.student_id
                                                         WHERE ps.group_leader = 1 AND ps.session = '$session' AND ps.group_approval='0'";
                                                         $result1 = mysqli_query($connection, $query1);



                                                         
                                                         // Fetching All Information
                                                         if ($result1 && mysqli_num_rows($result1) > 0) {
                                                            echo '<div class="table-container">';
                                                            echo '<table id="searchResults" class="table">';
                                                            
                                                            echo '<thead>';
                                                            echo '<tr>';
                                                            echo '<th></th>'; // Checkbox column header
                                                            echo '<th>Group Number</th>';
                                                            echo '<th>Group Leader Name</th>';
                                                            echo '</tr>';
                                                            echo '</thead>';
                                                            echo '<tbody>';
                                                        
                                                            // Display each row of data
                                                            $rowCount = 0; // Track row count
                                                            while ($row = mysqli_fetch_assoc($result1)) {
                                                                $rowCount++; // Increment row count
                                                                echo '<tr class="group-row" data-group-number="' . $row['group_number'] . '">';
                                                                echo '<td><input type="checkbox" class="row-checkbox" data-row="' . $rowCount . '"></td>';
                                                                // Checkbox for each row
                                                                echo '<td class="group-number">' . $row['group_number'] . '</td>';
                                                                echo '<td>' . $row['name'] . '</td>';
                                                                echo '</tr>';
                                                            }
                                                        
                                                            echo '</tbody>';
                                                            echo '</table>';
                                                            echo '</div>';
                                                        }
                                                         else {
                                                             echo "No projects found for session: $session ";
                                                         }
                                                         ?>
                                                            </div>
                                                        

                                                        
                                                        <div class="table-responsive card-header">
                                                       
                                                            
                                                            
                                                        </div>
                                                        <?php
                                        } else 
                                        ?>
                            </div>
                            </div>
                                                    
                   <br>
                        <div class="card">
                            <div class="card-header pb-0">
                                
                                    <div class="col-lg-6 col-7">
                                       My Selected Group
                                    </div>
                                    <div class="card-body px-0 pb-2 ">
                                    <div class="table-responsive card-header " >
                                    <?php
                                            if( $teacher_name && $group_app==1)
                                            {
                                         ?>
                                                             <div class="col-md-6">
                                                                <div class="mb-3">
                                                                <button type="button" class="btn btn-danger" id="notMine">This group is not Mine</button>
                                                                </div>
                                                            </div>

                                                <div class="table-responsive card-header">
                                                <?php
                                                        
                                                        ////////////// Fatching All Information///////////////////
                                                        $query1 = "SELECT ps.*, u.* 
                                                        FROM project_students ps
                                                        
                                                        INNER JOIN users u ON ps.student_id = u.student_id
                                                        WHERE ps.group_leader = 1 AND ps.session = '$session' AND ps.group_approval='$teacher_name'";
                                                        $result1 = mysqli_query($connection, $query1);



                                                        
                                                        // Fetching All Information
                                                        if ($result1 && mysqli_num_rows($result1) > 0) {
                                                           echo '<div class="table-container">';
                                                           echo '<table id="searchResults" class="table">';
                                                         
                                                           echo '<thead>';
                                                           echo '<tr>';
                                                           echo '<th></th>'; // Checkbox column header
                                                           echo '<th>Group Number</th>';
                                                           echo '<th>Group Leader Name</th>';
                                                           echo '</tr>';
                                                           echo '</thead>';
                                                           echo '<tbody>';
                                                       
                                                           // Display each row of data
                                                           $rowCount = 0; // Track row count
                                                           while ($row = mysqli_fetch_assoc($result1)) {
                                                               $rowCount++; // Increment row count
                                                               echo '<tr class="group-row" data-group-number="' . $row['group_number'] . '">';
                                                               echo '<td><input type="checkbox" class="row-checkbox1" data-row="' . $rowCount . '"></td>';
                                                               // Checkbox for each row
                                                               echo '<td class="group-number">' . $row['group_number'] . '</td>';
                                                               echo '<td>' . $row['name'] . '</td>';
                                                               echo '</tr>';
                                                           }
                                                       
                                                           echo '</tbody>';
                                                           echo '</table>';
                                                           echo '</div>';
                                                       }
                                                        else {
                                                            echo "Please Select Your Group";
                                                        }
                                                        ?>
                                                 </div> 
                                                 <?php
                                        } else 
                                        ?>
                                    </div>
                                    </div>
                                    </div>
                                    
                                    </div>
                    </div>
                   

                    



                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                        <div class="card-header pb-0">
                          



                          
<h6>Please Create a New Project</h6>


                            <h6>Project Approval Pending</h6>

                            
                            <h6>Your Project Approved By <?php echo $approved_by_faculty ?> </h6>

                           




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
<!-- boot -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Action Successfully Updated</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Your action has been successfully updated.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>




<!-- Modal HTML -->
<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="responseModalLabel">Response</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Response content will be inserted here -->
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary close" data-dismiss="modal" aria-label="Close">Close</button>
            </div>
        </div>
    </div>
</div>


    </main>

    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugins/perfect-scrollbar.min.js"></script>
    

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
<script>
    function uncheckAllCheckboxes() {
    document.querySelectorAll('.row-checkbox').forEach(function(checkbox) {
        checkbox.checked = false;
    });
}

    // Function to check checkboxes within given range
    function checkRange(start, end) {
    var checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(function(checkbox) {
        var groupNumberElement = checkbox.closest('tr').querySelector('.group-number');
        if (groupNumberElement !== null) {
            var groupNumber = parseInt(groupNumberElement.textContent.trim());
            if (!isNaN(groupNumber) && groupNumber >= start && groupNumber <= end) {
                checkbox.checked = true; // Check the checkbox if it falls within the range
                console.log("Checkbox checked");
            } else {
                checkbox.checked = false; // Uncheck otherwise
                console.log("Checkbox unchecked");
            }
        }
    });
}


    // Event listener for changes in startGroup input
    document.getElementById('startGroup').addEventListener('change', function () {
        var startGroup = parseInt(this.value); // Parse the value to integer
        var endGroup = parseInt(document.getElementById('endGroup').value); // Get endGroup value
        console.log("Start group: " + startGroup);
        console.log("End group: " + endGroup);
        if (!isNaN(startGroup) && !isNaN(endGroup)) {
            // If both startGroup and endGroup are valid numbers
            checkRange(startGroup, endGroup); // Check the checkboxes within the range
        }
        else {
        uncheckAllCheckboxes(); // Uncheck all checkboxes if either start or end group is not a number
    }
    });

    // Event listener for changes in endGroup input
    document.getElementById('endGroup').addEventListener('change', function () {
        var endGroup = parseInt(this.value); // Parse the value to integer
        var startGroup = parseInt(document.getElementById('startGroup').value); // Get startGroup value
        console.log("Start group: " + startGroup);
        console.log("End group: " + endGroup);
        if (!isNaN(startGroup) && !isNaN(endGroup)) {
            // If both startGroup and endGroup are valid numbers
            checkRange(startGroup, endGroup); // Check the checkboxes within the range
        }
        else {
        uncheckAllCheckboxes(); // Uncheck all checkboxes if either start or end group is not a number
    }
    });

    // Event listener for row checkbox
    document.querySelectorAll('.row-checkbox').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            handleRowSelection(checkbox);
        });
    });

    document.getElementById('selectMine').addEventListener('click', function () {
    var selectedRows = document.querySelectorAll('.row-checkbox:checked');
    var groupNumbers = [];
    // Extract group numbers from the selected rows
    selectedRows.forEach(function (row) {
        groupNumbers.push(row.parentNode.nextElementSibling.textContent.trim());
    });

    // Send an AJAX request to update the database
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response if needed
            console.log(xhr.responseText); // Log the response from the server
            $('#successModal').modal('show');
            $('#successModal').on('hidden.bs.modal', function (e) {
    // Reload the page
    location.reload();
});
        }
    };
    xhr.open('POST', 'update_database.php', true); // Adjust the URL to your server-side script
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send('groupNumbers=' + JSON.stringify(groupNumbers)); // Send the selected group numbers to the server
});







$(document).ready(function() {
    $('#notMine').click(function() {
        // Array to store selected group numbers
        var selectedGroups = [];
        
        // Loop through each checked checkbox and extract the group number
        $('.row-checkbox1:checked').each(function() {
            selectedGroups.push($(this).closest('.group-row').data('group-number'));
        });

        // Check if any group is selected
        if(selectedGroups.length > 0) {
            // Ask for confirmation before proceeding with deletion
            var confirmation = confirm("Are you sure you want to delete the selected groups?");
            
            // Proceed with deletion if user confirms
            if (confirmation) {
                // Send an AJAX request to delete selected groups
                $.ajax({
                    url: 'delete_groups.php', // Adjust the URL according to your setup
                    method: 'POST',
                    data: { groups: selectedGroups },
                    success: function(response) {
                        console.log(response);
                        // Insert response into modal body
                        $('#responseModal .modal-body').html(response);
                        
                        // Show the modal
                        $('#responseModal').modal('show');
                     
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if any
                        console.error(xhr.responseText);
                    }
                });
            }
        } else {
            alert('Please select at least one group to delete.');
        }
    });
});




// Attach click event handler to the "Close" button inside the modal
$(document).on('click', '.close', function() {
    // Reload the page upon modal close
    console.log('hi');
    location.reload();
});
// Attach click event handler to the "Close" button inside the modal




</script>

<script>
    // Add event listener to input field for dynamic search
    document.getElementById('searchText').addEventListener('input', searchProjects);

    function searchProjects() {
        // Get search criteria from the form
        var searchText = document.getElementById('searchText').value;

        // AJAX request to fetch search results
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('searchResults').innerHTML = xhr.responseText;
            }
        };
        // Adjust the URL to your server-side script
        xhr.open('GET', 'search.php?searchText=' + encodeURIComponent(searchText), true);
        xhr.send();
    }
    
</script>

</body>

</html>
