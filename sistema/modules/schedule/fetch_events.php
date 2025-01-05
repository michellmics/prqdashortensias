<?php
header('Content-Type: application/json');

$conn = new mysqli('localhost', 'hortensias_sitebd', '#0100069620061#', 'hortensias_condominio');

$sql = "SELECT id, titulo AS title, inicio AS start, fim AS end FROM eventos";
$result = $conn->query($sql);

$events = [];
while ($row = $result->fetch_assoc()) {
    $events[] = $row;
}

echo json_encode($events);
?>
