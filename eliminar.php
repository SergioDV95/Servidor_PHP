<?php
session_start();
include_once('base_de_datos.php');
$id = $_SERVER['REQUEST_METHOD'] == "POST" ? (int)$_POST['Id'] : $_SESSION['Id'];
$sql_eliminar = "DELETE FROM Usuarios WHERE Id = {$id}";
try {
   if ($conn->query($sql_eliminar)) {
      if ($id == $_SESSION['Id']) {
         session_unset();
         session_destroy();
      }
      header("Location: main.php");
   } else {
      throw new Exception("Fallo al eliminar los datos: " . $conn->error);
   }
} catch (Exception $e) {
   echo 'Ha ocurrido un error: ',  $e->getMessage(), "\n";
} finally {
   $conn->close();
}