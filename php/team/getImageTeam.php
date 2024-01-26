<?php

/* ------------------------ GET IMAGE OF THE TEAM ------------------------ */

include('../creation/connection.php');

$databaseName = "MarcianGol";
mysqli_select_db($conn, $databaseName);

$team_name = $_POST['teamName'];
$response = new stdClass();
$response->success = false;

try {
    $stmt = $conn->prepare("SELECT photo FROM team WHERE name = ?");
    
    if (!$stmt) {
        throw new Exception("Error preparing the query: " . $conn->error);
    }

    $stmt->bind_param("s", $team_name);

    if (!$stmt->execute()) {
        throw new Exception("Error executing the query: " . $stmt->error);
    }

    $stmt->bind_result($photoPath);
    
    if (!$stmt->fetch()) {
        throw new Exception("There is no result for the team: " . $team_name);
    }

    $response->success = true;
    $response->imagePath = $photoPath;

} catch (Exception $e) {
    $response->error = $e->getMessage();
}

// Return the image path as a JSON
echo json_encode($response);

// Close the statement and the connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>
