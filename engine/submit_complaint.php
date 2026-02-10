<?php
// engine/submit_complaint.php
require_once 'db_connect.php';

// Check if data is received
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tracking_id = $_POST['tracking_id'];
    $category = $_POST['category'];
    $location = $_POST['location'];
    $landmark = $_POST['landmark'];
    $description = $_POST['description'];

    // Handle File Upload
    $image_path = "https://via.placeholder.com/400x200?text=No+Image"; // Default

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = time() . '_' . basename($_FILES['image']['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // Store the path relative to the root (so it works from any page)
            $image_path = 'uploads/' . $file_name;
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO complaints (tracking_id, category, location, landmark, description, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $tracking_id, $category, $location, $landmark, $description, $image_path);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Complaint saved successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
