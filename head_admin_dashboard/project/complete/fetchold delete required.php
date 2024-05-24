<?php
// Include necessary files and start session if needed
include '../../../database.php';
session_start();
// Define start and end dates
$startDate = '2024-03-20'; // Example start date
$endDate = '2024-04-03'; // Example end date

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

// Generate the HTML content for project management based on fetched data
$projectManagementHTML = '<div class="table-responsive">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th>Day</th>
                                        <th>Date</th>
                                        <th>Content</th>
                                    </tr>
                                </thead>
                                <tbody>';
                                for ($i = 1; $i <= $duration; $i++) {
                                    $currentDate = clone $startDateTime;
                                    $currentDate->modify('+' . ($i - 1) . ' days');
                                
                                    // Check if the current day is a Friday
                                    if ($currentDate->format('N') == 5) { // 5 corresponds to Friday
                                        $projectManagementHTML .= '<tr class="edit-date">';
                                        $projectManagementHTML .= '<td>' . $i . '</td>'; // Display day number
                                        $projectManagementHTML .= '<td style="background-color: pink;" class="date">' . $currentDate->format('d-m-Y') . '</td>';
                                        $projectManagementHTML .= '<td>Content for day ' . $i . '</td>';
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
