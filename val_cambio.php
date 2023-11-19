<?php
session_start();
$reg_nombre = "/^[a-záéíóúñ]{1,30}$/i";
$reg_correo = "/^[\w\-#$%&]+@[a-z]+(\.[a-z]{1,5}){1,3}$/i";
$reg_pass = "/^[^\s<>]{8,16}$/i";
$err_nombre = $err_apellido = $err_correo = $err_pass = $err_pass_val = "";
$nombre = $apellido = $correo = $contrasena = "";
$id = $_POST['Id'] ? (int)$_POST['Id'] : $_SESSION['Id'];

require_once('base_de_datos.php');
try {
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["correo"])){
            if (!preg_match($reg_nombre, $_POST["nombre"])){ 
                $err_nombre = "Nombre inválido"; 
                throw new Exception($err_nombre);
            }
            if (!preg_match($reg_nombre, $_POST["apellido"])){ 
                $err_apellido = "Apellido inválido";
                throw new Exception($err_apellido);
            }
            if (!preg_match($reg_correo, $_POST["correo"])){ 
                $err_correo = "Correo inválido";
                throw new Exception($err_correo);
            } else {
                $nombre = ucfirst(strtolower(despejar_datos($_POST["nombre"])));
                $apellido = ucfirst(strtolower(despejar_datos($_POST["apellido"])));
                $correo = despejar_datos($_POST["correo"]);
                if (!empty($_POST["contraseña"]) && !empty($_POST["val_contraseña"])){
                    if (!preg_match($reg_pass, $_POST["contraseña"])){ 
                        $err_pass = "Contraseña inválida";
                        throw new Exception($err_pass);
                    } elseif ($_POST["contraseña"] !== $_POST["val_contraseña"]){
                        $err_pass_val = "Las contraseñas no coinciden";
                        throw new Exception($err_pass_val);
                    } else {
                        $contrasena = password_hash(despejar_datos($_POST["contraseña"]), PASSWORD_DEFAULT);
                        $stmt = $conn->prepare("UPDATE Usuarios SET Nombre = ?, Apellido = ?, Correo = ?, Contraseña = ? WHERE Id = ?");
                        $stmt->bind_param("ssssi", $nombre, $apellido, $correo, $contrasena, $id);
                    }
                } elseif (empty($_POST["contraseña"]) || empty($_POST["val_contraseña"])) {
                    $stmt = $conn->prepare("UPDATE Usuarios SET Nombre = ?, Apellido = ?, Correo = ? WHERE Id = ?");
                    $stmt->bind_param("sssi", $nombre, $apellido, $correo, $id);
                } 
                if ($stmt->execute()) {
                    if ($id == $_SESSION['Id']) {
                        $_SESSION['Nombre'] = $nombre;
                        $_SESSION['Apellido'] = $apellido;
                        $_SESSION['Correo'] = $correo;
                    }
                    header("Location: main.php");
                }
                else {
                    throw new Exception("Fallo al insertar los datos: " . $stmt->error);
                }
            }
        }
    }
} catch (Exception $e) {
    echo 'Ha ocurrido un error: ',  $e->getMessage(), "\n";
} finally {
    $conn->close();
}

function despejar_datos($post){
    $post = trim($post);
    $post = stripslashes($post);
    $post = htmlspecialchars($post);
    return $post;
}