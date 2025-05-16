<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include("config.php");

$task = $_POST['task'] ?? '';

if ($task) {
    $stmt = $conn->prepare("INSERT INTO todos (task, completed) VALUES (?, 0)");
    $stmt->bind_param("s", $task);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "no task"]);
}
?>
