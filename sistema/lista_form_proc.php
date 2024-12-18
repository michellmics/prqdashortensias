<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 1800); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: index.php");
  exit();
}


class registerVisitante extends SITE_ADMIN
{
    public function insertVisitante($documento, $nome, $userid, $status)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT LIS_IDLISTACONVIDADOS, USU_IDUSUARIO, LIS_DCNOME, LIS_DCDOCUMENTO FROM LIS_LISTACONVIDADOS WHERE LIS_DCNOME = :nome AND USU_IDUSUARIO = :userid";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if (isset($user['USU_IDUSUARIO'])) {
                echo "Usuário já cadastrado."; 
                //exit();
            } else 
                {
                    $result = $this->insertVisitListaInfo($nome, $userid, $documento, $status);
                    echo "Convidado cadastrado com sucesso."; 
                    
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar convidado."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $nome = $_POST['nome'];
    $userid = $_POST['userid'];
    $status = $_POST['status'];

 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerVisitante = new registerVisitante();
     $registerVisitante->insertVisitante($documento, $nome, $userid, $status);
 }
 ?>