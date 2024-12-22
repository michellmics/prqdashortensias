<?php
include_once 'objetos.php'; // Carrega a classe de conexão e objetos

session_start(); // Inicia a sessão para armazenar dados do usuário

// Evita cache das páginas
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

class LoginSystem extends SITE_ADMIN
{
    public function validateUser($apartamento, $password)
    {
        try {
            // Cria conexão com o banco de dados
            if (!$this->pdo) {
                $this->conexao();
            }

            // Prepara a consulta SQL para verificar o usuário
            $sql = "SELECT USU_IDUSUARIO, USU_DCSENHA, USU_DCEMAIL, USU_DCNOME, USU_DCNIVEL, USU_DCBLOCO, USU_DCAPARTAMENTO FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :apartamento";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':apartamento', $apartamento, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Se o usuário for encontrado e a senha for válida
            if ($user && password_verify($password, $user['USU_DCSENHA'])) {
                $_SESSION['user_id'] = $user['USU_IDUSUARIO']; // Armazena o ID na sessão
                $_SESSION['user_name'] = $user['USU_DCNOME'];
                $_SESSION['user_email'] = $user['USU_DCEMAIL'];
                $_SESSION['user_apartamento'] = $user['USU_DCAPARTAMENTO'];
                $_SESSION['user_bloco'] = $user['USU_DCBLOCO'];
                $_SESSION['user_nivelacesso'] = $user['USU_DCNIVEL'];

                echo '<meta http-equiv="refresh" content="0;url=sistema/index.php">'; // Redireciona após login bem-sucedido
                exit();
             
            } else 
                {
                    $_SESSION = [];
                    session_destroy();
                    echo "Usuário ou senha incorretos."; 
                }
        } catch (PDOException $e) {  
            echo "Erro: " . $e->getMessage();
        } 
    }
}

// Processa a requisição POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    // Sua chave secreta
    $secretKey = "6Lf3654qAAAAADXFzRqJWg7dN-XLJN_JJFMD7Lgx"; 

    // O token enviado pelo reCAPTCHA v2
    $recaptchaResponse = $_POST['g-recaptcha-response'];

    // Verifique se o token foi recebido
    if (!empty($recaptchaResponse))  
    {
        
        // Verifique o reCAPTCHA fazendo uma solicitação à API do Google
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
        $responseKeys = json_decode($response, true);

        // Verifique o sucesso da validação
        if ($responseKeys["success"]) 
        {

            $apartamento = $_POST['apartamento'];
            $password = $_POST['password'];

            $loginSystem = new LoginSystem();
            $result=$loginSystem->validateUser($apartamento, $password);
        }
        else 
            {
                // Validação falhou
                echo "Falha na verificação do reCAPTCHA. Por favor, tente novamente.";
            }
    }
    else 
        {
            // reCAPTCHA não foi resolvido
            echo "Por favor, complete o reCAPTCHA.";
        }
}
 
?>
