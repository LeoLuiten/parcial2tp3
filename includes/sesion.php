<?php
/**
 * Control de sesiones de usuario
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Iniciar sesión si no está iniciada
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/**
 * Verificar si el usuario está logueado
 * @return bool - true si está logueado, false si no
 */
function estaLogueado() {
    return isset($_SESSION['usuario_id']) && !empty($_SESSION['usuario_id']);
}

/**
 * Verificar acceso a la página (redirige a login si no está logueado)
 */
function verificarAcceso() {
    if (!estaLogueado()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Obtener datos del usuario logueado
 * @return array|null - Datos del usuario o null si no está logueado
 */
function obtenerUsuarioLogueado() {
    if (!estaLogueado()) {
        return null;
    }
    
    return array(
        'id' => $_SESSION['usuario_id'],
        'nombre' => $_SESSION['usuario_nombre'],
        'apellido' => $_SESSION['usuario_apellido'],
        'usuario' => $_SESSION['usuario_login'],
        'foto' => $_SESSION['usuario_foto'],
        'rol_id' => $_SESSION['usuario_rol_id'],
        'rol_nombre' => $_SESSION['usuario_rol_nombre']
    );
}

/**
 * Verificar si el usuario tiene un rol específico
 * @param int $rol_id - ID del rol a verificar
 * @return bool - true si tiene el rol, false si no
 */
function tieneRol($rol_id) {
    if (!estaLogueado()) {
        return false;
    }
    
    return $_SESSION['usuario_rol_id'] == $rol_id;
}

/**
 * Verificar si el usuario es Administrador
 * @return bool - true si es admin, false si no
 */
function esAdmin() {
    return tieneRol(1);
}

/**
 * Verificar si el usuario es Líder
 * @return bool - true si es líder, false si no
 */
function esLider() {
    return tieneRol(2);
}

/**
 * Verificar si el usuario puede acceder (no es Analista ni Programador)
 * @return bool - true si puede acceder, false si no
 */
function puedeAcceder() {
    if (!estaLogueado()) {
        return false;
    }
    
    // Solo Admin (1) y Líder (2) pueden acceder
    return $_SESSION['usuario_rol_id'] == 1 || $_SESSION['usuario_rol_id'] == 2;
}

/**
 * Verificar permisos específicos según la tabla de permisos
 * @param string $seccion - proyectos, empresas, paises, usuarios
 * @param string $accion - ver_listado, editar, cancelar, cargar, etc.
 * @return bool - true si tiene permiso, false si no
 */
function tienePermiso($seccion, $accion) {
    if (!estaLogueado()) {
        return false;
    }
    
    $rol_id = $_SESSION['usuario_rol_id'];
    
    // Admin tiene todos los permisos
    if ($rol_id == 1) {
        return true;
    }
    
    // Líder tiene permisos limitados según la tabla del parcial
    if ($rol_id == 2) {
        $permisos = array(
            'proyectos' => array('ver_listado' => true, 'editar' => false, 'cancelar' => false, 'cargar' => true),
            'empresas' => array('ver_listado' => true, 'editar' => false, 'borrar' => false, 'cargar' => true),
            'paises' => array('ver_listado' => false, 'editar' => false, 'borrar' => false),
            'usuarios' => array('ver_listado' => false, 'editar' => false, 'borrar' => false)
        );
        
        if (isset($permisos[$seccion][$accion])) {
            return $permisos[$seccion][$accion];
        }
    }
    
    return false;
}

/**
 * Cerrar sesión
 */
function cerrarSesion() {
    session_start();
    session_unset();
    session_destroy();
}

/**
 * Iniciar sesión de usuario
 * @param array $usuario_datos - Datos del usuario
 */
function iniciarSesion($usuario_datos) {
    $_SESSION['usuario_id'] = $usuario_datos['Id'];
    $_SESSION['usuario_nombre'] = $usuario_datos['Nombre'];
    $_SESSION['usuario_apellido'] = $usuario_datos['Apellido'];
    $_SESSION['usuario_login'] = $usuario_datos['Usuario'];
    $_SESSION['usuario_foto'] = $usuario_datos['Foto'];
    $_SESSION['usuario_rol_id'] = $usuario_datos['Id_Rol'];
    $_SESSION['usuario_rol_nombre'] = $usuario_datos['Denominacion'];
}
?>