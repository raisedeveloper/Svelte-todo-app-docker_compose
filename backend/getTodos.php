<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include("config.php");

$result = $conn->query("SELECT * FROM todos");

$todos = [];
while($row = $result->fetch_assoc()) {
    $todos[] = $row;
}

echo json_encode($todos);
?>
