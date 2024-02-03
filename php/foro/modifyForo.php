<?php

/* ------------------------ INSERT A FORO IN DATABASE ------------------------ */
/* 

It needs:
    - The path of the photo.
    - The name of the foro.
    - The description of the foro.
    - The name of the league.

It returns an object with the next keys:
    - success: Boolean.
    - Message: In case there is a problem it contains the problem message.

*/


include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../league/getIdLeague.php");
include ("../logConnection/logError.php");
include ("validation.php");

// Leer el cuerpo de la solicitud
$putData = file_get_contents("php://input");

// Decodificar los datos JSON (asumiendo que los datos están en formato JSON)
$data = json_decode($putData, true);

$id_foro = !empty($data['id_foro']) ? $data['id_foro'] : null;
$photo = !empty($data['photo']) ? $data['photo'] : null;
$name = !empty($data['name']) ? $data['name'] : null;
$description = !empty($data['description']) ? $data['description'] : null;
$name_league = !empty($data['name_league']) ? $data['name_league'] : null;


$result = new stdClass();
$result->success = true;
$result->message = "";

# Evaluate empty values
if (empty($photo) || empty($name) || empty($description) || empty($name_league)) {
    $result->success = false;
    $result->message .= "All field must be complete";
    die (json_encode($result));
}

# Evaluate length of name
if (!is_name_valid($name)) {
    $result->success = false;
    $result->message .= "Name must be less than 50 characters";
    die (json_encode($result));
}

# Evaluate length of description
if (!is_description_valid($description)) {
    $result->success = false;
    $result->message .= "Description must be less than 150 characters";
    die (json_encode($result));
}

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

$result_league = get_league_id($conn, $name_league);   

if (!$result_league->success) {
    $result->message .= "Theres is no league named: " . $name_league;
    $result->success = false;
    die (json_encode($result));
}   

/* Query execution */
$stmt = $conn->prepare("UPDATE foro SET 
                        photo = ?,
                        name = ?,
                        description = ?,
                        id_league = ?
                        WHERE id_foro = ?");

if (!$stmt) {
    $result->message .= "Error preparing the query: " . $conn->error;
    $result->success = false;
    set_error_log($result->message);
    #$stmt->close();
    $conn->close();
    die (json_encode($result));
}

$stmt->bind_param("sssii", $photo, $name, $description, $result_league->id_league, $id_foro);

if (!$stmt->execute()) {
    $result->message .= " Error executing the query: " . $stmt->error;
    $result->success = false;
    set_error_log($result->message);
    $stmt->close();
    $conn->close();
    die (json_encode($result));
}   

$stmt->close();
$conn->close(); 

echo json_encode($result);


?>