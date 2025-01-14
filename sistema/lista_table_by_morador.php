<?php
	//ini_set('display_errors', 1);
	//ini_set('display_startup_errors', 1);
	//error_reporting(E_ALL);

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

    if ($_SESSION['user_nivelacesso'] != "SINDICO" && $_SESSION['user_nivelacesso'] != "PORTARIA") 
    {
      header("Location: noAuth.php");
      exit();
    }
  

  	$blocoSession = $_SESSION['user_bloco'];
  	$apartamentoSession = $_SESSION['user_apartamento'];
  	$nomeSession =  ucwords($_SESSION['user_name']);
  	$usuariologado = $nomeSession." <b>BL</b> ".$blocoSession." <b>AP</b> ".$apartamentoSession;
  	$userid = $_GET['id'];


	$siteAdmin = new SITE_ADMIN();
	$siteAdmin->getListaActiveInfo($userid);

	if(count($siteAdmin->ARRAY_LISTAINFO) > 0)
	{
	  // Configurações de Paginação
	  $registrosPorPagina = 100;
	  $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	  $totalRegistros = count($siteAdmin->ARRAY_LISTAINFO);
	  $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

	  // Determina o índice de início para a página atual
	  $inicio = ($paginaAtual - 1) * $registrosPorPagina;

	  // Divide o array para exibir apenas os registros da página atual
	  $dadosPagina = array_slice($siteAdmin->ARRAY_LISTAINFO, $inicio, $registrosPorPagina);
	}
	else
	  	{
	    	$dadosPagina = "Não há visitantes cadastrados para este morador.";
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
		
	
    <section class="content">
	<div class="box-body table-responsive no-padding">
                  <table class="table table-hover">
                    <tr>
                      <th></th> 
					            <th></th> 
                      <th>NOME</th>
                      <th>DOC</th>  
                    </tr>

					          <? $lin = 0 ?>
                    
                <?php foreach ($dadosPagina as $usuario): ?>

                  <?php
                    // Obter a data atual menos 12 horas
                    $dataLimite = date('Y-m-d H:i:s', strtotime('-12 hours'));
                    
                    if (strtotime($usuario['LIS_DTULTIMA_ENTRADA']) > strtotime($dataLimite)) 
                    {
                      $rowColor = "background-color:rgb(86, 209, 115);"; // Verde claro
                      $lineColor = "color:rgb(255, 255, 255);";
                      $b_remover = "";
                      $b_adicionar = "display: none;";
                    } else 
                        {
                          $rowColor = "background-color: #ffffff;"; // Branco
                          $lineColor = "color:#993399;";
                          $b_remover = "display: none;";
                          $b_adicionar = "";
                        }
                    ?>

                  <tr style="<?= $rowColor; ?>">                      
                        <td style="text-transform: uppercase; font-size: 15px;">
                        </td> <? $lin++; ?>
						<td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; <? echo $lineColor; ?>"> <? echo $lin; ?></td>
                        <td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; <? echo $lineColor; ?>"> <?= htmlspecialchars(strlen($usuario['LIS_DCNOME']) > 20 ? substr($usuario['LIS_DCNOME'], 0, 20) . '...' : $usuario['LIS_DCNOME']) ?></td>                        
                        <td style="text-transform: uppercase; font-size: 10px; vertical-align: middle; <? echo $lineColor; ?>"><?= htmlspecialchars(strlen($usuario['LIS_DCDOCUMENTO']) > 25 ? substr($usuario['LIS_DCDOCUMENTO'], 0, 12) . '...' : $usuario['LIS_DCDOCUMENTO']) ?></td> 
                      
                        <td>
                        <!-- Ícone com ação -->
                        <button class="btn btn-sm btn-info"  style="background-color:rgb(60, 99, 136); color: white; <? echo $b_adicionar; ?>" onclick="setDataVisita('<?= htmlspecialchars($usuario['LIS_IDLISTACONVIDADOS']) ?>', '<?= htmlspecialchars($apartamentoSession) ?>')">
                            <i class="fa fa-check-circle"></i>
                        </button>
                        <button class="btn btn-sm btn-info"  style="background-color:rgb(12, 97, 50); color: white; <? echo $b_remover; ?>" onclick="setDataVisitaRem('<?= htmlspecialchars($usuario['LIS_IDLISTACONVIDADOS']) ?>', '<?= htmlspecialchars($apartamentoSession) ?>')">
                        <i class="fa fa-close"></i>
                        </button>
                        
                    </td>
                      
                      
                      </tr>
                    <?php endforeach; ?>   
                    </tr>
                  </table>
                </div><!-- /.box-body -->
</section><!-- /.content -->

<!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      function setDataVisita(idVisita, apartamentoSession){
        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Lista de Convidados',
          text: "Têm certeza que deseja marcar a entrada do convidado?",
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
              url: "convidado_set_data.php", // URL para processamento
              type: "POST",
              data: { id: idVisita, ap: apartamentoSession}, // Dados enviados
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
              text: 'Erro ao atualizar a data de entrada do convidado.',
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

<!-- ######################################################## --> 
    <!-- SWEETALERT 2 -->   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
      function setDataVisitaRem(idVisita){
        event.preventDefault(); // Impede o envio padrão do formulário
        Swal.fire({
          title: 'Lista de Convidados',
          text: "Têm certeza que deseja remover a entrada do convidado?",
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
              url: "convidado_set_data_rem.php", // URL para processamento
              type: "POST",
              data: { id: idVisita}, // Dados enviados
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
              text: 'Erro ao atualizar a data de entrada do visitante.',
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