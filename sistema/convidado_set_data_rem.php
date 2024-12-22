<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

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

            $resultado = $this->updateDataVisitaRem($LIS_IDLISTACONVIDADOS);
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