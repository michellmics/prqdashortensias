<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação básica para os campos obrigatórios
    $dataInicio = $_POST['dataInicio'] ?? null;
    $dataFim = $_POST['dataFim'] ?? null;
    $clienteOrigin = $_POST['clienteOrigin'] ?? null;
    $status = $_POST['status'] ?? null;
    $mktId = $_POST['mktId'] ?? null;
    $imagem="";

    $publi = new SITE_ADMIN();

    if (!$dataInicio || !$dataFim || !$clienteOrigin || !$status || !$mktId) {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
        exit;
    }

    function converteData($dataHora) 
    {
        $dateTime = DateTime::createFromFormat('d/m/Y H:i:s', $dataHora);
        return $dateTime->format('Y-m-d H:i:s');
    }

    $dataInicio = converteData($dataInicio);
    $dataFim = converteData($dataFim);


    // Verifica se um arquivo foi enviado
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];

        $microtime = microtime(true); // Retorna o tempo atual como float
        $timestamp = (int)($microtime * 1000); // Converte para milissegundos

        // Define o diretório de upload
        $clienteOriginPath = preg_replace('/[^a-zA-Z0-9_-]/', '', $clienteOrigin);
        $uploadDirectory = "uploads/$clienteOriginPath/";
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Cria o diretório se não existir
        }

        // Define o caminho para salvar a imagem
        $uploadPath = $uploadDirectory . $timestamp . "_" . basename($file['name']);

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $imagem = $uploadPath; // Adiciona o caminho da imagem ao resultado
        } else {
            $result['success'] = false;
            $result['message'] = 'Erro ao mover o arquivo';
        }
    } else {
        $imagem = null; // Caso nenhuma imagem seja enviada
    }

	$insertPubli = $publi->insertPubliInfo($dataInicio,$dataFim,$clienteOrigin,$status,$mktId,$imagem); 
    
    if($insertPubli == "OK")
    {
        echo json_encode("OK");
    }
    else
        {
            echo json_encode($insertPubli);    
        }

} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
