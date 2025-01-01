<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

include_once '../../objetos.php';

$siteAdmin = new SITE_ADMIN();

function removeBOM($filePath) {
    $fileContents = file_get_contents($filePath);
    if (substr($fileContents, 0, 3) == "\xEF\xBB\xBF") {
        $fileContents = substr($fileContents, 3);
        file_put_contents($filePath, $fileContents);
    }
}

function processCSV($filePath) {
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        $header = fgetcsv($handle);

        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
            foreach ($data as &$item) {
                // Normaliza o texto
                $item = preg_replace('/^[\s\xC2\xA0]+|[\s\xC2\xA0]+$/', '', $item); // Remove espaços no início/fim
                $item = preg_replace('/\s+/', ' ', $item); // Substitui múltiplos espaços por um único
            }

            // Debug: Mostrar códigos ASCII
            echo "Valor atual: " . htmlspecialchars($data[0]) . "<br>";
            echo "Códigos ASCII: ";
            for ($i = 0; $i < strlen($data[0]); $i++) {
                echo ord($data[0][$i]) . " ";
            }
            echo "<br><br>";

            // Comparação do valor
            if (trim($data[0]) === "Receitas Ordinárias (99,58%)") {
                echo "Encontrado: Receitas Ordinárias (99,58%)!";
            }

            die(); // Para interromper e inspecionar
        }

        fclose($handle);
    } else {
        echo "Erro ao abrir o arquivo.";
    }
}

$filePath = 'receitas.csv';
removeBOM($filePath);
processCSV($filePath);
?>
