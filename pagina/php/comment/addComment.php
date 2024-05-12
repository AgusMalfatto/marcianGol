<?php

/* ------------------------ ADD NEW COMMENT TO DATABASE ------------------------ */
/* 

It recives:
    - description: Comment of the user.
    - id_foro: Id of the foro the comment was made on.

Returns an object with the next keys:
    - success: Boolean.
    - message: Error message.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include_once ("../error_stmt/errorFunctions.php");
include_once ("validation.php");

$description = !empty($_POST['description']) ? $_POST['description'] : null;
$id_foro = !empty($_POST['id_foro']) ? $_POST['id_foro'] : null;

$result = new stdClass();

if (($description == null) || ($id_foro == null)) {
    error_request($result, "All fields must be complete");
}

!is_comment_valid($description) ? error_request($result, "Comment must be less than 150 characters") : 0;

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);
if (!is_foro_active($conn, $id_foro)) {
    error_request($result, "The Foro is not active or it doesn't exists");
}

$date_comment = date('Y-m-d');

$stmt = $conn->prepare("INSERT INTO comment (description, date_comment, id_foro, id_user) VALUE (?, ?, ?, ?)");
!$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;

$stmt->bind_param("ssii", $description, $date_comment, $id_foro, $_SESSION['id_user']);

!$stmt->execute() ? error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn) : 0;

$result->id_newComment = mysqli_insert_id($conn);

$result->success = true;

echo json_encode($result);

?>