<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

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


class setDataConvidado extends SITE_ADMIN
{
    public function setDataConvidado($LIS_IDLISTACONVIDADOS)
    {
       
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao(); 
            }

            $resultado = $this->updateDataVisita($LIS_IDLISTACONVIDADOS);

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "ATUALIZAÇÃO DE VISITANTE";
            $LOG_DCMSG = "O visitante com id $LIS_IDLISTACONVIDADOS teve a entrada registrada com sucesso.";
            $LOG_DCUSUARIO = $_SESSION['user_id'];
            $LOG_DCAPARTAMENTO = $_SESSION['user_apartamento'];
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//

            echo $resultado;
            
    }
}

// Processa a requisição GET
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; 
 
     $setData = new setDataConvidado();
     $setData->setDataConvidado($id);
 }
 ?>