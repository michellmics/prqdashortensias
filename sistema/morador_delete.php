<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
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
    
            // Inicia uma transação
            $this->pdo->beginTransaction();
    
            // Prepara a consulta SQL para deletar da tabela USU_USUARIO
            $sql = "DELETE FROM USU_USUARIO WHERE USU_IDUSUARIO = :USU_IDUSUARIO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
            $stmt->execute();
    
            // Prepara a consulta SQL para deletar da tabela LIS_LISTACONVIDADOS
            $sql = "DELETE FROM LIS_LISTACONVIDADOS WHERE USU_IDUSUARIO = :USU_IDUSUARIO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
            $stmt->execute();
    
            // Commit na transação se tudo deu certo
            $this->pdo->commit();

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "REMOÇÃO DE CADASTRO";
            $LOG_DCMSG = "O usuário com ID $USU_IDUSUARIO foi removido com sucesso.";
            $LOG_DCUSUARIO = $_SESSION['user_id'];
            $LOG_DCAPARTAMENTO = "N/A";
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//
    
            echo "Usuário deletado com sucesso.";
    
        } catch (PDOException $e) {
            // Se ocorrer algum erro, faz o rollback e exibe a mensagem de erro
            $this->pdo->rollBack();
            echo "Não foi possível deletar o usuário: " . $e->getMessage();
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