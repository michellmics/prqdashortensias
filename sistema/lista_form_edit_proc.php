<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
    public function updateVisitante($documento, $nome, $userid, $status, $visitanteid)
    {

        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao(); 
            } 

            $result = $this->updateVisitanteInfo($nome, $userid, $documento, $status, $visitanteid);
            echo "Convidado atualizado com sucesso."; 
        
        } catch (PDOException $e) {  
            echo "Erro ao atualizar convidado."; 
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