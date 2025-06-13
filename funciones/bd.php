<?php
/**
 * Funciones para manejo de base de datos
 * Segundo Desempeño - Técnicas de Programación 3
 */

/**
 * Ejecutar una consulta SELECT y devolver resultados
 * @param string $consulta - La consulta SQL
 * @return array|false - Array de resultados o false si hay error
 */
function ejecutarConsulta($consulta) {
    global $conexion;
    
    $resultado = mysqli_query($conexion, $consulta);
    
    if (!$resultado) {
        return false;
    }
    
    $datos = array();
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $datos[] = $fila;
    }
    
    return $datos;
}

/**
 * Ejecutar una consulta INSERT, UPDATE o DELETE
 * @param string $consulta - La consulta SQL
 * @return bool - true si se ejecutó correctamente, false si hubo error
 */
function ejecutarComando($consulta) {
    global $conexion;
    
    $resultado = mysqli_query($conexion, $consulta);
    
    return $resultado ? true : false;
}

/**
 * Obtener el último ID insertado
 * @return int - El último ID insertado
 */
function obtenerUltimoId() {
    global $conexion;
    return mysqli_insert_id($conexion);
}

/**
 * Escapar cadenas para evitar inyección SQL
 * @param string $cadena - La cadena a escapar
 * @return string - La cadena escapada
 */
function escaparCadena($cadena) {
    global $conexion;
    return mysqli_real_escape_string($conexion, $cadena);
}

/**
 * Obtener una sola fila de resultado
 * @param string $consulta - La consulta SQL
 * @return array|false - Array con la fila o false si no hay resultados
 */
function obtenerFila($consulta) {
    global $conexion;
    
    $resultado = mysqli_query($conexion, $consulta);
    
    if (!$resultado) {
        return false;
    }
    
    return mysqli_fetch_assoc($resultado);
}

/**
 * Contar el número de filas de un resultado
 * @param string $consulta - La consulta SQL
 * @return int - Número de filas
 */
function contarFilas($consulta) {
    global $conexion;
    
    $resultado = mysqli_query($conexion, $consulta);
    
    if (!$resultado) {
        return 0;
    }
    
    return mysqli_num_rows($resultado);
}
?>