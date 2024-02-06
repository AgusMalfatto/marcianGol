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
include_once ("../league/getIdLeague.php");
include_once ("../error_stmt/errorFunctions.php");
include ("validation.php");

$photo = !empty($_POST['photo']) ? $_POST['photo'] : null;
$name = !empty($_POST['name']) ? $_POST['name'] : null;
$description = !empty($_POST['description']) ? $_POST['description'] : null;
$name_league = !empty($_POST['name_league']) ? $_POST['name_league'] : null;

$result = new stdClass();
$result->success = true;

# Evaluate empty values
if (empty($photo) || empty($name) || empty($description) || empty($name_league)) {
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

$date_creation = date('Y-m-d');


/* Query execution */
$stmt = $conn->prepare("INSERT INTO foro (photo, name, description, date_creation, id_league, id_user) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("ssssii", $photo, $name, $description, $date_creation, $result_league->id_league, $_SESSION['id_user']);

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
}   

$stmt->close();
$conn->close(); 

echo json_encode($result);
?>