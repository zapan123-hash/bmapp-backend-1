<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$latihan_name = $_POST['latihan_name'] ?? '';
$progress = $_POST['progress'] ?? 0;

// Check if record exists
$check = $conn->prepare("SELECT * FROM latihan_progress WHERE user_id = ?");
$check->bind_param("i", $user_id);
$check->execute();
$res = $check->get_result();

if ($res->num_rows > 0) {
    // update existing
    $sql = "UPDATE latihan_progress 
            SET $latihan_name = ? 
            WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $progress, $user_id);
    $stmt->execute();
} else {
    // insert new
    $sql = "INSERT INTO latihan_progress (user_id, $latihan_name) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $progress);
    $stmt->execute();
}

echo json_encode(["success" => true, "message" => "Progress saved"]);
$conn->close();
?>
