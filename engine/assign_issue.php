<?php
// engine/assign_issue.php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $corporator_id = $_POST['corporator_id'];

    if (empty($complaint_id) || empty($corporator_id)) {
        echo json_encode(["status" => "error", "message" => "Incomplete data"]);
        exit;
    }

    // Start Transaction
    $conn->begin_transaction();

    try {
        // 1. Insert into assignments table
        $stmt1 = $conn->prepare("INSERT INTO assignments (complaint_id, corporator_id) VALUES (?, ?)");
        $stmt1->bind_param("si", $complaint_id, $corporator_id);
        $stmt1->execute();

        // 2. Update complaint status to 'Assigned'
        $stmt2 = $conn->prepare("UPDATE complaints SET status = 'Assigned' WHERE tracking_id = ?");
        $stmt2->bind_param("s", $complaint_id);
        $stmt2->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Issue successfully assigned"]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Failed to assign issue: " . $e->getMessage()]);
    }

    $conn->close();
}
?>
