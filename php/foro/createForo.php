<?php

include ("../database/connection.php");
include ("../league/getIdLeague.php");

$name = !empty($_GET['name']) ? $_GET['name'] : null;

$db_name = "marciangol";
mysqli_select_db($conn, $db_name);

$result = get_league_id($conn, $name);

echo json_encode($result);


?>