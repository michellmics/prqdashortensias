<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
include_once '../objetos.php'; // Carrega a classe de conexão e objetos

// Verifica se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação básica para os campos obrigatórios
    $dataInicio = $_POST['data_inicio'] ?? null;
    $dataFim = $_POST['data_fim'] ?? null;
    $nomeCliente = $_POST['nome_cliente'] ?? null;

    if (!$dataInicio || !$dataFim || !$nomeCliente) {
        echo json_encode(['success' => false, 'message' => 'Campos obrigatórios ausentes']);
        exit;
    }

    // Inicializa o resultado
    $result = [
        'success' => true,
        'message' => 'Dados recebidos com sucesso',
        'data' => [
            'data_inicio' => $dataInicio,
            'data_fim' => $dataFim,
            'nome_cliente' => $nomeCliente,
        ]
    ];

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['file'];

        // Define o diretório de upload
        $uploadDirectory = 'uploads/';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true); // Cria o diretório se não existir
        }

        // Define o caminho para salvar a imagem
        $uploadPath = $uploadDirectory . basename($file['name']);

        // Move a imagem para o diretório de uploads
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            $result['data']['imagem'] = $uploadPath; // Adiciona o caminho da imagem ao resultado
        } else {
            $result['success'] = false;
            $result['message'] = 'Erro ao mover o arquivo';
        }
    } else {
        $result['data']['imagem'] = null; // Caso nenhuma imagem seja enviada
    }

    // Retorna o resultado em JSON
    echo json_encode($result);
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
