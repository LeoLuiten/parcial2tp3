<?php
/**
 * Listado de empresas del sistema
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común
include 'includes/header.php';

// Verificar permisos
if (!tienePermiso('empresas', 'ver_listado')) {
    header("Location: index.php");
    exit();
}

// Consulta para obtener empresas con datos relacionados (ordenadas por denominación)
$consulta = "SELECT e.Id, e.Denominacion, e.Fecha_Carga, e.Observaciones,
                    p.Denominacion as Pais_Nombre, p.Imagen as Pais_Imagen,
                    CONCAT(u.Nombre, ' ', u.Apellido) as Usuario_Nombre,
                    u.Foto as Usuario_Foto
             FROM empresas e
             INNER JOIN paises p ON e.Id_Pais = p.Id
             INNER JOIN usuarios u ON e.Id_Usuario_Carga = u.Id
             ORDER BY e.Denominacion ASC";

$empresas = ejecutarConsulta($consulta);
$total_empresas = $empresas ? count($empresas) : 0;

// Función para formatear fecha
function formatearFecha($fecha) {
    return date('d/m/Y', strtotime($fecha));
}
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Empresas</strong> Listado general.</h1>
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h4 class="text-info">Visualizando <?php echo $total_empresas; ?> registros</h4>
                        <hr />
                    </div>

                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Denominación</th>
                                <th>Fecha de carga</th>
                                <th>Cargada por</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($empresas && count($empresas) > 0): ?>
                                <?php foreach ($empresas as $index => $empresa): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <img src="img/countries/<?php echo $empresa['Pais_Imagen']; ?>" 
                                             width="36" height="36" class="rounded-circle me-2" 
                                             alt="<?php echo $empresa['Pais_Imagen']; ?>" 
                                             title="<?php echo $empresa['Pais_Nombre']; ?>">
                                        <?php echo htmlspecialchars($empresa['Denominacion']); ?>
                                    </td>
                                    <td>
                                        <?php echo formatearFecha($empresa['Fecha_Carga']); ?>
                                    </td>
                                    <td>
                                        <img src="img/avatars/<?php echo $empresa['Usuario_Foto']; ?>" 
                                             width="36" height="36" class="rounded-circle me-2" 
                                             alt="<?php echo $empresa['Usuario_Foto']; ?>">
                                        <?php echo htmlspecialchars($empresa['Usuario_Nombre']); ?>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm success" 
                                           href="editar_empresa.php?id=<?php echo $empresa['Id']; ?>">
                                            <span data-feather="edit"></span> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm" 
                                           href="borrar_empresa.php?id=<?php echo $empresa['Id']; ?>"
                                           onclick="return confirm('¿Estás seguro de borrar esta empresa?')">
                                            <span data-feather="delete"></span> Borrar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay empresas registradas</td>
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