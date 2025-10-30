<?php
session_start();
include "db.php";

if (!isset($_SESSION["user_id"])) {
    die("You must login first!");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"];
    $score   = intval($_POST["score"]);

    // insert new score
    $stmt = $conn->prepare("INSERT INTO leaderboard (user_id, score) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $score);

    if ($stmt->execute()) {
        echo "Score added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<form method="POST" action="">
    <input type="number" name="score" placeholder="Enter score" required><br>
    <button type="submit">Submit Score</button>
</form>
