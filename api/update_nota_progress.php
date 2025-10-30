<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$opened = $_POST['opened'] ?? 0;
$total = 4;

if ($user_id == 0) {
    echo json_encode(["success" => false, "message" => "Missing user_id"]);
    exit;
}

$progress = min(1, $opened / $total);

$stmt = $conn->prepare("UPDATE progress SET nota_progress = ? WHERE user_id = ?");
$stmt->bind_param("di", $progress, $user_id);
$ok = $stmt->execute();

echo json_encode([
    "success" => $ok,
    "progress" => $progress,
]);

$stmt->close();
$conn->close();
?>
