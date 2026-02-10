<?php
// engine/approve_work.php
require_once 'db_connect.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'] ?? '';

    if (empty($complaint_id)) {
        echo json_encode(["status" => "error", "message" => "Complaint ID is required"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE complaints SET status = 'Resolved' WHERE tracking_id = ?");
    $stmt->bind_param("s", $complaint_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Complaint marked as Resolved!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    }

    $conn->close();
}
?>
