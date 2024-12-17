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
        <title>asdsadsadsad</title>
		
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
    color: #ccc; /* Cinza clarinho para o texto */
    font-size: 12px; /* Fonte pequena */
    text-align: left; /* Centraliza o texto */
    padding: 0; /* Remove espaçamento interno */
    height: 30px; /* Altura do footer */
    line-height: 30px; /* Centraliza verticalmente o texto */
    position: fixed; /* Fixa o footer */
    bottom: 0; /* Colado no final da página */
    width: 100%; /* Largura total */
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
								<li><i class="fa fa-phone"></i>3123213213</li>
								<li><i class="fa fa-envelope"></i><a href="mailto:sada@sdf.com">23123213123</a></li>
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
									<a href="#slider"><img src="https://serconeo.com.br/new/img/logo_serconeo.png" alt="#"></a>
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
											<li><a href="#slider">Inicio</a></li>
											<li><a href="#empresa">Empresa </a></li>
											<li><a href="#servicos">Serviços </a></li>
											<li><a href="#contato">Contato </a></li>
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
                <h3 class="box-title">Cadastro de Visitante</h3>
            </div><!-- /.box-header -->
            <div class="box-body">

                <button type="button" name="voltar" class="btn btn-warning" onclick="window.history.back()">VOLTAR</button>
                <button type="button" id="salvar_empresa_1" name="salvar_empresa_1" class="btn btn-primary" onclick="openModal()">SALVAR CADASTRO</button>

                    <div class="form-group has-warning">
                        <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Nome Completo do Visitante</label>
                        <div class="form-row">
                            <!-- Nome Completo do Visitante ocupa 8 partes da largura e Documento ocupa 4 partes -->
                            <div class="col-8">
                            <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Nome Completo do Visitante</label>
                                <input id="nome" name="nome" style="text-transform: uppercase;" type="text" class="form-control" id="inputWarning" placeholder="NOME COMPLETO..." required/>
                            </div>
                            <div class="col-4">
                            <label class="control-label" for="inputWarning"><i class="fa fa-bell-o"></i> Documento</label>
                                <input id="documento" name="documento" style="text-transform: uppercase;" type="text" class="form-control" placeholder="RG OU CPF" maxlength="10" />
                            </div>
                        </div>
                    </div>


            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!--/.col (right) -->
</section><!-- /.content -->



<!-- Footer -->
<footer class="footerNew">
  Codemaze - Soluções de MKT e Software
</footer>

<!-- Scripts -->
<script src="js/jquery.min.js"></script>
<script src="js/jquery-migrate-3.0.0.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script src="js/easing.js"></script>
<script src="js/colors.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script src="js/jquery.nav.js"></script>
<script src="js/slicknav.min.js"></script>
<script src="js/jquery.scrollUp.min.js"></script>
<script src="js/niceselect.js"></script>
<script src="js/tilt.jquery.min.js"></script>
<script src="js/owl-carousel.js"></script>
<script src="js/jquery.counterup.min.js"></script>
<script src="js/steller.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/main.js"></script>

<script>
    // Função para abrir o modal com os campos de nome e documento
    function openModal() {
        Swal.fire({
            title: "Cadastro de Visitante",
            html: `
                <input id="nome" class="swal2-input" placeholder="Nome Completo" style="text-transform: uppercase;">
                <input id="documento" class="swal2-input" placeholder="Documento (RG ou CPF)" maxlength="10" style="text-transform: uppercase;">
            `,
            focusConfirm: false,
            preConfirm: () => {
                const nome = Swal.getPopup().querySelector('#nome').value;
                const documento = Swal.getPopup().querySelector('#documento').value;

                if (!nome || !documento) {
                    Swal.showValidationMessage('Por favor, preencha todos os campos');
                    return false;
                }

                // Aqui você pode adicionar a lógica para salvar os dados ou enviá-los para o backend
                console.log('Nome:', nome);
                console.log('Documento:', documento);

                return { nome, documento };  // Retorna os dados inseridos
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Cadastro Salvo',
                    text: `Nome: ${result.value.nome}, Documento: ${result.value.documento}`,
                    icon: 'success'
                });
            }
        });
    }
</script>

    </body>
</html>
