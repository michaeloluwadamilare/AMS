<?php
// Database connection configuration
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'attendance_db';

// Create a database connection
$conn = new mysqli($hostname, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}
