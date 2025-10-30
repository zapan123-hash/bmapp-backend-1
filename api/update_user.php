<?php
header("Content-Type: application/json");
require "db.php";

$id       = $_POST['id'] ?? '';
$name     = $_POST['name'] ?? '';
$password = $_POST['password'] ?? '';
$email    = $_POST['email'] ?? '';

if (empty($id) || empty($name) || empty($email)) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

// Check if password field is filled
if (!empty($password)) {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users1 SET name = ?, email = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssi", $name, $email, $hashedPassword, $id);
} else {
    $stmt = $conn->prepare("UPDATE users1 SET name = ?, email = ? WHERE id = ?");
    $stmt->bind_param("ssi", $name, $email, $id);
}

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Profile updated"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to update: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
