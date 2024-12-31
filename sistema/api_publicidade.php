<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once '../objetos.php'; // Carrega a classe de conexão e objetos




// Verifica se um arquivo foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if(isset($_FILES['file']))
    {
        $file = $_FILES['file'];

        // Verifica se houve erro no upload
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Define o diretório de upload
            $uploadDirectory = 'uploads/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true); // Cria o diretório se não existir
            }
    
            // Define o caminho para salvar a imagem
            $uploadPath = $uploadDirectory . basename($file['name']);
    
            // Move a imagem para o diretório de uploads
            if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
                // Retorna um JSON com sucesso e o caminho da imagem
                echo json_encode(['success' => true, 'path' => $uploadPath]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Erro ao mover o arquivo']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro no upload da imagem']);
        }
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum arquivo enviado']);
        }
    }

    




?>
