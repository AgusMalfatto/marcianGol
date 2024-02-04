<?php

/* ------------------------ GET DATA FOROS ------------------------ */

/* 

If it recives an id of the foro, it returns that one. If not, then returns all the foros actives in the database.

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.
    - data: Array of objects, each index is one foro.

*/


include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../error_stmt/errorFunctions.php");


$id_foro = !empty($_GET['id_foro']) ? $_GET['id_foro'] : null;

$result = new stdClass();
$result->success = true;
$result->message = "";

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

if ($id_foro === null) {
    $stmt = $conn->prepare("SELECT F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description
                    FROM foro F
                    INNER JOIN league L
                    ON F.id_league = L.id_league
                    WHERE F.active = 1");

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error) : 0;

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error) : 0;
    
    $result->data = array(); // Inicializamos un array para almacenar las filas

    $resultSet = $stmt->get_result();

    while ($row = $resultSet->fetch_assoc()) {
        $result->data[] = $row; // Añadimos cada fila al array
    }

    empty($result->data) ? error_stmt($result, "There is no foros actives in database") : 0;

} else {
    $stmt = $conn->prepare("SELECT F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description
                    FROM foro F
                    INNER JOIN league L
                    ON F.id_league = L.id_league
                    WHERE F.active = 1 AND F.id_foro = ?");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error) : 0;

    $stmt->bind_param("i", $id_foro);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error) : 0;

    $result->data = array(); // Inicializamos un array para almacenar las filas

    $resultSet = $stmt->get_result();

    while ($row = $resultSet->fetch_assoc()) {
        $result->data[] = $row; // Añadimos cada fila al array
    }

    empty($result->data) ? error_stmt($result, "There is no foro with ID: '" . $id_foro . "' or it is not active.") : 0;
    
}


$resultSet->close();
$stmt->close();
$conn->close();

// $result->data ahora contiene todas las filas de resultados
echo json_encode($result);
?>