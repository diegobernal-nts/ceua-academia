<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($APP_NAME ?? 'CEUA Academia') ?></title>
    <link rel="icon" type="image/png" href="/public/images/favicon.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link href="/public/assets/css/style.css" rel="stylesheet">
    
    <!-- Estricto Control de Sesión Client-Side -->
    <script>
        if (document.cookie.indexOf('is_logged_in=1') === -1) {
            window.location.replace('/');
        }
    </script>
</head>
<body class="bg-light">

<?php 
$currentUri = parse_url($_SERVER['REQUEST_URI'] ?? '/dashboard', PHP_URL_PATH);
?>
<div class="d-flex flex-column flex-md-row min-vh-100">
    
    <!-- Sidebar (PC) -->
    <aside class="d-none d-md-flex flex-column p-3 text-white bg-dark" style="width: 280px;">
        <a href="/dashboard" class="d-flex justify-content-center align-items-center mb-3 mb-md-0 w-100 text-white text-decoration-none">
            <img src="/public/images/ceua_academia_blanco.png" alt="CEUA Academia" style="max-height: 70px; width: auto;">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto gap-2">
            <li class="nav-item">
                <a href="/dashboard" class="nav-link <?= ($currentUri === '/dashboard' || $currentUri === '/') ? 'active' : 'text-white' ?>" aria-current="page">
                    <i class="bi bi-house-door me-2"></i> Inicio
                </a>
            </li>
            <li>
                <a href="/estudiantes" class="nav-link <?= (strpos($currentUri, '/estudiantes') === 0) ? 'active' : 'text-white' ?>">
                    <i class="bi bi-people me-2"></i> Estudiantes
                </a>
            </li>
            <li>
                <a href="/catalogos" class="nav-link <?= (strpos($currentUri, '/catalogos') === 0) ? 'active' : 'text-white' ?>">
                    <i class="bi bi-journal-bookmark me-2"></i> Catálogos
                </a>
            </li>
            <li>
                <a href="#" class="nav-link text-white">
                    <i class="bi bi-gear me-2"></i> Configuración
                </a>
            </li>
        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle fs-4 me-2"></i>
                <strong><?= htmlspecialchars($user['email'] ?? 'Usuario') ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                <li><a class="dropdown-item" href="#">Perfil</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="/logout">Cerrar Sesión</a></li>
            </ul>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-grow-1 p-4 pb-5 pb-md-4">
        <?= $content ?>
    </main>

    <!-- Bottom Navigation (Mobile) -->
    <nav class="d-md-none fixed-bottom bg-white border-top pb-safe">
        <div class="d-flex justify-content-around py-2">
            <a href="/dashboard" class="text-center text-decoration-none d-flex flex-column align-items-center w-100 <?= ($currentUri === '/dashboard' || $currentUri === '/') ? 'text-primary' : 'text-secondary' ?>">
                <i class="bi bi-house-door-fill fs-4"></i>
                <span style="font-size: 0.75rem;">Inicio</span>
            </a>
            <a href="/estudiantes" class="text-center text-decoration-none d-flex flex-column align-items-center w-100 <?= (strpos($currentUri, '/estudiantes') === 0) ? 'text-primary' : 'text-secondary' ?>">
                <i class="bi bi-people fs-4"></i>
                <span style="font-size: 0.75rem;">Estudiantes</span>
            </a>
            <a href="#" class="text-center text-decoration-none text-secondary d-flex flex-column align-items-center w-100">
                <i class="bi bi-journal-bookmark fs-4"></i>
                <span style="font-size: 0.75rem;">Programas</span>
            </a>
            <a href="#" class="text-center text-decoration-none text-secondary d-flex flex-column align-items-center w-100" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-4"></i>
                <span style="font-size: 0.75rem;">Más</span>
            </a>
        </div>
    </nav>
</div>

<!-- Offcanvas Mobile Menu (For the "Más" option) -->
<div class="offcanvas offcanvas-bottom rounded-top-4 h-auto" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header border-bottom">
    <h5 class="offcanvas-title fw-bold" id="mobileMenuLabel">Opciones</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="list-group list-group-flush">
        <a href="#" class="list-group-item list-group-item-action py-3"><i class="bi bi-gear me-3 text-secondary"></i>Configuración</a>
        <a href="#" class="list-group-item list-group-item-action py-3"><i class="bi bi-person me-3 text-secondary"></i>Perfil</a>
        <a href="/logout" class="list-group-item list-group-item-action py-3 text-danger"><i class="bi bi-box-arrow-right me-3"></i>Cerrar Sesión</a>
    </div>
  </div>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
