<?php
// Connection details
$host = "localhost";
$user = "noble@";
$pass = "222001745";
$database = "travelbookingsystem";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>

