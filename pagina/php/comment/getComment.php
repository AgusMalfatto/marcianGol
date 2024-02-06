<?php

/* ------------------------ GET COMMENTS OF ONE FORO ------------------------ */
/* 

It recives an id of the foro

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.
    - data: Array of objects, each index is one comment (id_comment, description, date_comment, likes, dislikes, name, last_name).

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include_once ("../error_stmt/errorFunctions.php");
include_once ("validation.php");

$id_foro = !empty($_GET['id_foro']) ? $_GET['id_foro'] : null;
$result = new stdClass();
$result->success = true;

$id_foro == null ? error_request($result, "All fields must be complete.") : 0;


$db_name = "marciangol";
mysqli_select_db($conn, $db_name);
!is_foro_active($conn, $id_foro) ? error_request($result, "The Foro is not active or it doesn't exists") : 0;

$stmt = $conn->prepare("SELECT C.id_comment, C.description, C.date_comment, C.likes, C.dislikes, U.name, U.last_name
                        FROM comment C 
                        INNER JOIN user U
                        ON C.id_user = U.id_user
                        WHERE C.active = 1 AND C.id_foro = ?");

!$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

$stmt->bind_param("i", $id_foro);

!$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;
    
$result->data = array(); // Inicializamos un array para almacenar las filas

$resultSet = $stmt->get_result();

while ($row = $resultSet->fetch_assoc()) {
    $result->data[] = $row; // Añadimos cada fila al array
}

empty($result->data) ? error_request($result, "There is no comments in this foro yet") : 0;

echo json_encode($result);

?>