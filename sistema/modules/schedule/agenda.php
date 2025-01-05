<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>
</head>
<body>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br', // Idioma em português
                initialView: 'dayGridMonth', // Exibe o calendário mensal por padrão
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridDay'
                },
                selectable: true, // Permite selecionar horários na visualização diária
                events: 'fetch_events.php', // Rota para buscar eventos do backend
                
                // Quando o usuário clica em um dia no calendário mensal
                dateClick: function(info) {
                    calendar.changeView('timeGridDay', info.dateStr); // Muda para a visualização diária
                },

                // Permite selecionar horários na visualização diária 
                select: function(info) {
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

                // Configurações adicionais
                editable: true, // Permite arrastar e editar eventos
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
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
