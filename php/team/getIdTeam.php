<?php

/* ------------------------ FUNCTION TO GET ID OF THE TEAM ------------------------ */



function get_team_id($team_name){

    /* 
        Parameter: The name of the team
        Return: An object with the id team and the status of the result
    */
    include('../database/connection.php');

    $databaseName = "MarcianGol";
    mysqli_select_db($conn, $databaseName);

    
    # Variable to return
    $result = new stdClass();
    $result->success = false;
    $result->id_team = -1;

    try {
        $stmt = $conn->prepare("SELECT id_team FROM team WHERE name = ?");
        
        if (!$stmt) {
            throw new Exception("Error preparing the query: " . $conn->error);
            $result->success = false;
        }

        $stmt->bind_param("s", $team_name);

        if (!$stmt->execute()) {
            throw new Exception("Error executing the query: " . $stmt->error);
        }

        $stmt->bind_result($id_team);
        
        if (!$stmt->fetch()) {
            $id_team = -1;
        } else {
            $result->success = true;
            $result->id_team = $id_team;
        }

    } catch (Exception $e) {
        $result->message = $e->error;
    }

    // Close the statement and the connection
    if ($stmt) {
        $stmt->close();
    }
    $conn->close();
    return $result;
}

?>
