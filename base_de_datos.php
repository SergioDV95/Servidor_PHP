<?php

require_once('conexion.php');

$sql_bd = "CREATE DATABASE IF NOT EXISTS Proyecto CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci; USE Proyecto;";

try{
    if ($conn->multi_query($sql_bd)) {
        do {
            if ($result = $conn->store_result()) {
                $result->free();
            }
        } while ($conn->next_result());
    } else {
        throw new Exception("Fallo al crear la base de datos, " . $conn->connect_error);
    }    
} catch (Exception $e) {
    die('Ha ocurrido un error: ' . $e->getMessage() . "\n");
}

$sql_tabla= "CREATE TABLE IF NOT EXISTS Usuarios(
    Id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(30) NOT NULL,
    Apellido VARCHAR(30) NOT NULL,
    Correo VARCHAR(50) NOT NULL,
    Contraseña VARCHAR(255) NOT NULL,
    Genero CHAR(6) NOT NULL,
    Rol CHAR(13) NOT NULL DEFAULT 'Usuario',
    Fecha_Registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Fecha_Actualización TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);";

try {
    $conn->query($sql_tabla);
} catch (Exception $e) {
    die('Ha ocurrido un error: ' . $e->getMessage() . "\n");
}