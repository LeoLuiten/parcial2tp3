<?php
/**
 * Formulario para cargar nuevos proyectos
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común
include 'includes/header.php';

// Verificar permisos (Admin o Líder pueden cargar proyectos)
if (!tienePermiso('proyectos', 'cargar')) {
    header("Location: index.php");
    exit();
}

// Variables para mensajes y datos
$mensaje = '';
$tipo_mensaje = '';
$denominacion = '';
$empresa_id = '';
$lider_id = '';
$observaciones = '';
$prioridad = 0;

// Procesar formulario si se envió
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $denominacion = isset($_POST['denominacion']) ? trim($_POST['denominacion']) : '';
    $empresa_id = isset($_POST['empresa_id']) ? (int)$_POST['empresa_id'] : 0;
    $lider_id = isset($_POST['lider_id']) ? (int)$_POST['lider_id'] : 0;
    $observaciones = isset($_POST['observaciones']) ? trim($_POST['observaciones']) : '';
    $prioridad = isset($_POST['prioridad']) ? 1 : 0;
    
    // Validaciones
    $errores = array();
    
    if (empty($denominacion)) {
        $errores[] = "La denominación es obligatoria";
    }
    
    if ($empresa_id <= 0) {
        $errores[] = "Debe seleccionar una empresa";
    }
    
    if ($lider_id <= 0) {
        $errores[] = "Debe seleccionar un líder";
    }
    
    // Si no hay errores, insertar en BD
    if (empty($errores)) {
        $denominacion_escapada = escaparCadena($denominacion);
        $observaciones_escapadas = escaparCadena($observaciones);
        $fecha_actual = date('Y-m-d');
        $usuario_actual = $usuario['id'];
        
        $consulta_insertar = "INSERT INTO proyectos 
                             (Denominacion, Id_Empresa, Id_Lider, Observaciones, Prioridad, Id_Estado, Fecha_Carga, Id_Usuario_Carga) 
                             VALUES 
                             ('$denominacion_escapada', $empresa_id, $lider_id, '$observaciones_escapadas', $prioridad, 1, '$fecha_actual', $usuario_actual)";
        
        if (ejecutarComando($consulta_insertar)) {
            $mensaje = "Registro cargado correctamente.";
            $tipo_mensaje = "success";
            // Limpiar formulario
            $denominacion = '';
            $empresa_id = '';
            $lider_id = '';
            $observaciones = '';
            $prioridad = 0;
        } else {
            $mensaje = "No se pudo guardar el proyecto.";
            $tipo_mensaje = "danger";
        }
    } else {
        $mensaje = implode("<br>", $errores);
        $tipo_mensaje = "danger";
    }
}

// Obtener empresas para el selector (ordenadas alfabéticamente)
$consulta_empresas = "SELECT Id, Denominacion FROM empresas ORDER BY Denominacion";
$empresas = ejecutarConsulta($consulta_empresas);

// Obtener líderes para el selector (usuarios con rol Líder, ordenados alfabéticamente)
$consulta_lideres = "SELECT u.Id, CONCAT(u.Apellido, ', ', u.Nombre) as Nombre_Completo 
                     FROM usuarios u 
                     WHERE u.Id_Rol = 2 
                     ORDER BY u.Apellido, u.Nombre";
$lideres = ejecutarConsulta($consulta_lideres);
?>

<main class="content">
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 mb-3"><strong>Proyectos</strong> Cargar nuevo.</h1>
        </div>
        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="card">
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
                    
                    <form method="POST" action="">
                        <div class="card-body">
                            <h5 class="card-title mb-0">Denominación <i class="align-middle me-2" data-feather="command"></i></h5>
                            <input type="text" class="form-control" name="denominacion" 
                                   placeholder="Ingresa el nombre del Proyecto" 
                                   value="<?php echo $denominacion; ?>" required>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Empresa <i class="align-middle me-2" data-feather="command"></i></h5>
                            <select class="form-select mb-3" name="empresa_id" required>
                                <option value="">Para quien trabajaremos...</option>
                                <?php if ($empresas): ?>
                                    <?php foreach ($empresas as $empresa): ?>
                                        <option value="<?php echo $empresa['Id']; ?>" 
                                                <?php echo ($empresa_id == $empresa['Id']) ? 'selected' : ''; ?>>
                                            <?php echo $empresa['Denominacion']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Líder <i class="align-middle me-2" data-feather="command"></i></h5>
                            <select class="form-select mb-3" name="lider_id" required>
                                <option value="">Selecciona una opción</option>
                                <?php if ($lideres): ?>
                                    <?php foreach ($lideres as $lider): ?>
                                        <option value="<?php echo $lider['Id']; ?>" 
                                                <?php echo ($lider_id == $lider['Id']) ? 'selected' : ''; ?>>
                                            <?php echo $lider['Nombre_Completo']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title mb-0">Observaciones</h5>
                            <textarea class="form-control" rows="2" name="observaciones" 
                                      placeholder="Observaciones del tema..."><?php echo $observaciones; ?></textarea>
                        </div>
                        
                        <div class="card-body">
                            <label class="form-check">
                                <input class="form-check-input" type="checkbox" name="prioridad" value="1" 
                                       <?php echo ($prioridad == 1) ? 'checked' : ''; ?>>
                                <span class="form-check-label">
                                    Tildar si es solicitado con prioridad
                                </span>
                            </label>
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