<?php

/* ------------------------ VALIDATION FUNCTIONS TO COMMENTS ------------------------ */


function is_foro_active($conn, $id_foro) {


    include_once ("../error_stmt/errorFunctions.php");

    $result = new stdClass();

    if (!$id_foro) {
        $result->success = false;
        $conn->close();
        return $result->success;
    }

    $stmt = $conn->prepare("SELECT * FROM foro WHERE id_foro = ? AND active = 1");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $stmt->error, $stmt, $conn) : 0;

    $stmt->bind_param("i", $id_foro);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;
    # Getting the results
    $stmt->store_result();

    if ($stmt->num_rows > 0){
        $result->success = true;
    } else {
        $result->success = false;
        $stmt->close();
        $conn->close();
    }

     return $result->success;
}

# Validate the length of the foro description
function is_comment_valid($comment) {
    return strlen($comment) < 150;
}

# Return the number of likes and dislikes a comment has.
function likes_count($conn, $id_comment) {

    include_once ("../error_stmt/errorFunctions.php");

    $result = new stdClass();
    $result->likes = 0;
    $result->dislikes = 0;

    if (!$id_comment) {
        $result->success = false;
        $conn->close();
        return $result->success;
    }

    $stmt = $conn->prepare("SELECT likes, dislikes FROM comment WHERE id_comment = ? AND active = 1");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $stmt->error, $stmt, $conn) : 0;

    $stmt->bind_param("i", $id_comment);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;
    # Getting the results
    $stmt->bind_result($result->likes, $result->dislikes);

    if (!$stmt->fetch()) {
        $result->success = false;
    } else {
        $result->success = true;
    }

     return $result;
}


?>