<?php

/* ------------------------ FUNCTION TO GET ID OF THE LEAGUE ------------------------ */

function get_league_id($conn, $league_name) {
    /* 
        It returns the ID of the name league passed as parameter.

        Parameters: 
            $conn : The connection to the database.
            $league_name : Name of the league.
        
        Return: 
            Returns an object with three keys:
                success: True or False if the result is okay or not.
                message: Message of the error in case there were a problem.
                id_league: ID of the league in case it was captured.
    */
    include_once ("../error_stmt/errorFunctions.php");
    

    $result = new stdClass();

    if (empty($league_name)) {
        error_request($result, "Name league can't be null");
    }
        
    try {
        $stmt = $conn->prepare("SELECT id_league FROM league WHERE description = ? LIMIT 1");
        
        if (!$stmt) {
            error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
        }

        $stmt->bind_param("s", $league_name);

        if (!$stmt->execute()) {
            error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
        }

        $stmt->bind_result($id_league);
        
        if (!$stmt->fetch()) {
            error_request($result, "No result for the league: " . $league_name);
        } else {
            $result->success = true;
            $result->id_league = $id_league;            
        }

    } catch (Exception $e) {
        $result->message = $e->error;
    }
        
    

    
    return $result;
}

?>