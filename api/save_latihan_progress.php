<?php
require "db.php";
header("Content-Type: application/json");

$user_id = $_POST['user_id'] ?? 0;
$latihan_name = $_POST['latihan_name'] ?? '';
$percentage = $_POST['percentage'] ?? 0; // 🔹 Add this line

if ($user_id == 0 || empty($latihan_name)) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

// Check if user already has latihan progress entry
$stmt = $conn->prepare("
    SELECT id FROM latihan_progress
    WHERE user_id = ? AND latihan_name = ?
");
$stmt->bind_param("is", $user_id, $latihan_name);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows == 0) {
    // 🔹 insert new record with initial progress
    $insert = $conn->prepare("
        INSERT INTO latihan_progress (user_id, latihan_name, times_opened, percentage)
        VALUES (?, ?, 1, ?)
    ");
    $insert->bind_param("isd", $user_id, $latihan_name, $percentage);
    $insert->execute();
    $insert->close();
} else {
    // 🔹 update existing record with latest percentage
    $update = $conn->prepare("
        UPDATE latihan_progress
        SET times_opened = times_opened + 1,
            percentage = ?
        WHERE user_id = ? AND latihan_name = ?
    ");
    $update->bind_param("dis", $percentage, $user_id, $latihan_name);
    $update->execute();
    $update->close();
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true]);
?>
