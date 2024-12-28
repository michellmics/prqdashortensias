<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

  	include_once '../objetos.php'; 

    session_start(); 
    define('SESSION_TIMEOUT', 43200); // 12 horas
  
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

    if ($_SESSION['user_nivelacesso'] != "SINDICO") 
    {
      header("Location: noAuth.php");
      exit();
    }

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
		<?php include 'src/preloader.php'; ?>
		<!-- End Preloader -->
     

		<!-- Header Area -->
		<?php include 'src/header.php'; ?>
		<!-- End Header Area -->


					
  		<!-- ini content Area -->
		<section class="content" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
			<div class="container">
		
				<div class="col-md-5" style="border: none; outline: none;">
				  Escolha o mês
				  <form class="">
				    <fieldset style="border: none; outline: none;">
				      <div class="control-group">
				        <div class="controls">
				          <div class="input-prepend input-group">
				            <span class="add-on input-group-addon">
				              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
				            </span>
				            <!-- Substituí o input para aceitar apenas meses -->
				            <input type="month" name="reservation-month" id="reservation-month" class="form-control" />
				          </div>
				        </div>
				      </div>
				    </fieldset>
				  </form>
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
    				      <div id="echart_gauge_codemaze" style="height:350px;"></div>
    				    </div>
    				  </div>
    				</div>
    				<!-- FIM GRAFICO GAUGE -->


  					<!-- INI GRAFICO PIZZA DETALHE -->
					<div class="col-md-6 col-sm-12" style="border: 0px solid #d4cccb;">
        			  <div class="x_panel">
        			    <div class="x_title">
        			      <h1>Receitas</h1>
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

					<!-- INI TABELA -->
					<div class="col-md-12 col-sm-12 ">
        			  <div class="x_panel">FFF
        			    <div class="x_title">
        			      <h2>Button Example <small>Users</small></h2>
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
        			        <div class="row">
        			            <div class="col-sm-12">
        			              <div class="card-box table-responsive">
        			      <p class="text-muted font-13 m-b-30">
        			        The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
        			      </p>
        			      <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
        			        <thead>
        			          <tr>
        			            <th>Name</th>
        			            <th>Position</th>
        			            <th>Office</th>
        			            <th>Age</th>
        			            <th>Start date</th>
        			            <th>Salary</th>
        			          </tr>
        			        </thead>
  		
  		
        			        <tbody>
        			          <tr>
        			            <td>Tiger Nixon</td>
        			            <td>System Architect</td>
        			            <td>Edinburgh</td>
        			            <td>61</td>
        			            <td>2011/04/25</td>
        			            <td>$320,800</td>
        			          </tr>
        			          <tr>
        			            <td>Garrett Winters</td>
        			            <td>Accountant</td>
        			            <td>Tokyo</td>
        			            <td>63</td>
        			            <td>2011/07/25</td>
        			            <td>$170,750</td>
        			          </tr>
        			          <tr>
        			            <td>Ashton Cox</td>
        			            <td>Junior Technical Author</td>
        			            <td>San Francisco</td>
        			            <td>66</td>
        			            <td>2009/01/12</td>
        			            <td>$86,000</td>
        			          </tr>
        			          <tr>
        			            <td>Cedric Kelly</td>
        			            <td>Senior Javascript Developer</td>
        			            <td>Edinburgh</td>
        			            <td>22</td>
        			            <td>2012/03/29</td>
        			            <td>$433,060</td>
        			          </tr>
        			          <tr>
        			            <td>Airi Satou</td>
        			            <td>Accountant</td>
        			            <td>Tokyo</td>
        			            <td>33</td>
        			            <td>2008/11/28</td>
        			            <td>$162,700</td>
        			          </tr>
        			          <tr>
        			            <td>Brielle Williamson</td>
        			            <td>Integration Specialist</td>
        			            <td>New York</td>
        			            <td>61</td>
        			            <td>2012/12/02</td>
        			            <td>$372,000</td>
        			          </tr>
        			          <tr>
        			            <td>Herrod Chandler</td>
        			            <td>Sales Assistant</td>
        			            <td>San Francisco</td>
        			            <td>59</td>
        			            <td>2012/08/06</td>
        			            <td>$137,500</td>
        			          </tr>
        			          <tr>
        			            <td>Rhona Davidson</td>
        			            <td>Integration Specialist</td>
        			            <td>Tokyo</td>
        			            <td>55</td>
        			            <td>2010/10/14</td>
        			            <td>$327,900</td>
        			          </tr>
        			          <tr>
        			            <td>Colleen Hurst</td>
        			            <td>Javascript Developer</td>
        			            <td>San Francisco</td>
        			            <td>39</td>
        			            <td>2009/09/15</td>
        			            <td>$205,500</td>
        			          </tr>
        			          <tr>
        			            <td>Sonya Frost</td>
        			            <td>Software Engineer</td>
        			            <td>Edinburgh</td>
        			            <td>23</td>
        			            <td>2008/12/13</td>
        			            <td>$103,600</td>
        			          </tr>
        			          <tr>
        			            <td>Jena Gaines</td>
        			            <td>Office Manager</td>
        			            <td>London</td>
        			            <td>30</td>
        			            <td>2008/12/19</td>
        			            <td>$90,560</td>
        			          </tr>
        			          <tr>
        			            <td>Quinn Flynn</td>
        			            <td>Support Lead</td>
        			            <td>Edinburgh</td>
        			            <td>22</td>
        			            <td>2013/03/03</td>
        			            <td>$342,000</td>
        			          </tr>
        			          <tr>
        			            <td>Charde Marshall</td>
        			            <td>Regional Director</td>
        			            <td>San Francisco</td>
        			            <td>36</td>
        			            <td>2008/10/16</td>
        			            <td>$470,600</td>
        			          </tr>
        			          <tr>
        			            <td>Haley Kennedy</td>
        			            <td>Senior Marketing Designer</td>
        			            <td>London</td>
        			            <td>43</td>
        			            <td>2012/12/18</td>
        			            <td>$313,500</td>
        			          </tr>
        			          <tr>
        			            <td>Tatyana Fitzpatrick</td>
        			            <td>Regional Director</td>
        			            <td>London</td>
        			            <td>19</td>
        			            <td>2010/03/17</td>
        			            <td>$385,750</td>
        			          </tr>
        			          <tr>
        			            <td>Michael Silva</td>
        			            <td>Marketing Designer</td>
        			            <td>London</td>
        			            <td>66</td>
        			            <td>2012/11/27</td>
        			            <td>$198,500</td>
        			          </tr>
        			          <tr>
        			            <td>Paul Byrd</td>
        			            <td>Chief Financial Officer (CFO)</td>
        			            <td>New York</td>
        			            <td>64</td>
        			            <td>2010/06/09</td>
        			            <td>$725,000</td>
        			          </tr>
        			          <tr>
        			            <td>Gloria Little</td>
        			            <td>Systems Administrator</td>
        			            <td>New York</td>
        			            <td>59</td>
        			            <td>2009/04/10</td>
        			            <td>$237,500</td>
        			          </tr>
        			          <tr>
        			            <td>Bradley Greer</td>
        			            <td>Software Engineer</td>
        			            <td>London</td>
        			            <td>41</td>
        			            <td>2012/10/13</td>
        			            <td>$132,000</td>
        			          </tr>
        			          <tr>
        			            <td>Dai Rios</td>
        			            <td>Personnel Lead</td>
        			            <td>Edinburgh</td>
        			            <td>35</td>
        			            <td>2012/09/26</td>
        			            <td>$217,500</td>
        			          </tr>
        			          <tr>
        			            <td>Jenette Caldwell</td>
        			            <td>Development Lead</td>
        			            <td>New York</td>
        			            <td>30</td>
        			            <td>2011/09/03</td>
        			            <td>$345,000</td>
        			          </tr>
        			          <tr>
        			            <td>Yuri Berry</td>
        			            <td>Chief Marketing Officer (CMO)</td>
        			            <td>New York</td>
        			            <td>40</td>
        			            <td>2009/06/25</td>
        			            <td>$675,000</td>
        			          </tr>
        			          <tr>
        			            <td>Caesar Vance</td>
        			            <td>Pre-Sales Support</td>
        			            <td>New York</td>
        			            <td>21</td>
        			            <td>2011/12/12</td>
        			            <td>$106,450</td>
        			          </tr>
        			          <tr>
        			            <td>Doris Wilder</td>
        			            <td>Sales Assistant</td>
        			            <td>Sidney</td>
        			            <td>23</td>
        			            <td>2010/09/20</td>
        			            <td>$85,600</td>
        			          </tr>
        			          <tr>
        			            <td>Angelica Ramos</td>
        			            <td>Chief Executive Officer (CEO)</td>
        			            <td>London</td>
        			            <td>47</td>
        			            <td>2009/10/09</td>
        			            <td>$1,200,000</td>
        			          </tr>
        			          <tr>
        			            <td>Gavin Joyce</td>
        			            <td>Developer</td>
        			            <td>Edinburgh</td>
        			            <td>42</td>
        			            <td>2010/12/22</td>
        			            <td>$92,575</td>
        			          </tr>
        			          <tr>
        			            <td>Jennifer Chang</td>
        			            <td>Regional Director</td>
        			            <td>Singapore</td>
        			            <td>28</td>
        			            <td>2010/11/14</td>
        			            <td>$357,650</td>
        			          </tr>
        			          <tr>
        			            <td>Brenden Wagner</td>
        			            <td>Software Engineer</td>
        			            <td>San Francisco</td>
        			            <td>28</td>
        			            <td>2011/06/07</td>
        			            <td>$206,850</td>
        			          </tr>
        			          <tr>
        			            <td>Fiona Green</td>
        			            <td>Chief Operating Officer (COO)</td>
        			            <td>San Francisco</td>
        			            <td>48</td>
        			            <td>2010/03/11</td>
        			            <td>$850,000</td>
        			          </tr>
        			          <tr>
        			            <td>Shou Itou</td>
        			            <td>Regional Marketing</td>
        			            <td>Tokyo</td>
        			            <td>20</td>
        			            <td>2011/08/14</td>
        			            <td>$163,000</td>
        			          </tr>
        			          <tr>
        			            <td>Michelle House</td>
        			            <td>Integration Specialist</td>
        			            <td>Sidney</td>
        			            <td>37</td>
        			            <td>2011/06/02</td>
        			            <td>$95,400</td>
        			          </tr>
        			          <tr>
        			            <td>Suki Burks</td>
        			            <td>Developer</td>
        			            <td>London</td>
        			            <td>53</td>
        			            <td>2009/10/22</td>
        			            <td>$114,500</td>
        			          </tr>
        			          <tr>
        			            <td>Prescott Bartlett</td>
        			            <td>Technical Author</td>
        			            <td>London</td>
        			            <td>27</td>
        			            <td>2011/05/07</td>
        			            <td>$145,000</td>
        			          </tr>
        			          <tr>
        			            <td>Gavin Cortez</td>
        			            <td>Team Leader</td>
        			            <td>San Francisco</td>
        			            <td>22</td>
        			            <td>2008/10/26</td>
        			            <td>$235,500</td>
        			          </tr>
        			          <tr>
        			            <td>Martena Mccray</td>
        			            <td>Post-Sales support</td>
        			            <td>Edinburgh</td>
        			            <td>46</td>
        			            <td>2011/03/09</td>
        			            <td>$324,050</td>
        			          </tr>
        			          <tr>
        			            <td>Unity Butler</td>
        			            <td>Marketing Designer</td>
        			            <td>San Francisco</td>
        			            <td>47</td>
        			            <td>2009/12/09</td>
        			            <td>$85,675</td>
        			          </tr>
        			          <tr>
        			            <td>Howard Hatfield</td>
        			            <td>Office Manager</td>
        			            <td>San Francisco</td>
        			            <td>51</td>
        			            <td>2008/12/16</td>
        			            <td>$164,500</td>
        			          </tr>
        			          <tr>
        			            <td>Hope Fuentes</td>
        			            <td>Secretary</td>
        			            <td>San Francisco</td>
        			            <td>41</td>
        			            <td>2010/02/12</td>
        			            <td>$109,850</td>
        			          </tr>
        			          <tr>
        			            <td>Vivian Harrell</td>
        			            <td>Financial Controller</td>
        			            <td>San Francisco</td>
        			            <td>62</td>
        			            <td>2009/02/14</td>
        			            <td>$452,500</td>
        			          </tr>
        			          <tr>
        			            <td>Timothy Mooney</td>
        			            <td>Office Manager</td>
        			            <td>London</td>
        			            <td>37</td>
        			            <td>2008/12/11</td>
        			            <td>$136,200</td>
        			          </tr>
        			          <tr>
        			            <td>Jackson Bradshaw</td>
        			            <td>Director</td>
        			            <td>New York</td>
        			            <td>65</td>
        			            <td>2008/09/26</td>
        			            <td>$645,750</td>
        			          </tr>
        			          <tr>
        			            <td>Olivia Liang</td>
        			            <td>Support Engineer</td>
        			            <td>Singapore</td>
        			            <td>64</td>
        			            <td>2011/02/03</td>
        			            <td>$234,500</td>
        			          </tr>
        			          <tr>
        			            <td>Bruno Nash</td>
        			            <td>Software Engineer</td>
        			            <td>London</td>
        			            <td>38</td>
        			            <td>2011/05/03</td>
        			            <td>$163,500</td>
        			          </tr>
        			          <tr>
        			            <td>Sakura Yamamoto</td>
        			            <td>Support Engineer</td>
        			            <td>Tokyo</td>
        			            <td>37</td>
        			            <td>2009/08/19</td>
        			            <td>$139,575</td>
        			          </tr>
        			          <tr>
        			            <td>Thor Walton</td>
        			            <td>Developer</td>
        			            <td>New York</td>
        			            <td>61</td>
        			            <td>2013/08/11</td>
        			            <td>$98,540</td>
        			          </tr>
        			          <tr>
        			            <td>Finn Camacho</td>
        			            <td>Support Engineer</td>
        			            <td>San Francisco</td>
        			            <td>47</td>
        			            <td>2009/07/07</td>
        			            <td>$87,500</td>
        			          </tr>
        			          <tr>
        			            <td>Serge Baldwin</td>
        			            <td>Data Coordinator</td>
        			            <td>Singapore</td>
        			            <td>64</td>
        			            <td>2012/04/09</td>
        			            <td>$138,575</td>
        			          </tr>
        			          <tr>
        			            <td>Zenaida Frank</td>
        			            <td>Software Engineer</td>
        			            <td>New York</td>
        			            <td>63</td>
        			            <td>2010/01/04</td>
        			            <td>$125,250</td>
        			          </tr>
        			          <tr>
        			            <td>Zorita Serrano</td>
        			            <td>Software Engineer</td>
        			            <td>San Francisco</td>
        			            <td>56</td>
        			            <td>2012/06/01</td>
        			            <td>$115,000</td>
        			          </tr>
        			          <tr>
        			            <td>Jennifer Acosta</td>
        			            <td>Junior Javascript Developer</td>
        			            <td>Edinburgh</td>
        			            <td>43</td>
        			            <td>2013/02/01</td>
        			            <td>$75,650</td>
        			          </tr>
        			          <tr>
        			            <td>Cara Stevens</td>
        			            <td>Sales Assistant</td>
        			            <td>New York</td>
        			            <td>46</td>
        			            <td>2011/12/06</td>
        			            <td>$145,600</td>
        			          </tr>
        			          <tr>
        			            <td>Hermione Butler</td>
        			            <td>Regional Director</td>
        			            <td>London</td>
        			            <td>47</td>
        			            <td>2011/03/21</td>
        			            <td>$356,250</td>
        			          </tr>
        			          <tr>
        			            <td>Lael Greer</td>
        			            <td>Systems Administrator</td>
        			            <td>London</td>
        			            <td>21</td>
        			            <td>2009/02/27</td>
        			            <td>$103,500</td>
        			          </tr>
        			          <tr>
        			            <td>Jonas Alexander</td>
        			            <td>Developer</td>
        			            <td>San Francisco</td>
        			            <td>30</td>
        			            <td>2010/07/14</td>
        			            <td>$86,500</td>
        			          </tr>
        			          <tr>
        			            <td>Shad Decker</td>
        			            <td>Regional Director</td>
        			            <td>Edinburgh</td>
        			            <td>51</td>
        			            <td>2008/11/13</td>
        			            <td>$183,000</td>
        			          </tr>
        			          <tr>
        			            <td>Michael Bruce</td>
        			            <td>Javascript Developer</td>
        			            <td>Singapore</td>
        			            <td>29</td>
        			            <td>2011/06/27</td>
        			            <td>$183,000</td>
        			          </tr>
        			          <tr>
        			            <td>Donna Snider</td>
        			            <td>Customer Support</td>
        			            <td>New York</td>
        			            <td>27</td>
        			            <td>2011/01/25</td>
        			            <td>$112,000</td>
        			          </tr>
        			        </tbody>
        			      </table>
        			    </div>
        			  </div>
        			</div>
        			<!-- FIM TABELA -->

				

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