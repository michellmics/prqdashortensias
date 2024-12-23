<?php
include_once 'objetos.php'; 

class RecSystem extends SITE_ADMIN
{
    public function CheckValidUser($apartamento)
    {
            if (!$this->pdo) {
                $this->conexao();
            }

            $sql = "SELECT USU_DCEMAIL FROM USU_USUARIO WHERE USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':USU_DCAPARTAMENTO', $apartamento, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user['USU_DCEMAIL']) 
            {
                $email = $user['USU_DCEMAIL'];
                return $email;             
            } else 
                {
                    echo "Apartamento não cadastrado no sistema. Entre em contato com o síndico.";
                    exit();
                }
        
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') 
{
    $apartamento = $_POST['apartamento'];

    $RecSystem = new RecSystem();
    
    $result=$RecSystem->CheckValidUser($apartamento);

}
 
?>
