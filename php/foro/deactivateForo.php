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
include ("../logConnection/logError.php");

$id_foro = !empty($_POST['id_foro']) ? $_POST['id_foro'] : null;

$result = new stdClass();

if (empty($id_foro)) {
    $result->success = false;
    $result->message = "All fields must be complete.";
    die (json_encode($result));
}

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE foro SET active = 0 WHERE id_foro = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    $result->success = false;
    $result->message = " Error preparing the query: " . $conn->error;
    set_error_log($result->message);
} else {
    $stmt->bind_param("i", $id_foro);

    if (!$stmt->execute()) {
        $result->success = false;
        $result->message = " Error executing the query: " . $stmt->error;
        set_error_log($result->message);
    } else {
        $result->id = $id_foro;
        $result->success = true;
    }
}

$stmt->close();
$conn->close(); 

echo json_encode($result);
?>