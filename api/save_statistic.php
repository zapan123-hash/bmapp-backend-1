<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$nota_name = $_POST['nota_name'] ?? '';

if (!$user_id || !$nota_name) {
    echo json_encode(["success" => false, "message" => "Missing parameters"]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO nota_statistic (user_id, nota_name) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $nota_name);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "Statistic saved"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to save"]);
}

$stmt->close();
$conn->close();
?>
