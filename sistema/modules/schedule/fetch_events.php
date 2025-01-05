<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}
    // Atualiza o timestamp da última atividade
$_SESSION['last_activity'] = time();

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}

$blocoSession = $_SESSION['user_bloco'];
$apartamentoSession = $_SESSION['user_apartamento'];
$nomeSession =  ucwords($_SESSION['user_name']);
$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
$userid = $_SESSION['user_id'];

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
