<?php
/**
 * Formulario para cargar nuevas empresas
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común
include 'includes/header.php';

// Verificar permisos (Admin o Líder pueden cargar empresas)
if (!tienePermiso('empresas', 'cargar')) {
    header("Location: index.php");
    exit();
}

// Variables para mensajes y datos del formulario
$mensaje = '';
$tipo_mensaje = '';
$denominacion = '';
$pais_id = '';
$observaciones = '';

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $denominacion = isset($_POST['denominacion']) ? trim($_POST['denominacion']) : '';
    $pais_id = isset($_POST['pais_id']) ? (int)$_POST['pais_id'] : 0;
    $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';
    
    // Validaciones
    $errores = array();
    
    if (empty($denominacion)) {
        $errores[] = "La denominación es obligatoria";
    }
    
    if ($pais_id <= 0) {
        $errores[] = "Debe seleccionar un país";
    }
    
    // Si no hay errores, insertar en BD
    if (empty($errores)) {
        $denominacion_escapada = escaparCadena($denominacion);
        $observaciones_escapadas = escaparCadena($observaciones);
        $fecha_actual = date('Y-m-d');
        $usuario_actual = $usuario['id'];
        
        $consulta_insertar = "INSERT INTO empresas 
                             (Denominacion, Id_Pais, Observaciones, Fecha_Carga, Id_Usuario_Carga) 
                             VALUES 
                             ('$denominacion_escapada', $pais_id, '$observaciones_escapadas', '$fecha_actual', $usuario_actual)";
        
        if (ejecutarComando($consulta_insertar)) {
            $mensaje = "Registro cargado correctamente.";
            $tipo_mensaje = "success";
            // Limpiar formulario
            $denominacion = '';
            $pais_id = '';
            $observaciones = '';
        } else {
            $mensaje = "No se pudo guardar la empresa.";
            $tipo_mensaje = "danger";
        }
    } else {
        $mensaje = implode("<br>", $errores);
        $tipo_mensaje = "danger";
    }
}

// Obtener países para el selector (ordenados alfabéticamente)
$consulta_paises = "SELECT Id, Denominacion FROM paises ORDER BY Denominacion";
$paises = ejecutarConsulta($consulta_paises);
?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Cargar Nueva Empresa</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card-header">
                    <?php if (!empty($mensaje)): ?>
                        <?php if ($tipo_mensaje == 'success'): ?>
                            <h4 class="text-success">
                                <i class="align-middle" data-feather="check-square"></i> <?php echo $mensaje; ?>
                            </h4>
                        <?php else: ?>
                            <h4 class="text-danger">
                                <i class="align-middle me-2" data-feather="alert-circle"></i> <?php echo $mensaje; ?>
                            </h4>
                        <?php endif; ?>
                    <?php else: ?>
                        <h4 class="text-info">
                            Los campos con <i class="align-middle me-2" data-feather="command"></i> son obligatorios
                        </h4>
                    <?php endif; ?>
                </div>

                <div class="card">
                    <form method="POST" action="">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Denominación <i class="align-middle me-2" data-feather="command"></i></h5>
                            <input type="text" class="form-control" name="denominacion" 
                                   placeholder="Ingresa el nombre" 
                                   value="<?php echo $denominacion; ?>" required>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">País <i class="align-middle me-2" data-feather="command"></i></h5>
                            <select class="form-select mb-3" name="pais_id" required>
                                <option value="">Elige una opción</option>
                                <?php if ($paises): ?>
                                    <?php foreach ($paises as $pais): ?>
                                        <option value="<?php echo $pais['Id']; ?>" 
                                                <?php echo ($pais_id == $pais['Id']) ? 'selected' : ''; ?>>
                                            <?php echo $pais['Denominacion']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Observaciones</h5>
                            <textarea class="form-control" rows="2" name="observaciones" 
                                      placeholder="Comentarios generales..."><?php echo $observaciones; ?></textarea>
                        </div>

                        <div class="card-body">
                            <button type="submit" class="btn btn-primary">Registrar Datos</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Incluir footer común
include 'includes/footer.php';
?>