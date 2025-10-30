<?php
$host = getenv('DB_HOST') ?: 'nozomi.proxy.rlwy.net';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: 'hitsKBmLDvcEmfKutRwAUkOjumtTwyop';
$db   = getenv('DB_NAME') ?: 'railway';
$port = getenv('DB_PORT') ?: 35370;

$conn = new mysqli($host, $user, $pass, $db, $port);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Database connection failed: " . $conn->connect_error
    ]));
}

// ❌ Remove this line:
// echo json_encode(["success"=>true,"message"=>"Connected to Railway MySQL"]);
?>
