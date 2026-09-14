<?php
namespace Aura\Controllers;

use Aura\Core\View;

class BaseController {
    
    public function __construct() {
        // En frontend podemos iniciar sesión local de PHP
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    protected function render($view, $data = [], $layout = 'main') {
        $viewObj = new View();
        $viewObj->setLayout($layout);
        
        $html = $viewObj->render($view, $data);
        
        // Return a Response object containing the HTML with no-cache headers to secure back-button
        return new \Aura\Core\Response($html, 200, [
            'Content-Type' => 'text/html; charset=utf-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ]);
    }

    protected function requireAuth() {
        if (empty($_SESSION['api_key'])) {
            header("Location: /");
            exit();
        }
        return $_SESSION['user'] ?? [];
    }

    protected function apiGet($endpoint) {
        if (empty($_SESSION['api_key'])) {
            return ['status' => 'error', 'message' => 'No auth token'];
        }

        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        $ch = curl_init($apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia',
            'X-API-Key: ' . $_SESSION['api_key']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            return json_decode($response, true) ?? ['status' => 'error'];
        }
        return ['status' => 'error', 'code' => $httpCode];
    }

    protected function apiPost($endpoint, $payload = []) {
        if (empty($_SESSION['api_key'])) {
            return ['status' => 'error', 'message' => 'No auth token'];
        }

        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        $ch = curl_init($apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia',
            'X-API-Key: ' . $_SESSION['api_key']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            return $decoded ?? ['status' => 'success'];
        }
        
        return $decoded ?? ['status' => 'error', 'code' => $httpCode];
    }
    protected function apiPut($endpoint, $payload = []) {
        if (empty($_SESSION['api_key'])) {
            return ['status' => 'error', 'message' => 'No auth token'];
        }

        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        $ch = curl_init($apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia',
            'X-API-Key: ' . $_SESSION['api_key']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300) {
            return $decoded ?? ['status' => 'success'];
        }
        return $decoded ?? ['status' => 'error', 'code' => $httpCode];
    }

    protected function apiDelete($endpoint) {
        if (empty($_SESSION['api_key'])) {
            return ['status' => 'error', 'message' => 'No auth token'];
        }

        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        $ch = curl_init($apiUrl . $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia',
            'X-API-Key: ' . $_SESSION['api_key']
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);
        if ($httpCode >= 200 && $httpCode < 300) {
            return $decoded ?? ['status' => 'success'];
        }
        return $decoded ?? ['status' => 'error', 'code' => $httpCode];
    }
}
