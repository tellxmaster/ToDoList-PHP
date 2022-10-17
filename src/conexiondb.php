<?php
    $username = 'root';
    $password = 'elitslot45';
    $dsn      = 'mysql:host=localhost; dbname=usuarios';

    try {
        $conexion = new PDO($dsn, $username, $password);
        $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    } catch (PDOException $e) {
        echo "<p class='error' style='color:red; text-align:center;'> Fallo al conectarse a la base de datos" . $e->getMessage() . "</p>";       
    }
?>