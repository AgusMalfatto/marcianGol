<?php

/* ------------------------ GET IMAGE OF THE TEAM ------------------------ */
/* 

It recives the name of the team.

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.
    - imagePath: Path of the image.

*/

include ("../session/validateSession.php");
include ('../database/connection.php');
include_once ('../error_stmt/errorFunctions.php');

$databaseName = "MarcianGol";
mysqli_select_db($conn, $databaseName);

$team_name = !empty($_GET['teamName']) ? $_GET['teamName'] : null;

$result = new stdClass();
$result->success = false;

if ($team_name == null) {
    error_request($result, "All fields must be complete.");
}


try {
    $stmt = $conn->prepare("SELECT photo FROM team WHERE name = ?");
    
    if (!$stmt) {
        error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
    }

    $stmt->bind_param("s", $team_name);

    if (!$stmt->execute()) {
        error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
    }

    $stmt->bind_result($photoPath);
    
    if (!$stmt->fetch()) {
        error_request($result, "No result for the team: " . $team_name);
    }

    $result->success = true;
    $result->imagePath = $photoPath;

} catch (Exception $e) {
    $result->error = $e->getMessage();
}

// Return the image path as a JSON
echo json_encode($result);

// Close the statement and the connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>
