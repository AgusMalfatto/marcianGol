<?php
/* ------------------------ DATABASE CONNECTION ------------------------ */

$servername = "localhost";
$username = "root";
$password = "Racing.2010";

$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection has failed: " . mysqli_connect_error());
}
else {
    echo "Connection success";
}

?>