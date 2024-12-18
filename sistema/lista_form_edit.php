<?php
	include_once '../objetos.php'; // Carrega a classe de conexão e objetos
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

	session_start(); 
	define('SESSION_TIMEOUT', 1800); // 30 minutos

	if (!isset($_SESSION['user_id'])) 
	{
	  header("Location: index.php");
	  exit();
	}

	$blocoSession = $_SESSION['user_bloco'];
	$apartamentoSession = $_SESSION['user_apartamento'];
	$nomeSession =  ucwords($_SESSION['user_name']);
	$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
	$userid = $_SESSION['user_id'];

	$idvisitante = $_GET['id'];
	$siteAdmin = new SITE_ADMIN();
	$siteAdmin->getListaInfoByid($idvisitante); 

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
											<li><a href="morador_form.php">Cadastro de Usuário </a></li>
											<li><a href="lista_table.php">Salão de Festas </a></li>
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
		
	
        <section class="content">      
    <!-- right column -->
    <div class="col-md-6">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Cadastro de Convidados</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form id="form-empresa" role="form" method="POST">

					<!-- CAMPOS COMO VARIAVEIS -->
                  	<input type="hidden" name="userid" value="<? echo $userid; ?>"/>
					<input type="hidden" name="visitanteid" value="<? echo $siteAdmin->ARRAY_LISTAINFO["LIS_IDLISTACONVIDADOS"]; ?>"/> 
                  	<!-- CAMPOS COMO VARIAVEIS -->

                    <div class="form-group has-warning">
						<label class="control-label" for="inputWarning"> </label>
                        <div class="form-row">
                            <!-- Nome Completo do Visitante ocupa 8 partes da largura e Documento ocupa 4 partes -->
                            <div class="col-8">
								<label class="control-label" for="inputWarning">Nome Completo</label>
                                <input id="nome" name="nome" value="<? echo $siteAdmin->ARRAY_LISTAINFO["LIS_DCNOME"]; ?>" style="text-transform: uppercase;" type="text" class="form-control" id="inputWarning" placeholder="NOME COMPLETO..." maxlength="28" readonly required/>
                            </div>
                            <div class="col-4">
								<label class="control-label" for="inputWarning">Documento</label>
                                <input id="documento" name="documento" value="<? echo $siteAdmin->ARRAY_LISTAINFO["LIS_DCDOCUMENTO"]; ?>" style="text-transform: uppercase;" type="text" class="form-control" placeholder="RG OU CPF" maxlength="12" oninput="this.value = this.value.replace(/[^A-Za-z0-9-]/g, '')" required />
                            </div>
                        </div>
						<div class="form-row" style="margin-bottom: 10px;  margin: 10px;">
  						<?php
							$statusAtivo="";
							$statusInativo="";

							if($siteAdmin->ARRAY_LISTAINFO["LIS_STSTATUS"] == "ATIVO")
							{
								$statusAtivo = "checked";
							}
							if($siteAdmin->ARRAY_LISTAINFO["LIS_STSTATUS"] == "INATIVO")
							{
								$statusInativo = "checked";
							}
						?>
						<div class="col-7">
								<label class="control-label" for="inputWarning">Status do Convidado</label>
								<div>
								    <label>
								        <input type="radio" name="status" value="ATIVO" required <? echo $statusAtivo; ?>>
								        ATIVO
								    </label>
								</div>
								<div>
								    <label>
								        <input type="radio" name="status" value="INATIVO" required <? echo $statusInativo; ?>>
								        INATIVO
								    </label>
								</div>
                            </div>
							</div>
                    </div>

                    <button type="button" name="voltar" class="btn btn-warning" onclick="window.history.back()">VOLTAR</button>
                    <button type="button" id="salvar_empresa_1" name="salvar_empresa_1" class="btn btn-primary">SALVAR CADASTRO</button>

                </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (right) -->
</section><!-- /.content -->




<!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>

                function validarFormulario() {
                    const nome = document.querySelector('input[name="nome"]').value.trim();
                    const documento = document.querySelector('input[name="documento"]').value.trim();
					const status = document.querySelector('input[name="status"]:checked'); 

                    if (!nome || !documento || !status) {
                        alert("Todos os campos devem ser preenchidos.");
                        return false;
                    }
                    return true;
                }


      function confirmAndSubmit(event) {
          // Chama a validação do formulário
        const isValid = validarFormulario();

        // Se a validação falhar, interrompe a execução
        if (!isValid) {
            return;
        }

        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Formulário de convidados',
          text: "Têm certeza que deseja atualizar o convidado?",
          showDenyButton: true,
          confirmButtonText: 'SIM',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#599dce",
          denyButtonColor: "#de2f37",
          width: '600px', // Largura do alerta
          icon: 'warning',
          customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text'
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Capturar os dados do formulário
            var formData = new FormData($("#form-empresa")[0]); // Usa o FormData para enviar arquivos
            // Fazer a requisição AJAX
            $.ajax({
              url: "lista_form_edit_proc.php", // URL para processamento
              type: "POST",
              data: formData,
              processData: false, // Impede o jQuery de processar os dados
              contentType: false, // Impede o jQuery de definir o tipo de conteúdo
              success: function (response) {
                Swal.fire({
              title: 'Salvo!',
              text: `${response}`,
              icon: 'success',
              width: '600px', // Largura do alerta
              confirmButtonColor: "#599dce",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            }).then(() => {
                  // Redirecionar ou atualizar a página, se necessário
                  location.reload();
                });
              },
              error: function (xhr, status, error) {
                Swal.fire({
              title: 'Erro!',
              text: 'Erro ao atualizar o convidado.',
              icon: 'error',
              width: '600px', // Largura do alerta
              confirmButtonColor: "#4289a6",
              customClass: {
                title: 'swal-title', // Aplicando a mesma classe do título
                content: 'swal-content', // Aplicando a mesma classe do texto
                htmlContainer: 'swal-text',
                confirmButton: 'swal-confirm-btn'
              }
            });
              },
            });
          } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire('Cancelado', 'Nenhuma alteração foi salva.', 'info');
          }
        });
      }
      // Associar a função ao botão de submit
      $(document).ready(function () {
        $("#salvar_empresa_1").on("click", confirmAndSubmit);
      });
</script> 
<style>
  /* Estilos para aumentar o tamanho da fonte */
  .swal-title {
    font-size: 36px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 24px !important; /* Tamanho maior para o conteúdo */
  }

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 20px !important; /* Tamanho maior para os textos dos botões */
    padding: 12px 12px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   



















<!-- Footer -->
<footer class="footerNew">
  <a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de MKT e Software
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

		
		
    </body>
</html>