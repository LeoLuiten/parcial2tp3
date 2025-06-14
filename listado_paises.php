<?php
/**
 * Listado de países del sistema
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común
include 'includes/header.php';

// Solo administradores pueden ver países
if (!esAdmin()) {
    header("Location: index.php");
    exit();
}

// Consulta para obtener países
$consulta = "SELECT Id, Denominacion, Imagen FROM paises ORDER BY Denominacion";
$paises = ejecutarConsulta($consulta);
$total_paises = $paises ? count($paises) : 0;
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Países con que trabajamos.</strong> Listado general.</h1>
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-header">
                        <h4 class="text-info">Visualizando <?php echo $total_paises; ?> registros</h4>
                        <hr />
                    </div>

                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Denominación</th>
                                <th class="d-none d-md-table-cell">País</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($paises && count($paises) > 0): ?>
                                <?php foreach ($paises as $index => $pais): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($pais['Denominacion']); ?></td>
                                    <td class="d-none d-md-table-cell">
                                        <img src="img/countries/<?php echo $pais['Imagen']; ?>" 
                                             width="36" height="36" class="rounded-circle me-2" 
                                             alt="<?php echo $pais['Imagen']; ?>">
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm success" 
                                           href="editar_pais.php?id=<?php echo $pais['Id']; ?>">
                                            <span data-feather="edit"></span> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm" 
                                           href="borrar_pais.php?id=<?php echo $pais['Id']; ?>"
                                           onclick="return confirm('¿Estás seguro de borrar este país?')">
                                            <span data-feather="delete"></span> Borrar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay países registrados</td>
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