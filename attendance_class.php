<?php

class Attendance
{
    private $conn; // MySQLi connection object

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAttendanceForMonth($month, $year) {
        $attendanceData = array();

        // Query the database to fetch attendance records for the specified month and year
        $sql = "SELECT staff_id FROM attendance WHERE MONTH(date) = ? AND YEAR(date) = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch the attendance records
        while ($row = $result->fetch_assoc()) {
            $staffId = $row['staff_id'];

            // Store the staff ID in the array
            $attendanceData[$staffId][] = true;
        }

        return $attendanceData;
    }
    

    public function markAttendance($staffId, $date, $status)
    {
        // Check if attendance already marked for the staff and date
        $existingAttendance = $this->getAttendanceByStaffAndDate($staffId, $date);
        if ($existingAttendance) {
            // Attendance already marked for the staff and date
            return false;
        }

        $sql = "INSERT INTO attendance (staff_id, date, status) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iss", $staffId, $date, $status);
        $stmt->execute();
        return true;
    }

    private function getAttendanceByStaffAndDate($staffId, $date)
    {
        $sql = "SELECT * FROM attendance WHERE staff_id = ? AND date = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("is", $staffId, $date);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function getAttendanceByDate($date)
    {
        $sql = "SELECT staff.name, attendance.status
                FROM attendance
                INNER JOIN staff ON attendance.staff_id = staff.id
                WHERE attendance.date = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $date);
        $stmt->execute();
        $result = $stmt->get_result();

        $attendanceData = array();
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }

        return $attendanceData;
    }

    public function getAttendanceByStaff($staffId)
    {
        $sql = "SELECT date, status
                FROM attendance
                WHERE staff_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $staffId);
        $stmt->execute();
        $result = $stmt->get_result();

        $attendanceData = array();
        while ($row = $result->fetch_assoc()) {
            $attendanceData[] = $row;
        }

        return $attendanceData;
    }

    public function calculatePayroll($staffId, $month, $year)
    {
        $sql = "SELECT COUNT(*) AS absent_days
                FROM attendance
                WHERE staff_id = ? AND MONTH(date) = ? AND YEAR(date) = ? AND status = 'Absent'";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("iii", $staffId, $month, $year);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $absentDays = $row['absent_days'];

        $monthlySalary = $this->getMonthlySalary($staffId);
        $dailyPay = $monthlySalary / cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $deductedAmount = $absentDays * $dailyPay;
        $payroll = $monthlySalary - $deductedAmount;

        return $payroll;
    }

    private function getMonthlySalary($staffId)
    {
        $sql = "SELECT monthly_salary
                FROM staff
                WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $staffId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['monthly_salary'];
    }
}
