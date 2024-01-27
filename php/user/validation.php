<?php

/* ------------------------ PHP VALIDATION FUNCTIONS ------------------------ */

function is_email_valid($conn, $email) {
    /* 
        Validate if an email recive as a parameter is valid to register new user.

        Parameters: 
            $conn : The connection to the database.
            $email : Email to validate.
        
        Return:
            If the $email is empty return false.
            If there is a problem in the query throws an Exception.
            If there is no $email in the database then returns true.
            If the $email is in the database then returns false.
    */
    if (empty($email)) {
        return false;
    }

    try {
        $stmt = $conn->prepare("SELECT email FROM user WHERE email = ? LIMIT 1");

        if (!$stmt) {
            throw new Exception("Error preparing the query: " . $conn->error);
        }

        $stmt->bind_param("s", $email);

        if (!$stmt->execute()) {
            throw new Exception("Error executing the query: " . $stmt->error);
        }

        $stmt->bind_result($result_email);
        
        $exists = $stmt->fetch();

        $stmt->close();
        
        return !$exists;

    } catch (Exception $e) {
        // Manejo de errores, puedes logear, retornar un mensaje de error, etc.
        return false;
    }
}

?>