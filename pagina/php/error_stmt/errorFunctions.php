<?php

/* ------------------------ DECLARE ERROR IN STMT CONNECTION ------------------------ */


function error_stmt($result, $message, $stmt, $conn) {
    /* 
    
        It recives an object, and an error message.

        Sets the error on error.log file and return to client the error.

    */
    include_once ("../logConnection/logError.php");

    $stmt ? $stmt->close() : 0;
    $conn ? $conn->close() : 0;
    
    $result->success = false;
    $result->message = $message;
    set_error_log($result->message);
    die (json_encode($result));
}


function error_request($result, $message) {
    /* 
    
        It recives an object, and an error message.

    */
    include_once ("../logConnection/logError.php");
    
    $result->success = false;
    $result->message = $message;
    die (json_encode($result));
}

?>