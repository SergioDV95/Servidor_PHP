<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registro</title>
</head>
<body id="registro">
    <div id="contenedor">
        <h2 id="titular">Registro</h2>
        <form id="datos" action="val_registro.php" method="POST">
            <label for="nombre" form="datos">Nombre:</label>
            <input type="text" name="nombre" title="Primer Nombre" required>
            <label for="apellido" form="datos">Apellido:</label>
            <input type="text" name="apellido" title="Primer Apellido" required>
            <label for="correo" form="datos">Correo:</label>
            <input type="email" name="correo"  title="Correo Electrónico" required>
            <label for="contraseña" form="datos">Contraseña:</label>
            <input type="password" name="contraseña"  title="Contraseña" required>
            <label for="val_contraseña" form="datos">Repetir contraseña:</label>
            <input type="password" name="val_contraseña"  title="Validar contraseña" required>
            <fieldset id="genero" form="datos">
                <label for="genero" form="datos">Hombre</label>
                <input type="radio" name="genero" value="Hombre" title="Genero" required>
                <label for="genero" form="datos">Mujer</label>
                <input type="radio" name="genero" value="Mujer" title="Genero" required>
            </fieldset>
            <input class="boton" type="submit" title="Registrarse" value="Registrarse">
        </form>
    </div>
</body>
</html>