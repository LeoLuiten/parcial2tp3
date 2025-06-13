<?php
/**
 * Menú lateral con control de permisos
 * Segundo Desempeño - Técnicas de Programación 3
 */
?>
<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.php">
            <span class="align-middle">AdminKit</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Proyectos
            </li>

            <?php if (tienePermiso('proyectos', 'ver_listado')): ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="listado_proyectos.php">
                    <i class="align-middle me-2" data-feather="list"></i> <span class="align-middle">Listado</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (tienePermiso('proyectos', 'cargar')): ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="carga_proyecto.php">
                    <i class="align-middle me-2" data-feather="file"></i><span class="align-middle">Cargar nuevo</span>
                </a>
            </li>
            <?php endif; ?>

            <li class="sidebar-header">
                Empresas
            </li>
            
            <?php if (tienePermiso('empresas', 'ver_listado')): ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="listado_empresas.php">
                    <i class="align-middle me-2" data-feather="award"></i> <span class="align-middle">Listado</span>
                </a>
            </li>
            <?php endif; ?>
            
            <?php if (tienePermiso('empresas', 'cargar')): ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="carga_empresa.php">
                    <i class="align-middle me-2" data-feather="file"></i><span class="align-middle">Cargar nueva</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (esAdmin()): ?>
            <li class="sidebar-item">
                <a class="sidebar-link" href="listado_paises.php">
                    <i class="align-middle me-2" data-feather="map-pin"></i><span class="align-middle">Listado de países</span>
                </a>
            </li>
            <?php endif; ?>

            <?php if (esAdmin()): ?>
            <li class="sidebar-header">
                Personal
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="listado_usuarios.php">
                    <i class="align-middle me-2" data-feather="user"></i><span class="align-middle">Listado de usuarios</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>