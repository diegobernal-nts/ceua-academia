<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Bienvenido, <?= htmlspecialchars(explode('@', $user['email'] ?? '')[0]) ?></h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Reportes</button>
        </div>
    </div>
</div>

<!-- KPIs -->
<div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-4">
    <!-- Estudiantes -->
    <div class="col">
        <div class="card glow-card h-100 shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title text-primary"><i class="bi bi-people me-2"></i>Total Estudiantes</h6>
                <p class="card-text display-5 fw-bold"><?= number_format($kpis['totales']['estudiantes']) ?></p>
            </div>
        </div>
    </div>
    <!-- Programas -->
    <div class="col">
        <div class="card glow-card h-100 shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title text-success"><i class="bi bi-journal-bookmark me-2"></i>Programas Activos</h6>
                <p class="card-text display-5 fw-bold"><?= number_format($kpis['totales']['programas']) ?></p>
            </div>
        </div>
    </div>
    <!-- Centros -->
    <div class="col">
        <div class="card glow-card h-100 shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title text-warning"><i class="bi bi-building me-2"></i>Centros de Asesoría</h6>
                <p class="card-text display-5 fw-bold"><?= number_format($kpis['totales']['centros']) ?></p>
            </div>
        </div>
    </div>
    <!-- Generación -->
    <div class="col">
        <div class="card glow-card h-100 shadow-sm border-0">
            <div class="card-body">
                <h6 class="card-title text-info"><i class="bi bi-calendar-event me-2"></i>Última Generación</h6>
                <p class="card-text fs-4 fw-bold mt-3"><?= htmlspecialchars($kpis['totales']['ultima_generacion']) ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Gráficos -->
<div class="row g-4 mb-4">
    <!-- Gráfico por Centro -->
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 py-2">Estudiantes por Centro de Asesoría</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <?php if (empty($kpis['graficos']['por_centro'])): ?>
                    <p class="text-muted">No hay datos suficientes.</p>
                <?php else: ?>
                    <canvas id="chartCentro" style="max-height: 250px;"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Gráfico por Estatus -->
    <div class="col-12 col-lg-6">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 py-2">Estudiantes por Estatus</h6>
            </div>
            <div class="card-body d-flex justify-content-center align-items-center" style="min-height: 300px;">
                <?php if (empty($kpis['graficos']['por_estatus'])): ?>
                    <p class="text-muted">No hay datos suficientes.</p>
                <?php else: ?>
                    <canvas id="chartEstatus" style="max-height: 250px;"></canvas>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // Configuración global de Chart.js para Dark Theme
    Chart.defaults.color = '#717777'; // Texto secundario
    Chart.defaults.font.family = "'Inter', sans-serif";
    
    // Paleta de colores para las gráficas
    const palette = [
        '#2AA4E4', // Acento
        '#0326AD', // Acento Profundo
        '#EF4444', // Alerta
        '#10B981', // Verde success (tailwind base)
        '#F59E0B', // Naranja warning
        '#8B5CF6'  // Morado
    ];

    // Data PHP a JS - Por Centro
    const dataCentro = <?= json_encode($kpis['graficos']['por_centro']) ?>;
    if (dataCentro && dataCentro.length > 0 && document.getElementById('chartCentro')) {
        const ctxCentro = document.getElementById('chartCentro').getContext('2d');
        new Chart(ctxCentro, {
            type: 'doughnut',
            data: {
                labels: dataCentro.map(item => item.nombre || 'No Asignado'),
                datasets: [{
                    data: dataCentro.map(item => item.total),
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                },
                cutout: '70%' // Hace la dona más delgada y elegante
            }
        });
    }

    // Data PHP a JS - Por Estatus
    const dataEstatus = <?= json_encode($kpis['graficos']['por_estatus']) ?>;
    if (dataEstatus && dataEstatus.length > 0 && document.getElementById('chartEstatus')) {
        const ctxEstatus = document.getElementById('chartEstatus').getContext('2d');
        new Chart(ctxEstatus, {
            type: 'pie',
            data: {
                labels: dataEstatus.map(item => item.estatus || 'DESCONOCIDO'),
                datasets: [{
                    data: dataEstatus.map(item => item.total),
                    backgroundColor: palette,
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'right' }
                }
            }
        });
    }
});
</script>
