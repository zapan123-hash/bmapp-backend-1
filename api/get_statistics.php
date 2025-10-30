<?php
header("Content-Type: application/json");
require "db.php";

$id = $_POST['user_id'] ?? $_GET['id'] ?? 0;

// ✅ Retrieve full user data
$stmt = $conn->prepare("
    SELECT p.*, u.name 
    FROM progress p 
    JOIN users1 u ON u.id = p.user_id
    WHERE p.user_id = ?
");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

// ✅ Quiz leaderboard
$quizLeaderboard = [];
$qRes = $conn->query("
    SELECT u.name, 
           COALESCE(quiz1_score,0)+COALESCE(quiz2_score,0)+COALESCE(quiz3_score,0)+COALESCE(quiz4_score,0) AS total_quiz
    FROM progress p
    JOIN users1 u ON u.id = p.user_id
    ORDER BY total_quiz DESC
    LIMIT 3
");
while ($r = $qRes->fetch_assoc()) {
    $quizLeaderboard[] = $r;
}

// ✅ Test leaderboard
$testLeaderboard = [];
$tRes = $conn->query("
    SELECT u.name, 
           COALESCE(test1_score,0)+COALESCE(test2_score,0)+COALESCE(test3_score,0)+COALESCE(test4_score,0) AS total_test
    FROM progress p
    JOIN users1 u ON u.id = p.user_id
    ORDER BY total_test DESC
    LIMIT 3
");
while ($r = $tRes->fetch_assoc()) {
    $testLeaderboard[] = $r;
}

// ✅ Nota statistics
$notaStats = [];
$nStmt = $conn->prepare("
    SELECT nota_name, COUNT(*) AS times_opened
    FROM nota_statistic
    WHERE user_id = ?
    GROUP BY nota_name
");
$nStmt->bind_param("i", $id);
$nStmt->execute();
$nRes = $nStmt->get_result();

$totalNotes = 4;
$openedNotes = 0;
while ($r = $nRes->fetch_assoc()) {
    $notaStats[] = $r;
    $openedNotes++;
}
$notaPercentage = $totalNotes > 0 ? round(($openedNotes / $totalNotes) * 100) : 0;

// ✅ Calculate total quiz & test score
$totalQuiz = 
    ($row["quiz1_score"] ?? 0) + 
    ($row["quiz2_score"] ?? 0) + 
    ($row["quiz3_score"] ?? 0) + 
    ($row["quiz4_score"] ?? 0);

$totalTest = 
    ($row["test1_score"] ?? 0) + 
    ($row["test2_score"] ?? 0) + 
    ($row["test3_score"] ?? 0) + 
    ($row["test4_score"] ?? 0);

// ✅ Determine statuses
$testStatuses = [];
for ($i = 1; $i <= 4; $i++) {
    $col = "test{$i}_score";
    $testStatuses["test$i"] = ($row[$col] ?? 0) > 0 ? "selesai" : "belum";
}

$quizStatuses = [];
for ($i = 1; $i <= 4; $i++) {
    $col = "quiz{$i}_score";
    $quizStatuses["quiz$i"] = ($row[$col] ?? 0) > 0 ? "selesai" : "belum";
}

// ✅ Final JSON response
if ($row) {
    echo json_encode([
        "success" => true,
        "data" => [
            "user_name" => $row["name"],
            "quiz_score" => $totalQuiz,
            "test_score" => $totalTest,
            "quiz_leaderboard" => $quizLeaderboard,
            "test_leaderboard" => $testLeaderboard,
            "nota_statistics" => $notaStats,
            "nota_percentage" => $notaPercentage,
            "latihan1_progress" => $row["latihan1_progress"] ?? 0,
            "latihan2_progress" => $row["latihan2_progress"] ?? 0,
            "latihan3_progress" => $row["latihan3_progress"] ?? 0,
            "latihan4_progress" => $row["latihan4_progress"] ?? 0,

            // ✅ Include all quiz & test scores
            "quiz1_score" => $row["quiz1_score"] ?? 0,
            "quiz2_score" => $row["quiz2_score"] ?? 0,
            "quiz3_score" => $row["quiz3_score"] ?? 0,
            "quiz4_score" => $row["quiz4_score"] ?? 0,

            "test1_score" => $row["test1_score"] ?? 0,
            "test2_score" => $row["test2_score"] ?? 0,
            "test3_score" => $row["test3_score"] ?? 0,
            "test4_score" => $row["test4_score"] ?? 0,

            "test_status" => $testStatuses,
            "quiz_status" => $quizStatuses
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "No data found"]);
}

$stmt->close();
$nStmt->close();
$conn->close();
?>
