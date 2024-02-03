<?php

/* ------------------------ DEACTIVATE USER IN DATABASE ------------------------ */
/* 

It need the User Id as 'id_user.

Returns an object with the next keys:
    - success: Boolean.
    - message: If there were an error then it saves here.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");

$message = new stdClass();

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE user SET active = 0 WHERE id_user = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    $message->success = false;
    $message->message = " Error preparing the query: " . $conn->error;
} else {
    $stmt->bind_param("i", $_SESSION['id_user']);

    if (!$stmt->execute()) {
        $message->success = false;
        $message->message = " Error executing the query: " . $stmt->error;
    } else {
        header('location: ../../index.php');
    }
}

$stmt->close();
$conn->close(); 

echo json_encode($message);
?>