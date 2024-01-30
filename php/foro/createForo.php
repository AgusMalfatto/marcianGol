<?php

include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../league/getIdLeague.php");

$photo = !empty($_POST['photo']) ? $_POST['photo'] : null;
$name = !empty($_POST['name']) ? $_POST['name'] : null;
$description = !empty($_POST['description']) ? $_POST['description'] : null;
$name_league = !empty($_POST['name_league']) ? $_POST['name_league'] : null;
$id_user = !empty($_POST['id_user']) ? $_POST['id_user'] : null;

$result = new stdClass();
$result->success = true;
$result->message = "";

if (empty($photo) || empty($name) || empty($description) || empty($name_league) || empty($id_user)) {
    $result->success = false;
    $result->message .= "All field must be complete";
}

if ($result->success) {
    $db_name = "marciangol";
    mysqli_select_db($conn, $db_name);
    
    $result = get_league_id($conn, $name_league);
    
    
}

echo json_encode($result);


?>