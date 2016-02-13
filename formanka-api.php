<?php
header('Content-Type: text/html; charset=utf-8');
header("Content-Type: text/plain");
header('Content-Type: application/json');

$user = 'root';
$password = 'root';
$db = 'go-lunch-db';
$host = 'localhost';
$port = 8889;
$table = 'formanka';

$conn = new mysqli($host, $user, $password, $db, $port);
if ($conn->connect_error) {
    die("Database fail " . $conn->connect_error);
}
$ret = [];
$sql = "SELECT * FROM $table";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()) {
    $ret[] = $row;
}
echo json_encode($ret);
$conn->close();
