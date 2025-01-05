<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.7/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.7/locales/pt-br.js"></script>
</head>
<body>
    <div id="calendar"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'pt-br',
                initialView: 'dayGridMonth',
                editable: true,
                selectable: true,
                events: 'fetch_events.php', // Rota para buscar eventos
                select: function(info) {
                    const titulo = prompt("Título do evento:");
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
