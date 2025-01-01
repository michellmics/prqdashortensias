<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

include_once '../../objetos.php';

$siteAdmin = new SITE_ADMIN();  

function removeBOM($filePath) {
    // Ler o conteúdo do arquivo
    $fileContents = file_get_contents($filePath);

    // Verificar se o arquivo contém o BOM UTF-8
    if (substr($fileContents, 0, 3) == "\xEF\xBB\xBF") {
        // Remover o BOM (os três primeiros bytes)
        $fileContents = substr($fileContents, 3);
        
        // Regravar o arquivo sem o BOM
        file_put_contents($filePath, $fileContents);
    }

    echo "BOM removido, se presente.";
}

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
                $item = preg_replace('/^[\s\xC2\xA0]+/', '', $item);  // Remove espaços no início
                $item = preg_replace('/[\s\xC2\xA0]+$/', '', $item);  // Remove espaços no final
                $item = preg_replace('/\s+/', ' ', $item);  // Substitui múltiplos espaços internos por um único espaço
            }
            
            if ($data[0] == "Receitas  Ordinárias  (99,58%)"){
                // Adiciona as informações da linha à variável
                echo "aquiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
            }

            /*
                echo "Dados da linha:<br>";
                print_r($data);
                echo "<br><br>";
                die();
            */
            var_dump($data[0]);
            
           // echo '<pre>' . htmlspecialchars($data[0]) . '</pre>';
            //print_r($data[0]);
            die();

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
removeBOM($filePath);
processCSV($filePath);
?>
