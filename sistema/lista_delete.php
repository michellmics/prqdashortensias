<?php
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

session_start(); 
define('SESSION_TIMEOUT', 43200); // 30 minutos

if (!isset($_SESSION['user_id'])) 
{
  header("Location: index.php");
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