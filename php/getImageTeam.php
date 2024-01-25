<?php
include('connection.php');
$databaseName = "MarcianGol";
mysqli_select_db($conn, $databaseName);

$team_name = $_POST['teamName'];
$response = new stdClass();
$response->success = false;

try {
    $stmt = $conn->prepare("SELECT photo FROM team WHERE name = ?");
    
    if (!$stmt) {
        throw new Exception("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("s", $team_name);

    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }

    $stmt->bind_result($photoPath);
    
    if (!$stmt->fetch()) {
        throw new Exception("No se encontraron resultados para el equipo: " . $team_name);
    }

    $response->success = true;
    $response->imagePath = $photoPath;

} catch (Exception $e) {
    $response->error = $e->getMessage();
}

// Devolver la ruta de la imagen como JSON
echo json_encode($response);

// Cerrar el statement y la conexión
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>
