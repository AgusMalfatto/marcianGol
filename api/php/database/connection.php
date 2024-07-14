<?php
/* ------------------------ DATABASE CONNECTION ------------------------ */

include ("config.php");

$conn = mysqli_connect($database_config['servername'], $database_config['username'], $database_config['password']);

if (!$conn) {
    set_error_log(mysqli_connect_error());
    die("Connection has failed: " . mysqli_connect_error());
}
/* else {
    echo "Connection success";
}*/


?>