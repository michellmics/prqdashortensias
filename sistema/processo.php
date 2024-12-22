<?php
// Nome do arquivo com os dados
$arquivoEntrada = 'aprocessar.csv';
$arquivoSaida = 'dados_processados.csv';

// Abrir o arquivo de entrada
$linhas = file($arquivoEntrada);

// Array para armazenar as linhas processadas
$dadosProcessados = [];

foreach ($linhas as $linha) {
    // Separar os valores por vírgula
    $valores = explode(',', trim($linha));

    // O quarto valor é a sequência numérica (CPF ou similar)
    $senha = $valores[3];

    // Gerar o hash para o valor
    $passHash = password_hash($senha, PASSWORD_DEFAULT);

    // Substituir o quarto valor pelo hash
    $valores[3] = $passHash;

    // Recriar a linha
    $dadosProcessados[] = implode(',', $valores);
}

// Escrever o arquivo de saída
file_put_contents($arquivoSaida, implode(PHP_EOL, $dadosProcessados));

echo "Processamento concluído! Dados salvos em: $arquivoSaida\n";
