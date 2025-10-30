<?php
include "db.php";

// get top 10
$sql = "SELECT u.username, l.score, l.created_at 
        FROM leaderboard l
        JOIN users u ON l.user_id = u.id
        ORDER BY l.score DESC
        LIMIT 10";

$result = $conn->query($sql);
?>

<h2>Leaderboard</h2>
<table border="1" cellpadding="8">
    <tr>
        <th>Rank</th>
        <th>Username</th>
        <th>Score</th>
        <th>Date</th>
    </tr>
    <?php
    $rank = 1;
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$rank}</td>
                <td>{$row['username']}</td>
                <td>{$row['score']}</td>
                <td>{$row['created_at']}</td>
              </tr>";
        $rank++;
    }
    ?>
</table>
