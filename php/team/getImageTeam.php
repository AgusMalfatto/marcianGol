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
include('../database/connection.php');
include('../logConnection/logError.php');

$databaseName = "MarcianGol";
mysqli_select_db($conn, $databaseName);

$team_name = $_POST['teamName'];

$result = new stdClass();
$result->success = false;
$result->messsage = "";


try {
    $stmt = $conn->prepare("SELECT photo FROM team WHERE name = ?");
    
    if (!$stmt) {
        $result->message = "Error preparing the query: " . $conn->error;
        set_error_log($result->message);
        die (json_encode($result));
    }

    $stmt->bind_param("s", $team_name);

    if (!$stmt->execute()) {
        $result->message = "Error executing the query: " . $stmt->error;
        set_error_log($result->message);
        die (json_encode($result));
    }

    $stmt->bind_result($photoPath);
    
    if (!$stmt->fetch()) {
        $result->message = "There is no result for the team: " . $team_name;
        die (json_encode($result));
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
