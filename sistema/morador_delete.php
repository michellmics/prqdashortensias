<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: index.php");
  exit();
}

if ($_SESSION['user_nivelacesso'] != "SINDICO") 
{
  header("Location: noAuth.php");
  exit();
}


class deleteMorador extends SITE_ADMIN
{
    public function deleteMoradorinfo($USU_IDUSUARIO)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "DELETE FROM USU_USUARIO WHERE USU_IDUSUARIO = :USU_IDUSUARIO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
            $stmt->execute();

            echo "Usuário deletado com sucesso.";
            

        } catch (PDOException $e) {  
            echo "Não foi possível deletar o usuário.";
        } 
    }
}

// Processa a requisição GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
 
     $deleteMorador = new deleteMorador();
     $deleteMorador->deleteMoradorinfo($id);
 }
 ?>