<?php
class Staff
{
    private $conn; // MySQLi connection object

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllStaff()
    {
        $sql = "SELECT * FROM staff";
        $result = $this->conn->query($sql);

        $staffData = array();
        while ($row = $result->fetch_assoc()) {
            $staffData[] = $row;
        }

        return $staffData;
    }

    public function getStaffById($staffId)
    {
        $sql = "SELECT * FROM staff WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $staffId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function addStaff($name, $monthlySalary)
    {
        $sql = "INSERT INTO staff (name, monthly_salary) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sd", $name, $monthlySalary);
        return $stmt->execute();
    }

    public function updateStaff($staffId, $name, $monthlySalary)
    {
        $sql = "UPDATE staff SET name = ?, monthly_salary = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sdi", $name, $monthlySalary, $staffId);
        return $stmt->execute();
    }

    public function deleteStaff($staffId)
    {
        $sql = "DELETE FROM staff WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $staffId);
        return $stmt->execute();
    }
    public function updateSalary($staffId, $salary) {
        $sql = "UPDATE staff SET monthly_salary = ? WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("di", $salary, $staffId);
        $stmt->execute();
        $stmt->close();
    }
}
