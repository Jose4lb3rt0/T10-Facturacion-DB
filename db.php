<?php

    $host = "localhost";
    $user="root";
    $pass= "";
    $port = 3306;
    $bd = "facturacion";

    try{
        $conexion = new PDO("mysql:host=$host;dbname=$bd;charset=utf8",$user,$pass);
        $conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo "Error al conectar a la base de datos: " . $e->getMessage();
        die();
    }

    /*
    $conexion = mysqli_connect($hostname, $user, $pass, $bd);
    if(mysqli_connect_errno()){
        echo "No se pudo conectar a la base de datos.";
        exit();
    }else{
        echo "Funciona";
    }

    mysqli_select_db($conexion,$bd) or die("No se encuentra la base de datos");

    mysqli_set_charset($conexion,"utf8");
    */