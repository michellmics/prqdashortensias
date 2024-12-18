<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 1800); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: index.php");
  exit();
}


class registerUser extends SITE_ADMIN
{
    public function insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            $nome = strtoupper($nome);
            $email = strtoupper($email);

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL FROM USU_USUARIO WHERE USU_DCEMAIL = :email";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if (isset($user['USU_IDUSUARIO'])) {
                echo "Usuário já cadastrado."; 
                //exit();
            } else 
                {
                    $passHash = password_hash($senha, PASSWORD_DEFAULT);
                    $result = $this->insertUserInfo($email, $nome, $bloco, $apartamento, $nivel, $passHash);
                    
                    $SUBJECT = "Cadastro de novo usuário";
                    $MSG = "O morador(a) $nome com e-mail $email foi cadastrado no sistema do Condomínio Parque das Hortências.";
                    $this->notifyEmail($SUBJECT, $MSG); //notificação por email

                    $SUBJECT = "Seja Bem vindo(a) ao Condomínio Parque das Hortênsias";
                    $MSG = "Olá $nome, você foi cadastrado(a) no sistema do Condomínio Parque das Hortênsias. Seu usuário é seu e-mail e sua senha é: $senha. Para entrar no sistêma acesse: https://www.prqdashortensias.com.br/";
                    $this->notifyUsuarioEmail($SUBJECT, $MSG, $email); //notificação por email

                    echo "Usuário cadastrado com sucesso."; 
                    
                }
        } catch (PDOException $e) {  
            echo "Erro ao cadastrar usuário."; 
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
 
     // Cria o objeto de registro de usuário e chama o método insertUser
     $registerUser = new registerUser();
     $registerUser->insertUser($email, $senha, $nome, $bloco, $apartamento, $nivel);
 }
 ?>