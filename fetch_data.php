<?php

include 'database.php';

// Write your query to fetch specific table data
$sql = "SELECT * FROM notice order by id DESC";
$result = $connection->query($sql);

$data = array();
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}
echo json_encode($data);

$connection->close();
?>