<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

include_once '../../objetos.php';

$siteAdmin = new SITE_ADMIN();  

function processCSV($filePath) {
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ler o cabeçalho
        $header = fgetcsv($handle);  // Aqui lemos o cabeçalho

        // Exibir o cabeçalho para referência (opcional)
        //echo "Cabeçalho do CSV:<br>";
        //print_r($header);
        //echo "<br><br>";

        //Ler os dados de pagamento da taxa condominal
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

            foreach ($data as &$item) {
                // Remove espaços comuns e NBSP do início usando regex
                $item = preg_replace('/^[\s\xC2\xA0]+/', '', $item);
            }

            $data[0] = preg_replace('/\s+/', ' ', $data[0]);  // Substitui múltiplos espaços por um único espaço
            $data[0] = trim($data[0]);  // Remove espaços extras nas extremidades
            
            if (trim($data[0]) == "Parcelamento  SABESP"){
                // Adiciona as informações da linha à variável
                echo "aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
            }

            /*
                echo "Dados da linha:<br>";
                print_r($data);
                echo "<br><br>";
                die();
            */

            echo '<pre>' . htmlspecialchars($data[0]) . '</pre>';
            //print_r($data[0]);


        }


        // Fechar o arquivo
        fclose($handle);

        //print_r($data);
        die();

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
