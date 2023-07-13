<?php
require_once 'connection.php';
require_once 'attendance_class.php';

// Start the session to access session data
session_start();

// Check if the user is authenticated, redirect to login page if not
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

// Create an instance of the Attendance class
$attendance = new Attendance($conn);

// Process the attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $staffId = $_POST['staff_id'];
    $attendanceStatus = $_POST['attendance'];
    $date = date('Y-m-d');
    // Update the staff attendance
    $attendance->markAttendance($staffId,$date, $attendanceStatus);

    // Redirect back to the attendance page
    header("Location: staffattendance.php");
    exit;
}
?>
