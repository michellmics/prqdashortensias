<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}


class deleteLista extends SITE_ADMIN
{
    public function deleteListaConvidados($LIS_IDLISTACONVIDADOS)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "DELETE FROM LIS_LISTACONVIDADOS WHERE LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);
            $stmt->execute();

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "REMOÇÃO DE VISITANTE";
            $LOG_DCMSG = "O visitante com id $LIS_IDLISTACONVIDADOS foi removido com sucesso.";
            $LOG_DCUSUARIO = $_SESSION['user_id'];
            $LOG_DCAPARTAMENTO = "N/A";
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//

            echo "Convidado deletado com sucesso.";
            

        } catch (PDOException $e) {  
            echo "Não foi possível deletar o convidado.";
        } 
    }
}

// Processa a requisição GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
 
     $deleteLista = new deleteLista();
     $deleteLista->deleteListaConvidados($id);
 }
 ?>