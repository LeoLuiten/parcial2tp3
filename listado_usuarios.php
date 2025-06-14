<?php
/**
 * Listado de usuarios del sistema
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común (control de acceso incluido)
include 'includes/header.php';

// Solo admin puede ver usuarios
if (!esAdmin()) {
    header("Location: index.php");
    exit();
}

// Consulta para obtener usuarios con sus roles
$consulta = "SELECT u.Id, u.Nombre, u.Apellido, u.Usuario, u.Foto, r.Denominacion as Rol_Nombre
             FROM usuarios u 
             INNER JOIN roles r ON u.Id_Rol = r.Id 
             ORDER BY u.Apellido, u.Nombre";

$usuarios = ejecutarConsulta($consulta);
?>

<main class="content">
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3"><strong>Usuarios</strong> Listado general.</h1>
        <div class="row">
            <div class="col-12 col-lg-12 col-xxl-12 d-flex">
                <div class="card flex-fill">
                    
                    <table class="table table-hover my-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Apellido y Nombre</th>
                                <th>Rol</th>
                                <th>Usuario</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($usuarios && count($usuarios) > 0): ?>
                                <?php foreach ($usuarios as $index => $usuario): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td>
                                        <img src="img/avatars/<?php echo $usuario['Foto']; ?>" width="36" height="36" class="rounded-circle me-2" alt="<?php echo $usuario['Foto']; ?>">
                                        <?php echo $usuario['Apellido'] . ' ' . $usuario['Nombre']; ?>
                                    </td>
                                    <td><?php echo $usuario['Rol_Nombre']; ?></td>
                                    <td><?php echo $usuario['Usuario']; ?></td>
                                    <td>
                                        <a class="btn btn-primary btn-sm success" href="editar_usuario.php?id=<?php echo $usuario['Id']; ?>">
                                            <span data-feather="edit"></span> Editar
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="borrar_usuario.php?id=<?php echo $usuario['Id']; ?>" 
                                           onclick="return confirm('¿Estás seguro de borrar este usuario?')">
                                            <span data-feather="delete"></span> Borrar
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No hay usuarios registrados</td>
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