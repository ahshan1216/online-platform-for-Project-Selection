<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();
$teacher_id = $_SESSION['teacher_id'];

// Retrieve the clicked date from the AJAX request
$date = $_POST['date'];


$query = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result = mysqli_query($connection, $query);

$html = ''; // Initialize HTML variable

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $session = $row['session'];
    $name = $row['name'];
}
    else {
        // Handle case where user data is not found
        $html .= '<tr><td colspan="3">User data not found</td></tr>';
    }
  

    // Table header
    $html .= '<thead>';
    $html .= '<tr>';
    $html .= '<th>Group Number</th>';
    $html .= '<th>Project Name</th>';
    $html .= '<th>Action</th>';
    
    $html .= '</tr>';
    $html .= '</thead>';

    // Table body
    $html .= '<tbody id="tableId">';
   
    $queryy = "SELECT * FROM $session
    WHERE approved_by_faculty = '$name'
    ORDER BY group_number ASC";

$resulty = mysqli_query($connection, $queryy);
if ($resulty && mysqli_num_rows($resulty) > 0) {
    while ($rowy = mysqli_fetch_assoc($resulty)) {
        $projectId = $rowy['id'];

        // Query to get the status from project_management table
        $query_status = "SELECT status FROM project_management WHERE project_id = '$projectId' AND time='$date'";
        $result_status = mysqli_query($connection, $query_status);

        if ($result_status && mysqli_num_rows($result_status) > 0) {
            $status_row = mysqli_fetch_assoc($result_status);
            $status = $status_row['status'];
        } else {
            $status = ''; // Default status if not found
        }

        // Set row color based on status
        $rowColor = '';
        switch ($status) {
            case 'complete':
                $rowColor = 'style="background-color: green;"';
                break;
            case 'not-complete':
                $rowColor = 'style="background-color: pink;"';
                break;
            case 'partially':
                $rowColor = 'style="background-color: #f7cb73;"';
                break;
            case 'pending':
                $rowColor = 'style="background-color: lightblue;"';
                break;
            default:
                $rowColor = ''; // Default color (white)
                break;
        }

        $html .= '<tr data-projectid="' . $rowy['id'] . '" ' . $rowColor . '>';
            $html .= '<td class="group-number" style="color: black;">' . $rowy['group_number'] . '</td>'; // Add class for group number
            $html .= '<td class="project-name" style="color: black;">' . $rowy['project_name'] . '</td>'; // Add class for project name
            $html .= '<td class="date-cell" style="display: none;">' . $date . '</td>';
           $html .= '<td class="project-id" style="display: none;">' . $rowy['id'] . '</td>';
            $html .= '<td><button class="btn btn-primary action-btn" data-group="' . $rowy['group_number'] . '">Action</button></td>';
           
            $html .= '</tr>';
        }
    }
        
     else {
        // Handle case where no data is found
        $html .= '<tr><td colspan="3">No data available</td></tr>';
    }
    $html .= '</tbody>';


// Echo the generated HTML content back to the AJAX request
echo $html;
?>

<script>
$(document).ready(function() {
    // Handle click event on action buttons
    $('.action-btn').click(function() {
        // Retrieve data from the clicked row
        var groupNumber = $(this).closest('tr').find('.group-number').text();
        var projectName = $(this).closest('tr').find('.project-name').text();
        var projectid = $(this).closest('tr').find('.project-id').text();
        var date = $(this).closest('tr').find('.date-cell').text();

        // Debugging: Log data to console
        console.log('Group Number:', groupNumber);
        console.log('Project Name:', projectName);
        console.log('Date:', date);

        // Set the content of the modal header
        $('#groupNumber').text(groupNumber);
        $('#projectName').text(projectName);
        $('#projectid').text(projectid);
        $('#date').text(date);

        // Clear previous group members
        $('#groupMembers').empty();

        // Fetch group members via AJAX
        $.ajax({
            url: 'fetch1.php',
            method: 'POST',
            data: { groupNumber: groupNumber,date:date },
            success: function(response) {
                // Append fetched group members to the modal body
                $('#groupMembers').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error fetching group members:', error);
            }
        });

        $.ajax({
            url: 'fetch2.php',
            method: 'POST',
            data: { projectid: projectid ,date:date },
            success: function(response) {
                // Append fetched group members to the modal body
                $('#projectdes').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error fetching group members:', error);
            }
        });

        $.ajax({
            url: 'fetch3.php',
            method: 'POST',
            data: { projectid: projectid ,date:date },
            success: function(response) {
                // Append fetched group members to the modal body
                $('#comment').html(response);
            },
            error: function(xhr, status, error) {
                // Handle error
                console.error('Error fetching group members:', error);
            }
        });


        // Show the modal
        $('#exampleModal').modal('show');
    });
});





$(document).ready(function() {
    $('.action-btn1').off('click').on('click', function() {
      // Retrieve data from the modal
      var groupNumber = $('#groupNumber').text();
      var comment = $('#comment').val();
      var status = $(this).data('status'); // Get status from data-status attribute
      var date = $('#date').text(); // Retrieve the date from the modal
      var projectid = $('#projectid').text();
      var session = <?php echo json_encode($session); ?>;

      // Debugging: Log data to console
      console.log('Group Number:', groupNumber);
      console.log('Comment:', comment);
      console.log('Status:', status);
      console.log('Date:', date);
      

      // Send AJAX request to update project status
      $.ajax({
        type: 'POST',
        url: 'update_project_status.php',
        data: {
          groupNumber: groupNumber,
          status: status,
          projectid: projectid,
          session:session,
          comment: comment,
          
          date: date // Include date in the data sent to update_project_status.php
        },
        success: function(response) {
                            // Debugging: Log response from server
                            console.log(response);
                            var rowStyle = '';
                            switch (response) {
                                case 'complete':
                                    rowStyle = 'background-color: green;';
                                    break;
                                case 'not-complete':
                                    rowStyle = 'background-color: pink;';
                                    break;
                                case 'partially':
                                    rowStyle = 'background-color: #f7cb73;';
                                    break;
                                case 'pending':
                                    rowStyle = 'background-color: lightblue;';
                                    break;
                                default:
                                    // Handle other cases here
                                    break;
                            }

                            $('#tableId').find('tr[data-projectid="' + projectid + '"]').attr('style', rowStyle);

                    },
        error: function(xhr, status, error) {
          // Handle errors
          console.error('Error:', error);
        }
        });
    });
});


</script>

