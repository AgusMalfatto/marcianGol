<?php

include ('../session/validateSession.php');
include ('../database/connection.php');
include ('../logConnection/logError.php');


// Leer el cuerpo de la solicitud
$putData = file_get_contents("php://input");

// Decodificar los datos JSON (asumiendo que los datos están en formato JSON)
$data = json_decode($putData, true);

// Obtener los valores necesarios
$name = isset($data['name']) && !empty($data['name']) ? $data['name'] : null;
$last_name = isset($data['last_name']) && !empty($data['last_name']) ? $data['last_name'] : null;
$team_name = isset($data['team_name']) && !empty($data['team_name']) ? $data['team_name'] : null;

$result = new stdClass();
$result->message = "";
$result->success = true;

if(($name === null) || ($last_name === null) || ($team_name === null)) {
    $result->message .= " All fields must be completed.";
    $result->success = false;
}

if ($result->success) {
    $databaseName = "marcianGol";
    mysqli_select_db($conn, $databaseName);

    if ($result->success) {
        
            # Get the id team of the user
            include ("../team/getIdTeam.php");
            $id_team = get_team_id($conn, $team_name);

            if ($id_team->success) {

                # Insert instruction
                $insertUserQuery = "UPDATE /* user SET name = ? */, last_name = ?, id_team = ? WHERE id_user = ?";
                $stmt = $conn->prepare($insertUserQuery);
                
                if (!$stmt) {
                    $result->message .= " Error preparing the query: " . $conn->error;
                    $result->success = false;
                    set_error_log($result->message);
                }

                $stmt->bind_param("ssii", $name, $last_name, $id_team->id_team, $_SESSION['id_user']);

                if (!$stmt->execute()) {
                    $result->message .= " Error executing the query: " . $stmt->error;
                    $result->success = false;
                    set_error_log($result->message);
                } 
                
                $stmt->close();
                $conn->close(); 
            } else {
                $result->message .= "The team '" . $team_name ."' doesn't exists";
                $result->success = false;
            }
    }
}    

echo json_encode($result);

?>