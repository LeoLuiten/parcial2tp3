<?php
/**
 * Página de login
 * Segundo Desempeño - Técnicas de Programación 3
 */

// Iniciar sesión para manejar mensajes
session_start();

// Si ya está logueado, redirigir al panel
if (isset($_SESSION['usuario_id'])) {
    header("Location: index.php");
    exit();
}

// Variables para mensajes
$mensaje_error = '';
$mensaje_permisos = '';

// Verificar si hay mensajes de error
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'datos_incorrectos':
            $mensaje_error = 'Datos incorrectos, intenta de nuevo.';
            break;
        case 'sin_permisos':
            $mensaje_permisos = 'No tienes permisos asignados para ingresar al panel';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="img/icons/icon-48x48.png" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>Sign In | AdminKit Demo</title>

    <link href="css/app.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-3">
                                    <div class="text-center mt-4">
                                        <p class="lead">
                                            <img src="img/avatars/login.png" width="150" height="150">
                                        <h1 class="h2">Ingresa tus datos.</h1>
                                        </p>
                                    </div>
                                    
                                    <div class="card-header">
                                        <?php if (!empty($mensaje_error)): ?>
                                        <h4 class="text-danger"><?php echo $mensaje_error; ?></h4>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($mensaje_permisos)): ?>
                                        <h4 class="text-danger"><?php echo $mensaje_permisos; ?></h4>
                                        <?php endif; ?>
                                    </div>

                                    <form method="POST" action="validar.php">
                                        <div class="mb-3">
                                            <label class="form-label">Login</label>
                                            <input class="form-control form-control-lg" 
                                                   name="usuario" 
                                                   type="text" 
                                                   placeholder="Ingresa tu email o usuario" 
                                                   required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input class="form-control form-control-lg" 
                                                   name="password" 
                                                   type="password" 
                                                   placeholder="Ingresa tu password" 
                                                   required />
                                        </div>
                                        <div class="d-grid gap-2 mt-3">
                                            <button class="btn btn-lg btn-primary" type="submit">Ingresar</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="js/app.js"></script>

</body>

</html>