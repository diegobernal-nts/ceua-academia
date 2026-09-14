<div class="container-fluid px-4 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0 text-primary"><i class="bi bi-journal-bookmark me-2"></i>Catálogos del Sistema</h2>
    </div>

    <div class="card bg-dark shadow-sm border-secondary rounded-4">
        <div class="card-header bg-dark border-0 pt-4 pb-0 px-4">
            <ul class="nav nav-tabs card-header-tabs" id="catalogosTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-white" id="programas-tab" data-bs-toggle="tab" data-bs-target="#programas" type="button" role="tab" aria-controls="programas" aria-selected="true">
                        <i class="bi bi-book me-2"></i>Programas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-muted" id="centros-tab" data-bs-toggle="tab" data-bs-target="#centros" type="button" role="tab" aria-controls="centros" aria-selected="false">
                        <i class="bi bi-building me-2"></i>Centros de Asesoría
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-bold text-muted" id="generaciones-tab" data-bs-toggle="tab" data-bs-target="#generaciones" type="button" role="tab" aria-controls="generaciones" aria-selected="false">
                        <i class="bi bi-calendar-event me-2"></i>Generaciones
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body p-4">
            <div class="tab-content" id="catalogosTabsContent">
                
                <!-- Tab Programas -->
                <div class="tab-pane fade show active" id="programas" role="tabpanel" aria-labelledby="programas-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0">Programas de Estudio Activos</h5>
                        <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalAgregarPrograma"><i class="bi bi-plus-lg me-1"></i>Nuevo</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Programa</th>
                                    <th>Nivel Académico</th>
                                    <th>RVOE</th>
                                    <th>Estatus</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($programas)): ?>
                                    <tr><td colspan="6" class="text-center text-muted py-4">No hay programas registrados.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($programas as $p): ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $p['id'] ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($p['nombre']) ?></td>
                                        <td><?= htmlspecialchars($p['nivel']) ?></td>
                                        <td><?= htmlspecialchars($p['rvoe'] ?? 'N/A') ?></td>
                                        <td><span class="badge bg-success">ACTIVO</span></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-info me-1 btn-edit-programa" data-id="<?= $p['id'] ?>" data-nombre="<?= htmlspecialchars($p['nombre']) ?>" data-nivel="<?= htmlspecialchars($p['nivel']) ?>" data-rvoe="<?= htmlspecialchars($p['rvoe'] ?? '') ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger btn-delete-programa" data-id="<?= $p['id'] ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Centros -->
                <div class="tab-pane fade" id="centros" role="tabpanel" aria-labelledby="centros-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0">Centros de Asesoría Activos</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Centro</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($centros)): ?>
                                    <tr><td colspan="3" class="text-center text-muted py-4">No hay centros registrados.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($centros as $c): ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $c['id'] ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($c['nombre']) ?></td>
                                        <td><span class="badge bg-success">ACTIVO</span></td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Generaciones -->
                <div class="tab-pane fade" id="generaciones" role="tabpanel" aria-labelledby="generaciones-tab">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-white mb-0">Catálogo de Generaciones</h5>
                        <button class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalAgregarGeneracion"><i class="bi bi-plus-lg me-1"></i>Nuevo</button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Año Inicio</th>
                                    <th>Año Término</th>
                                    <th class="text-end">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($generaciones)): ?>
                                    <tr><td colspan="6" class="text-center text-muted py-4">No hay generaciones registradas.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($generaciones as $g): ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $g['id'] ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($g['nombre']) ?></td>
                                        <td><?= htmlspecialchars($g['descripcion']) ?></td>
                                        <td><?= htmlspecialchars($g['anio_inicio']) ?></td>
                                        <td><?= htmlspecialchars($g['anio_termino']) ?></td>
                                        <td class="text-end">
                                            <button class="btn btn-sm btn-outline-info me-1 btn-edit-generacion" data-id="<?= $g['id'] ?>" data-nombre="<?= htmlspecialchars($g['nombre']) ?>" data-descripcion="<?= htmlspecialchars($g['descripcion']) ?>" data-anio-inicio="<?= htmlspecialchars($g['anio_inicio']) ?>" data-anio-termino="<?= htmlspecialchars($g['anio_termino']) ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button class="btn btn-sm btn-outline-danger btn-delete-generacion" data-id="<?= $g['id'] ?>"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Pequeño script para manejar el color de las pestañas inactivas/activas
    document.addEventListener('DOMContentLoaded', function() {
        const triggerTabList = [].slice.call(document.querySelectorAll('#catalogosTabs button'))
        triggerTabList.forEach(function (triggerEl) {
            triggerEl.addEventListener('click', function (event) {
                // Remove text-white from all, add text-muted
                triggerTabList.forEach(btn => {
                    btn.classList.remove('text-white');
                    btn.classList.add('text-muted');
                });
                // Add text-white to active
                event.target.classList.remove('text-muted');
                event.target.classList.add('text-white');
            })
        })
    });
