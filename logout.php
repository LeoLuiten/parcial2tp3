<?php
/**
 * Cerrar sesión de usuario
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir archivo de sesiones
require_once 'includes/sesion.php';

// Cerrar sesión
cerrarSesion();

// Redirigir al login
header("Location: login.php");
exit();
?>