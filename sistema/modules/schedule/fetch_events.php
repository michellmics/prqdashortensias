<?php
header('Content-Type: application/json');

include_once '../../../objetos.php'; // Carrega a classe de conexão e objetos

// Instancia a classe SITE_ADMIN e chama a função de conexão
$admin = new SITE_ADMIN();
$admin->conexao(); // Conecta ao banco de dados usando a configuração

// Consulta SQL para obter os eventos
$sql = "SELECT id, titulo AS title, inicio AS start, fim AS end FROM eventos";
$stmt = $admin->pdo->prepare($sql);
$stmt->execute();

// Armazenando os resultados
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retorna os eventos em formato JSON
echo json_encode($events);
?>
