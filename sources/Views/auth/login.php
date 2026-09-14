<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-12 col-md-8 col-lg-5">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <img src="/public/images/ceua_academia_blanco.png" alt="CEUA Academia" class="img-fluid mb-2" style="max-height: 80px; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.3));">
                        <p class="text-muted">Inicio de sesión</p>
                    </div>
                    
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    
                    <form id="loginForm" method="POST" action="/login">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="nombre@ejemplo.com" required>
                            <label for="email">Correo electrónico</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" required>
                            <label for="password">Contraseña</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
