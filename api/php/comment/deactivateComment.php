<?php

/* ------------------------ DEACTIVATE COMMENT IN DATABASE ------------------------ */
/* 

It need the comment Id.

Returns an object with the next keys:
    - success: Boolean.
    - message: If there were an error then it saves here.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include_once ("../error_stmt/errorFunctions.php");

$id_comment = !empty($_POST['id_comment']) ? $_POST['id_comment'] : null;
$result = new stdClass();

($id_comment === null) ? error_request($result, "The comment ID can't be null") : 0;

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE comment SET active = 0 WHERE id_comment = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("i", $id_comment);

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
} 

$result->success = true;

$stmt->close();
$conn->close(); 

echo json_encode($result);
?>