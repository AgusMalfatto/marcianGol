<?php

/* ------------------------ DEACTIVATE FORO IN DATABASE ------------------------ */
/* 

It need the id of the foro.

Returns an object with the next keys:
    - success: Boolean.
    - message: If there were an error then it saves here.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include ("../error_stmt/errorFunctions.php");

$id_foro = !empty($_POST['id_foro']) ? $_POST['id_foro'] : null;

$result = new stdClass();

if (empty($id_foro)) {
    error_request($result, "All fields must be complete.");
}

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE foro SET active = 0 WHERE id_foro = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("i", $id_foro);

if (!$stmt->execute()) {    
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
} else {
    $result->id = $id_foro;
    $result->success = true;
}


$stmt->close();
$conn->close(); 

echo json_encode($result);
?>