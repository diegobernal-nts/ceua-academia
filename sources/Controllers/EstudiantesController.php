<?php
namespace Aura\Controllers;

class EstudiantesController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        
        // Proteger acceso
        if (empty($_SESSION['api_key'])) {
            header("Location: /");
            exit();
        }
    }

    public function index() {
        $user = $this->requireAuth();

        // 1. Obtener Estudiantes
        $estResponse = $this->apiGet('/estudiantes');
        $estudiantes = $estResponse['status'] === 'success' ? $estResponse['data'] : [];

        // 2. Obtener Catálogos para el Modal
        $progRes = $this->apiGet('/catalogos/programas');
        $centrosRes = $this->apiGet('/catalogos/centros');
        $genRes = $this->apiGet('/catalogos/generaciones');
        $esqRes = $this->apiGet('/catalogos/esquemas_pago');

        $programas = $progRes['status'] === 'success' ? $progRes['data'] : [];
        $centros = $centrosRes['status'] === 'success' ? $centrosRes['data'] : [];
        $generaciones = $genRes['status'] === 'success' ? $genRes['data'] : [];
        $esquemas = $esqRes['status'] === 'success' ? $esqRes['data'] : [];

        return $this->render('estudiantes/index', [
            'user' => $user,
            'estudiantes' => $estudiantes,
            'programas' => $programas,
            'centros' => $centros,
            'generaciones' => $generaciones,
            'esquemas' => $esquemas
        ], 'dashboard');
    }

    public function agregar() {
        $this->requireAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        $response = $this->apiPost('/estudiantes/agregar', $input);
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    public function cargaMasiva() {
        $this->requireAuth();
        
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            echo json_encode(['status' => 'error', 'message' => 'Datos inválidos']);
            return;
        }

        $response = $this->apiPost('/estudiantes/carga-masiva', $input);
        
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
