<?php
/**
 * Archivo de conexión a la base de datos
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Configuración de la base de datos
$servidor = "localhost";
$usuario_bd = "root";
$password_bd = "";
$nombre_bd = "consultora";

// Crear conexión
$conexion = mysqli_connect($servidor, $usuario_bd, $password_bd, $nombre_bd);

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Establecer charset UTF-8
mysqli_set_charset($conexion, "utf8");

/**
 * Función para cerrar la conexión
 */
function cerrarConexion() {
    global $conexion;
    if ($conexion) {
        mysqli_close($conexion);
    }
}
?>