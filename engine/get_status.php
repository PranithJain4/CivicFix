<?php
// engine/get_status.php
require_once 'db_connect.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $tracking_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM complaints WHERE tracking_id = ?");
    $stmt->bind_param("s", $tracking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $complaint = $result->fetch_assoc();
        echo json_encode([
            "status_code" => "success",
            "complaint_id" => $complaint['tracking_id'],
            "category" => $complaint['category'],
            "location" => $complaint['location'],
            "landmark" => $complaint['landmark'],
            "description" => $complaint['description'],
            "submitted_date" => date("M d, Y", strtotime($complaint['created_at'])),
            "status" => $complaint['status'],
            "proof_image" => $complaint['image_path'],
            "work_image" => $complaint['work_image'],
            "work_notes" => $complaint['work_notes'],
            "last_updated" => date("M d, Y", strtotime($complaint['created_at']))
        ]);
    } else {
        echo json_encode(["status_code" => "error", "message" => "Complaint not found"]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(["status_code" => "error", "message" => "ID not provided"]);
}
?>
