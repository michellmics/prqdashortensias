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
            max-width: 100%;
            padding: 20px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #calendar {
            max-width: 100%;
        }

        .fc-toolbar-title {
            font-weight: 400;
            font-size: 1.2em; /* Menor tamanho para o título */
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
            background-color:rgb(123, 72, 128);
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
                font-size: 1.1em;
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
        }

        /* Para garantir que o calendário se ajuste bem ao tamanho da tela */
        @media (max-width: 480px) {
            .fc-toolbar-title {
                font-size: 1em; /* Título ainda menor em telas muito pequenas */
            }
        }
    </style>
    
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>
<body>
    <div id="calendar-container">
        <div id="calendar"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br', // Definir idioma para português
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
                    const event = info.event;
                    const confirmar = confirm(`Você quer editar o evento "${event.title}"?`);
                    if (confirmar) {
                        const titulo = prompt("Digite o novo título do evento:", event.title);
                        if (titulo) {
                            event.setProp('title', titulo);
                            fetch('update_event.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    id: event.id,
                                    titulo: titulo,
                                    inicio: event.startStr,
                                    fim: event.endStr
                                })
                            }).then(() => calendar.refetchEvents());
                        }
                    }
                }
            });

            // Renderiza o calendário
            calendar.render();
        });
    </script>
</body>
</html>
