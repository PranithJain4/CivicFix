<?php
// engine/resolve_complaint.php
require_once 'db_connect.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'corporator') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'] ?? '';
    $notes = $_POST['notes'] ?? '';

    if (empty($complaint_id) || empty($notes)) {
        echo json_encode(["status" => "error", "message" => "Complaint ID and Notes are required"]);
        exit;
    }

    // Handle File Upload
    $work_image = "https://via.placeholder.com/400x200?text=No+Work+Image"; // Default

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = 'work_' . time() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            $image_path = 'uploads/' . $file_name;
            $work_image = $image_path;
        }
    }

    // Update complaint status to 'Under Review' and save closing notes/image
    $stmt = $conn->prepare("UPDATE complaints SET status = 'Under Review', work_notes = ?, work_image = ? WHERE tracking_id = ?");
    $stmt->bind_param("sss", $notes, $work_image, $complaint_id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Work submitted for review!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Database error: " . $conn->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
