<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	header('Content-Type: application/json');

  	include_once '../../objetos_chart.php'; 
	$siteCharts = new SITE_CHARTS();    

 	$siteCharts->getDespesasFull();
  	echo json_encode($siteCharts->ARRAY_DESPESAFULLINFO);




?>

