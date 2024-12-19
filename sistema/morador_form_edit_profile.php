<?php
	include_once '../objetos.php'; // Carrega a classe de conexão e objetos
	
	session_start(); 
	define('SESSION_TIMEOUT', 43200); // 30 minutos
	
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

	$idmorador= $_GET['id'];
	$siteAdmin = new SITE_ADMIN();
	$siteAdmin->getMoradoreInfoById($userid); 
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
		<!-- ######################################################## --> 
    	<!-- SWEETALERT 2 --> 
    	<!-- SweetAlert2 CSS -->
    	<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.min.css" rel="stylesheet">
    	<!-- SweetAlert2 JS -->
    	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.5/dist/sweetalert2.all.min.js"></script>
    	<!-- ######################################################## --> 

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
		
	
        <section class="content">      
    <!-- right column -->
    <div class="col-md-6">
        <!-- general form elements disabled -->
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">Cadastro de Usuário</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
			<form id="form-empresa" role="form" method="POST" enctype="multipart/form-data">
  					<!-- CAMPOS COMO VARIAVEIS -->
					<input type="hidden" name="userid" value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_IDUSUARIO"]; ?>"/>
                  	<!-- CAMPOS COMO VARIAVEIS -->

                    <div class="form-group has-warning">
						<label class="control-label" for="inputWarning"> </label>
                        <div class="form-row">
                            <!-- Nome Completo do Visitante ocupa 8 partes da largura e Documento ocupa 4 partes -->
                            <div class="col-8">
								<label class="control-label" for="inputWarning">Nome Completo</label>
                                <input readonly id="nome" name="nome" value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_DCNOME"]; ?>" style="text-transform: uppercase;" type="text" class="form-control" id="inputWarning" placeholder="ENTER..." maxlength="28" oninput="this.value = this.value.replace(/[^A-Za-z ]/g, '')" required/>
                            </div>
                            <div class="col-2">
								<label class="control-label" for="inputWarning">Bloco</label>
                                <input readonly id="bloco" name="bloco"  value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_DCBLOCO"]; ?>" type="number" class="form-control" placeholder="" maxlength="1" required />
                            </div>
							<div class="col-2">
								<label class="control-label" for="inputWarning">Apart.</label>
                                <input readonly id="apartamento" name="apartamento" value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_DCAPARTAMENTO"]; ?>" type="number" class="form-control" placeholder="" maxlength="4" required />
                            </div>
                        </div>
						<div class="form-row">
							<div class="col-12">
								<label class="control-label" for="inputWarning">E-mail</label>
                                <input id="email" name="email" style="text-transform: uppercase;" value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_DCEMAIL"]; ?>" type="text" class="form-control" placeholder="ENTER..." maxlength="50" oninput="this.value = this.value.replace(/[^A-Za-z0-9._@-]/g, '')" required />
                            </div>
						</div>
						<div class="form-row">
							<?php
								$morador="";
								$portaria="";
								$sindico="";

								if($siteAdmin->ARRAY_MORADORINFO["USU_DCNIVEL"] == "MORADOR")
								{
									$morador = "checked";
								}
								if($siteAdmin->ARRAY_MORADORINFO["USU_DCNIVEL"] == "PORTARIA")
								{
									$portaria = "checked";
								}
								if($siteAdmin->ARRAY_MORADORINFO["USU_DCNIVEL"] == "SINDICO")
								{
									$sindico = "checked";
								}

							?>
							
							<div class="col-7">
								<label class="control-label" for="inputWarning">Nível</label>
								<div>
								    <label>
								        <input disabled  type="radio" name="nivel" value="MORADOR" <? echo $morador; ?> required>
								        MORADOR
								    </label>
								</div>
								<div>
								    <label>
								        <input disabled  type="radio" name="nivel" value="PORTARIA" <? echo $portaria; ?> required>
								        PORTARIA
								    </label>
								</div>
								<div>
								    <label>
								        <input disabled  type="radio" name="nivel" value="SINDICO" <? echo $sindico; ?> required>
								        SÍNDICO
								    </label>
								</div>
                            </div>
							<input type="hidden" name="nivel" value="<?php echo $siteAdmin->ARRAY_MORADORINFO["USU_DCNIVEL"]; ?>">
							<div class="col-5">
								<label class="control-label" for="inputWarning">Senha</label>
                                <input id="senha" name="senha" value="<? echo $siteAdmin->ARRAY_MORADORINFO["USU_DCSENHA"]; ?>" type="password" class="form-control" placeholder="" minlength="8" maxlength="10" required />
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
    	const bloco = document.querySelector('input[name="bloco"]').value.trim();
    	const apartamento = document.querySelector('input[name="apartamento"]').value.trim();
    	const email = document.querySelector('input[name="email"]').value.trim();
    	const senha = document.querySelector('input[name="senha"]').value.trim();
		const nivel = document.querySelector('input[name="nivel"]:checked'); 
        
		if (!nome || !bloco || !apartamento || !email || !senha || !nivel) {
            alert("Todos os campos devem ser preenchidos.");
            return false;
        }

		// Validação do e-mail
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'E-mail Inválido',
                text: 'Por favor, insira um endereço de e-mail válido.',
            });
            return false;
        }

        // Validação da senha
        const senhaRegex = /^(?=.*[A-Z])(?=.*[\W_])(?=.{8,})/;
        if (!senhaRegex.test(senha)) {
            Swal.fire({
                icon: 'error',
                title: 'Senha Inválida',
                text: 'A senha deve ter pelo menos 8 caracteres, incluir uma letra maiúscula e um caractere especial.',
            });
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
          title: 'Formulário de usuários',
          text: "Têm certeza que deseja cadastrar o usuário?",
          showDenyButton: true,
          confirmButtonText: 'SIM',
          denyButtonText: `CANCELAR`,
          confirmButtonColor: "#993399",
          denyButtonColor: "#D8BFD8",
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
              url: "morador_form_edit_proc.php", // URL para processamento
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
              confirmButtonColor: "#993399",
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
              text: 'Erro ao cadastrar o usuário.',
              icon: 'error',
              width: '600px', // Largura do alerta
              confirmButtonColor: "#993399",
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


<script>
		document.getElementById('apartamento').addEventListener('input', function (e) {
	    const maxLength = 4;
	    const value = e.target.value;

	    // Limita o comprimento a 4 caracteres
	    if (value.length > maxLength) {
	        e.target.value = value.slice(0, maxLength);
	    }
		});
	document.getElementById('bloco').addEventListener('input', function (e) {
	    const maxLength = 1;
	    const value = e.target.value;

	    // Limita o comprimento a 4 caracteres
	    if (value.length > maxLength) {
	        e.target.value = value.slice(0, maxLength);
	    }
		});
</script>
















<!-- Footer -->
<footer class="footerNew">
<a href="https://codemaze.com.br" target="_blank"><b>Codemaze</b></a> - Soluções de MKT e Software | <b><font color="red"><? echo $_SESSION['user_nivelacesso']; ?></font></b>
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