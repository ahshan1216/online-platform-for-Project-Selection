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
if(isset($_POST['groupNumber'])) {
    // Get the group number from the POST request
    $groupNumber = $_POST['groupNumber'];


    // Query to fetch group members (student names) based on the group number
    $query = "SELECT * FROM tasks WHERE group_number = '$groupNumber'";
    $result = mysqli_query($connection, $query);

    // Initialize an empty string to store HTML content
    $html = '';
    $html .= '<button id="insert-btn" class="insert-btn">Insert Task</button>';
   

    // Return the HTML content
    echo $html;
} else {
    // If the group number is not provided in the POST request, display an error message
    echo 'Error: Group number not provided';
}
?>

<script>
$(document).ready(function() {
    console.log("Number of .edit-btn elements:", $('.edit-btn').length);
    // Remove existing event handlers for .edit-btn
    $(document).off('click', '.edit-btn');
    $(document).on('click', '.edit-btn', function(event) {
        console.log("Edit button clicked");
        var button = event.target;
        var taskId = button.getAttribute('data-task-id');
        var taskLabel = document.querySelector('label[for="' + taskId + '"]');
        var taskText = taskLabel.textContent.trim();
        var textarea = document.createElement('textarea');
        textarea.value = taskText;
        textarea.style.color = '#000'; // Set text color to black
        taskLabel.parentNode.insertBefore(textarea, taskLabel);
        taskLabel.style.display = 'none';
        button.style.display = 'none';
        var confirmButton = document.createElement('button');
        confirmButton.textContent = 'Confirm';
        confirmButton.classList.add('confirm-btn'); // Add 'confirm-btn' class to the button
        taskLabel.parentNode.insertBefore(confirmButton, taskLabel);
        confirmButton.addEventListener('click', function () {
            var newTaskText = textarea.value.trim();
            // Update task via AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_task.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                    // Update the task label with the new text
                    taskLabel.textContent = newTaskText;
                    // Clean up
                    textarea.parentNode.removeChild(textarea);
                    confirmButton.parentNode.removeChild(confirmButton);
                    taskLabel.style.display = 'inline';
                    button.style.display = 'inline';
                    updateTaskList();
                }
            };
            xhr.send('taskId=' + encodeURIComponent(taskId) + '&newTaskText=' + encodeURIComponent(newTaskText));
        });
    });
});

</script>



<script>
    // Function to fetch and update tasks from the server
    var groupNumber = "<?php echo $groupNumber; ?>"; // Assign groupNumber from PHP
    function updateTaskList() {
        console.log(groupNumber);
        // Send an AJAX request to fetch the updated task list
        var xhr = new XMLHttpRequest();
xhr.open('GET', 'fetch_tasks.php?groupNumber=' + encodeURIComponent(groupNumber), true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                // Update the task container with the fetched HTML content
                document.getElementById('task-container').innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    // Call the updateTaskList function initially to fetch and display tasks
    //updateTaskList();

    // Periodically update the task list every 2 seconds
    //setInterval(updateTaskList, 2000);
</script>





<script>

$(document).ready(function() {
    // Handle click event on action buttons
    $('.insert-btn').on('click', function() {
        var groupNumber = "<?php echo $groupNumber; ?>"; // Assign groupNumber from PHP
        var insertButton = document.getElementById('insert-btn');

        var textarea = document.createElement('textarea');
        textarea.placeholder = "Enter task here";
        textarea.classList.add('task-textarea'); // Add class for styling
        var confirmButton = document.createElement('button');
        confirmButton.textContent = 'Confirm';
        confirmButton.classList.add('confirm-btn'); // Add 'confirm-btn' class to the button

        // Insert textarea and confirm button before the insert button
        insertButton.parentNode.insertBefore(textarea, insertButton);
        insertButton.parentNode.insertBefore(confirmButton, insertButton);

        // Hide the insert button
        insertButton.style.display = 'none';

        confirmButton.addEventListener('click', function () {
            var newTaskText = textarea.value.trim();
            // Check if the textarea is not empty
            if (newTaskText !== "") {
                // Update task via AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'insert_task.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == XMLHttpRequest.DONE && xhr.status == 200) {
                        // Create new task element and append it to the task container
                        var taskContainer = document.getElementById('task-container'); // Assuming you have a task container
                        var newTaskLabel = document.createElement('label');
                        newTaskLabel.textContent = newTaskText;
                        taskContainer.appendChild(newTaskLabel);

                        // Clean up
                        textarea.parentNode.removeChild(textarea);
                        confirmButton.parentNode.removeChild(confirmButton);
                        insertButton.style.display = 'inline'; // Show the insert button again
                        updateTaskList();
                    }
                };
                xhr.send('taskText=' + encodeURIComponent(newTaskText) + '&groupNumber=' + encodeURIComponent(groupNumber));
            } else {
                // If textarea is empty, show an alert
                alert("Please enter a task.");
            }
        });
    });

});
$(document).off('click', '.delete-btn');
// Handle click event on delete buttons using event delegation
$(document).on('click', '.delete-btn', function() {
    var button = $(this); // The clicked delete button
    var taskId = button.data('task-id'); // Get the task ID from data attribute
    var confirmation = confirm('Are you sure you want to delete this task?');
    
    if (confirmation) {
        // Delete task via AJAX
        $.ajax({
            url: 'delete_task.php',
            method: 'POST',
            data: { taskId: taskId },
            success: function(response) {
                // Remove the task element from the DOM
                $('.task [for="' + taskId + '"]').parent().remove();
                updateTaskList();
            },
            error: function(xhr, status, error) {
                console.error('Error deleting task:', error);
            }
        });
    }
});

</script>