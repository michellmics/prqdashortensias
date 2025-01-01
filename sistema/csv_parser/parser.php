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
        //echo "Cabeçalho do CSV:<br>";
        print_r($header);
        echo "<br><br>";

        //Ler os dados de pagamento da taxa condominal
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                        // Remover espaços e tabulações no início de cada valor
                        $data = array_map(function($item) {
                            return ltrim($item); // Remove espaços e tabulações do início da string
                        }, $data);
            
            if ($data[0] == "Taxa Condominial"){
                // Adiciona as informações da linha à variável
                echo "aquii";
            }

            /*
                echo "Dados da linha:<br>";
                print_r($data);
                echo "<br><br>";
                die();
            */
            print_r($data[0]);
            echo "<br>";

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
