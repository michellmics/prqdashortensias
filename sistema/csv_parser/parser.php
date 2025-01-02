<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: text/html; charset=UTF-8');

include_once '../../objetos.php';

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

    $siteAdmin = new SITE_ADMIN();  
    $dataHoraAtual = date('Y-m-d H:i:s'); 

    // Abrir o arquivo CSV
    if (($handle = fopen($filePath, 'r')) !== FALSE) {
        // Ler o cabeçalho
        $header = fgetcsv($handle);  // Aqui lemos o cabeçalho

        //campos a serem verificados
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
        $CARTAO_ACESSO = [];
        $isCartaoAcesso = false;
        $OUTRAS_RECEITAS = [];
        $isOutrasReceitas = false;
        $RENDIMENTO_APLICACAO = [];
        $isRendimentoAplicacao = false;
        $FUNDO_INADIMPLENCIA = [];
        $isFundoInadimplencia = false;
        $CONSUMO_AGUA = [];
        $isConsumoAgua = false;
        $PARCELAMENTO_SABESP = [];
        $isParcelamentoSabesp = false;
        $SALAO_FESTA = [];
        $isSalaoFesta = false;
        $ACORDOS_RECEBIDOS = [];
        $isAcordosRecebidos = false;

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
                    'DATANOW' => $dataHoraAtual,
                    'COMPETENCIA MES USUARIO' => 'Outubro',
                    'COMPETENCIA ANO USUARIO' => '2024',
                    'TIPO' => 'RECEITA',
                    'TITULO' => 'Taxa Condominial',
                ];
            }
            // FIM TAXA CONDOMINAL

           // INI MULTAS
           if ($data[0] == "Multas"){$isMultas = true;continue;}
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
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Multas',
               ];
            }
            // FIM MULTAS

            // INI JUROS
           if ($data[0] == "Juros"){$isJuros = true;continue;}
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
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Juros',
               ];
            }
            // FIM JUROS
            
            // INI HONORARIOS ADVOCATICIOS
           if ($data[0] == "Honorários Advocaticios"){$isAdvocaticios = true;continue;}
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
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Honorários Advocaticios',
               ];
            }
            // FIM HONORARIOS ADVOCATICIOS
                        
            // INI ATUALIZACAO MONETARIA
           if ($data[0] == "Atualização Monetária"){$isAtualizacaoMonetaria = true;continue;}
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
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Atualização Monetária',
               ];
            }
            // FIM ATUALIZACAO MONETARIA

            // INI PAGAMENTO A MENOR
           if ($data[0] == "Pagamento a menor"){$isPagamentoMenor = true;continue;}
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
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Pagamento a menor',
               ];
            }
            // FIM PAGAMENTO A MENOR

            // INI CARTAO DE ACESSO
           if ($data[0] == "Cartão de Acesso"){$isCartaoAcesso = true;continue;}
           if ($isCartaoAcesso && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isCartaoAcesso = false; // Sai da seção
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
               $CARTAO_ACESSO[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Cartão de Acesso',
               ];
            }
            // FIM CARTAO DE ACESSO

            // INI OUTRAS RECEITAS
           if ($data[0] == "Outras Receitas"){$isOutrasReceitas = true;continue;}
           if ($isOutrasReceitas && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isOutrasReceitas = false; // Sai da seção
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
               if ($data[3] != "") { //junção de varias receitas sem total.
                $OUTRAS_RECEITAS[] = [
                    'DESCRICAO' => $data[0],
                    'COMPETENCIA MES' => $mes,
                    'COMPETENCIA ANO' => $ano,
                    'VALOR' => $data[3],
                    'DATANOW' => $dataHoraAtual,
                    'COMPETENCIA MES USUARIO' => 'Outubro',
                    'COMPETENCIA ANO USUARIO' => '2024',
                    'TIPO' => 'RECEITA',
                    'TITULO' => 'Outras Receitas',
                ];
                }
            }
            // FIM OUTRAS RECEITAS

            // INI RENDIMENTO APLICAÇÃO
           if ($data[0] == "Rendimento Aplicação F.O."){$isRendimentoAplicacao = true;continue;}
           if ($isRendimentoAplicacao && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isRendimentoAplicacao = false; // Sai da seção
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
               $RENDIMENTO_APLICACAO[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Rendimento Aplicação F.O.',
               ];
            }
            // FIM RENDIMENTO APLICAÇÃO

            // INI FUNDO INADIMPLENCA
           if ($data[0] == "F. Inadimplencia"){$isFundoInadimplencia = true;continue;}
           if ($isFundoInadimplencia && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isFundoInadimplencia = false; // Sai da seção
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
               $FUNDO_INADIMPLENCIA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'F. Inadimplencia',
               ];
            }
            // FIM FUNDO INADIMPLENCA

            // INI CONSUMO AGUA
           if ($data[0] == "Consumo de água"){$isConsumoAgua = true;continue;}
           if ($isConsumoAgua && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isConsumoAgua = false; // Sai da seção
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
               $CONSUMO_AGUA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Consumo de água',
               ];
            }
            // FIM CONSUMO AGUA

            // INI PARCELAMENTO SABESP
           if ($data[0] == "Parcelamento SABESP"){$isParcelamentoSabesp = true;continue;}
           if ($isParcelamentoSabesp && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isParcelamentoSabesp = false; // Sai da seção
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
               $PARCELAMENTO_SABESP[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Parcelamento SABESP',
               ];
            }
            // FIM PARCELAMENTO SABESP

            // INI SALAO DE FESTAS
           if ($data[0] == "Salao de Festa"){$isSalaoFesta = true;continue;}
           if ($isSalaoFesta && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isSalaoFesta = false; // Sai da seção
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
               $SALAO_FESTA[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Salao de Festa',
               ];
            }
            // FIM SALAO DE FESTAS

            // INI ACORDOS RECEBIDOS
           if ($data[0] == "Acordos Recebidos"){$isAcordosRecebidos = true;continue;}
           if ($isAcordosRecebidos && !empty($data[0])) {
               // Verifica se é o fim da seção (exemplo: outra categoria ou seção vazia)
               if (strpos($data[0], 'Total') !== false || empty(trim($data[0]))) {
                   $isAcordosRecebidos = false; // Sai da seção
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
               $ACORDOS_RECEBIDOS[] = [
                   'DESCRICAO' => $data[0],
                   'COMPETENCIA MES' => $mes,
                   'COMPETENCIA ANO' => $ano,
                   'VALOR' => $data[3],
                   'DATANOW' => $dataHoraAtual,
                   'COMPETENCIA MES USUARIO' => 'Outubro',
                   'COMPETENCIA ANO USUARIO' => '2024',
                   'TIPO' => 'RECEITA',
                   'TITULO' => 'Salao de Festa',
               ];
            }
            // FIM ACORDOS RECEBIDOS
        }

        //Alertas de campos vazio
        if(count($TAXA_CONDOMINAL) == 0){echo "ATENÇÃO: TAXA_CONDOMINAL VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($TAXA_CONDOMINAL);}
        if(count($MULTAS) == 0){echo "ATENÇÃO: MULTAS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($MULTAS);}
        if(count($JUROS) == 0){echo "ATENÇÃO: JUROS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($JUROS);}
        if(count($ADVOCATICIOS) == 0){echo "ATENÇÃO: ADVOCATICIOS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ADVOCATICIOS);}
        if(count($ATUALIZACAO_MONETARIA) == 0){echo "ATENÇÃO: ATUALIZACAO_MONETARIA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ATUALIZACAO_MONETARIA);}
        if(count($PAGAMENTO_A_MENOR) == 0){echo "ATENÇÃO: PAGAMENTO_A_MENOR VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($PAGAMENTO_A_MENOR);}
        if(count($CARTAO_ACESSO) == 0){echo "ATENÇÃO: CARTAO_ACESSO VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($CARTAO_ACESSO);}
        if(count($OUTRAS_RECEITAS) == 0){echo "ATENÇÃO: OUTRAS_RECEITAS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($OUTRAS_RECEITAS);}
        if(count($RENDIMENTO_APLICACAO) == 0){echo "ATENÇÃO: RENDIMENTO_APLICACAO VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($RENDIMENTO_APLICACAO);}
        if(count($FUNDO_INADIMPLENCIA) == 0){echo "ATENÇÃO: FUNDO_INADIMPLENCIA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($FUNDO_INADIMPLENCIA);}
        if(count($CONSUMO_AGUA) == 0){echo "ATENÇÃO: CONSUMO_AGUA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($CONSUMO_AGUA);}
        if(count($PARCELAMENTO_SABESP) == 0){echo "ATENÇÃO: PARCELAMENTO_SABESP VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($PARCELAMENTO_SABESP);}
        if(count($SALAO_FESTA) == 0){echo "ATENÇÃO: SALAO_FESTA VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($SALAO_FESTA);}
        if(count($ACORDOS_RECEBIDOS) == 0){echo "ATENÇÃO: ACORDOS_RECEBIDOS VAZIO, Contate o Administrador do Sistema.<br>";} else {$siteAdmin->insertConciliacaoInfo($ACORDOS_RECEBIDOS);}

        fclose($handle);

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
