<?php
namespace Aura\Controllers;

use Aura\Core\View;

class CatalogosController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        // El constructor de BaseController inicializa View()
    }

    public function index() {
        $this->requireAuth();
        
        // Consumir API endpoints
        $programasResponse = $this->apiGet('/catalogos/programas');
        $centrosResponse = $this->apiGet('/catalogos/centros');
        $generacionesResponse = $this->apiGet('/catalogos/generaciones');
        $esquemasResponse = $this->apiGet('/catalogos/esquemas_pago');

        $programas = $programasResponse['status'] === 'success' ? $programasResponse['data'] : [];
        $centros = $centrosResponse['status'] === 'success' ? $centrosResponse['data'] : [];
        $generaciones = $generacionesResponse['status'] === 'success' ? $generacionesResponse['data'] : [];
        $esquemas = $esquemasResponse['status'] === 'success' ? $esquemasResponse['data'] : [];

        return $this->render('catalogos/index', [
            'programas' => $programas,
            'centros' => $centros,
            'generaciones' => $generaciones,
            'esquemas' => $esquemas
        ], 'dashboard');
    }
    public function agregarPrograma() {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $this->apiPost("/catalogos/programas", $input);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editarPrograma($id) {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $this->apiPut("/catalogos/programas/{$id}", $input);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function eliminarPrograma($id) {
        $this->requireAuth();
        $response = $this->apiDelete("/catalogos/programas/{$id}");
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function agregarGeneracion() {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $this->apiPost("/catalogos/generaciones", $input);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function editarGeneracion($id) {
        $this->requireAuth();
        $input = json_decode(file_get_contents('php://input'), true);
        $response = $this->apiPut("/catalogos/generaciones/{$id}", $input);
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function eliminarGeneracion($id) {
        $this->requireAuth();
        $response = $this->apiDelete("/catalogos/generaciones/{$id}");
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
