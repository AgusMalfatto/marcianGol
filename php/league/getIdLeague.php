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
    
    $result = new stdClass();
    $result->message = "";

    if (empty($league_name)) {
        $result->success = false;
        $result->message = "Name league can't be null";
    } else {
        
        try {
            $stmt = $conn->prepare("SELECT id_league FROM league WHERE description = ? LIMIT 1");
            
            if (!$stmt) {
                $result->success = false;
                $result->message .= " || Error preparing the query: " . $conn->error;
            }

            $stmt->bind_param("s", $league_name);

            if (!$stmt->execute()) {
                $result->message .= " || Error executing the query: " . $stmt->error;
            }

            $stmt->bind_result($id_league);
            
            if (!$stmt->fetch()) {
                $result->success = false;
                $result->message = " || No result for the league: " . $league_name;
            } else {
                $result->success = true;
                $result->id_league = $id_league;            
            }

        } catch (Exception $e) {
            $result->message = $e->error;
        }
        
    }

    
    return $result;
}

?>