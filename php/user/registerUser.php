<?php

/* ------------------------ REGISTER USER IN DATABASE ------------------------ */
/* 

It needs the next parameters:
    - Name: as 'name'.
    - Last Name: as 'last_name'.
    - Email: as 'email'.
    - Password: as 'password'.
    - Team: as 'team_name'.

Returns:
    If the information was Okay, then redirect to login.
    If the information was not Okay, then returns an object $result with the next keys:
        - message: Message of what failed.
        - success: Always in false.

*/

include ("../database/connection.php");
include ("validation.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = !empty($_POST['name']) ? $_POST['name'] : null;
    $last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : null;
    $email = !empty($_POST['email']) ? $_POST['email'] : null;
    $plain_password = !empty($_POST['password']) ? $_POST['password'] : null;
    $team_name = !empty($_POST['team_name']) ? $_POST['team_name'] : null;

    $result = new stdClass();
    $result->message = "";
    $result->success = true;

    if(($name === null) || ($last_name === null) || ($email === null) || ($plain_password === null) || ($team_name === null)) {
        $result->message .= " All fields must be completed.";
        $result->success = false;
    }

    if ($result->success) {
        $databaseName = "marcianGol";
        mysqli_select_db($conn, $databaseName);

        # Validate the email in the database
        if (!is_email_valid($conn, $email)){
            $result->message .= " The email already exists.";
            $result->success = false;
        } 

        if ($result->success) {

            # Validate the password format
            if (!is_pass_valid($plain_password)) {
                $result->message .= " The password is not valid.";
                $result->success = false;
            } else {

                $hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);
            
                # Get the id team of the user
                include ("../team/getIdTeam.php");
                $id_team = get_team_id($conn, $team_name);

                if ($id_team->success) {

                    # Insert instruction
                    $insertUserQuery = "INSERT INTO user (name, last_name, email, password, id_team) VALUES (?, ?, ?, ?, ?)";
                    $stmt = $conn->prepare($insertUserQuery);
                    
                    if (!$stmt) {
                        $result->message .= " Error preparing the query: " . $conn->error;
                        $result->success = false;
                    }

                    $stmt->bind_param("ssssi", $name, $last_name, $email, $hashed_password, $id_team->id_team);

                    if (!$stmt->execute()) {
                        $result->message .= " Error executing the query: " . $stmt->error;
                        $result->success = false;
                    }
                    
                    $stmt->close();
                    $conn->close(); 
                } else {
                    $result->message .= "The team '" . $team_name ."' doesn't exists";
                    $result->success = false;
                }
            }   
        }
    }    

    if ($result->success) {
        header('location: ../../index.html');
    }

    echo json_encode($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode("METODO GET");
}


?>