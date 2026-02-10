<?php
// engine/get_assigned_tasks.php
require_once 'db_connect.php';

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'corporator') {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$username = $_SESSION['username'];

// 1. Get the corporator ID associated with this username
$stmt = $conn->prepare("SELECT id FROM corporators WHERE name = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    echo json_encode(["status" => "error", "message" => "Corporator record not found"]);
    exit;
}

$corp = $res->fetch_assoc();
$corp_id = $corp['id'];

// 2. Fetch complaints assigned to this corporator
$stmt2 = $conn->prepare("
    SELECT c.* 
    FROM complaints c
    JOIN assignments a ON c.tracking_id = a.complaint_id
    WHERE a.corporator_id = ? AND c.status = 'Assigned'
    ORDER BY c.created_at DESC
");
$stmt2->bind_param("i", $corp_id);
$stmt2->execute();
$result = $stmt2->get_result();

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);

$conn->close();
?>
