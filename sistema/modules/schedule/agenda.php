<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    
    <!-- Estilos Personalizados -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9fafc;
        }

        #calendar-container {
            max-width: 75%;
            margin: 0 auto;
            padding: 10px;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .fc-button:hover {
            background-color: #0056b3;
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
            background-color: #FFB703;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 0.8em;
            padding: 2px 4px;
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
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>
<body>
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
                allDayText: 'Dia Todo', // Alterar "ALL DAY" para "Todo o dia"
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
                events: 'fetch_events.php',
                dateClick: function(info) {
                    // Alternar para visualização diária ao clicar no dia
                    calendar.changeView('timeGridDay', info.dateStr);
                },
                select: function(info) {
                    // Adicionar evento ao selecionar horário
                    const titulo = prompt("Digite o título do evento:");
                    if (titulo) {
                        fetch('add_event.php', {
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
                    fetch('update_event.php', {
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
                        fetch('delete_event.php', {
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
                        fetch('delete_event.php', {
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
</body>
</html>
