<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
include("config.php");

$id = $_POST['id'] ?? '';

if ($id) {
    $stmt = $conn->prepare("DELETE FROM todos WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "no id"]);
}
?>
