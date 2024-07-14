<?php

/* ------------------------ VALIDATION FUNCTIONS TO COMMENTS ------------------------ */

# Validate if a foro exists and its active
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

# Validate if a comment exists and its active
function is_comment_active($conn, $id_comment) {


    include_once ("../error_stmt/errorFunctions.php");

    $result = new stdClass();

    if (!$id_comment) {
        $result->success = false;
        $conn->close();
        return $result->success;
    }

    $stmt = $conn->prepare("SELECT * FROM comment WHERE id_comment = ? AND active = 1");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $stmt->error, $stmt, $conn) : 0;

    $stmt->bind_param("i", $id_comment);

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

# Return if the user had already gave like or dislike to one comment.
function like_status($conn, $id_comment) {

    include_once ("../error_stmt/errorFunctions.php");

    $result = new stdClass();

    if (!$id_comment) {
        $result->success = false;
        $conn->close();
        return $result->success;
    }

    $stmt = $conn->prepare("SELECT  is_like
                            FROM likes
                            WHERE id_comment = ? AND id_user = ?;");
    !$stmt ? error_stmt($result, "Error preparing the query: " . $stmt->error, $stmt, $conn) : 0;

    $stmt->bind_param("ii", $id_comment, $_SESSION['id_user']);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;

    # Getting the results
    $resultSet = $stmt->get_result();

    // Obtener la primera fila del resultado
    $row = $resultSet->fetch_assoc();

    empty($row['is_like']) ? $result->user_likes = 0 : $result->user_likes = 1;
    
    return $result;    
}

# Return the number of likes the comment has
function count_likes($conn, $id_comment) {

    include_once ("../error_stmt/errorFunctions.php");

    $result = new stdClass();

    if (!$id_comment) {
        $result->success = false;
        $conn->close();
        return $result->success;
    }

    $stmt = $conn->prepare("SELECT COUNT(1) as count_likes
                            FROM likes 
                            WHERE id_comment = ?;");

    !$stmt ? error_stmt($result, "Error preparing the query: " . $stmt->error, $stmt, $conn) : 0;

    $stmt->bind_param("i", $id_comment);

    !$stmt->execute() ? error_stmt($result, "Error executing the query: " . $stmt->error, $stmt, $conn) : 0;

    # Getting the results
    $resultSet = $stmt->get_result();

    $row = $resultSet->fetch_assoc();

    // Obtener los valores de 'count_likes' de la fila resultante
    $result->count_likes = $row['count_likes'];
    
    return $result;
    
}


?>