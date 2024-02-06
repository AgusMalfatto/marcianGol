<?php

/* ------------------------ FUNCTION TO GET ID OF THE TEAM ------------------------ */



function get_team_id($conn, $team_name){

    /* 
        It returns the ID of the name team passed as parameter.

        Parameters: 
            $conn : The connection to the database.
            $team_name : Name of the team.
        
        Return: 
            Returns an object with three keys:
                success: True or False if the result is okay or not.
                message: Message of the error in case there were a problem.
                id_team: ID of the team in case it was captured.
    */

    include_once ('../error_stmt/errorFunctions.php');

    $result = new stdClass();
    $result->success = false;
    $result->id_team = -1;

    $stmt = $conn->prepare("SELECT id_team FROM team WHERE name = ?");
    
    if (!$stmt) {
        error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
    }

    $stmt->bind_param("s", $team_name);

    if (!$stmt->execute()) {
        error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
    }

    $stmt->bind_result($id_team);
    
    if (!$stmt->fetch()) {
            error_request($result, "No result for the team: " . $team_name);
    } else {
        $result->success = true;
        $result->id_team = $id_team;
    }

    return $result;
}

?>
