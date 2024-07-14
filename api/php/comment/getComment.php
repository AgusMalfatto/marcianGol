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
$filter = !empty($_GET['filter_text']) ? $_GET['filter_text'] : null;
$order_by = !empty($_GET['order_by']) ? $_GET['order_by'] : null;
$result = new stdClass();
$result->success = true;

$id_foro == null ? error_request($result, "All fields must be complete.") : 0;


$db_name = "marciangol";
mysqli_select_db($conn, $db_name);
!is_foro_active($conn, $id_foro) ? error_request($result, "The Foro is not active or it doesn't exists") : 0;

if (($filter === null) && ($order_by === null)) {
    $stmt = $conn->prepare("SELECT C.id_user, C.id_comment, C.description, C.date_comment, U.name, U.last_name, 
                            SUM(
                                IF (L.id_user = ?, 1, 0)
                            ) as Reaction,
                            SUM(
                                CASE 
                                    WHEN L.is_like = 1 THEN 1
                                    WHEN L.is_like = 0 THEN -1
                                    ELSE 0
                                END
                            ) as Likes

                            FROM comment C 
                            INNER JOIN user U
                                ON C.id_user = U.id_user
                            LEFT JOIN likes L 
                                ON C.id_comment = L.id_comment
                            WHERE C.active = 1 AND C.id_foro = ?
                            GROUP BY C.id_user, C.id_comment, C.description, C.date_comment, U.name, U.last_name
                            ORDER BY C.id_comment DESC, Likes DESC;");

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

    $stmt->bind_param("ii", $_SESSION['id_user'], $id_foro);    
} else {
    $query = "SELECT C.id_user, C.id_comment, C.description, C.date_comment, U.name, U.last_name, 
                SUM(
                    IF (L.id_user = ?, 1, 0)
                ) as Reaction,
                SUM(
                    CASE 
                        WHEN L.is_like = 1 THEN 1
                        WHEN L.is_like = 0 THEN -1
                        ELSE 0
                    END
                ) as Likes

                FROM comment C 
                INNER JOIN user U
                    ON C.id_user = U.id_user
                LEFT JOIN likes L 
                    ON C.id_comment = L.id_comment
                WHERE C.active = 1 AND C.id_foro = ?";
    if ($filter !== null) {
        $query = $query . " AND (U.name LIKE CONCAT('%', ?, '%')
                            OR U.last_name LIKE CONCAT('%', ?, '%')
                            OR C.description LIKE CONCAT('%', ?, '%')
                            OR C.date_comment LIKE CONCAT('%', ?, '%'))";

    }

    $query = $query . " GROUP BY C.id_user, C.id_comment, C.description, C.date_comment, U.name, U.last_name";

    if ($order_by !== null) {
        $query = $query . " ORDER BY " . $order_by;        
    }
    
    $stmt = $conn->prepare($query);    
    
    $filter_sql = '%' . $filter . '%';

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;
    
    if ($filter !== null) {
        $stmt->bind_param("iissss", $_SESSION['id_user'], $id_foro, $filter_sql, $filter_sql, $filter_sql, $filter_sql);   
    } else {
        $stmt->bind_param("ii", $_SESSION['id_user'], $id_foro);  
    }
        
}


!$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;
    
$result->data = array(); // Inicializamos un array para almacenar las filas

$resultSet = $stmt->get_result();

while ($row = $resultSet->fetch_assoc()) {
    $result->data[] = $row; // Añadimos cada fila al array
}

$result->id_userSession = $_SESSION['id_user'];
$result->admin = $_SESSION['admin'];

empty($result->data) ? error_request($result, "There is no comments in this foro yet") : 0;

echo json_encode($result);

?>