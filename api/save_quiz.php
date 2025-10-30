<?php
header("Content-Type: application/json");
require "db.php";

$user_id = $_POST['user_id'] ?? 0;
$quiz_name = $_POST['quiz_name'] ?? '';
$score = $_POST['score'] ?? 0;

// Allowed quiz/test names
$allowed = ["quiz1","quiz2","quiz3","quiz4","test1","test2","test3","test4"];

if ($user_id && in_array($quiz_name, $allowed)) {
    $column = $quiz_name . "_score"; // e.g. quiz1_score

    // Check if the user already has a progress row
    $check = $conn->prepare("SELECT user_id FROM progress WHERE user_id=?");
    $check->bind_param("i", $user_id);
    $check->execute();
    $res = $check->get_result();

    if ($res->num_rows == 0) {
        // Create a new progress record
        $insert = $conn->prepare("INSERT INTO progress (user_id, $column) VALUES (?, ?)");
        $insert->bind_param("ii", $user_id, $score);
        $insert->execute();
        $insert->close();
    } else {
        // Update existing progress
        $update = $conn->prepare("UPDATE progress SET $column=? WHERE user_id=?");
        $update->bind_param("ii", $score, $user_id);
        $update->execute();
        $update->close();
    }

    $check->close();
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
?>
