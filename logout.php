<?php
    require("./config/config.php");
    session_start();
    session_unset();
    session_destroy();
    ConsoleLog("Session destroyed: {$_SESSION["username"]}");
    ConsoleLog("Logged out: {$_SESSION["username"]}");
    header('Location: '.ROOT_URL.'/login.php');
?>