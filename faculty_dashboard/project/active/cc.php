<!-- Include Bootstrap CSS -->
<?php
include '../../../database.php';
?>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Include jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Include Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Button to trigger the modal -->
<button class="btn btn-primary action-btn00">Action</button>

<!-- Modal -->    
<div class="modal fade " id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="row custom-modal">
    <!-- First Modal -->
    <div class="col-md-6 ">
        <div class="modal-dialog ">
            <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Project Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
            <p><strong>Date:</strong> <span id="date"></span></p>
                <p><strong>Group Number:</strong> <span id="groupNumber"></span></p>
                <p><strong>Project Name:</strong> <span id="projectName"></span></p>
                <span style="display: none;" id="projectid"></span>


                <div class="form-group">
                <strong>Project Activity</strong> 
                <div id="projectdes"></div>
            
                </div>

                <!-- Present System -->
                <p><strong>Present System:</strong></p>
                <div id="groupMembers"></div> <!-- Placeholder for group members checkboxes -->




                <!-- Comment section -->
                <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" id="comment" value="comment" rows="3"></textarea>
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <!-- Submit button -->
                <button type="button" class="btn btn-success action-btn1" data-status="complete" >Complete</button>
                <button type="button" class="btn btn-warning action-btn1" data-status="partially">Partially</button>
                <button type="button" class="btn btn-danger action-btn1" data-status="not-complete">Not Complete</button>
                
                <!-- Close button -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!-- Additional buttons -->
                
            </div>
            </div>
        </div>
        </div>


    <div class="col-md-6">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h5 class="modal-title" id="taskModalLabel">Task Details</h5>
                            
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                        
                            <!-- Add your content for the Task modal here -->
                            <div id="task"></div>
                            <!-- Task details can be added here -->
                            <div id="task-container">
                                    <!-- Tasks will be dynamically added here -->
                                </div>

                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <!-- Add buttons or actions specific to the Task modal here -->
                        </div>
                    </div>
                </div>
            </div>

            </div>
            </div>

<!-- Script to trigger the modal -->
<script>
    $(document).ready(function() {
        $('.action-btn00').click(function() {
            $('#exampleModal').modal('show');
        });
    });
</script>
<script>





    
</script>
