<?php
	include_once '../objetos.php'; // Carrega a classe de conexão e objetos

	session_start(); 
	define('SESSION_TIMEOUT', 43200); // 30 minutos
	
	if (!isset($_SESSION['user_id'])) 
	{
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

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
        
        <!-- FullCalendar CSS -->
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
		
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
 <!-- Estilos Personalizados -->
 <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafc;
        }

        #calendar-container {
            max-width: 70%;
            margin: 0 auto;
            padding: 10px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        #calendar {
            max-width: 100%;
            height: 450px; /* Altura do calendário */
            margin: 0 auto;
        }

        .fc-toolbar-title {
            font-weight: 400;
            font-size: 1em; /* Tamanho reduzido do título */
            color: #333;
        }

        .fc-button {
            font-size: 0.9em;
            background-color: #8e44ad; /* Cor lilás mais escura */
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .fc-button:hover {
            background-color: #6c3483; /* Lilás mais escuro ao passar o mouse */
        }

        .fc-daygrid-day {
            font-size: 0.85em;
            color: #555;
        }

        .fc-daygrid-day:hover {
            background-color: #f1f4f8;
            cursor: pointer;
        }

        .fc-event {
            background-color:rgb(143, 79, 121);
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.8em;
            padding: 2px 4px;
            font-weight: normal;
        }

        .fc-day-today {
            background-color: #E3F2FD !important;
        }

        @media (max-width: 768px) {
            /* Ajustar título do calendário para telas menores */
            .fc-toolbar-title {
                font-size: 1em;
            }

            .fc-button {
                font-size: 0.8em;
                padding: 5px 10px;
            }

            /* Ajustar o calendário para melhor visualização em celulares */
            #calendar-container {
                padding: 10px;
            }

            .fc-daygrid-day {
                font-size: 0.75em; /* Reduzir tamanho da fonte em celulares */
            }

            .fc-event {
                font-size: 0.7em; /* Reduzir fonte de eventos em celulares */
            }

            #calendar {
                height: 350px; /* Diminuir a altura em dispositivos móveis */
            }
        }

        /* Para garantir que o calendário se ajuste bem ao tamanho da tela */
        @media (max-width: 480px) {
            .fc-toolbar-title {
                font-size: 1em; /* Título ainda menor em telas muito pequenas */
            }
        }

        .delete-btn {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .delete-btn:hover {
            background-color: #d32f2f;
        }

        .event-details {
            margin-top: 10px;
            font-size: 0.9em;
            color: #333;
        }
    </style>
    

<!-- pop-up promoção CSS -->
<style>
    #promoPopup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5); /* Fundo escuro semi-transparente */
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .popup-content {
        position: relative;
		background: transparent; /* Alterado para transparente */
        padding: 20px;
        border-radius: 10px;
        box-shadow: none;
        max-width: 90%;
        max-height: 90%;
        text-align: center;
    }

    .popup-content img {
        max-width: 100%;
        height: auto;
    }

    .close-btn {
		top: -20px; /* Move o botão para cima da imagem */
        right: -20px; /* Move o botão para a direita da imagem */
        position: absolute;
        background:rgb(0, 0, 0);
        color: white;
        border: none;
        font-size: 20px;
        padding: 5px 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    .close-btn:hover {
        background: #cc0000;
    }
</style>
<!-- pop-up promoção CSS -->
		
    </head>
    <body>
	
		<!-- Preloader -->
		<?php include 'src/preloader.php'; ?>
		<!-- End Preloader -->
     

		<!-- Header Area -->
		<?php include 'src/header.php'; ?>
		<!-- End Header Area -->



		<!--  Pop-up publicidade-->
        <div id="promoPopup" style="display: none;">
            <div class="popup-content">
                <button class="close-btn" onclick="closePopup()">×</button>
                <a <?php echo $publiImageLink; ?>>
                    <img src="<?php echo $publiImage; ?>" alt="Promoção" style="max-width: 100%; height: auto;">
                </a>
            </div>
        </div>
		<!--  Pop-up publicidade-->
		



		<section class="content">
    
    
        <div id="calendar-container">
        <div id="calendar"></div>
        <div class="event-details">
            <strong>Evento Selecionado:</strong> <span id="event-title">Nenhum evento selecionado</span>
        </div>
        <button class="delete-btn" id="delete-btn">Excluir Evento</button>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const deleteBtn = document.getElementById('delete-btn');
    const eventTitle = document.getElementById('event-title');
    let selectedEvent = null; // Armazenar o evento selecionado

    const calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'pt-br', // Definir idioma para português
        allDayText: 'Todo o dia', // Alterar "ALL DAY" para "Todo o dia"
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next',
            center: 'title',
            right: 'dayGridMonth,timeGridDay'
        },
        buttonText: {
            today: 'Hoje',
            month: 'Mês',
            week: 'Semana',
            day: 'Dia'
        },
        selectable: true,
        events: 'modules/schedule/fetch_events.php',
        dateClick: function(info) {
            // Alternar para visualização diária ao clicar no dia
            calendar.changeView('timeGridDay', info.dateStr);
        },
        select: function(info) {
            // Adicionar evento ao selecionar horário
            const titulo = prompt("Digite o título do evento:");
            if (titulo) {
                fetch('modules/schedule/add_event.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        titulo: titulo,
                        inicio: info.startStr,
                        fim: info.endStr
                    })
                }).then(() => calendar.refetchEvents());
            }
        },
        editable: true,
        eventDrop: function(info) {
            // Atualizar o evento após mover
            fetch('modules/schedule/update_event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: info.event.id,
                    inicio: info.event.startStr,
                    fim: info.event.endStr
                })
            }).then(() => calendar.refetchEvents());
        },
        eventResize: function(info) {
            // Atualizar o evento após redimensionamento
            fetch('modules/schedule/update_event.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: info.event.id,
                    inicio: info.event.startStr,
                    fim: info.event.endStr
                })
            }).then(() => calendar.refetchEvents());
        },
        eventClick: function(info) {
            selectedEvent = info.event;
            eventTitle.textContent = selectedEvent.title;
            deleteBtn.style.display = 'inline-block'; // Mostrar o botão de exclusão
        }
    });

    // Função para excluir o evento
    deleteBtn.addEventListener('click', function() {
        if (selectedEvent) {
            const confirmar = confirm(`Você quer excluir o evento "${selectedEvent.title}"?`);
            if (confirmar) {
                fetch('modules/schedule/delete_event.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: selectedEvent.id
                    })
                }).then(() => {
                    selectedEvent.remove(); // Remover o evento do calendário
                    calendar.refetchEvents(); // Atualizar o calendário
                    eventTitle.textContent = 'Nenhum evento selecionado'; // Resetar o título
                    deleteBtn.style.display = 'none'; // Esconder o botão de exclusão
                });
            }
        }
    });

    // Adicionando evento de teclado para pressionar "Delete" e excluir o evento
    document.addEventListener('keydown', function(event) {
        if (event.key === "Delete" && selectedEvent) {
            const confirmar = confirm(`Você quer excluir o evento "${selectedEvent.title}"?`);
            if (confirmar) {
                fetch('modules/schedule/delete_event.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        id: selectedEvent.id
                    })
                }).then(() => {
                    selectedEvent.remove(); // Remover o evento do calendário
                    calendar.refetchEvents(); // Atualizar o calendário
                    eventTitle.textContent = 'Nenhum evento selecionado'; // Resetar o título
                    deleteBtn.style.display = 'none'; // Esconder o botão de exclusão
                });
            }
        }
    });

    // Renderiza o calendário
    calendar.render();
});

    </script>


		</section>



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