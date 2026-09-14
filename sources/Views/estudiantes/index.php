<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Estudiantes</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-sm btn-outline-success me-2" data-bs-toggle="modal" data-bs-target="#modalCargaMasiva">
            <i class="bi bi-file-earmark-spreadsheet me-1"></i> Carga Masiva CSV
        </button>
        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevoEstudiante">
            <i class="bi bi-person-plus me-1"></i> Nuevo Estudiante
        </button>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body">
        <div class="table-responsive">
            <table id="estudiantesTable" class="table table-hover align-middle w-100">
                <thead class="table-light">
                    <tr>
                        <th>Matrícula</th>
                        <th>Nombre Completo</th>
                        <th>Programa</th>
                        <th>Centro de Asesoría</th>
                        <th>Estatus</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($estudiantes as $est): ?>
                    <tr>
                        <td>
                            <span class="badge bg-secondary"><?= htmlspecialchars($est['matricula'] ?? 'SIN MATRÍCULA') ?></span>
                        </td>
                        <td>
                            <div class="fw-bold"><?= htmlspecialchars(trim($est['nombre'] . ' ' . $est['apellido_paterno'] . ' ' . $est['apellido_materno'])) ?></div>
                        </td>
                        <td><?= htmlspecialchars($est['programa'] ?? 'No Asignado') ?></td>
                        <td><?= htmlspecialchars($est['centro'] ?? 'No Asignado') ?></td>
                        <td>
                            <?php 
                                $estatus = strtoupper($est['estatus_inscripcion'] ?? 'INSCRITO');
                                $badgeClass = 'bg-secondary';
                                
                                switch ($estatus) {
                                    case 'INSCRITO':
                                        $badgeClass = 'bg-info text-dark';
                                        break;
                                    case 'ACTIVO':
                                        $badgeClass = 'bg-success';
                                        break;
                                    case 'SUSPENDIDO':
                                        $badgeClass = 'bg-warning text-dark';
                                        break;
                                    case 'BAJA':
                                        $badgeClass = 'bg-danger';
                                        break;
                                    case 'EGRESADO':
                                        $badgeClass = 'bg-primary';
                                        break;
                                }
                            ?>
                            <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($estatus) ?></span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-secondary" title="Ver Expediente"><i class="bi bi-folder2-open"></i></button>
                            <button class="btn btn-sm btn-outline-primary" title="Editar"><i class="bi bi-pencil"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- DataTables CSS & JS -->
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#estudiantesTable').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json',
        },
        pageLength: 10,
        responsive: true,
        order: [[1, 'asc']] // Ordenar por nombre completo por defecto
    });
});
</script>

