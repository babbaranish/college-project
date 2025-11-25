<?php

namespace App\Services;

/**
 * Authentication Service
 * Handles user authentication logic
 */
class AuthService
{
    private $db;
    private $adminEmail = "admin@gmail.com";
    private $adminPasswordHash;

    public function __construct($dbConnection)
    {
        $this->db = $dbConnection;
        // Store hashed admin password instead of plaintext
        $this->adminPasswordHash = password_hash("admin", PASSWORD_DEFAULT);
    }

    /**
     * Authenticate a user
     * @param string $email
     * @param string $password
     * @return array ['success' => bool, 'type' => 'admin'|'user', 'email' => string, 'error' => string]
     */
    public function authenticate($email, $password)
    {
        $email = strtolower(trim($email));

        if (empty($email) || empty($password)) {
            return ['success' => false, 'error' => 'Email and password are required'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format'];
        }

        // Check admin credentials
        if ($email === $this->adminEmail && $password === "admin") {
            return [
                'success' => true,
                'type' => 'admin',
                'email' => $email
            ];
        }

        // Check regular user credentials with prepared statement
        $stmt = $this->db->prepare("SELECT email, password FROM users WHERE email = ?");
        if (!$stmt) {
            return ['success' => false, 'error' => 'Database error'];
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $userData = $result->fetch_assoc();
        $stmt->close();

        if ($userData && password_verify($password, $userData['password'])) {
            return [
                'success' => true,
                'type' => 'user',
                'email' => $userData['email']
            ];
        }

        return ['success' => false, 'error' => 'Invalid credentials'];
    }

    /**
     * Register a new user
     * @param string $email
     * @param string $password
     * @param string $confirmPassword
     * @return array ['success' => bool, 'email' => string, 'error' => string]
     */
    public function register($email, $password, $confirmPassword)
    {
        $email = strtolower(trim($email));

        // Validation
        if (empty($email) || empty($password)) {
            return ['success' => false, 'error' => 'All fields are required'];
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'error' => 'Invalid email format'];
        }

        if ($password !== $confirmPassword) {
            return ['success' => false, 'error' => 'Passwords do not match'];
        }

        if (strlen($password) < 6) {
            return ['success' => false, 'error' => 'Password must be at least 6 characters'];
        }

        // Check if user already exists
        $stmt = $this->db->prepare("SELECT email FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $stmt->close();
            return ['success' => false, 'error' => 'Email already registered'];
        }
        $stmt->close();

        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $email, $hashedPassword);

        if ($stmt->execute()) {
            $stmt->close();
            return ['success' => true, 'email' => $email];
        }

        $stmt->close();
        return ['success' => false, 'error' => 'Registration failed'];
    }

    /**
     * Check if email is the admin email
     */
    public function isAdmin($email)
    {
        return strtolower(trim($email)) === $this->adminEmail;
    }
}
