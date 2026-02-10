<?php
// engine/delete_corporator.php
require_once 'db_connect.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(["status" => "error", "message" => "ID is required"]);
        exit;
    }

    // Get the name/email first to delete the user
    $stmt = $conn->prepare("SELECT name FROM corporators WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows === 0) {
        echo json_encode(["status" => "error", "message" => "Corporator not found"]);
        exit;
    }

    $corp = $res->fetch_assoc();
    $name = $corp['name'];

    // Start Transaction
    $conn->begin_transaction();

    try {
        // 1. Delete from corporators table
        $stmt1 = $conn->prepare("DELETE FROM corporators WHERE id = ?");
        $stmt1->bind_param("i", $id);
        $stmt1->execute();

        // 2. Delete from users table (assumes username matches name)
        $stmt2 = $conn->prepare("DELETE FROM users WHERE username = ? AND role = 'corporator'");
        $stmt2->bind_param("s", $name);
        $stmt2->execute();

        $conn->commit();
        echo json_encode(["status" => "success", "message" => "Corporator and their login credentials deleted."]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
    }

    $conn->close();
}
?>
