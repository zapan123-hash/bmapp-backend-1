<?php
header("Content-Type: application/json");
require "db.php";

// Receive POST data
$name        = $_POST['name'] ?? '';
$oldPassword = $_POST['old_password'] ?? '';
$newPassword = $_POST['new_password'] ?? '';

if (empty($name) || empty($oldPassword) || empty($newPassword)) {
    echo json_encode(["success" => false, "message" => "Sila isi semua maklumat (nama, kata laluan lama, dan kata laluan baharu)."]);
    exit;
}

// Check if user exists by name
$stmt = $conn->prepare("SELECT id, password FROM users1 WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(["success" => false, "message" => "Nama pengguna tidak dijumpai."]);
    exit;
}

$user = $result->fetch_assoc();

// Verify old password
if (!password_verify($oldPassword, $user['password'])) {
    echo json_encode(["success" => false, "message" => "Kata laluan lama tidak betul."]);
    exit;
}

// Hash new password
$newHashed = password_hash($newPassword, PASSWORD_BCRYPT);

// Update password in database
$update = $conn->prepare("UPDATE users1 SET password = ? WHERE id = ?");
$update->bind_param("si", $newHashed, $user['id']);

if ($update->execute()) {
    echo json_encode(["success" => true, "message" => "Kata laluan berjaya dikemas kini."]);
} else {
    echo json_encode(["success" => false, "message" => "Ralat semasa mengemas kini kata laluan."]);
}

$update->close();
$stmt->close();
$conn->close();
?>
