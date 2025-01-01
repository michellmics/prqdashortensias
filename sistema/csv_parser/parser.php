<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../objetos.php';

$siteAdmin = new SITE_ADMIN();  

function processCSV($filePath) {
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ler o cabeçalho
        $header = fgetcsv($handle);  // Aqui lemos o cabeçalho

        // Exibir o cabeçalho para referência (opcional)
        echo "Cabeçalho do CSV:<br>";
        print_r($header);
        echo "<br><br>";

        // Ler cada linha do arquivo CSV
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            // Exibir os dados de cada linha
            echo "Dados da linha:<br>";
            print_r($data);
            echo "<br><br>";

            die();

            // Aqui você pode adicionar lógica para processar os dados
            // Exemplo: se quiser acessar uma coluna específica:
            // $nome = $data[0];  // Primeira coluna
            // $email = $data[1];  // Segunda coluna
            // Processar os dados conforme necessário
        }

        // Fechar o arquivo
        fclose($handle);

        echo "Dados importados com sucesso!";
    } else {
        echo "Erro ao abrir o arquivo.";
    }
}

// Caminho do arquivo CSV
$filePath = 'receitas.csv';

// Chamar a função para processar o CSV
processCSV($filePath);
?>
