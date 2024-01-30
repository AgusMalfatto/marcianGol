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

    $result = new stdClass();
    $result->success = false;
    $result->id_team = -1;

    try {
        $stmt = $conn->prepare("SELECT id_team FROM team WHERE name = ?");
        
        if (!$stmt) {
            $result->message = "Error preparing the query: " . $conn->error;
            $result->success = false;
        }

        $stmt->bind_param("s", $team_name);

        if (!$stmt->execute()) {
            $result->message = "Error executing the query: " . $stmt->error;
            $result->success = false;
        }

        $stmt->bind_result($id_team);
        
        if (!$stmt->fetch()) {
            $result->success = false;
            $result->message = "No result for the name: " . $team_name;
            $id_team = -1;
        } else {
            $result->success = true;
            $result->id_team = $id_team;
        }

    } catch (Exception $e) {
        $result->message = $e->error;
    }

    return $result;
}

?>
