<?php

/* ------------------------ GET DATA USERS ------------------------ */

/* 

It need the User Id as 'id_user.

Returns an object with the next keys:
    - success: Boolean.
    - message: If there were an error then it saves here.
    - id_user: User ID.
    - name: Name of the user.
    - last_name: Last name of the user.
    - email: Email of the user.
    - photo: Path of the photo.

*/


include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../error_stmt/errorFunctions.php");

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    $active_user = !empty($_GET['active_user']) ? $_GET['active_user'] : null;

    $result = new stdClass();
    $result->success = true;

    $databaseName = "marcianGol";
    mysqli_select_db($conn, $databaseName);

    if ($active_user === null) {
        $stmt = $conn->prepare("SELECT U.id_user, U.name, U.last_name, U.email, U.admin, T.photo
                                FROM user U
                                INNER JOIN team T
                                ON T.id_team = U.id_team
                                WHERE U.id_user = ?");

        if (!$stmt) {
            error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
        } 
        
        $stmt->bind_param("i", $_SESSION['id_user']);

        if (!$stmt->execute()) {
            error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
        } 
        
        $stmt->bind_result($result->id_user, $result->name, $result->last_name, $result->email, $result->admin, $result->photo);

        if (!$stmt->fetch()) {
            error_request($result, "No result for the Id User: " . $_SESSION['id_user']);
        } else {
            $result->success = true;
        }

        
    } else {
        $stmt = $conn->prepare("SELECT U.id_user, U.name as user_name, U.last_name, U.email, U.admin, T.name, U.active
                                FROM user U
                                INNER JOIN team T
                                ON T.id_team = U.id_team");


        !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

        !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;
        
        $result->data = array(); // Inicializamos un array para almacenar las filas
        
        $resultSet = $stmt->get_result();
        
        while ($row = $resultSet->fetch_assoc()) {
            $result->data[] = $row; // Añadimos cada fila al array
        }
        
        empty($result->data) ? error_request($result, "There is no users in database") : 0;
    }
    
    echo json_encode($result);        

}


?>