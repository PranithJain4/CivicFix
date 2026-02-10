<?php
// engine/migrate_db.php
require_once 'db_connect.php';

echo "<h1>Database Migration Tool</h1>";

// 1. Drop old tables to ensure fresh schema
echo "Dropping old tables...<br>";
$conn->query("SET FOREIGN_KEY_CHECKS = 0;");
$conn->query("DROP TABLE IF EXISTS assignments;");
$conn->query("DROP TABLE IF EXISTS complaints;");
$conn->query("SET FOREIGN_KEY_CHECKS = 1;");

// 2. Re-create Complaints Table with expanded fields
echo "Re-creating Complaints Table...<br>";
$conn->query("CREATE TABLE complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_id VARCHAR(20) UNIQUE NOT NULL,
    category VARCHAR(100) NOT NULL,
    location TEXT NOT NULL,
    landmark TEXT,
    description TEXT,
    image_path VARCHAR(255),
    
    -- Work completion fields
    work_notes TEXT,
    work_image VARCHAR(255),
    
    status VARCHAR(50) DEFAULT 'Pending Investigation',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// 3. Re-create Assignments Table with correct Reference
echo "Re-creating Assignments Table (Referencing tracking_id)...<br>";
$conn->query("CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id VARCHAR(20) NOT NULL,
    corporator_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complaint_id) REFERENCES complaints(tracking_id) ON DELETE CASCADE,
    FOREIGN KEY (corporator_id) REFERENCES corporators(id) ON DELETE CASCADE
)");

echo "<h2>Migration Complete!</h2>";
echo "<p>The database schema is now updated to support real work uploads.</p>";
echo "<p><a href='../admin.php'>Go to Dashboard</a></p>";

$conn->close();
?>
