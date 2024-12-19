<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: index.php");
  exit();
}


class registerUser extends SITE_ADMIN
{
    public function insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel, $userid)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

                $nome = strtoupper($nome);
                $email = strtoupper($email);

                $passHash = password_hash($senha, PASSWORD_DEFAULT);
                $result = $this->updateUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash, $userid);
                echo "Usuário atualizado com sucesso.";                     
                
        } catch (PDOException $e) {  
            echo "Erro ao atualizar usuário."; 
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $nome = $_POST['nome'];
    $bloco = $_POST['bloco'];
    $apartamento = $_POST['apartamento'];
    $nivel = $_POST['nivel']; 
    $userid = $_POST['userid'];
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerUser = new registerUser();
     $registerUser->updateUser($email, $senha, $nome, $bloco, $apartamento, $nivel, $userid);
 }
 ?>