<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: https://www.prqdashortensias.com.br/index.php");
  exit();
}


class registerVisitante extends SITE_ADMIN
{
    public function updateVisitante($documento, $nome, $userid, $status, $visitanteid)
    {
        $nome = strtoupper($nome);
        $documento = strtoupper($documento);

        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao(); 
            } 

            $result = $this->updateVisitanteInfo($nome, $userid, $documento, $status, $visitanteid);

            //--------------------LOG----------------------//
            $LOG_DCTIPO = "ATUALIZAÇÃO DE VISITANTE";
            $LOG_DCMSG = "O visitante $nome foi atualizado para o status $status.";
            $LOG_DCUSUARIO = $_SESSION['user_id'];
            $LOG_DCAPARTAMENTO = $_SESSION['user_apartamento'];
            $this->insertLogInfo($LOG_DCTIPO, $LOG_DCMSG, $LOG_DCUSUARIO, $LOG_DCAPARTAMENTO);
            //--------------------LOG----------------------//

            echo  $result;
        
        } catch (PDOException $e) {  
            echo $result; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $documento = $_POST['documento'];
    $nome = $_POST['nome'];
    $userid = $_POST['userid'];
    $status = $_POST['status'];
    $visitanteid = $_POST['visitanteid']; 

 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerVisitante = new registerVisitante();
     $registerVisitante->updateVisitante($documento, $nome, $userid, $status, $visitanteid);
 }
 ?>