<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../../objetos.php'; // Carrega a classe de conexão e objetos

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Recebe os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

// Escapa os dados para evitar injeção de SQL
$titulo = $data['titulo'];
$inicio = $data['inicio'];
$fim = $data['fim'];

$stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
$stmt->bindParam(':inicio', $inicio, PDO::PARAM_STR);
$stmt->bindParam(':fim', $fim, PDO::PARAM_STR);

$sql = "INSERT INTO eventos (titulo, inicio, fim) VALUES (:titulo, ':inicio', ':fim')";
$conn->query($sql);

echo json_encode(['status' => 'success']);
?>
