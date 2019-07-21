<?php
// Database configuration
$dbHost     = "localhost"; // database host
$dbUsername = "root";  // database username
$dbPassword = ""; // database password
$dbName     = "highlight";  // database name

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}
?>