<?php
/**
 * Listado de proyectos del sistema
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común
include 'includes/header.php';

// Verificar permisos
if (!tienePermiso('proyectos', 'ver_listado')) {
    header("Location: index.php");
    exit();
}

// Procesar acción de cancelar proyecto
$mensaje = '';
$tipo_mensaje = '';

if (isset($_GET['accion']) && $_GET['accion'] == 'cancelar' && isset($_GET['id'])) {
    $proyecto_id = (int)$_GET['id'];
    
    if ($proyecto_id > 0) {
        // Solo admin puede cancelar proyectos
        if (esAdmin()) {
            $consulta_cancelar = "UPDATE proyectos SET Id_Estado = 4 WHERE Id = $proyecto_id";
            
            if (ejecutarComando($consulta_cancelar)) {
                $mensaje = "Proyecto cancelado correctamente.";
                $tipo_mensaje = "success";
            } else {
                $mensaje = "No se pudo cancelar el proyecto.";
                $tipo_mensaje = "danger";
            }
        } else {
            $mensaje = "No tienes permisos para cancelar proyectos.";
            $tipo_mensaje = "danger";
        }
    }
}

// Consulta para obtener proyectos con todos los datos relacionados
$consulta = "SELECT p.Id, p.Denominacion, p.Fecha_Carga, p.Observaciones, p.Prioridad,
                    e.Denominacion as Empresa_Nombre, 
                    pais.Imagen as Pais_Imagen,
                    est.Denominacion as Estado_Nombre, est.Id as Estado_Id,
                    CONCAT(lider.Apellido, ' ', lider.Nombre) as Lider_Nombre,
                    lider.Foto as Lider_Foto
             FROM proyectos p
             INNER JOIN empresas e ON p.Id_Empresa = e.Id
             INNER JOIN paises pais ON e.Id_Pais = pais.Id
             INNER JOIN estados est ON p.Id_Estado = est.Id
             INNER JOIN usuarios lider ON p.Id_Lider = lider.Id
             ORDER BY p.Prioridad DESC, p.Fecha_Carga ASC"; // Prioridad primero, luego por fecha

$proyectos = ejecutarConsulta($consulta);
$total_proyectos = $proyectos ? count($proyectos) : 0;

// Función para obtener la clase CSS del estado
function obtenerClaseEstado($estado_id) {
    switch ($estado_id) {
        case 1: return 'bg-info';      // Análisis Iniciado
        case 2: return 'bg-warning';   // En Desarrollo  
        case 3: return 'bg-success';   // Terminado
        case 4: return 'bg-danger';    // Cancelado
        default: return 'bg-secondary';
    }
}

// Función para formatear fecha
function formatearFecha($fecha) {
    return date('d/m/Y', strtotime($fecha));
}
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Proyectos</strong> Listado general.</h1>
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <?php if (!empty($mensaje)): ?>
                            <h4 class="text-<?php echo $tipo_mensaje; ?>">
                                <?php if ($tipo_mensaje == 'success'): ?>
                                    <i class="align-middle" data-feather="check-square"></i>
                                <?php else: ?>
                                    <i class="align-middle me-2" data-feather="alert-circle"></i>
                                <?php endif; ?>
                                <?php echo $mensaje; ?>
                            </h4>
                        <?php endif; ?>
                        
                        <h4 class="text-info">Visualizando <?php echo $total_proyectos; ?> registros</h4>
                    </div>

                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Denominación</th>
                                <th class="d-none d-md-table-cell">Fecha Carga</th>
                                <th class="d-none d-md-table-cell">Empresa</th>
                                <th>Estado</th>
                                <th class="d-none d-md-table-cell">Líder</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($proyectos && count($proyectos) > 0): ?>
                                <?php foreach ($proyectos as $index => $proyecto): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <?php if ($proyecto['Prioridad'] == 1): ?>
                                            <span class="badge bg-danger me-2" title="Alta Prioridad">
                                                <i data-feather="alert-triangle" style="width: 12px; height: 12px;"></i> URGENTE
                                            </span>
                                            <br>
                                        <?php endif; ?>
                                        <strong><?php echo $proyecto['Denominacion']; ?></strong>
                                    </td>
                                    <td class="d-none d-md-table-cell"><?php echo formatearFecha($proyecto['Fecha_Carga']); ?></td>
                                    <td class="d-none d-md-table-cell">
                                        <img src="img/countries/<?php echo $proyecto['Pais_Imagen']; ?>" width="36" height="36" class="rounded-circle me-2">
                                        <?php echo $proyecto['Empresa_Nombre']; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?php echo obtenerClaseEstado($proyecto['Estado_Id']); ?>">
                                            <?php echo strtoupper($proyecto['Estado_Nombre']); ?>
                                        </span>
                                    </td>
                                    <td class="d-none d-md-table-cell">
                                        <img src="img/avatars/<?php echo $proyecto['Lider_Foto']; ?>" width="36" height="36" class="rounded-circle me-2">
                                        <?php echo $proyecto['Lider_Nombre']; ?>
                                    </td>
                                    <td>
                                        <?php if (esAdmin()): ?>
                                            <a class="btn btn-primary btn-sm" href="editar_proyecto.php?id=<?php echo $proyecto['Id']; ?>">
                                                <span data-feather="edit"></span> Editar
                                            </a>
                                            <?php if ($proyecto['Estado_Id'] != 4): // Solo si no está cancelado ?>
                                                <a class="btn btn-warning btn-sm" 
                                                   href="?accion=cancelar&id=<?php echo $proyecto['Id']; ?>"
                                                   onclick="return confirm('¿Estás seguro de cancelar este proyecto?')">
                                                    <span data-feather="alert-triangle"></span> Cancelar
                                                </a>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">Solo lectura</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="text-center">No hay proyectos registrados</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
// Incluir footer común
include 'includes/footer.php';
?>