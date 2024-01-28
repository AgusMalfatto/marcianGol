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

        $exists = $stmt->fetch();

        $stmt->close();
        
        return !$exists;

    } catch (Exception $e) {
        // Manejo de errores, puedes logear, retornar un mensaje de error, etc.
        return false;
    }
}


function is_pass_valid($pass) {
    /* 
        Validate if a password recive as a parameter is in a valid format (1 upper case, 1 lower case, 1 number).

        Parameters: 
            $pass : The password to validate
        
        Return:
            If the $pass is empty return false.
            If the password is in correct format it returns true, and if not the returns false.
    */

    if (empty($pass)) {
        return false;
    }

    $uppercase = preg_match('/[A-Z]/', $pass);
    $lowercase = preg_match('/[a-z]/', $pass);
    $number = preg_match('/[0-9]/', $pass);

    return $uppercase && $lowercase && $number;
}

?>