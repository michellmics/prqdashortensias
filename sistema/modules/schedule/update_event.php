<?php
$data = json_decode(file_get_contents('php://input'), true);

$conn = new mysqli('localhost', 'usuario', 'senha', 'banco');

$id = $conn->real_escape_string($data['id']);
$inicio = $conn->real_escape_string($data['inicio']);
$fim = $conn->real_escape_string($data['fim']);

$sql = "UPDATE eventos SET inicio = '$inicio', fim = '$fim' WHERE id = $id";
$conn->query($sql);

echo json_encode(['status' => 'success']);
?>
