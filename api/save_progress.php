<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$latihan_name = $_POST['latihan_name'] ?? '';
$percentage = $_POST['percentage'] ?? 0;

$allowed = ["latihan1", "latihan2", "latihan3", "latihan4"];

if ($user_id && in_array($latihan_name, $allowed)) {
    $column = $latihan_name . "_progress";

    // Check if user exists in progress
    $check = $conn->prepare("SELECT user_id FROM progress WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        // Insert if not exists
        $insert = $conn->prepare("INSERT INTO progress (user_id, $column) VALUES (?, ?)");
        $insert->bind_param("id", $user_id, $percentage);
        $insert->execute();
        $insert->close();
    } else {
        // Update existing record
        $update = $conn->prepare("UPDATE progress SET $column = ? WHERE user_id = ?");
        $update->bind_param("di", $percentage, $user_id);
        $update->execute();
        $update->close();
    }

    $check->close();
    echo json_encode(["success" => true, "message" => "Progress saved successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
?>
