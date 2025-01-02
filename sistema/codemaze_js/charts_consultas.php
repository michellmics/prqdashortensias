<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	header('Content-Type: application/json');

	$dados = json_decode(file_get_contents("php://input"), true);
	$consulta = isset($dados['consulta']) ? $dados['consulta'] : null; 
	$dataCalendario = isset($dados['dataCalendario']) ? $dados['dataCalendario'] : null; 

  	include_once '../../objetos_chart.php'; 
	$siteCharts = new SITE_CHARTS(); 
	
	 switch ($consulta) {
        case 'inadimplencia':
			$valorInadimplencia = $siteCharts->getInadimplenciaFull();
			echo "33";
            break;

        case 'despesas':
			$siteCharts->getDespesasFull();
			echo json_encode($siteCharts->ARRAY_DESPESAFULLINFO);
            break;

        case 'receita':
			$siteCharts->getReceitasFull();
			echo json_encode($siteCharts->ARRAY_DESPESAFULLINFO);
            break;

        default:
            $resultados = ['erro' => 'Consulta inválida ou não especificada'];
            break;
    }
	






?>

