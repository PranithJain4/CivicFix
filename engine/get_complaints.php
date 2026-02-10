<?php
// engine/get_complaints.php
require_once 'db_connect.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM complaints ORDER BY created_at DESC";
$result = $conn->query($sql);

$complaints = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $complaints[] = $row;
    }
}

echo json_encode($complaints);

$conn->close();
?>
