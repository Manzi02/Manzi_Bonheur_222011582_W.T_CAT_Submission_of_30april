<?php
// Connection details
    $host = "localhost";
    $user = "MANZI";
    $pass = "Bonheur";
    $database = "gym_information_system";

// Creating connection
$connection = new mysqli($host, $user, $pass, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>