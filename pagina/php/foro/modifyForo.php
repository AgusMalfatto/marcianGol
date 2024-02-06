<?php

/* ------------------------ UPDATE A FORO IN DATABASE ------------------------ */
/* 

It needs:
    - The id of the foro.
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
include_once ("../league/getIdLeague.php");
include_once ("../error_stmt/errorFunctions.php");
include ("validation.php");

// Reading the body of the request.
$putData = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($putData, true);

$id_foro = !empty($data['id_foro']) ? $data['id_foro'] : null;
$photo = !empty($data['photo']) ? $data['photo'] : null;
$name = !empty($data['name']) ? $data['name'] : null;
$description = !empty($data['description']) ? $data['description'] : null;
$name_league = !empty($data['name_league']) ? $data['name_league'] : null;


$result = new stdClass();
$result->success = true;

# Evaluate empty values
if (empty($id_foro) || empty($photo) || empty($name) || empty($description) || empty($name_league)) {
    error_request($result, "All field must be complete");
}

# Evaluate length of name
if (!is_name_valid($name)) {
    error_request($result, "Name must be less than 50 characters");
}

# Evaluate length of description
if (!is_description_valid($description)) {
    error_request($result, "Description must be less than 150 characters");
}

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

$result_league = get_league_id($conn, $name_league);   

if (!$result_league->success) {
    error_request($result, "Theres is no league named: " . $name_league);
}   

/* Query execution */
$stmt = $conn->prepare("UPDATE foro SET 
                        photo = ?,
                        name = ?,
                        description = ?,
                        id_league = ?
                        WHERE id_foro = ?");

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("sssii", $photo, $name, $description, $result_league->id_league, $id_foro);

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
}   

$stmt->close();
$conn->close(); 

echo json_encode($result);


?>