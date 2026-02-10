<?php
// engine/fix_admin.php
require_once 'db_connect.php';

// Disable FK checks to drop safely if needed
$conn->query("SET FOREIGN_KEY_CHECKS = 0;");

// 1. Create Complaints Table
$conn->query("CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_id VARCHAR(20) UNIQUE NOT NULL,
    category VARCHAR(100) NOT NULL,
    location TEXT NOT NULL,
    landmark TEXT,
    description TEXT,
    image_path VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Pending Investigation',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// 2. Create Corporators Table
$conn->query("CREATE TABLE IF NOT EXISTS corporators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(100) NOT NULL,
    coverage TEXT NOT NULL,
    type VARCHAR(50) NOT NULL
)");

// 3. Create Assignments Table
// NOTE: Recreating it to ensure correct FK to tracking_id
$conn->query("DROP TABLE IF EXISTS assignments;");
$conn->query("CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id VARCHAR(20) NOT NULL,
    corporator_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complaint_id) REFERENCES complaints(tracking_id) ON DELETE CASCADE,
    FOREIGN KEY (corporator_id) REFERENCES corporators(id) ON DELETE CASCADE
)");

// 4. Create Users Table
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('citizen', 'admin', 'corporator') DEFAULT 'citizen',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

$email = 'admin@civicfix.com';
$password = 'admin123';
$username = 'System Admin';
$role = 'admin';

// Hash the password correctly
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Clean up old admin
$conn->query("DELETE FROM users WHERE email = '$email'");

// Insert correctly
$stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $hashed_password, $role);

if ($stmt->execute()) {
    echo "<h1>Database Setup & Admin Fixed!</h1>";
    echo "<p>All tables have been verified/created with corrected constraints.</p>";
    echo "<p>You can now login with:</p>";
    echo "<ul><li><strong>Email:</strong> $email</li><li><strong>Password:</strong> $password</li></ul>";
    echo "<p><a href='../login.php'>Go to Login Page</a></p>";
} else {
    echo "<h1>Error</h1>";
    echo "<p>" . $stmt->error . "</p>";
}

$conn->close();
?>
