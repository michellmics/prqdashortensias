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

}

function processCSV($filePath) {
    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ler o cabeçalho
        $header = fgetcsv($handle);  // Aqui lemos o cabeçalho

        $TAXA_CONDOMINAL = [];
        $isTaxaCondominial = false;

        $MULTAS = [];
        $isMultas = false;

        $JUROS = [];
        $isJuros = false;

        $ADVOCATICIOS = [];
        $isAdvocaticios = false;

        $ATUALIZACAO_MONETARIA = [];
        $isAtualizacaoMonetaria = false;

        $PAGAMENTO_A_MENOR = [];
        $isPagamentoMenor = false;

        //Ler os dados de pagamento da taxa condominal
        while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {

            foreach ($data as &$item) {
                // Substitui NBSP por espaços comuns
                $item = str_replace("\xC2\xA0", ' ', $item);
                $item = trim($item);
                // Substitui múltiplos espaços internos (inclusive NBSP) por um único espaço comum
                $item = preg_replace('/\s+/', ' ', $item);
            }

            
           // INI TAXA CONDOMINAL
            if ($data[0] == "Taxa Condominial"){$isTaxaCondominial = true;continue;}
            // Se estamos na seção "Taxa Condominial" e a linha não está vazia
            if ($isTaxaCondominial && !empty($data[0])) {
                // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
                if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                    $isTaxaCondominial = false; // Sai da seção
                    continue;
                }    
                
                // Extrai o mês e o ano se o valor da competência estiver no formato esperado
                $competencia = $data[1];
                $mes = $competencia; // Valor padrão, caso não seja no formato esperado
                $ano = null;         // Valor padrão para o ano
                
                if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                    $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                    $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
                }
                $TAXA_CONDOMINAL[] = [
                    'DESCRICAO' => $data[0],
                    'COMPETENCIA MES' => $mes,
                    'COMPETENCIA ANO' => $ano,
                    'VALOR' => $data[3],
                ];
            }
            // FIM TAXA CONDOMINAL

           // INI MULTAS
           if ($data[0] == "Multas"){$isMultas = true;continue;}
           // Se estamos na seção "Taxa Condominial" e a linha não está vazia
           if ($isMultas && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isMultas = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $MULTAS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
               ];
            }
            // FIM MULTAS

            // INI JUROS
           if ($data[0] == "Juros"){$isJuros = true;continue;}
           // Se estamos na seção "Taxa Condominial" e a linha não está vazia
           if ($isJuros && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isJuros = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $JUROS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
               ];
            }
            // FIM JUROS
            
            // INI HONORARIOS ADVOCATICIOS
           if ($data[0] == "Honorários Advocaticios"){$isAdvocaticios = true;continue;}
           // Se estamos na seção "Taxa Condominial" e a linha não está vazia
           if ($isAdvocaticios && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAdvocaticios = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $ADVOCATICIOS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
               ];
            }
            // FIM HONORARIOS ADVOCATICIOS
                        
            // INI ATUALIZACAO MONETARIA
           if ($data[0] == "Atualização Monetária"){$isAtualizacaoMonetaria = true;continue;}
           // Se estamos na seção "Taxa Condominial" e a linha não está vazia
           if ($isAtualizacaoMonetaria && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAtualizacaoMonetaria = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $ATUALIZACAO_MONETARIA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
               ];
            }
            // FIM ATUALIZACAO MONETARIA

            // INI PAGAMENTO A MENOR
           if ($data[0] == "Pagamento a menor"){$isPagamentoMenor = true;continue;}
           // Se estamos na seção "Taxa Condominial" e a linha não está vazia
           if ($isPagamentoMenor && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isPagamentoMenor = false; // Sai da seção
                   continue;
               }    

               // Extrai o mês e o ano se o valor da competência estiver no formato esperado
               $competencia = $data[1];
               $mes = $competencia; // Valor padrão, caso não seja no formato esperado
               $ano = null;         // Valor padrão para o ano

               if (preg_match('/^([A-Za-z]{3})-(\d{2})$/', $competencia, $matches)) {
                   $mes = $matches[1]; // Primeiro grupo corresponde ao mês
                   $ano = '20' . $matches[2]; // Segundo grupo corresponde ao ano (convertido para formato completo)
               }
               $PAGAMENTO_A_MENOR[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
               ];
            }
            // FIM PAGAMENTO A MENOR






        }
        echo "<pre>";
        //print_r($TAXA_CONDOMINAL);
        echo "</pre>";

        echo "<pre>";
        //print_r($MULTAS);
        echo "</pre>";

        echo "<pre>";
        //print_r($JUROS);
        echo "</pre>"; 

        echo "<pre>";
        //print_r($ADVOCATICIOS);
        echo "</pre>"; 

        echo "<pre>";
        //print_r($ATUALIZACAO_MONETARIA);
        echo "</pre>"; 

        echo "<pre>";
        print_r($PAGAMENTO_A_MENOR);
        echo "</pre>";
      


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
