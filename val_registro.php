<?php
$reg_nombre = "/^[a-záéíóúñ]{1,30}$/i";
$reg_correo = "/^[\w\-#$%&]+@[a-z]+(\.[a-z]{1,5}){1,3}$/i";
$reg_pass = "/^[^\s<>]{8,16}$/i";
$err_nombre = $err_apellido = $err_correo = $err_pass = $err_pass_val = "";

require_once('base_de_datos.php');
try {
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST["nombre"]) && !empty($_POST["apellido"]) && !empty($_POST["correo"]) && !empty($_POST["contraseña"]) && !empty($_POST["val_contraseña"]) && !empty($_POST["genero"])){
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
            } elseif (preg_match($reg_correo, $_POST["correo"])) {
                $stmt1 = $conn->prepare("SELECT * FROM Usuarios WHERE Correo = ?");
                $stmt1->bind_param("s", $_POST["correo"]);
                $stmt1->execute();
                $comprobacion = $stmt1->get_result();
                if ($comprobacion->num_rows == 1){
                    $err_correo = "El correo ya existe";
                    throw new Exception($err_correo);
                }
            }
            if (!preg_match($reg_pass, $_POST["contraseña"])){ 
                $err_pass = "Contraseña inválida";
                throw new Exception($err_pass);
            } else {
                $nombre = ucfirst(strtolower(despejar_datos($_POST["nombre"])));
                $apellido = ucfirst(strtolower(despejar_datos($_POST["apellido"])));
                $correo = despejar_datos($_POST["correo"]);
                $genero = $_POST["genero"];
                if ($_POST["contraseña"] !== $_POST["val_contraseña"]){
                    $err_pass_val = "Las contraseñas no coinciden";
                    throw new Exception($err_pass_val);
                } else {
                    $contrasena = password_hash(despejar_datos($_POST["contraseña"]), PASSWORD_DEFAULT);
                }
                $stmt2 = $conn->prepare("INSERT INTO Usuarios(Nombre, Apellido, Correo, Contraseña, Genero) 
                VALUES (?, ?, ?, ?, ?)");
                $stmt2->bind_param("sssss", $nombre, $apellido, $correo, $contrasena, $genero);
                $err_nombre = $err_apellido = $err_correo = $err_pass = $err_pass_val = "";
                if ($stmt2->execute()) {
                    echo "<h3>Registro exitoso</h3>\n";
                    $msg = wordwrap("Hola $nombre,\nGracias por registrarte en mi sitio.\nAhora puedes iniciar sesión con tu correo y contraseña.", 70);
                    if (mail($correo, "Confirmación de registro", $msg)) {
                        echo "<h4>Correo enviado con éxito.</h4>";
                    }
                    $nombre = $apellido = $correo = $contrasena = $genero = "";
                    header("Location: sesion.php");
                } else {
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