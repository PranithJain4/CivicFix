-- engine/schema.sql

-- Complaints Table
CREATE TABLE IF NOT EXISTS complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tracking_id VARCHAR(20) UNIQUE NOT NULL,
    category VARCHAR(50) NOT NULL,
    location TEXT NOT NULL,
    landmark TEXT,
    description TEXT,
    image_path VARCHAR(255),
    status VARCHAR(50) DEFAULT 'Pending Investigation',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Corporators Table
CREATE TABLE IF NOT EXISTS corporators (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    category VARCHAR(50) NOT NULL,
    coverage TEXT NOT NULL,
    type VARCHAR(50) NOT NULL
);

-- Assignments Table (Links complaints to corporators)
CREATE TABLE IF NOT EXISTS assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    complaint_id VARCHAR(50) NOT NULL,
    corporator_id INT NOT NULL,
    assigned_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (complaint_id) REFERENCES complaints(tracking_id),
    FOREIGN KEY (corporator_id) REFERENCES corporators(id)
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('citizen', 'admin', 'corporator') DEFAULT 'citizen',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default Admin Account (Email: admin@civicfix.com | Password: admin123)
-- This allows the admin to login directly without signup.
-- Citizens can signup normally.
-- Corporators are added by Admin.
INSERT IGNORE INTO users (username, email, password, role) 
VALUES ('System Admin', 'admin@civicfix.com', '$2y$10$89M4vG1h6K1p/Aqd6nO8qOa6M4vG1h6K1p/Aqd6nO8qOa6M4vG1h6', 'admin');
