<?php
$servername = "localhost"; // Change if your database is hosted elsewhere
$username = "root";        // Change if using a different DB user
$password = "";            // Change if your MySQL has a password
$database = "travella_db"; // Your database name

// Create MySQLi connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
