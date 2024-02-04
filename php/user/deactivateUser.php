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
include ("../logConnection/logError.php");

$result = new stdClass();

$databaseName = "marcianGol";
mysqli_select_db($conn, $databaseName);

# Update instruction
$updateQuery = "UPDATE user SET active = 0 WHERE id_user = ?";
$stmt = $conn->prepare($updateQuery);

if (!$stmt) {
    $result->success = false;
    $result->message = " Error preparing the query: " . $conn->error;
    set_error_log($result->message);
} else {
    $stmt->bind_param("i", $_SESSION['id_user']);

    if (!$stmt->execute()) {
        $result->success = false;
        $result->message = " Error executing the query: " . $stmt->error;
        set_error_log($result->message);
    } else {
        header('location: ../../index.php');
    }
}

$stmt->close();
$conn->close(); 

echo json_encode($result);
?>