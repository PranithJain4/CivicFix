<?php
// engine/add_corporator.php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $category = $_POST['category'] ?? '';
    $coverage = $_POST['coverage'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $type = "Department"; // Default type

    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Name, Email, and Password are required"]);
        exit;
    }

    // Start Transaction
    $conn->begin_transaction();

    try {
        // 1. Insert into corporators table
        $stmt1 = $conn->prepare("INSERT INTO corporators (name, category, coverage, type) VALUES (?, ?, ?, ?)");
        $stmt1->bind_param("ssss", $name, $category, $coverage, $type);
        $stmt1->execute();

        $corporator_id = $conn->insert_id;

        // 2. Insert into users table
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $role = 'corporator';
        $stmt2 = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("ssss", $name, $email, $hashed_password, $role);
        $stmt2->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Corporator added successfully and can now login."]);
    } catch (Exception $e) {
        $conn->rollback();
        if ($conn->errno === 1062) {
            echo json_encode(["status" => "error", "message" => "Email already exists"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
        }
    }

    $conn->close();
}
?>
