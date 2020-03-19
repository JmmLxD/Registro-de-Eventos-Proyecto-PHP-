<?php
    $host = "localhost";
    $password = "";
    $db = "proyecto_eventos";
    $user = "root";
    $dns = "mysql:host=" . $host . ";dbname=" . $db;
    $con = new PDO($dns,$user,$password); 
?>