<?php
namespace Aura\Controllers;

class AuthController extends BaseController {
    
    public function index() {
        if (!empty($_SESSION['api_key'])) {
            header("Location: /dashboard");
            exit();
        }
        
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $this->render('auth/login', ['error' => $error]);
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /");
            exit();
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $apiUrl = (new \Aura\Settings\Data())->getApiURL();
        
        $ch = curl_init($apiUrl . '/login');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'email' => $email,
            'password' => $password
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-System-ID: ceuaacademia'
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $responseData = json_decode($response, true);

        if ($httpCode === 200 && isset($responseData['user']['api_key'])) {
            // Guardar en sesión local del frontend
            $_SESSION['api_key'] = $responseData['user']['api_key'];
            $_SESSION['user'] = $responseData['user'];
            
            // Cookie para validación estricta en JS (prevenir vista en botón atrás)
            setcookie('is_logged_in', '1', 0, '/');
            
            // TODO: Redirigir al dashboard principal de academia
            header("Location: /dashboard");
            exit();
        }

        // Si falla, guardar el error en sesión y devolver al form
        $_SESSION['error'] = $responseData['error'] ?? 'Ocurrió un error al intentar iniciar sesión.';
        header("Location: /");
        exit();
    }

    public function logout() {
        if (!empty($_SESSION['api_key'])) {
            $apiUrl = (new \Aura\Settings\Data())->getApiURL();
            $apiKey = $_SESSION['api_key'];

            // Avisar a la API que destruya la llave en la BD
            $ch = curl_init($apiUrl . '/logout');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-System-ID: ceuaacademia',
                'X-API-Key: ' . $apiKey
            ]);
            curl_exec($ch);
            curl_close($ch);
        }

        // Destruir la cookie de JS
        setcookie('is_logged_in', '', time() - 3600, '/');

        // Destruir la sesión local
        session_destroy();
        header("Location: /");
        exit();
    }
}
