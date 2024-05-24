<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();

include '../../extention/header_database.php';

// Define start and end dates
$querya = "SELECT * FROM project_students WHERE group_number = '$user_group_number' AND group_leader='1'";
$resulta = mysqli_query($connection, $querya);

if ($resulta && mysqli_num_rows($resulta) > 0) {
    $row = mysqli_fetch_assoc($resulta);
    $group_approval_name = $row['group_approval'];
    
} else {
    $group_approval = ' ';
}

$queryt = "SELECT * FROM time WHERE teacher_name = '$group_approval_name' AND session= '$session'";
$resultt = mysqli_query($connection, $queryt);

if ($resultt && mysqli_num_rows($resultt) > 0) {
    $row = mysqli_fetch_assoc($resultt);

    $startDate = $row['starting_date']; // Example start date
    $endDate = $row['ending_date']; // Example end date
    $day =   $row['class_date'];
    
} else {
    $startDate =  ' '; // Example start date
    $endDate =  ' '; // Example end date
    $day = ' ';
}


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






// Calculate duration based on start and end dates
$startDateTime = new DateTime($startDate);
$endDateTime = new DateTime($endDate);
$interval = $startDateTime->diff($endDateTime);
$duration = $interval->days + 1; // Add 1 to include the end date
// Retrieve the selected project ID from the AJAX request
$projectId = $_POST['project_id'];

// Query the database to fetch project management content based on the selected project ID
// Here, you will fetch the data from your database based on the $projectId
// For demonstration purposes, I'll generate a sample HTML content
$y = 1;

// Generate the HTML content for project management based on fetched data
$projectManagementHTML = '<div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>';
for ($i = 1; $i <= $duration; $i++) {
    $currentDate = clone $startDateTime;
    $currentDate->modify('+' . ($i - 1) . ' days');

    // Check if the current day is a Friday
    if ($currentDate->format('N') == $day) { // 5 corresponds to Friday
        $backgroundColor = '#f7cb73'; // Default background color
        // Define start and end dates
        $querys = "SELECT * FROM project_management WHERE project_id = '$projectId' AND time='" . $currentDate->format('d-m-Y') . "'";
        $results = mysqli_query($connection, $querys);

        if ($results && mysqli_num_rows($results) > 0) {
            $row = mysqli_fetch_assoc($results);
            $status = $row['status'];
            $title = $row['title'];
            $description = $row['description'];
            
        } else {
            $status = 'Click Here For Update Your Project';
            $title = '';
            $description = '';
           
        }

        // Determine background color based on $status
        switch ($status) {
            case 'Pending':
                $backgroundColor = 'lightblue';
                break;
            case 'complete':
                $backgroundColor = 'green';
                break;
            case 'partially':
                $backgroundColor = 'yellow';
                break;
            case 'not-complete':
                $backgroundColor = 'pink';
                break;
            default:
                // Use default background color
        }
        $blinkClass = ($currentDate->format('Y-m-d') == $tt) ? 'blink-pink' : '';
        $projectManagementHTML .= '<tr class="edit-date date-cell " style="background-color: ' . $backgroundColor . ';">';
        $projectManagementHTML .= '<td style="color: black;">' . $y . '</td>'; // Display day number
        $projectManagementHTML .= '<td style="color: black;" class="date-cell" >' . $currentDate->format('d-m-Y') . '</td>';
        $projectManagementHTML .= '<td style="color: black;">' . $status .'</td>';
        $projectManagementHTML .= '<td style="display: none;">' . $title .'</td>';
        $projectManagementHTML .= '<td value="$description" style="display: none;">' . $description .'</td>';
        $y = $y + 1;
        $projectManagementHTML .= '</tr>';
    }
    // Add more columns as needed
}

$projectManagementHTML .= '</tbody>
                        </table>
                    </div>';

// Echo the generated HTML content back to the AJAX request
echo $projectManagementHTML;
?>
<style>
    @keyframes blink {
  50% {
    background-color: pink;
  }
}

.blink-pink {
  animation: blink 1s infinite;
}
    </style>
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
                        <label for="present">Present</label>
                        <div id="present" class="form-control"></div>
                </div>

                    <div class="form-group">
                        <label for="editDescription">Description:</label>
                        <textarea class="form-control" id="editDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                
                <div id="button1"> </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    var currentTitle = ''; // Variable to store current title
    var currentDescription = ''; // Variable to store current description

    // Function to handle click event on date cells
    $('.edit-date').click(function() {
        // Get the date associated with the clicked cell
        var date = $(this).find('td:nth-child(2)').text(); // Get the date from the second column
        var projectId = <?php echo json_encode($projectId); ?>; // Get the project ID from PHP variable

        console.log('edit',date);
        function fetchAndDisplayStatus() {
        $.ajax({
            url: 'fetch_status.php?date=' + date, // Path to your server-side script that fetches the status
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                // Iterate through the response data
                var html = '<ul>';
                $.each(response, function (studentId, status) {
                    html += '<li>' + studentId + ' - ' + status + '</li>';
                });
                html += '</ul>';

                // Display the status data in the present div
                $('#present').html(html);
            },
            error: function (xhr, status, error) {
                console.error('Error occurred while fetching status:', error);
            }
        });
    }


        $.ajax({
            type: 'POST',
            url: 'process_date.php', // Replace 'process_date.php' with the actual path to your PHP script
            data: {date: date,projectId: projectId}, // Send the date variable to the PHP script
            success: function(response) {
                console.log('Response from PHP script: ' + response);
                $('#button1').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error sending date: ' + error);
            }
        });
        // Set the date in the modal header
        $('#editModalLabel').text('Edit Content - ' + date); // Update the modal title with the date
        
        // Get the title and description associated with the clicked cell
        currentTitle = $(this).find('td:nth-child(4)').text(); // Get the title from the third column
        currentDescription = $(this).find('td:nth-child(5)').text(); // Get the description from the fourth column
        
        // Set the title and description in the modal form fields
        $('#editTitle').val(currentTitle); // Set the value of the editTitle input field
        $('#editDescription').val(currentDescription); // Set the value of the editDescription textarea
            // Call the fetchAndDisplayStatus function when the document is ready
    fetchAndDisplayStatus();
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

    // Function to handle submission of the edit form
    function submitEdit() {
        // Get the edited data from the form
        var editedTitle = $('#editTitle').val();
        var editedDescription = $('#editDescription').val();
        var date = $('#editModalLabel').text().split(' - ')[1]; // Extract the date from the modal title

        // Make an AJAX request to send the form data to the server
        $.ajax({
            type: 'POST',
            url: 'save_project_management.php', // Update the URL to your PHP script
            data: {
                project_id: <?php echo $projectId; ?>,
                title: editedTitle,
                description: editedDescription,
                time: date, // Send the date to the server
                group_number: <?php echo $user_group_number; ?> ,
                session: '<?php echo $session; ?>'
            },
            success: function(response) {
                // Handle the response from the server
                if (response === 'success') {
                    // Optionally, you can perform actions upon successful insertion
                    console.log('Data saved successfully');
                    // Reload the window after successful submission
                    window.location.reload();
                } else {
                    console.error('Failed to save data');
                }
                // Close the modal regardless of success or failure
                $('#editModal').modal('hide');
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                // Close the modal in case of error
                $('#editModal').modal('hide');
            }
        });
    }
    $(document).ready(function() {
        

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

