<?php

/* ------------------------ REGISTER USER IN DATABASE ------------------------ */

include ("../database/connection.php");
include ("validation.php");

$name = !empty($_POST['name']) ? $_POST['name'] : null;
$last_name = !empty($_POST['last_name']) ? $_POST['last_name'] : null;
$email = !empty($_POST['email']) ? $_POST['email'] : null;
$plain_password = !empty($_POST['password']) ? $_POST['password'] : null;
$team_name = !empty($_POST['id_team']) ? $_POST['id_team'] : null;


$message = "";

if(($name === null) || ($last_name === null) || ($email === null) || ($plain_password === null) || ($team_name === null)) {
    $message .= " All fields must be completed.";
} else {
    $databaseName = "marcianGol";
    mysqli_select_db($conn, $databaseName);

    # Validate the email in the database
    if (!is_email_valid($conn, $email)){
        $message .= " The email already exists.";
    } else {

        # Validate the password format
        if (!is_pass_valid($plain_password)) {
            $message .= " The password is not valid.";
        } else {

            $hassed_password = password_hash($plain_password, PASSWORD_DEFAULT);
        
            # Get the id team of the user
            include ("../team/getIdTeam.php");
            $id_team = get_team_id($team_name);

            if ($id_team->success) {

                # Insert instruction
                $insertUserQuery = "INSERT INTO user (name, last_name, email, password, id_team) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($insertUserQuery);
                
                if (!$stmt) {
                    $message .= " Error preparing the query: " . $conn->error;
                }

                $stmt->bind_param("ssssi", $name, $last_name, $email, $hassed_password, $id_team->id_team);

                if (!$stmt->execute()) {
                    $message .= " Error executing the query: " . $stmt->error;
                }
                
                $stmt->close();
                $conn->close(); 
            }
        }
        
    }
    

}

echo json_encode($message);


?>