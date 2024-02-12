<?php

/* ------------------------ GET NAME OF ALL THE TEAMS ON DATABASE ------------------------ */
/* 

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.
    - data: Array of the team names.

*/

#include ("../session/validateSession.php");
include ('../database/connection.php');
include_once ('../error_stmt/errorFunctions.php');

$databaseName = "MarcianGol";
mysqli_select_db($conn, $databaseName);

$result = new stdClass();
$result->success = false;

$stmt = $conn->prepare("SELECT name FROM team");

if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
}

$resultSet = $stmt->get_result();

while ($row = $resultSet->fetch_assoc()) {
    $result->data[] = $row; // Añadimos cada fila al array
}

empty($result->data) ? error_request($result, "There is no teams on database") : 0;

$result->success = true;

// Return the image path as a JSON
echo json_encode($result);

// Close the statement and the connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>
