<?php
header("Content-Type: application/json");
require "db.php";

$id = $_POST['id'] ?? 0;

if (empty($id)) {
    echo json_encode(["success" => false, "message" => "Missing user ID"]);
    exit;
}

if (!isset($_FILES['photo'])) {
    echo json_encode(["success" => false, "message" => "No photo uploaded"]);
    exit;
}

// Folder to save uploaded images
$targetDir = "uploads/";
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$photoName = basename($_FILES["photo"]["name"]);
$targetFilePath = $targetDir . time() . "_" . $photoName;
$imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
$allowedTypes = ["jpg", "jpeg", "png", "gif"];

// Check file type
if (!in_array($imageFileType, $allowedTypes)) {
    echo json_encode(["success" => false, "message" => "Invalid file type"]);
    exit;
}

// Move file to folder
if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
    // Save filename to database
    $stmt = $conn->prepare("UPDATE users1 SET photo = ? WHERE id = ?");
    $stmt->bind_param("si", $targetFilePath, $id);

    if ($stmt->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Photo uploaded successfully",
            "photo_url" => $targetFilePath
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Database update failed"]);
    }

    $stmt->close();
} else {
    echo json_encode(["success" => false, "message" => "Error uploading file"]);
}

$conn->close();
?>
