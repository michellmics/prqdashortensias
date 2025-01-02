<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

  	include_once '../objetos.php'; 

    session_start(); 
    define('SESSION_TIMEOUT', 43200); // 12 horas

	$siteAdmin = new SITE_ADMIN();  
  
    // Verifica se a sessão expirou
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
      session_unset(); // Limpa as variáveis da sessão
      session_destroy(); // Destroi a sessão
      header("Location: https://www.prqdashortensias.com.br/index.php");
      exit();
    }
  
    // Atualiza o timestamp da última atividade
    $_SESSION['last_activity'] = time();
	
  	if (!isset($_SESSION['user_id'])) 
  	{
  	  header("Location: https://www.prqdashortensias.com.br/index.php");
  	  exit();
  	}

    if ($_SESSION['user_nivelacesso'] != "SINDICO" && $_SESSION['user_nivelacesso'] != "MORADOR") 
    {
      header("Location: noAuth.php");
      exit();
    }

  	$blocoSession = $_SESSION['user_bloco'];
  	$apartamentoSession = $_SESSION['user_apartamento'];
  	$nomeSession =  ucwords($_SESSION['user_name']);
  	$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
  	$userid = $_SESSION['user_id'];

	$siteAdmin->getRelatoriosDisponiveis();
	$mesANoDefault = $siteAdmin->ARRAY_RELINFO[0]["MES"]."-".$siteAdmin->ARRAY_RELINFO[0]["ANO"];


	$dataValor = isset($_GET['data-valor']) ? strval($_GET['data-valor']) : $mesANoDefault; // Valor padrão
	  
?>

<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <!-- Meta Tags -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="Site keywords here">
		<meta name="description" content="">
		<meta name='copyright' content=''>
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<!-- Title -->
        <title>Condomínio Parque das Hortências</title>
		
		<!-- Favicon -->
        <link rel="icon" href="img/favicon.png">
		
		<!-- Google Fonts -->
		<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Nice Select CSS -->
		<link rel="stylesheet" href="css/nice-select.css">
		<!-- Font Awesome CSS -->
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- icofont CSS -->
        <link rel="stylesheet" href="css/icofont.css">
		<!-- Slicknav -->
		<link rel="stylesheet" href="css/slicknav.min.css">
		<!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="css/owl-carousel.css">
		<!-- Datepicker CSS -->
		<link rel="stylesheet" href="css/datepicker.css">
		<!-- Animate CSS -->
        <link rel="stylesheet" href="css/animate.min.css">
		<!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="css/magnific-popup.css">
		
		<!-- Medipro CSS -->
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="css/responsive.css">

        <!-- SWEETALERT -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<link rel="icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="shortcut icon" href="https://www.prqdashortensias.com.br/logo_icon.ico" type="image/x-icon">
    	<link rel="apple-touch-icon" href="https://www.prqdashortensias.com.br/logo_icon.png">
    	<meta name="apple-mobile-web-app-title" content="Hortensias">
    	<meta name="apple-mobile-web-app-capable" content="yes">
    	<meta name="apple-mobile-web-app-status-bar-style" content="default">

		<!-- DASHBOARD -->

		<!-- Chart.js -->
		<script src="vendors/Chart.js/dist/Chart.min.js"></script>
		<link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    	<script src="vendors/echarts/dist/echarts.min.js"></script>
    	<script src="vendors/echarts/map/js/world.js"></script>
		<!-- bootstrap-daterangepicker -->
		<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    	<!-- bootstrap-datetimepicker -->
    	<link href="vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
    	<!-- Ion.RangeSlider -->
    	<link href="vendors/normalize-css/normalize.css" rel="stylesheet">
    	<link href="vendors/ion.rangeSlider/css/ion.rangeSlider.css" rel="stylesheet">
    	<link href="vendors/ion.rangeSlider/css/ion.rangeSlider.skinFlat.css" rel="stylesheet">
    	<!-- Datatables -->
    	<link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    	<link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    	<link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    	<link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    	<link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

		

		<!-- DASHBOARD -->


        <style>
          /* Configuração geral do HTML e Body */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Footer fixo no final */
