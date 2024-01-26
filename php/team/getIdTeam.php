<?php

/* ------------------------ FUNCTION TO GET ID OF THE TEAM ------------------------ */

include('../creation/connection.php');

function get_team_id($team_name){

    /* 
        Parameter: The name of the team
        Return: The id of the team
    */

    $databaseName = "MarcianGol";
    mysqli_select_db($conn, $databaseName);

    try {
        $stmt = $conn->prepare("SELECT id_team FROM team WHERE name = ?");
        
        if (!$stmt) {
            throw new Exception("Error preparing the query: " . $conn->error);
        }

        $stmt->bind_param("s", $team_name);

        if (!$stmt->execute()) {
            throw new Exception("Error executing the query: " . $stmt->error);
        }

        $stmt->bind_result($id_team);
        
        if (!$stmt->fetch()) {
            throw new Exception("There is no result for the team: " . $team_name);
        }

    } catch (Exception $e) {
        return $e->getMessage();
    }

    // Close the statement and the connection
        if ($stmt) {
            $stmt->close();
        }
        $conn->close();
    }

    return $id_team;
?>
