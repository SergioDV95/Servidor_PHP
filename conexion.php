<?php
$conn = new mysqli("localhost", "root", "");
try {
    if ($conn->connect_error) {
        throw new Exception("La conexión fallo " . $conn->connect_error);
    }
} catch (Exception $e) {
    die('Ha ocurrido un error: ' . $e->getMessage() . "\n");
}