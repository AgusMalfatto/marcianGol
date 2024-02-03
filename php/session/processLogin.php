<?php

/* ------------------------ VERIFY THE LOGIN DATA ------------------------ */
/* 

It needs the next parameters:
    - Email: as 'email'.
    - Password: as 'password'.

Returns:
    If the login information is correct then it redirects to the index.
    If not, it returns false.
*/

include ("../database/connection.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

if (empty($email) || empty($password)) {
    echo json_encode(false);
}

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

$stmt = $conn->prepare("SELECT id_user, password, name, active FROM user WHERE email = ?");
if (!$stmt) {
    throw new Exception("Error preparing the query: " . $conn->error);
}

$stmt->bind_param("s", $email);

if (!$stmt->execute()) {
    throw new Exception("Error executing the query: " . $stmt->error);
}

$stmt->bind_result($id_user, $stored_password, $name, $active);
$exists = $stmt->fetch();

$stmt->close();

// Verify if the user exists and the password is correct
if ($exists && password_verify($password, $stored_password) && $active) {

    # Create a SESSION for the user
    session_start();
    
    $_SESSION['idSession'] = session_create_id();
    $_SESSION['id_user'] = $id_user;
    $_SESSION['name'] = $name;
    $_SESSION['active'] = $active;

    header("location: ../../index.html");
}

echo json_encode(false);
?>