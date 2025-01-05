<?php
include_once '../../../objetos.php'; // Carrega a classe de conexão e objetos

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Recebe os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Escapa os dados para evitar injeção de SQL
$titulo = $admin->pdo->quote($data['titulo']);
$inicio = $admin->pdo->quote($data['inicio']);
$fim = $admin->pdo->quote($data['fim']);

$sql = "INSERT INTO eventos (titulo, inicio, fim) VALUES ('$titulo', '$inicio', '$fim')";
$conn->query($sql);

echo json_encode(['status' => 'success']);
?>
