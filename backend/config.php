<?php
$host = "db";
$user = "todo";
$pass = "todo123";
$db = "todoapp";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
