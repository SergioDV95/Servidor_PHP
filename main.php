<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Pagina Principal</title>
</head>
<body>
    <nav>
        <a href="registro.php" <?php if(count($_SESSION) > 0) {echo "hidden";} ?>>
            <Button class="boton" type="button">
                Registrarse
            </Button>
        </a>
        <a href="sesion.php" <?php if(count($_SESSION) > 0) {echo "hidden";} ?>>
            <Button class="boton" type="button">
                Iniciar Sesión
            </Button>
        </a>
        <a href="editar_usuario.php">
            <button class="boton sesion" type="button" <?php if(count($_SESSION) == 0) {echo "hidden";}?>>
                Editar Perfil
            </button>
        </a>
        <form action="cerrar_sesion.php">
            <button class="boton sesion" type="submit" <?php if(count($_SESSION) == 0) {echo "hidden";}?>>
                Cerrar Sesión
            </button>
        </form>
    </nav>
    <?php 
    if (count($_SESSION) > 0) {
        if ($_SESSION["Genero"] == "Hombre") {
            echo "<h3 id='bienvenida'>Bienvenido {$_SESSION['Nombre']}</h3>";
        } else {
            echo "<h3 id='bienvenida'>Bienvenida {$_SESSION['Nombre']}</h3>";
        }
        $conn = new mysqli("localhost", "root", "", "Proyecto");
        if ($conn->connect_error) {
            die("La conexión falló: " . $conn->connect_error);
        }
        if ($_SESSION['Rol'] == "Usuario") {
            $sql = "SELECT * FROM Usuarios WHERE Id = {$_SESSION['Id']}";
            if ($result = $conn->query($sql)) {
                echo "<section id='principal'>";
                while ($fila = $result->fetch_assoc()) {
                    echo "<p><strong>Id:</strong> <span>{$fila['Id']}</span><br>";
                    echo "<strong>Nombre:</strong> <span>{$fila['Nombre']}</span><br>";
                    echo "<strong>Apellido:</strong> <span>{$fila['Apellido']}</span><br>";
                    echo "<strong>Correo:</strong> <span>{$fila['Correo']}</span><br>";
                    echo "<strong>Fecha de registro:</strong>"." <span>".date('d/m/Y', strtotime($fila['Fecha_Registro']))."</span><br>";
                    echo "<strong>Última actualización:</strong>"." <span>".date('d/m/Y', strtotime($fila['Fecha_Actualización'])).(date('h', strtotime($fila['Fecha_Actualización'])) == '01' ? " a la " : " a las ").date('h:ia', strtotime($fila['Fecha_Actualización']))."</span></p>";
                }
                echo "</section>";
                $conn->close();
            } else {
                echo "Ha ocurrido un error: " . $conn->error;
            }
        } else {
            $sql = "SELECT * FROM Usuarios";
            if ($result = $conn->query($sql)) {
                echo "<h4 id='lista'>Lista de Usuarios</h4>", "<section id='principal'>";
                while ($fila = $result->fetch_assoc()) {
                    if ($fila['Rol'] == $_SESSION['Rol']) {
                        continue;
                    }
                    echo "<div class='usuarios'><p><strong>Id:</strong> <span>{$fila['Id']}</span><br>";
                    echo "<strong>Nombre:</strong> <span>{$fila['Nombre']}</span><br>";
                    echo "<strong>Apellido:</strong> <span>{$fila['Apellido']}</span><br>";
                    echo "<strong>Correo:</strong> <span>{$fila['Correo']}</span><br>";
                    echo "<strong>Fecha de registro:</strong>"." <span>".date('d/m/Y', strtotime($fila['Fecha_Registro']))."</span><br>";
                    echo "<strong>Última actualización:</strong>"." <span>".date('d/m/Y', strtotime($fila['Fecha_Actualización'])).(date('h', strtotime($fila['Fecha_Actualización'])) == '01' ? " a la " : " a las ").date('h:ia', strtotime($fila['Fecha_Actualización']))."</span></p>";
                    echo "<div class='botones'><form action='editar_usuario.php' method='POST'><button class='boton editar' type='submit'>Editar</button><input type='hidden' name='Id' value='{$fila['Id']}'></form>";
                    echo "<form action='eliminar.php' method='POST'><button class='boton eliminar usuario' type='submit'>Eliminar</button><input type='hidden' name='Id' value='{$fila['Id']}'></form></div></div>";
                }
                echo "</section>";
            } else {
                echo "Ha ocurrido un error: " . $conn->error;
            }
        }
    }
    ?>
    </section>
</body>
</html>