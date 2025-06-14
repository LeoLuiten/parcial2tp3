<?php
/**
 * Validación de credenciales de login
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir archivos necesarios
require_once 'includes/conexion.php';
require_once 'includes/sesion.php';
require_once 'funciones/bd.php';

// Verificar que se envió el formulario por POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: login.php");
    exit();
}

// Obtener datos del formulario
$usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

// Validar que no estén vacíos
if (empty($usuario) || empty($password)) {
    header("Location: login.php?error=datos_incorrectos");
    exit();
}

// Escapar datos para evitar inyección SQL
$usuario = escaparCadena($usuario);
$password_md5 = md5($password);

// Consulta para buscar el usuario con sus datos de rol
$consulta = "SELECT u.*, r.Denominacion as Rol_Nombre 
             FROM usuarios u 
             INNER JOIN roles r ON u.Id_Rol = r.Id 
             WHERE u.Usuario = '$usuario' AND u.Password = '$password_md5'";

$resultado = obtenerFila($consulta);

// Verificar si se encontró el usuario
if (!$resultado) {
    header("Location: login.php?error=datos_incorrectos");
    exit();
}

// Verificar si el usuario puede acceder (no es Analista ni Programador)
$rol_id = $resultado['Id_Rol'];
if ($rol_id == 3 || $rol_id == 4) { // Analista Funcional o Programador
    header("Location: login.php?error=sin_permisos");
    exit();
}

// Iniciar sesión del usuario
iniciarSesion($resultado);

// Redirigir al panel principal
header("Location: index.php");
exit();
?>