<!-- Modal Nuevo Estudiante -->
<div class="modal fade" id="modalNuevoEstudiante" tabindex="-1" aria-labelledby="modalNuevoEstudianteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold" id="modalNuevoEstudianteLabel"><i class="bi bi-person-plus-fill me-2"></i>Registrar Nuevo Estudiante</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formNuevoEstudiante">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12"><h6 class="text-primary border-bottom border-secondary pb-2">Datos de Identidad</h6></div>
                        
                        <div class="col-md-4">
                            <label class="form-label small">CURP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="curp" minlength="18" maxlength="18" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-8">
                            <label class="form-label small">Nombre(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="nombre" required style="text-transform: uppercase;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small">Apellido Paterno <span class="text-danger">*</span></label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="apellido_paterno" required style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Apellido Materno</label>
                            <input type="text" class="form-control bg-dark text-white border-secondary" name="apellido_materno" style="text-transform: uppercase;">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small">WhatsApp</label>
                            <input type="tel" class="form-control bg-dark text-white border-secondary" name="whatsapp">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Correo Electrónico</label>
                            <input type="email" class="form-control bg-dark text-white border-secondary" name="correo">
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom border-secondary pb-2">Datos Académicos</h6></div>

                        <div class="col-md-6">
                            <label class="form-label small">Programa de Estudio <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_programa" id="selectPrograma" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($programas as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre'] . ' (' . $p['nivel'] . ')') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Centro de Asesoría <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_centro" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($centros as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small">Generación <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_generacion" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($generaciones as $g): ?>
                                    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Esquema de Pago <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_esquema_pago" id="selectEsquema" required disabled>
                                <option value="">Seleccione primero un programa...</option>
                                <?php foreach ($esquemas as $e): ?>
                                    <option value="<?= $e['id'] ?>" data-programa="<?= htmlspecialchars($e['id_programa'] ?? '') ?>">
                                        <?= htmlspecialchars($e['nombre'] . ' - ' . $e['anio_cohorte']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary" id="btnGuardarEstudiante">Guardar Estudiante</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectPrograma = document.getElementById('selectPrograma');
    const selectEsquema = document.getElementById('selectEsquema');
    
    // Almacenar todas las opciones originales en un array
    const todasLasOpcionesEsquema = Array.from(selectEsquema.options);

    selectPrograma.addEventListener('change', function() {
        const programaSeleccionado = this.value;
        
        // Limpiar el select de esquemas
        selectEsquema.innerHTML = '<option value="">Seleccione un esquema...</option>';
        
        if (!programaSeleccionado) {
            selectEsquema.disabled = true;
            selectEsquema.innerHTML = '<option value="">Seleccione primero un programa...</option>';
            return;
        }

        // Habilitar y filtrar
        selectEsquema.disabled = false;
        let hayOpciones = false;

        todasLasOpcionesEsquema.forEach(opcion => {
            if (opcion.value === "") return; // Ignorar el placeholder original
            
            if (opcion.getAttribute('data-programa') === programaSeleccionado) {
                selectEsquema.appendChild(opcion.cloneNode(true));
                hayOpciones = true;
            }
        });

        if (!hayOpciones) {
            selectEsquema.innerHTML = '<option value="">No hay esquemas para este programa</option>';
            selectEsquema.disabled = true;
        }
    });
});

document.getElementById('formNuevoEstudiante').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const form = e.target;
    const btn = document.getElementById('btnGuardarEstudiante');
    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());
    
    if (data.curp.length !== 18) {
        alert("La CURP debe tener exactamente 18 caracteres.");
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...';

    fetch('/estudiantes/agregar', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            alert("Estudiante registrado exitosamente. (ID Alumno: " + res.data.id_alumno + ")");
            window.location.reload(); // Recarga automática
        } else {
            alert("Error: " + (res.message || "No se pudo registrar el estudiante."));
            btn.disabled = false;
            btn.innerHTML = 'Guardar Estudiante';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Ocurrió un error inesperado al procesar la solicitud.");
        btn.disabled = false;
        btn.innerHTML = 'Guardar Estudiante';
    });
});
</script>

