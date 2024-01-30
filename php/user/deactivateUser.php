<?php

/* ------------------------ DEACTIVATE USER IN DATABASE ------------------------ */
/* 

It need the User Id as 'id_user.
Returns in a JSON format an object with a 'status' key on true if the user was deactivated, and 'error' key if there was an error.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");

#$id_user = !empty($_GET['id_user']) ? $_GET['id_user'] : null;

$message = new stdClass();

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE user SET active = 0 WHERE id_user = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    $message->status = false;
    $message->error = " Error preparing the query: " . $conn->error;
} else {
    $stmt->bind_param("i", $_SESSION['id_user']);

    if (!$stmt->execute()) {
        $message->status = false;
        $message->error = " Error executing the query: " . $stmt->error;
    } else {
        $message->status = true;
    }
}

$stmt->close();
$conn->close(); 

echo json_encode($message);
?>