<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the group number is provided in the POST request
if(isset($_POST['groupNumber'])) {
    // Get the group number from the POST request
    $groupNumber = $_POST['groupNumber'];
    $date = $_POST['date'];

    // Query to fetch group members (student names) based on the group number
    $query = "SELECT * FROM project_students AS ps
              INNER JOIN users AS u ON ps.student_id = u.student_id
              WHERE ps.group_number = '$groupNumber'";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';

    // Check if there are any group members
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the group members and generate HTML for checkboxes
        while ($row = mysqli_fetch_assoc($result)) {
            $studentName = $row['name'];
            $studentId = $row['student_id'];
            $html .= '<div class="form-check">';
            $html .= '<input class="form-check-input" type="checkbox" id="' . $studentId . '" name="groupMembers[]" value="' . $studentId . '">';
            $html .= '<label class="form-check-label" for="' . $studentId . '">' . $studentId . ' - ' . $studentName . '</label>';
            $html .= '</div>';
        }
    } else {
        // If no group members found, display a message
        $html .= '<p>No group members found</p>';
    }

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>

<script>
$(document).ready(function () {
     // Function to fetch the status of each student from the database
     function fetchStatus() {
        $.ajax({
            url: 'fetch_status.php', // Replace 'fetch_status.php' with your PHP script that fetches the status
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                // Iterate through the response data
                $.each(response, function (studentId, status) {
                    // Set the checkbox state based on the status
                    $('#' + studentId).prop('checked', status === 'present');
                });
            },
            error: function (xhr, status, error) {
                console.error('Error occurred while fetching status:', error);
            }
        });
    }

    // Fetch the status when the document is ready
    fetchStatus();



    var checkedState = {}; // Object to store the state of checkboxes

    $('.form-check-input').on('change', function () {
        var isChecked = $(this).prop('checked');
        var studentId = $(this).val();
        var date = <?php echo json_encode($date); ?>;
        var studentName = $(this).siblings('.form-check-label').text().trim();
        var splitName = studentName.split(' - ');
        var onlyName = splitName[1];
      
        // Store the state of the checkbox
        checkedState[studentId] = isChecked;
        console.log(checkedState[studentId] );
    });
    var date = <?php echo json_encode($date); ?>;
    // Event handler for closing the popup/modal
    $('#exampleModal').on('hidden.bs.modal', function () {
        console.log('hi');
        // Iterate through each checkbox inside the modal
        $('.form-check-input').each(function () {
            console.log('hi1');
            var studentId = $(this).val();
            var isChecked = $(this).prop('checked');
            var storedState = checkedState[studentId];
            var studentName = $(this).siblings('.form-check-label').text().trim();
        var splitName = studentName.split(' - ');
        var onlyName = splitName[1];

            // Determine status based on checkbox state
            var status = isChecked ? 'present' : 'absent';
            //console.log(studentId);
            //console.log(status);
            // Perform AJAX call to insert data into the database
            $.ajax({
                url: 'insert.php',
                method: 'POST',
                data: {studentId: studentId, date: date,onlyName:onlyName, status: status},
                success: function (response) {
                    
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    console.error('Error occurred while inserting data:', error);
                }
            });
        });
    });
});


    </script>

    