.footerNew {
    background-color: #f0f0f0; /* Cinza bem claro */
    color: #000; /* Cinza clarinho para o texto */
    font-size: 12px; /* Fonte pequena */
    text-align: center; /* Centraliza o texto */
    padding: 0; /* Remove espaçamento interno */
    height: 65px; /* Altura do footer */
    line-height: 30px; /* Centraliza verticalmente o texto */
    position: fixed; /* Fixa o footer */
    bottom: 0; /* Colado no final da página */
    width: 100%; /* Largura total */
}
 /* Botão de Salvar em lilás */
 .btn-primary {
      background-color:#8a0653; /* Lilás */
      border-color: #8a0653; /* Mesma cor da borda */
      color: white; /* Texto branco */
  }
  .btn-primary:hover {
      background-color: #993399; /* Lilás mais claro ao passar o mouse */
  }

  /* Botão de Voltar em lilás mais claro */
  .btn-warning {
      background-color: #D8BFD8; /* Lilás mais claro */
      border-color: #D8BFD8; /* Mesma cor da borda */
      color: #4B0082; /* Texto em roxo escuro */
  }
  .btn-warning:hover {
      background-color: #E6E6FA; /* Lilás ainda mais claro ao passar o mouse */
  }

        </style>
		
    </head>
    <body>
	
		<!-- Preloader -->
		<?php include 'src/preloader.php'; ?>
		<!-- End Preloader -->
     

		<!-- Header Area -->
		<?php include 'src/header.php'; ?>
		<!-- End Header Area -->


					
  		<!-- ini content Area -->
		<section class="content" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
	
			<div class="container">
			<div class="row">
				<div class="col-2">
				    <label class="control-label" for="mesAno">Mês</label>
				    <select id="mesAno" name="mesAno" class="form-control" required>
				        <?php
							foreach ($siteAdmin->ARRAY_RELINFO as $relatorio)
							{	
								$mesAno = $relatorio["MES"]."-".$relatorio["ANO"];
								$mesAnoLabel = ucfirst($mesAno);
								echo "<option value=\"$mesAno\">$mesAnoLabel </option>";
							}
				        ?>
				    </select>
				</div>
				<div class="col-auto d-flex align-items-end">
        <button 
            type="button" 
            class="btn btn-primary" 
            style="height: calc(2.25rem + 2px);" 
            onclick="window.location.href='pagina_adicionar_relatorio.php';">
            Adicionar Relatório
        </button>
    </div>
			</div>
				<div class="row">
					<!-- INI GRAFICO GAUGE -->
					  <div class="col-md-6 col-sm-12" style="border: 0px solid #d4cccb;">
    				  <div class="x_panel">
    				    <div class="x_title">
    				      <h1>Inadimplência</h1>
    				      <div class="clearfix"></div>
    				    </div>
    				    <div class="x_content">
    				      <div id="echart_gauge_codemaze" data-valor=<? echo $dataValor; ?> style="height:350px;"></div>
    				    </div>
    				  </div>
    				</div>
    				<!-- FIM GRAFICO GAUGE -->


  					<!-- INI GRAFICO PIZZA DETALHE -->
					<div class="col-md-6 col-sm-12" style="border: 0px solid #d4cccb;">
        			  <div class="x_panel">
        			    <div class="x_title">
        			      <h1>Receitas (Top 10)</h1>
        			      <ul class="nav navbar-right panel_toolbox">
        			        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        			        </li>
        			        <li class="dropdown">
        			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
        			          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        			              <a class="dropdown-item" href="#">Settings 1</a>
        			              <a class="dropdown-item" href="#">Settings 2</a>
        			            </div>
        			        </li>
        			        <li><a class="close-link"><i class="fa fa-close"></i></a>
        			        </li>
        			      </ul>
        			      <div class="clearfix"></div>
        			    </div>
        			    <div class="x_content">
        			      <div id="echart_pie_codemaze" data-valor=<? echo $dataValor; ?> style="height:350px;"></div>
        			    </div>						
        			  </div>
        			</div>
        			<!-- FIM GRAFICO PIZZA DETALHE -->
				</div>




				<div class="row">
        			<!-- INI GRAFICO AREA -->
        			<div class="col-md-12 col-sm-12  ">
        			  <div class="x_panel">
        			    <div class="x_title">
        			      <h1>Despesas</h1>
        			      <ul class="nav navbar-right panel_toolbox">
        			        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        			        </li>
        			        <li class="dropdown">
        			          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
        			          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        			              <a class="dropdown-item" href="#">Settings 1</a>
        			              <a class="dropdown-item" href="#">Settings 2</a>
        			            </div>
        			        </li>
        			        <li><a class="close-link"><i class="fa fa-close"></i></a>
        			        </li>
        			      </ul>
        			      <div class="clearfix"></div>
        			    </div>
        			    <div class="x_content">

        			      <div id="echart_line" style="height:350px;"></div>

        			    </div>
        			  </div>
        			</div>
        			<!-- FIM GRAFICO AREA -->
				</div>
				
				<div class="row">

				</div>
			</div>


		</section>
		<style>
  			/* Para dispositivos móveis (telas menores que 768px) */


  			@media (max-width: 768px) {
  			  .content {
  			    margin-top: 230px;
  			  }
  			}
			  @media (max-width: 450px) {
				.content {
  			    margin-top: 270px;
  			  }  				
			}	
			@media (max-width: 375px) {
				.content {
  			    margin-top: 400px;
  			  }  				
			}
			@media (max-width: 360px) {
				.content {
  			    margin-top: 350px;
  			  }  				
			}
			@media (max-width: 350px) {
				.content {
  			    margin-top: 300px;
  			  }  				
			}

  			/* Para telas maiores que 768px */
  			@media (min-width: 769px) {
  			  .content {
  			    margin-top: 100px;
  			  }
  			}
		</style>
  		<!-- end content Area -->