<!-- Modal Carga Masiva CSV -->
<div class="modal fade" id="modalCargaMasiva" tabindex="-1" aria-labelledby="modalCargaMasivaLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-secondary">
            <div class="modal-header border-secondary">
                <h5 class="modal-title fw-bold" id="modalCargaMasivaLabel"><i class="bi bi-file-earmark-spreadsheet-fill me-2"></i>Carga Masiva de Estudiantes (CSV)</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formCargaMasiva">
                <div class="modal-body">
                    <div class="alert alert-info border-0 rounded-4">
                        <i class="bi bi-info-circle-fill me-2"></i> Descarga la 
                        <a href="/public/plantilla_estudiantes.csv" download class="fw-bold alert-link">Plantilla CSV oficial</a>. 
                        Los datos académicos que elijas aquí abajo aplicarán para <strong>todos</strong> los alumnos del archivo.
                    </div>

                    <div class="row g-3">
                        <div class="col-12"><h6 class="text-primary border-bottom border-secondary pb-2">Variables Globales</h6></div>
                        
                        <div class="col-md-6">
                            <label class="form-label small">Programa de Estudio <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_programa" id="selectProgramaCsv" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($programas as $p): ?>
                                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['nombre'] . ' (' . $p['nivel'] . ')') ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Centro de Asesoría <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_centro" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($centros as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label small">Generación <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_generacion" required>
                                <option value="">Seleccione...</option>
                                <?php foreach ($generaciones as $g): ?>
                                    <option value="<?= $g['id'] ?>"><?= htmlspecialchars($g['nombre']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small">Esquema de Pago <span class="text-danger">*</span></label>
                            <select class="form-select bg-dark text-white border-secondary" name="id_esquema_pago" id="selectEsquemaCsv" required disabled>
                                <option value="">Seleccione primero un programa...</option>
                                <?php foreach ($esquemas as $e): ?>
                                    <option value="<?= $e['id'] ?>" data-programa="<?= htmlspecialchars($e['id_programa'] ?? '') ?>">
                                        <?= htmlspecialchars($e['nombre'] . ' - ' . $e['anio_cohorte']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-12 mt-4"><h6 class="text-primary border-bottom border-secondary pb-2">Archivo CSV</h6></div>
                        <div class="col-12">
                            <input type="file" class="form-control bg-dark text-white border-secondary" id="archivoCsv" accept=".csv" required>
                            <div class="form-text text-muted">Solo se permiten archivos terminados en .csv</div>
                        </div>

                        <!-- Contenedor para la vista previa -->
                        <div class="col-12" id="previewContainer" style="display: none;">
                            <h6 class="text-info mt-3"><i class="bi bi-eye"></i> Vista Previa de Alumnos</h6>
                            <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                                <table class="table table-dark table-sm table-bordered">
                                    <thead class="table-secondary text-dark sticky-top" id="previewTableHead"></thead>
                                    <tbody id="previewTableBody"></tbody>
                                </table>
                            </div>
                            <small class="text-success" id="previewStats"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnPrevisualizarCsv"><i class="bi bi-eye me-1"></i> Previsualizar CSV</button>
                    <button type="submit" class="btn btn-success d-none" id="btnProcesarCsv"><i class="bi bi-cloud-arrow-up-fill me-1"></i> Confirmar e Iniciar Carga</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Lógica de Cascada para Modal CSV
document.addEventListener('DOMContentLoaded', function() {
    const selectProg = document.getElementById('selectProgramaCsv');
    const selectEsq = document.getElementById('selectEsquemaCsv');
    const todasLasOpciones = Array.from(selectEsq.options);

    selectProg.addEventListener('change', function() {
        const progSel = this.value;
        selectEsq.innerHTML = '<option value="">Seleccione un esquema...</option>';
        
        if (!progSel) {
            selectEsq.disabled = true;
            selectEsq.innerHTML = '<option value="">Seleccione primero un programa...</option>';
            return;
        }

        selectEsq.disabled = false;
        let hayOpciones = false;

        todasLasOpciones.forEach(opcion => {
            if (opcion.value === "") return;
            if (opcion.getAttribute('data-programa') === progSel) {
                selectEsq.appendChild(opcion.cloneNode(true));
                hayOpciones = true;
            }
        });

        if (!hayOpciones) {
            selectEsq.innerHTML = '<option value="">No hay esquemas para este programa</option>';
            selectEsq.disabled = true;
        }
    });
});

// Variables globales para la carga
let estudiantesParseados = [];
const btnPrevisualizar = document.getElementById('btnPrevisualizarCsv');
const btnProcesar = document.getElementById('btnProcesarCsv');
const fileInput = document.getElementById('archivoCsv');
const previewContainer = document.getElementById('previewContainer');

// Lógica de Previsualización (clic en Previsualizar)
btnPrevisualizar.addEventListener('click', function() {
    if (!document.getElementById('formCargaMasiva').checkValidity()) {
        document.getElementById('formCargaMasiva').reportValidity();
        return;
    }

    if (fileInput.files.length === 0) return;
    
    const file = fileInput.files[0];
    const reader = new FileReader();

    btnPrevisualizar.disabled = true;
    btnPrevisualizar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Leyendo...';

    reader.onload = function(e) {
        const text = e.target.result;
        const lineas = text.split('\n').filter(line => line.trim() !== '');
        
        if (lineas.length <= 1) {
            alert("El archivo está vacío o solo contiene encabezados.");
            resetearBtnPrev();
            return;
        }

        estudiantesParseados = [];
        const encabezados = lineas[0].split(',').map(h => h.trim().toLowerCase());

        for (let i = 1; i < lineas.length; i++) {
            const currentLine = lineas[i].split(',').map(v => v.trim());
            const obj = {};
            
            encabezados.forEach((header, index) => {
                obj[header] = currentLine[index] || "";
            });
            
            if (!obj.curp) continue; // Ignorar filas sin CURP
            estudiantesParseados.push(obj);
        }

        if (estudiantesParseados.length === 0) {
            alert("No se detectaron alumnos válidos en el CSV.");
            resetearBtnPrev();
            return;
        }

        // Renderizar tabla
        const thead = document.getElementById('previewTableHead');
        const tbody = document.getElementById('previewTableBody');
        
        thead.innerHTML = '<tr>' + encabezados.map(h => `<th>${h}</th>`).join('') + '</tr>';
        
        // Mostrar máximo 50 registros en la vista previa para no colapsar el DOM
        const maxMostrar = Math.min(estudiantesParseados.length, 50);
        let tbodyHtml = '';
        
        for (let i = 0; i < maxMostrar; i++) {
            tbodyHtml += '<tr>' + encabezados.map(h => `<td>${estudiantesParseados[i][h] || ''}</td>`).join('') + '</tr>';
        }
        
        tbody.innerHTML = tbodyHtml;
        document.getElementById('previewStats').innerText = `${estudiantesParseados.length} alumnos detectados listos para cargar.`;
        
        previewContainer.style.display = 'block';
        
        // Cambiar botones
        btnPrevisualizar.classList.add('d-none');
        btnProcesar.classList.remove('d-none');
        resetearBtnPrev();
    };

    reader.readAsText(file);
});

// Resetea si el usuario cambia el archivo
fileInput.addEventListener('change', function() {
    previewContainer.style.display = 'none';
    btnProcesar.classList.add('d-none');
    btnPrevisualizar.classList.remove('d-none');
    estudiantesParseados = [];
});

function resetearBtnPrev() {
    btnPrevisualizar.disabled = false;
    btnPrevisualizar.innerHTML = '<i class="bi bi-eye me-1"></i> Previsualizar CSV';
}

// Lógica de Procesamiento del CSV (Envío al servidor)
document.getElementById('formCargaMasiva').addEventListener('submit', function(e) {
    e.preventDefault();
    
    if (estudiantesParseados.length === 0) {
        alert("Por favor, previsualice el archivo antes de continuar.");
        return;
    }

    const formObj = Object.fromEntries(new FormData(this).entries());
    const payload = {
        id_programa: formObj.id_programa,
        id_centro: formObj.id_centro,
        id_generacion: formObj.id_generacion,
        id_esquema_pago: formObj.id_esquema_pago,
        estudiantes: estudiantesParseados
    };

    btnProcesar.disabled = true;
    btnProcesar.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subiendo a la Base de Datos...';

    fetch('/estudiantes/carga-masiva', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(res => {
        if (res.status === 'success') {
            alert("¡Éxito! " + res.message);
            window.location.reload();
        } else {
            alert("Error de Validación (Rollback ejecutado):\n" + res.message);
            btnProcesar.disabled = false;
            btnProcesar.innerHTML = '<i class="bi bi-cloud-arrow-up-fill me-1"></i> Confirmar e Iniciar Carga';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert("Ocurrió un error inesperado al procesar la subida masiva.");
        btnProcesar.disabled = false;
        btnProcesar.innerHTML = '<i class="bi bi-cloud-arrow-up-fill me-1"></i> Confirmar e Iniciar Carga';
    });
});

</script>
