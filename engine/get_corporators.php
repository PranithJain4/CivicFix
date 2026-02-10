<?php
// engine/get_corporators.php
require_once 'db_connect.php';

header('Content-Type: application/json');

$sql = "SELECT * FROM corporators";
$result = $conn->query($sql);

$corporators = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $corporators[] = $row;
    }
}

echo json_encode($corporators);

$conn->close();
?>
