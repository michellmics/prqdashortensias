<?php
// delete_event.php
$data = json_decode(file_get_contents("php://input"));

if (isset($data->id)) {
    $eventId = $data->id;
    
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'hortensias_sitebd', '#0100069620061#', 'hortensias_condominio');
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Deletar o evento
    $sql = "DELETE FROM eventos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $eventId);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
    $conn->close();
}
?>
