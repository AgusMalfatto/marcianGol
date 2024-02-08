<?php

session_start();

if (!isset($_SESSION['idSession'])) {
    header('location: ../user/login.php');
}

?>