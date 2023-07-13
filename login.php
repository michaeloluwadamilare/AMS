<?php
require_once 'connection.php';

class Login
{
    private $conn; // MySQLi connection object

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function authenticate($username, $password)
    {
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();
            if (password_verify($password, $admin['password'])) {
                // Authentication successful
                return true;
            }
        }

        // Authentication failed
        return false;
    }

    public function signup($username, $password)
    {
        // Check if the username is already taken
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Username already exists
            return false;
        }

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new admin record into the database
        $sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ss", $username, $hashedPassword);
        $stmt->execute();

        return $stmt->affected_rows === 1;
    }
}
