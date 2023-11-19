<?php
session_start();
$id = $nombre = $apellido = $correo = null;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new mysqli("localhost", "root", "", "Proyecto");
    } catch (Exception $e) {
        echo 'Ha ocurrido un error: ',  $e->getMessage(), "\n";
    }
    $id = (int)$_POST['Id'];
    $sql = "SELECT * FROM Usuarios WHERE Id = ".$id;
    if ($result = $conn->query($sql)) {
        while ($fila = $result->fetch_assoc()) {
            $nombre = $fila['Nombre'];
            $apellido = $fila['Apellido'];
            $correo = $fila['Correo'];
        }
    } elseif ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Editar <?php if ($id) {echo "Usuario";} else {echo "Perfil";}?></title>
</head>
<body id="registro">
    <div id="contenedor">
        <h2 id="titular">Editar <?php if ($id) {echo "Usuario";} else {echo "Perfil";}?></h2>
        <?php if ($id) {echo "<h3>Edita los campos que quieras cambiar</h3>";} ?>
        <form id="datos" action="val_cambio.php" method="POST">
            <label for="nombre" form="datos">Cambiar nombre:</label>
            <input type="text" name="nombre" title="Primer Nombre" value=<?php if ($nombre) {echo $nombre;} else {echo $_SESSION['Nombre'];}?>>
            <label for="apellido" form="datos">Cambiar apellido:</label>
            <input type="text" name="apellido" title="Primer Apellido" value=<?php if ($apellido) {echo $apellido;} else {echo $_SESSION['Apellido'];}?>>
            <label for="correo" form="datos">Cambiar correo:</label>
            <input type="email" name="correo"  title="Correo Electrónico" value=<?php if ($correo) {echo $correo;} else {echo $_SESSION['Correo'];}?>>
            <label for="contraseña" form="datos">Nueva contraseña:</label>
            <input type="password" name="contraseña"  title="Contraseña">
            <label for="val_contraseña" form="datos">Repetir nueva contraseña:</label>
            <input type="password" name="val_contraseña"  title="Validar contraseña">
            <input class="boton" type="submit" title="Editar" value="Subir Cambios">
            <?php if ($id) {echo "<input type='hidden' name='Id' value='$id'>";}?>
			<a href="eliminar.php"<?php if ($id) {echo 'hidden';}?>>
				<input class="boton eliminar" type="button" title="Eliminar" value="Eliminar Cuenta">
			</a>
        </form>
    </div>
</body>
</html>