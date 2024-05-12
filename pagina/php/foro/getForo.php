<?php

/* ------------------------ GET DATA FOROS ------------------------ */

/* 

If it recives an id of the foro, it returns that one. If not, then returns all the foros actives in the database.
$active_foro recives a boolean: 1 if you need all the foros (actives and non-actives), if you need just active foros don´t send this parameter.

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.
    - data: Array of objects, each index is one foro (id_foro, photo, name, description, date_creation, description).

*/


include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../error_stmt/errorFunctions.php");


$id_foro = !empty($_GET['id_foro']) ? $_GET['id_foro'] : null;
$active_foro = !empty($_GET['active_foro']) ? $_GET['active_foro'] : null;

$result = new stdClass();
$result->success = true;

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

# If recives an ID of a foro
if ($id_foro === null) {
    if ($active_foro === null) {
        $stmt = $conn->prepare("SELECT F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description as league_description
                                FROM foro F
                                INNER JOIN league L
                                ON F.id_league = L.id_league
                                WHERE F.active = 1
                                ORDER BY F.id_foro DESC");
    } else {
        $stmt = $conn->prepare("SELECT F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description as league_description, F.active, COUNT(C.id_comment) as count_comment
                                FROM foro F
                                INNER JOIN league L
                                    ON F.id_league = L.id_league
                                LEFT JOIN comment C
                                    ON F.id_foro = C.id_foro
                                GROUP BY F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description, F.active
                                ORDER BY F.id_foro DESC");
    }
    

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;
    
    $result->data = array(); // Inicializamos un array para almacenar las filas

    $resultSet = $stmt->get_result();

    while ($row = $resultSet->fetch_assoc()) {
        $result->data[] = $row; // Añadimos cada fila al array
    }

    empty($result->data) ? error_request($result, "There is no foros actives in database") : 0;

} else {
    $stmt = $conn->prepare("SELECT F.id_foro, F.photo, F.name, F.description, F.date_creation, L.description as league_description
                    FROM foro F
                    INNER JOIN league L
                    ON F.id_league = L.id_league
                    WHERE F.active = 1 AND F.id_foro = ?");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

    $stmt->bind_param("i", $id_foro);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;

    $result->data = array(); // Inicializamos un array para almacenar las filas

    $resultSet = $stmt->get_result();

    while ($row = $resultSet->fetch_assoc()) {
        $result->data[] = $row; // Añadimos cada fila al array
    }

    empty($result->data) ? error_request($result, "There is no foro with ID: '" . $id_foro . "' or it is not active.") : 0;
    
}

$result->is_admin = $_SESSION['admin'];

$resultSet->close();
$stmt->close();
$conn->close();

// $result->data ahora contiene todas las filas de resultados
echo json_encode($result);
?>