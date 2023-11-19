<?php
session_start();
$conn = new mysqli("localhost", "root", "", "Proyecto");
if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
if (isset($_POST["correo"]) && isset($_POST["contraseña"])) {
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE Correo = ?");
    $stmt->bind_param("s", $_POST["correo"]);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows == 1){
        $fila = $resultado->fetch_assoc();
        if (password_verify($_POST["contraseña"], $fila["Contraseña"])) {
            $_SESSION["Id"] = $fila["Id"];
            $_SESSION["Nombre"] = $fila["Nombre"];
            $_SESSION["Apellido"] = $fila["Apellido"];
            $_SESSION["Correo"] = $fila["Correo"];
            $_SESSION["Rol"] = $fila["Rol"];
            $_SESSION["Genero"] = $fila["Genero"];
            $conn->close();
            header("Location: main.php");
        } else {
            die("La contraseña es incorrecta");
        }
    } else {
        die("El correo es incorrecto");
    }
}