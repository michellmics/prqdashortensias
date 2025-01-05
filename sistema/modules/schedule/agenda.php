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
                initialView: 'timeGridWeek', // Visualização com horários
                selectable: true, // Permite selecionar
                editable: true, // Permite mover eventos
                events: 'fetch_events.php', // URL para buscar eventos do backend

                // Seleção de data e hora
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
                        }).then(() => calendar.refetchEvents()); // Atualiza os eventos
                    }
                },

                // Arrastar e soltar eventos
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
                    }).then(() => calendar.refetchEvents()); // Atualiza os eventos
                }
            });

            calendar.render();
        });
    </script>
</body>
</html>
