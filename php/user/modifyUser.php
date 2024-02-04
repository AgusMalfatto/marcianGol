<?php

/* ------------------------ MODIFY USER FILE ------------------------ */
/* 

It needs:
    - The new name of the user.
    - The new last name.
    - The new team name.
    
It returns an object with the next keys:
    - success: Boolean.
    - Message: In case there is a problem it contains the problem message.

*/

include ('../session/validateSession.php');
include ('../database/connection.php');
include_once ('../error_stmt/errorFunctions.php');
include_once ("../team/getIdTeam.php");

// Reading the body of the request.
$putData = file_get_contents("php://input");

// Decode the JSON data
$data = json_decode($putData, true);

$name = isset($data['name']) && !empty($data['name']) ? $data['name'] : null;
$last_name = isset($data['last_name']) && !empty($data['last_name']) ? $data['last_name'] : null;
$team_name = isset($data['team_name']) && !empty($data['team_name']) ? $data['team_name'] : null;

$result = new stdClass();
$result->success = true;

if(($name === null) || ($last_name === null) || ($team_name === null)) {
    error_request($result, "All field must be complete");
}

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);
    
# Get the id team of the user
$id_team = get_team_id($conn, $team_name);

if (!$id_team->success) {
    error_request($result, "The team '" . $team_name ."' doesn't exists");
}

# Insert instruction
$insertUserQuery = "UPDATE user SET name = ?, last_name = ?, id_team = ? WHERE id_user = ?";
$stmt = $conn->prepare($insertUserQuery);

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("ssii", $name, $last_name, $id_team->id_team, $_SESSION['id_user']);

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
} 

$stmt->close();
$conn->close(); 

echo json_encode($result);

?>