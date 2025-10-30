<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$test_name = $_POST['test_name'] ?? '';
$score = $_POST['score'] ?? 0;

$allowed = ["test1", "test2", "test3", "test4"];

if ($user_id && in_array($test_name, $allowed)) {
    $column = $test_name . "_score";

    // ✅ Check if record exists
    $check = $conn->prepare("SELECT user_id FROM progress WHERE user_id = ?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows === 0) {
        // Insert new record
        $insert = $conn->prepare("INSERT INTO progress (user_id, $column) VALUES (?, ?)");
        $insert->bind_param("id", $user_id, $score);
        $insert->execute();
        $insert->close();
    } else {
        // Update existing record
        $update = $conn->prepare("UPDATE progress SET $column = ?, updated_at = NOW() WHERE user_id = ?");
        $update->bind_param("di", $score, $user_id);
        $update->execute();
        $update->close();
    }

    // ✅ Recalculate total test_score
    $updateTotal = $conn->prepare("
        UPDATE progress 
        SET test_score = COALESCE(test1_score,0) + COALESCE(test2_score,0) + COALESCE(test3_score,0) + COALESCE(test4_score,0)
        WHERE user_id = ?
    ");
    $updateTotal->bind_param("i", $user_id);
    $updateTotal->execute();
    $updateTotal->close();

    $check->close();

    echo json_encode([
        "success" => true,
        "message" => "Test progress saved successfully and total test score updated."
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid test data"
    ]);
}

$conn->close();
?>
