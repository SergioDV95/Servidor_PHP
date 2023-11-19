<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Iniciar Sesión</title>
</head>
<body id="registro">
    <div id="contenedor">
        <h2 id="titular">Iniciar Sesión</h2>
        <form id="datos" action="val_sesion.php" method="POST">
            <label for="correo" form="datos">Correo:</label>
            <input type="email" name="correo"  title="Correo Electrónico" required>
            <label for="contraseña" form="datos">Contraseña:</label>
            <input type="password" name="contraseña" title="Contraseña" required>
            <input class="boton" type="submit" title="Sesion" value="Iniciar Sesión">
        </form>
    </div>
</body>
</html>