<!-- Footer -->
<footer class="footerNew">
	<?php include 'src/footer.php'; ?>
</footer>
		

		
		<!-- jquery Min JS -->
        <script src="js/jquery.min.js"></script>
		<!-- jquery Migrate JS -->
		<script src="js/jquery-migrate-3.0.0.js"></script>
		<!-- jquery Ui JS -->
		<script src="js/jquery-ui.min.js"></script>
		<!-- Easing JS -->
        <script src="js/easing.js"></script>
		<!-- Color JS -->
		<script src="js/colors.js"></script>
		<!-- Popper JS -->
		<script src="js/popper.min.js"></script>
		<!-- Bootstrap Datepicker JS -->
		<script src="js/bootstrap-datepicker.js"></script>
		<!-- Jquery Nav JS -->
        <script src="js/jquery.nav.js"></script>
		<!-- Slicknav JS -->
		<script src="js/slicknav.min.js"></script>
		<!-- ScrollUp JS -->
        <script src="js/jquery.scrollUp.min.js"></script>
		<!-- Niceselect JS -->
		<script src="js/niceselect.js"></script>
		<!-- Tilt Jquery JS -->
		<script src="js/tilt.jquery.min.js"></script>
		<!-- Owl Carousel JS -->
        <script src="js/owl-carousel.js"></script>
		<!-- counterup JS -->
		<script src="js/jquery.counterup.min.js"></script>
		<!-- Steller JS -->
		<script src="js/steller.js"></script>
		<!-- Wow JS -->
		<script src="js/wow.min.js"></script>
		<!-- Magnific Popup JS -->
		<script src="js/jquery.magnific-popup.min.js"></script>
		<!-- Counter Up CDN JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/2.0.3/waypoints.min.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- Main JS -->
		<script src="js/main.js"></script>

  		<!-- DASHBOARD -->

		<!-- Chart.js -->
		<script src="vendors/Chart.js/dist/Chart.min.js"></script>
		<script src="codemaze_js/codemaze_js_custom.js?ver=<?php echo time(); ?>"></script>
		
		<!-- Bootstrap -->
		<script src="vendors/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
		<!-- NProgress -->
		<script src="vendors/nprogress/nprogress.js"></script>
		<!-- FastClick -->
		<script src="vendors/fastclick/lib/fastclick.js"></script>
		<!-- easy-pie-chart -->
		<script src="vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
		<!-- jQuery Sparklines -->
		<script src="vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
    	<!-- easy-pie-chart -->
    	<script src="vendors/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    	<!-- bootstrap-progressbar -->
    	<script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    	<!-- morris.js -->
    	<script src="vendors/raphael/raphael.min.js"></script>
    	<script src="vendors/morris.js/morris.min.js"></script>
    	<!-- bootstrap-daterangepicker -->
    	<script src="vendors/moment/min/moment.min.js"></script>
    	<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    	<!-- bootstrap-datetimepicker -->    
    	<script src="vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    	<!-- Datatables -->
    	<script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    	<script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    	<script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    	<script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    	<script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    	<script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    	<script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    	<script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    	<script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    	<script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    	<script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    	<script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    	<script src="vendors/jszip/dist/jszip.min.js"></script>
    	<script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    	<script src="vendors/pdfmake/build/vfs_fonts.js"></script>
		

		<!-- DASHBOARD -->
		<script>
    $(document).ready(function () {
        // Detecta mudança no combobox
        $('#mesAno').on('change', function () {
            const selectedValue = $(this).val(); // Valor selecionado no combobox
            const gauge = $('#echart_gauge_codemaze'); // Seleciona o elemento do gauge
            gauge.attr('data-valor', selectedValue); // Atualiza o atributo data-valor do gauge
            
            // Recarrega a página com o valor como parâmetro na URL
            const currentUrl = window.location.href.split('?')[0]; // Remove query strings antigas
            window.location.href = `${currentUrl}?data-valor=${selectedValue}`;
        });
    });
</script>
		
		
    </body>
</html>