<style>
.task {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.task-label {
    flex: 1; /* Takes up remaining space */
    margin-right: 10px;
    font-size: 16px;
}

.edit-btn, .delete-btn {
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

    .confirm-btn {
        padding: 8px 12px;
        font-size: 14px;
        border: none;
        border-radius: 4px;
        background-color: #28a745; /* Green color for confirm button */
        color: #fff;
        cursor: pointer;
        margin-right: 5px;
    }

    /* Hover effect for confirm button */
    .confirm-btn:hover {
        opacity: 0.8;
    }



.edit-btn {
    background-color: #007bff; /* Blue color for edit button */
    color: #fff;
}

.delete-btn {
    background-color: #dc3545; /* Red color for delete button */
    color: #fff;
    margin-left: 5px;
}

/* Hover effect for buttons */
.edit-btn:hover, .delete-btn:hover {
    opacity: 0.8;
}

    .insert-btn {
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #007bff; /* Blue color for insert button */
    color: #fff;
    cursor: pointer;
    margin-right: 5px;
}

/* Hover effect for insert button */
.insert-btn:hover {
    opacity: 0.8;
}

.task-textarea {
    width: 100%;
    display: block;
    margin-bottom: 10px;
}

.confirm-btn {
    padding: 8px 12px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    background-color: #28a745; /* Green color for confirm button */
    color: #fff;
    cursor: pointer;
    margin-right: 5px;
}

/* Hover effect for confirm button */
.confirm-btn:hover {
    opacity: 0.8;
}

   

</style>
<?php
// Include necessary files and start session if needed
include '../../../database.php';

// Check if the group number is provided in the POST request
if(isset($_GET['groupNumber'])) {
    // Get the group number from the POST request
    $groupNumber = $_GET['groupNumber'];

    // Query to fetch group members (student names) based on the group number
    $query = "SELECT * FROM tasks WHERE group_number = '$groupNumber'";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';
   
    // Check if there are any group members
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop through the group members and generate HTML for tasks
        while ($row = mysqli_fetch_assoc($result)) {
            $task_name = $row['task_name'];
            $taskId = $row['id'];
            $task_no = $row['task_no'];
            $html .= '<div class="task">';
            $html .= '<label class="task-label" for="">Task No:' . $task_no . '</label>';
            $html .= '<label class="task-label" for="' . $taskId . '">' . $task_name . '</label>';
            $html .= '<button class="edit-btn" data-task-id="' . $taskId . '">Edit</button>';
            $html .= '<button class="delete-btn" data-task-id="' . $taskId . '">Delete</button>';
            $html .= '</div>';
        }
    } else {
        // If no group members found, display a message
        $html .= '<p>No Comment found</p>';
    }

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>
<script>



    </script>