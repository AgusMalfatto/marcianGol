<?php

session_start();

if (!isset($_SESSION['idSession'])) {
    header('location: ../design/user/login.php');
}

?>