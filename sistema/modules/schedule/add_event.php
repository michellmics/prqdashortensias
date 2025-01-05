<?php
$data = json_decode(file_get_contents('php://input'), true);

$conn = new mysqli('localhost', 'usuario', 'senha', 'banco');

$titulo = $conn->real_escape_string($data['titulo']);
$inicio = $conn->real_escape_string($data['inicio']);
$fim = $conn->real_escape_string($data['fim']);

$sql = "INSERT INTO eventos (titulo, inicio, fim) VALUES ('$titulo', '$inicio', '$fim')";
$conn->query($sql);

echo json_encode(['status' => 'success']);
?>
