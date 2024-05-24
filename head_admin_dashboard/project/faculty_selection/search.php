<?php
// Include database connection

// Start session
session_start();
include '../../../database.php';

$teacher_id = $_SESSION['admin'];

$query1 = "SELECT * FROM users WHERE teacher_id = '$teacher_id'";
$result1 = mysqli_query($connection, $query1);

if ($result1 && mysqli_num_rows($result1) > 0) {
    $row = mysqli_fetch_assoc($result1);
    $session = $row['session'];
}
$sessionfaculty = $session . 'faculty';
// Check if the script is called via AJAX
if (isset($_GET['searchText'])) {
    // Get search criteria from the request
    $searchText = $_GET['searchText'];

    // Build the SQL query based on the search criteria
    $query = "SELECT * FROM users WHERE role='faculty' AND 
    NOT EXISTS (SELECT 1 FROM $sessionfaculty as s WHERE s.teacher_id = users.teacher_id)";

    // Add search condition if search text is provided
    // Add search condition if search text is provided
    if (!empty($searchText)) {
        // Check if the search text is numeric
        if (is_numeric($searchText)) {
            // Search by group number
            $query .= " AND LOWER(teacher_id) LIKE '%" . strtolower($searchText) . "%'"; // Assuming group_number is an integer
        } else {
            // Search by name (assuming 'name' is the column you want to search in the users table)
            $query .= " AND LOWER(name) LIKE '%" . strtolower($searchText) . "%'";
        }
    }

    // Execute the query
    $result = mysqli_query($connection, $query);

    // Build HTML table for search results
    $table = '<table class="table">';
    $table .= '<thead>';
    $table .= '<tr>';
    $table .= '<th></th>';
    $table .= '<th>Teacher ID</th>';
    $table .= '<th>Teacher Name</th>';
    // Add more table headers as needed for other columns
    $table .= '</tr>';
    $table .= '</thead>';
    $table .= '<tbody>';
// Display each row of data
$rowCount = 0; // Track row count
    // Fetch and add rows to the HTML table
    while ($row = mysqli_fetch_assoc($result)) {
        $rowCount++; // Increment row count
        
        $table .= '<tr class="group-row" data-group-number="' . $row['teacher_id'] . '">';
        $table .= '<td><input type="checkbox" class="row-checkbox" data-row="' . $rowCount . '"></td>';
        $table .= '<td class="group-number">' . $row['teacher_id'] . '</td>';
        $table .= '<td>' . $row['name'] . '</td>';
        // Add more table data cells as needed for other columns
        $table .= '</tr>';
    }

    $table .= '</tbody>';
    $table .= '</table>';

    // Send HTML table response
    echo $table;

    // Close connection
    $connection->close();
} else {
    // If not called via AJAX, return empty response or handle differently
    echo "Invalid request";
}
?>
