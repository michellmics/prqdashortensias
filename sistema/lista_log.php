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

	$siteAdmin = new SITE_ADMIN();
	$siteAdmin->getLogInfo();

	if(count($siteAdmin->ARRAY_LOGINFO) > 0)
	{
	  // Configurações de Paginação
	  $registrosPorPagina = 100;
	  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	  $totalRegistros = count($siteAdmin->ARRAY_LOGINFO);
	  $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

	  // Determina o índice de início para a página atual
	  $inicio = ($paginaAtual - 1) * $registrosPorPagina;

	  // Divide o array para exibir apenas os registros da página atual
	  $dadosPagina = array_slice($siteAdmin->ARRAY_LOGINFO, $inicio, $registrosPorPagina);
	}
	else
	  	{
	    	$dadosPagina = "Não há log de sistema.";
		}


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
                  <?php include 'src/menu.php'; ?>
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
	<div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th></th> 
					            <th></th> 
                      <th>NOME</th>
                      <th>DOC</th>   
					            <th></th>                
                    </tr>
                    <tr>
					<? $lin = 0 ?>
                    <?php foreach ($dadosPagina as $log): ?>
                     
                        <td style="text-transform: uppercase; font-size: 15px;">
                        </td> <? $lin++; ?>
						<td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; color:#993399; ?>"> <? echo $lin; ?></td>
                        <td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; color:#993399; ?>"> <?= htmlspecialchars(strlen($log['LOG_DTLOG']) > 20 ? substr($log['LOG_DTLOG'], 0, 20) . '...' : $log['LOG_DTLOG']) ?></td>                        
                        <td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; color:#993399; ?>"><?= htmlspecialchars(strlen($log['LOG_DCUSUARIO']) > 25 ? substr($log['LOG_DCUSUARIO'], 0, 12) . '...' : $log['LOG_DCUSUARIO']) ?></td> 
                        <td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; color:#993399; ?>"><?= htmlspecialchars(strlen($log['LOG_DCMSG']) > 25 ? substr($log['LOG_DCMSG'], 0, 12) . '...' : $log['LOG_DCMSG']) ?></td> 
						      
                      
                    <?php endforeach; ?>   
                    </tr>
                  </table>
                  
                </div><!-- /.box-body -->

                <!-- Paginação -->
<nav aria-label="Page navigation" class="text-center">
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="<?= ($i == $paginaAtual) ? 'active' : '' ?>">
                        <a href="?pagina=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
                
</section><!-- /.content -->
<!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      function confirmDelete(listid){
        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Lista de Convidados',
          text: "Têm certeza que deseja excluir o convidado?",
          showDenyButton: true,
          confirmButtonText: 'SIM',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#993399",
          denyButtonColor: "#D8BFD8",
          width: '600px', // Largura do alerta
          icon: 'warning',
          position: 'top', // Define a posição na parte superior da tela
          customClass: {
            title: 'swal-title', // Classe para o título
            content: 'swal-content', // Classe para o conteúdo (texto)
            confirmButton: 'swal-confirm-btn',
            denyButton: 'swal-deny-btn',
            htmlContainer: 'swal-text',
            popup: 'swal-custom-popup', // Classe para customizar o popup
          }
        }).then((result) => {
          if (result.isConfirmed) {
            // Capturar os dados do formulário
            var formData = $("#form-empresa").serialize();
            // Fazer a requisição AJAX
            $.ajax({
              url: "lista_delete.php", // URL para processamento
              type: "POST",
              data: { id: listid }, // Dados enviados
              success: function (response) {
                Swal.fire({
              title: 'Salvo!',
              text: `${response}`,
              icon: 'success',
              width: '200px', // Largura do alerta
              confirmButtonColor: "#993399",
              position: 'top', // Define a posição na parte superior da tela
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
              text: 'Erro ao deletar o convidado.',
              icon: 'error',
              width: '200px', // Largura do alerta
              confirmButtonColor: "#993399",
              position: 'top', // Define a posição na parte superior da tela
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
    font-size: 22px !important; /* Tamanho maior para o título */
  }

  .swal-text {
    font-size: 16px !important; /* Tamanho maior para o conteúdo */
  }

  @media screen and (max-width: 768px) {
  .swal-custom-popup {
    top: 10% !important; /* Ajuste de posição vertical */
    transform: translateY(0) !important; /* Centraliza no topo */
  }
}

  /* Aumentar o tamanho dos textos dos botões */
  .swal-confirm-btn,
  .swal-deny-btn,
  .swal-cancel-btn {
    font-size: 14px !important; /* Tamanho maior para os textos dos botões */
    padding: 9px 9px !important; /* Aumenta o espaço ao redor do texto */
  }
</style>
<!-- ######################################################## --> 
<!-- SWEETALERT 2 -->   


<script>
    // Função de validação
    	function validarFormulario(event) {
        event.preventDefault(); // Impede o envio do formulário

        // Captura os valores dos campos
        const nome = document.querySelector('input[name="nome"]').value.trim();
        const documento = document.querySelector('input[name="documento"]').value.trim();

        // Validações
        if (!nome || !documento) {
            Swal.fire({
                icon: 'error',
                title: 'Campos Obrigatórios',
                text: 'Todos os campos devem ser preenchidos.',
            });
            return false;
        }

        // Se todas as validações passarem
        Swal.fire({
            icon: 'success',
            title: 'Validação Bem-Sucedida',
            text: 'Formulário enviado com sucesso!',
        }).then(() => {
            // Envia o formulário após o SweetAlert
            document.getElementById('form-empresa').submit();
        });

        return true;
    }

    // Adiciona o evento de validação ao formulário
    document.getElementById('form-empresa').addEventListener('submit', validarFormulario);
</script>

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

		
		
    </body>
</html>