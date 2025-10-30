<?php
header("Content-Type: application/json");
require "db.php";

$id = $_GET['id'] ?? 0;

if ($id == 0) {
    echo json_encode(["success" => false, "message" => "Missing ID"]);
    exit;
}

// Fetch user info + progress
$stmt = $conn->prepare("
    SELECT u.id, u.name, u.email, u.password, u.photo,
           COALESCE(p.nota_progress, 0) AS nota_progress,
           COALESCE(p.latihan1_progress, 0) AS latihan1_progress,
           COALESCE(p.latihan2_progress, 0) AS latihan2_progress,
           COALESCE(p.latihan3_progress, 0) AS latihan3_progress,
           COALESCE(p.latihan4_progress, 0) AS latihan4_progress,
           COALESCE(p.quiz1_score, 0) AS quiz1_score,
           COALESCE(p.quiz2_score, 0) AS quiz2_score,
           COALESCE(p.quiz3_score, 0) AS quiz3_score,
           COALESCE(p.quiz4_score, 0) AS quiz4_score
    FROM users1 u
    LEFT JOIN progress p ON p.user_id = u.id
    WHERE u.id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($user = $res->fetch_assoc()) {
    // Normalize latihan progress (0-1 per item)
    $latihan_list = [
        ($user['latihan1_progress'] ?? 0) / 100,
        ($user['latihan2_progress'] ?? 0) / 100,
        ($user['latihan3_progress'] ?? 0) / 100,
        ($user['latihan4_progress'] ?? 0) / 100,
    ];
    $latihan_progress = array_sum($latihan_list) / 4; // average

    // Normalize quiz scores (0-1 per item)
    $quiz_list = [
        ($user['quiz1_score'] ?? 0) / 100,
        ($user['quiz2_score'] ?? 0) / 100,
        ($user['quiz3_score'] ?? 0) / 100,
        ($user['quiz4_score'] ?? 0) / 100,
    ];
    $quiz_progress = array_sum($quiz_list) / 4; // average

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user['id'],
            "name" => $user['name'],
            "email" => $user['email'],
            "password" => $user['password'], // ⚠️ remove in production
            "photo" => $user['photo'] ?? null,
            "nota_progress" => (float)$user['nota_progress'] / 100, // normalize if 0-100
            "latihan_progress" => (float)$latihan_progress,          // 0-1 normalized
            "quiz_progress" => (float)$quiz_progress,                // 0-1 normalized
            "latihan_list" => $latihan_list,
            "quiz_list" => $quiz_list
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "User not found"]);
}

$stmt->close();
$conn->close();
?>
