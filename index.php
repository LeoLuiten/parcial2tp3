<?php
/**
 * Dashboard principal del panel de administración
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Incluir header común (ya incluye control de acceso)
include 'includes/header.php';
?>

<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Has ingresado al panel de administración.</h1>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Elige tu opción desde el menú.</h5>
                    </div>
                    <div class="card-body">
                        <p>Bienvenido/a <strong><?php echo $usuario['nombre'] . ' ' . $usuario['apellido']; ?></strong></p>
                        <p>Tu rol es: <strong><?php echo $usuario['rol_nombre']; ?></strong></p>
                        
                        <?php if (esAdmin()): ?>
                        <div class="alert alert-info">
                            <h6>Como Administrador tienes acceso completo a todas las funciones del sistema:</h6>
                            <ul>
                                <li>Gestión completa de proyectos</li>
                                <li>Gestión completa de empresas</li>
                                <li>Visualización de países</li>
                                <li>Gestión de usuarios</li>
                            </ul>
                        </div>
                        <?php elseif (esLider()): ?>
                        <div class="alert alert-warning">
                            <h6>Como Líder tienes acceso a:</h6>
                            <ul>
                                <li>Ver listado de proyectos</li>
                                <li>Cargar nuevos proyectos</li>
                                <li>Ver listado de empresas</li>
                                <li>Cargar nuevas empresas</li>
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

<?php
// Incluir footer común
include 'includes/footer.php';
?>