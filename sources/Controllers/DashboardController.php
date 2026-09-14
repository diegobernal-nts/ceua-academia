<?php
namespace Aura\Controllers;

class DashboardController extends BaseController {
    
    public function __construct() {
        parent::__construct();
        
        // Protegemos el acceso al dashboard
        if (empty($_SESSION['api_key'])) {
            header("Location: /");
            exit();
        }
    }

    public function index() {
        $user = $_SESSION['user'] ?? [];
        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        $apiKey = $_SESSION['api_key'];

        // Llamar a la API para obtener KPIs
        $ch = curl_init($apiUrl . '/kpis/academia');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia',
            'X-API-Key: ' . $apiKey
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $kpis = [
            'totales' => [
                'estudiantes' => 0,
                'programas' => 0,
                'centros' => 0,
                'ultima_generacion' => 'Desconocida'
            ],
            'graficos' => [
                'por_centro' => [],
                'por_estatus' => []
            ]
        ];

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);
            if (isset($responseData['data'])) {
                $kpis = $responseData['data'];
            }
        }

        return $this->render('dashboard/index', [
            'user' => $user,
            'kpis' => $kpis
        ], 'dashboard');
    }
}
