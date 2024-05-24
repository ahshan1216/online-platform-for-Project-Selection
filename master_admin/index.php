<?php

// Include the database connection file
include '../database.php';
session_start();
echo '<div class="logout-btn">
<a href="/logout.php" class="btn btn-danger">Logout</a>
</div>';

$role=$_SESSION['role'] ;
$verify=$_SESSION['verify'];
if (!isset($_SESSION['master_admin']) || empty($_SESSION['master_admin'])) {
    // Redirect the user to the login page
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
}

if($role=='master_admin')
{
    if($verify)
    {
        $student_id = $_SESSION['master_admin'];
        

   

    }
    else
    {
        header("Location: ../credential/signin.php");
        exit(); // Make sure to stop the script execution after redirection
    }
    
     
}
   else
   {
    header("Location: ../credential/signin.php");
    exit(); // Make sure to stop the script execution after redirection
   }
// Fetch list of tables in the database
$tables_query = "SHOW TABLES";
$tables_result = $connection->query($tables_query);

// Check if tables exist
if ($tables_result->num_rows > 0) {
    // Iterate through each table
    while ($row = $tables_result->fetch_assoc()) {
        $table_name = $row["Tables_in_" . $dbname];

        // Fetch data from the current table
        $table_data_query = "SELECT * FROM " . $table_name;
        $table_data_result = $connection->query($table_data_query);

        // Display table name
        echo "<h2>Table: " . $table_name . "</h2>";

        // Check if table has any data
        if ($table_data_result->num_rows > 0) {
            // Display table data in a HTML table
            echo "<table border='1'><tr>";
            // Output table column names as table headers
            $field_names = array_keys($table_data_result->fetch_assoc());
            foreach ($field_names as $field_name) {
                echo "<th>" . $field_name . "</th>";
            }
            echo "<th>Actions</th>"; // Add a column for actions (delete and edit)

            echo "</tr>";

            // Move the pointer to the beginning of the result set
            $table_data_result->data_seek(0);

            // Output table data
            while ($row = $table_data_result->fetch_assoc()) {
                echo "<tr>";
                foreach ($row as $value) {
                    echo "<td>" . $value . "</td>";
                }

                // Add delete and edit buttons for each row
                echo "<td>";
                echo "<a href='delete.php?table=" . $table_name . "&id=" . $row['id'] . "'>Delete</a> | ";
                echo "<a href='edit.php?table=" . $table_name . "&id=" . $row['id'] . "'>Edit</a>";
                echo "</td>";

                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Table is empty";
        }

        // Free result memory
        $table_data_result->free_result();
    }
} else {
    echo "No tables found in the database";
}

// Close connection (if required)
//$connection->close();

?>
<style>
/* Style for the table */
table {
  width: 100%;
  border-collapse: collapse;
}

/* Style for table header */
th {
  padding: 10px;
  background-color: #f2f2f2;
  border: 1px solid #ddd;
}

/* Style for table data */
td {
  padding: 8px;
  border: 1px solid #ddd;
}

/* Style for actions column */
.actions-column {
  width: 100px; /* Adjust the width as needed */
  text-align: center;
}

/* Style for delete and edit links */
.actions-column a {
  display: inline-block;
  padding: 5px 10px;
  background-color: #007bff;
  color: #fff;
  text-decoration: none;
  border-radius: 3px;
  transition: background-color 0.3s;
}

/* Hover effect for delete and edit links */
.actions-column a:hover {
  background-color: #0056b3;
}
/* Style for the logout button */
.logout-btn {
  margin-bottom: 20px; /* Add some bottom margin for spacing */
  text-align: right; /* Align the button to the right */
}

.logout-btn .btn {
  margin-top: 10px; /* Add some top margin for spacing */
}

    </style>



