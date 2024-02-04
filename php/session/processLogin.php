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
include ("../error_stmt/errorFunctions.php");

ini_set('display_errors', 1);
error_reporting(E_ALL);

$email = isset($_POST['email']) ? $_POST['email'] : null;
$password = isset($_POST['password']) ? $_POST['password'] : null;

$result = new stdClass();

if (empty($email) || empty($password)) {
    error_request($result, "All field must be complete");
}

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

$stmt = $conn->prepare("SELECT id_user, password, name, active FROM user WHERE email = ?");
if (!$stmt) {
    error_stmt($result, "Error preparing the query: " . $conn->error, $stmt, $conn);
}

$stmt->bind_param("s", $email);

if (!$stmt->execute()) {
    error_stmt($result, "Error executing the query: " . $conn->error, $stmt, $conn);
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
$result->success = false;

echo json_encode($result);
?>