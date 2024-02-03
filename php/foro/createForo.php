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

$photo = !empty($_POST['photo']) ? $_POST['photo'] : null;
$name = !empty($_POST['name']) ? $_POST['name'] : null;
$description = !empty($_POST['description']) ? $_POST['description'] : null;
$name_league = !empty($_POST['name_league']) ? $_POST['name_league'] : null;

$result = new stdClass();
$result->success = true;
$result->message = "";

if (empty($photo) || empty($name) || empty($description) || empty($name_league)) {
    $result->success = false;
    $result->message .= "All field must be complete";
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

$date_creation = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO foro (photo, name, description, date_creation, id_league, id_user) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    $result->message .= "Error preparing the query: " . $conn->error;
    $result->success = false;
    set_error_log($result->message);
    #$stmt->close();
    $conn->close();
    die (json_encode($result));
}

$stmt->bind_param("ssssii", $photo, $name, $description, $date_creation, $result_league->id_league, $_SESSION['id_user']);

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