<?php
$conn = new mysqli('nozomi.proxy.rlwy.net', 'root', 'hitsKBmLDvcEmfKutRwAUkOjumtTwyop', 'railway', 35370);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = file_get_contents('my_app.sql');

if ($conn->multi_query($sql)) {
    do {} while ($conn->more_results() && $conn->next_result());
    echo "SQL file imported successfully!";
} else {
    echo "Error importing SQL: " . $conn->error;
}

$conn->close();
?>
