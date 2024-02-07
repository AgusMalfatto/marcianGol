<?php
    session_start();

    session_unset();

    session_destroy();
    header('location: ../../desing/user/login.php');

?>