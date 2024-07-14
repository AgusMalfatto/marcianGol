<?php

/* ------------------------ LIKE MANAGEMENT FILE ------------------------ */
/* 

It recives:
    - id_comment: The ID of the comment.
    - add_like: True (1) if it adds a like, or False (0) if remove a like.

Returns an object with the next keys:
    - success: Boolean.
    - reaction: Boolean, true if there is a reaction by the user, or false if there is not a reaction.
    - reaction_status: Boolean, true if its a like, or false if its a dislike.
    - message: Error message.

*/

include ("../session/validateSession.php");
include ("../database/connection.php");
include_once("../error_stmt/errorFunctions.php");
include_once("validation.php");



function delete_reaction($conn, $id_comment, $result) {
    $query = "DELETE FROM likes WHERE id_comment = ? AND id_user = ?";
    $stmt = $conn->prepare($query);

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;
    $stmt->bind_param("ii", $id_comment, $_SESSION['id_user']);
    
    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;
    $stmt->close();
}

function update_reaction($conn, $id_comment, $result) {
    $query = "UPDATE likes SET is_like = NOT is_like WHERE id_comment = ? AND id_user = ?";
    $stmt = $conn->prepare($query);

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;
    $stmt->bind_param("ii", $id_comment, $_SESSION['id_user']);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;
    $stmt->close();
}

function insert_reaction($conn, $id_comment, $result) {
    $query = "INSERT INTO likes (id_comment, id_user, is_like) VALUES (?, ?, 1)";
    $stmt = $conn->prepare($query);

    !$stmt ? error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn) : 0;
    $stmt->bind_param("ii", $id_comment, $_SESSION['id_user']);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;
    $stmt->close();
}


$id_comment = isset($_POST['id_comment']) ? $_POST['id_comment'] : null;

$result = new stdClass();
$result->id_comment = $id_comment;

($id_comment === null) ? error_request($result, "All fields must be complete") : 0;

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

# Validate if the comment exists and its active
$comment_active = is_comment_active($conn, $id_comment);

if (!$comment_active) {
    error_request($result, "The ID comment: '" . $id_comment . "' doesn't exists or its not active");
}

# Validate the number of likes
$likesInfo = like_status($conn, $id_comment);

# If the user had already react to the comment
if ($likesInfo->user_likes) {
    
    delete_reaction($conn, $id_comment, $result);
    $result->reaction = false;
} else {
    insert_reaction($conn, $id_comment, $result);
    $result->reaction = true;
}

# Number of likes of the comment
$count_likes = count_likes($conn, $id_comment);
$result->count_likes = $count_likes->count_likes;

$result->success = true;
$conn->close();

echo json_encode($result);

?>