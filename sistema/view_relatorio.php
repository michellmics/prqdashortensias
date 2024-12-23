<?php
	include_once '../objetos.php'; // Carrega a classe de conexão e objetos
	/*
	session_start(); 
	define('SESSION_TIMEOUT', 43200); // 30 minutos
	
	if (!isset($_SESSION['user_id'])) 
	{
	  header("Location: https://www.prqdashortensias.com.br/index.php");
	  exit();
	}
	*/
	$blocoSession = $_SESSION['user_bloco'];
	$apartamentoSession = $_SESSION['user_apartamento'];
	$nomeSession =  ucwords($_SESSION['user_name']);
	$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
	$userid = $_SESSION['user_id'];
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
    height: 30px; /* Altura do footer */
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
		<div class="preloader">
		    <div class="loader">
		        <div class="loader-outter"></div>
		        <div class="loader-inner"></div>

		        <div class="indicator"> 
		            <!-- Substitua este SVG pelo seu novo ícone -->
		            <svg width="50px" height="50px" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
		                <circle cx="50" cy="50" r="45" stroke="#000" stroke-width="5" fill="none" />
		                <circle cx="50" cy="50" r="40" stroke="#3498db" stroke-width="5" fill="none" />
		            </svg>
		        </div>
		    </div>
		</div>
		<!-- End Preloader -->
     

		<!-- Header Area -->
		<header class="header" >
			<!-- Topbar -->
			<div class="topbar">
				<div class="container">
					<div class="row">
						<div class="col-lg-6 col-md-5 col-12">
							<!-- Contact -->
							<ul class="top-link">
								<!-- <li><a href="#">Serviços</a></li> -->
								<!-- <li><a href="#">Contact</a></li> -->
								<!-- <li><a href="#">FAQ</a></li> -->
							</ul>
							<!-- End Contact -->
						</div>
						<div class="col-lg-6 col-md-7 col-12">
							<!-- Top Contact -->
							<ul class="top-contact">
								<li><b>Morador:</b> <? echo $usuariologado; ?></li> 
								<!--  <li><i class="fa fa-envelope"></i><a href="mailto:sada@sdf.com">23123213123</a></li> -->
							</ul>
							<!-- End Top Contact -->
						</div>
					</div>
				</div>
			</div>
			<!-- End Topbar -->
			<!-- Header Inner -->
			<div class="header-inner">
				<div class="container">
					<div class="inner">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-12">
								<!-- Start Logo -->
								<div class="logo">
									<a href="#slider"><img src="https://prqdashortensias.com.br/sistema/img/logo_hor_hort.png" alt="#"></a>
								</div>
								<!-- End Logo -->
								<!-- Mobile Nav -->
								<div class="mobile-nav"></div>
								<!-- End Mobile Nav -->
							</div>
							<div class="col-lg-7 col-md-9 col-12">
								<!-- Main Menu -->
								<div class="main-menu">
									<nav class="navigation">
										<ul class="nav menu">
											<li><a href="index.php">Inicio</a></li>
											<li><a href="morador_table.php">Moradores </a></li>
											<li><a href="lista_table.php">Minha Lista de Convidados </a></li>
											<li><a href="morador_form_edit_profile.php">Minha Conta </a></li> 
											<li><a href="../logoff.php">Sair </a></li>
										</ul>
									</nav>
								</div>
								<!--/ End Main Menu -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--/ End Header Inner -->
		</header>
		<!-- End Header Area -->
		
  		<!-- ini content Area -->
		<section class="content" style="display: flex; justify-content: center; align-items: center; height: 100vh; margin-top: 200px;">
			<div class="container">

				<div class="row">
					<!-- INI GRAFICO GAUGE -->
					  <div class="col-md-6 col-sm-12" style="border: 0px solid #d4cccb;">
    				  <div class="x_panel">
    				    <div class="x_title">
    				      <h2>Performance</h2>
    				      <div class="clearfix"></div>
    				    </div>
    				    <div class="x_content">
    				      <div id="echart_gauge_codemaze" style="height:350px;"></div>
    				    </div>
    				  </div>
    				</div>
    				<!-- FIM GRAFICO GAUGE -->


  					<!-- INI GRAFICO PIZZA DETALHE -->
					<div class="col-md-6 col-sm-12" style="border: 0px solid #d4cccb;">
        			  <div class="x_panel">
        			    <div class="x_title">
        			      <h2>Pie Graph</h2>
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

        			      <div id="echart_pie_codemaze" style="height:350px;"></div>

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
        			      <h2>Line Graph</h2>
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
				<div class="row">

				</div>
			</div>




















		</section>
  		<!-- end content Area -->

<!-- Footer -->
<footer class="footerNew">
  <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de Mkt e Software | <b><font color="red"><? echo $_SESSION['user_nivelacesso']; ?></font></b>
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
		<script src="codemaze_js\codemaze_js_custom.js"></script>
		
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

		
		
    </body>
</html>