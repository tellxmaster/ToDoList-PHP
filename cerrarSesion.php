<?php
    include_once 'src/session.php';
    session_destroy();
    header("location: inicioSesion.php");
?>