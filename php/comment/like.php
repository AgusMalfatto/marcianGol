<?php

/* ------------------------ LIKE MANAGEMENT FILE ------------------------ */
/* 

It recives:
    - id_comment: The ID of the comment.
    - add_like: True (1) if it adds a like, or False (0) if remove a like.

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include_once("../error_stmt/errorFunctions.php");
include_once("validation.php");

$id_comment = isset($_POST['id_comment']) ? $_POST['id_comment'] : null;
$add_like = isset($_POST['add_like']) ? (bool)$_POST['add_like'] : null;

$result = new stdClass();

($id_comment === null || $add_like === null) ? error_request($result, "All fields must be complete") : 0;

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);


# Validate the number of likes
$likesInfo = likes_count($conn, $id_comment);

if (!$add_like && ($likesInfo->success && isset($likesInfo->likes) && $likesInfo->likes <= 0)) {
    error_request($result, "This comment has no likes");
}

// Consulta para agregar o restar un like
$sql = ($add_like) ? "UPDATE comment SET likes = likes + 1 WHERE id_comment = ?" : "UPDATE comment SET likes = likes - 1 WHERE id_comment = ?";

$stmt = $conn->prepare($sql);

!$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;
$stmt->bind_param("i", $id_comment);

!$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;

$result->success = true;

$stmt->close();
$conn->close();

echo json_encode($result);

?>