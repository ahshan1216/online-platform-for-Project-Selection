<?php
$servername = "localhost";
$username = "etisparl_versity";
$password = "etisparl_versity";
$dbname = "etisparl_versity";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

?>