</script>

<!-- Modal Agregar Programa -->
<div class="modal fade" id="modalAgregarPrograma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Nuevo Programa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarPrograma">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Nombre del Programa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addProgNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Nivel Académico <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" id="addProgNivel" name="nivel" required>
                            <option value="LICENCIATURA">LICENCIATURA</option>
                            <option value="MAESTRÍA">MAESTRÍA</option>
                            <option value="DOCTORADO">DOCTORADO</option>
                            <option value="DIPLOMADO">DIPLOMADO</option>
                            <option value="ESPECIALIDAD">ESPECIALIDAD</option>
                            <option value="CURSO">CURSO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">RVOE</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addProgRvoe" name="rvoe" placeholder="Opcional">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnCrearProg"><i class="bi bi-check-circle me-1"></i> Crear Programa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Programa -->
<div class="modal fade" id="modalEditarPrograma" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Programa</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarPrograma">
                <div class="modal-body">
                    <input type="hidden" id="editProgId" name="id">
                    <div class="mb-3">
                        <label class="form-label small">Nombre del Programa <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editProgNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Nivel Académico <span class="text-danger">*</span></label>
                        <select class="form-select bg-dark text-white border-secondary" id="editProgNivel" name="nivel" required>
                            <option value="LICENCIATURA">LICENCIATURA</option>
                            <option value="MAESTRÍA">MAESTRÍA</option>
                            <option value="DOCTORADO">DOCTORADO</option>
                            <option value="DIPLOMADO">DIPLOMADO</option>
                            <option value="ESPECIALIDAD">ESPECIALIDAD</option>
                            <option value="CURSO">CURSO</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">RVOE</label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editProgRvoe" name="rvoe" placeholder="Opcional">
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarProg"><i class="bi bi-save me-1"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Agregar Generación -->
<div class="modal fade" id="modalAgregarGeneracion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Nueva Generación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAgregarGeneracion">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addGenNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="addGenDescripcion" name="descripcion" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small">Año Inicio <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="addGenAnioInicio" name="anio_inicio" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Año Término <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="addGenAnioTermino" name="anio_termino" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnCrearGen"><i class="bi bi-check-circle me-1"></i> Crear Generación</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Generación -->
<div class="modal fade" id="modalEditarGeneracion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Generación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditarGeneracion">
                <div class="modal-body">
                    <input type="hidden" id="editGenId" name="id">
                    <div class="mb-3">
                        <label class="form-label small">Nombre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editGenNombre" name="nombre" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small">Descripción <span class="text-danger">*</span></label>
                        <input type="text" class="form-control bg-dark text-white border-secondary" id="editGenDescripcion" name="descripcion" required>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small">Año Inicio <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="editGenAnioInicio" name="anio_inicio" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small">Año Término <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-dark text-white border-secondary" id="editGenAnioTermino" name="anio_termino" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarGen"><i class="bi bi-save me-1"></i> Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // --- PROGRAMAS ---
    
    // Agregar
    document.getElementById('formAgregarPrograma').addEventListener('submit', function(e) {
        e.preventDefault();
        const nombre = document.getElementById('addProgNombre').value;
        const nivel = document.getElementById('addProgNivel').value;
        const rvoe = document.getElementById('addProgRvoe').value;
        const btn = document.getElementById('btnCrearProg');
        
        btn.disabled = true;
        btn.innerHTML = 'Creando...';

        fetch('/catalogos/programas', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, nivel, rvoe })
        }).then(res => res.json()).then(res => {
            if (res.status === 'success') {
                window.location.reload();
            } else {
                alert("Error: " + res.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Crear Programa';
            }
        });
    });

    // Editar
    const modalEditarPrograma = new bootstrap.Modal(document.getElementById('modalEditarPrograma'));
    document.querySelectorAll('.btn-edit-programa').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editProgId').value = this.dataset.id;
            document.getElementById('editProgNombre').value = this.dataset.nombre;
            document.getElementById('editProgNivel').value = this.dataset.nivel;
            document.getElementById('editProgRvoe').value = this.dataset.rvoe;
            modalEditarPrograma.show();
        });
    });

    document.getElementById('formEditarPrograma').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editProgId').value;
        const nombre = document.getElementById('editProgNombre').value;
        const nivel = document.getElementById('editProgNivel').value;
        const rvoe = document.getElementById('editProgRvoe').value;
        const btn = document.getElementById('btnGuardarProg');
        
        btn.disabled = true;
        btn.innerHTML = 'Guardando...';

        fetch('/catalogos/programas/' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, nivel, rvoe })
        }).then(res => res.json()).then(res => {
            if (res.status === 'success') {
                window.location.reload();
            } else {
                alert("Error: " + res.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save me-1"></i> Guardar Cambios';
            }
        });
    });

    document.querySelectorAll('.btn-delete-programa').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm("¿Seguro que deseas eliminar este Programa? (No se borrará físicamente, quedará como Inactivo para preservar historiales).")) {
                fetch('/catalogos/programas/' + id, { method: 'DELETE' })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') window.location.reload();
                    else alert("Error: " + res.message);
                });
            }
        });
    });

    // --- GENERACIONES ---
    // Agregar
    document.getElementById('formAgregarGeneracion').addEventListener('submit', function(e) {
        e.preventDefault();
        const nombre = document.getElementById('addGenNombre').value;
        const descripcion = document.getElementById('addGenDescripcion').value;
        const anio_inicio = document.getElementById('addGenAnioInicio').value;
        const anio_termino = document.getElementById('addGenAnioTermino').value;
        const btn = document.getElementById('btnCrearGen');
        
        btn.disabled = true;
        btn.innerHTML = 'Creando...';

        fetch('/catalogos/generaciones', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, descripcion, anio_inicio, anio_termino })
        }).then(res => res.json()).then(res => {
            if (res.status === 'success') {
                window.location.reload();
            } else {
                alert("Error: " + res.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-check-circle me-1"></i> Crear Generación';
            }
        });
    });

    const modalEditarGeneracion = new bootstrap.Modal(document.getElementById('modalEditarGeneracion'));
    document.querySelectorAll('.btn-edit-generacion').forEach(btn => {
        btn.addEventListener('click', function() {
            document.getElementById('editGenId').value = this.dataset.id;
            document.getElementById('editGenNombre').value = this.dataset.nombre;
            document.getElementById('editGenDescripcion').value = this.dataset.descripcion;
            document.getElementById('editGenAnioInicio').value = this.dataset.anioInicio;
            document.getElementById('editGenAnioTermino').value = this.dataset.anioTermino;
            modalEditarGeneracion.show();
        });
    });

    document.getElementById('formEditarGeneracion').addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editGenId').value;
        const nombre = document.getElementById('editGenNombre').value;
        const descripcion = document.getElementById('editGenDescripcion').value;
        const anio_inicio = document.getElementById('editGenAnioInicio').value;
        const anio_termino = document.getElementById('editGenAnioTermino').value;
        const btn = document.getElementById('btnGuardarGen');
        
        btn.disabled = true;
        btn.innerHTML = 'Guardando...';

        fetch('/catalogos/generaciones/' + id, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, descripcion, anio_inicio, anio_termino })
        }).then(res => res.json()).then(res => {
            if (res.status === 'success') {
                window.location.reload();
            } else {
                alert("Error: " + res.message);
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-save me-1"></i> Guardar Cambios';
            }
        });
    });

    document.querySelectorAll('.btn-delete-generacion').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            if (confirm("¿Seguro que deseas eliminar esta Generación? (No se borrará físicamente, quedará como Inactiva para preservar historiales).")) {
                fetch('/catalogos/generaciones/' + id, { method: 'DELETE' })
                .then(res => res.json())
                .then(res => {
                    if (res.status === 'success') window.location.reload();
                    else alert("Error: " + res.message);
                });
            }
        });
    });
});
</script>
