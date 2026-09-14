<?php
namespace Aura\Core;

class Router {
    protected $routes = [];
    protected $container;

    public function __construct(?Container $container = null) {
        $this->container = $container ?: new Container();
    }

    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    public function put($path, $callback) {
        $this->routes['PUT'][$path] = $callback;
    }

    public function delete($path, $callback) {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
        $path = parse_url($requestUri, PHP_URL_PATH) ?? '';
        
        // Strip the base directory based strictly on WEB_URL
        $envFile = __DIR__ . '/../Settings/.data';
        if (file_exists($envFile)) {
            $env = @parse_ini_file($envFile);
            if ($env && !empty($env['WEB_URL'])) {
                $basePath = parse_url($env['WEB_URL'], PHP_URL_PATH) ?? '';
                $basePath = rtrim($basePath, '/');
                
                if ($basePath !== '' && strpos($path, $basePath) === 0) {
                    $path = substr($path, strlen($basePath));
                }
            }
        }

        if ($path === '') {
            $path = '/';
        }
        
        // Remove trailing slash if not root
        if ($path !== '/' && substr($path, -1) === '/') {
            $path = rtrim($path, '/');
        }

        $params = [];
        $callback = $this->routes[$method][$path] ?? false;

        if (!$callback && isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $routePath => $routeCallback) {
                if (strpos($routePath, '{') !== false) {
                    $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([^/]+)', $routePath);
                    $pattern = '#^' . $pattern . '$#';
                    if (preg_match($pattern, $path, $matches)) {
                        array_shift($matches);
                        $params = $matches;
                        $callback = $routeCallback;
                        break;
                    }
                }
            }
        }

        if ($callback) {
            if (is_callable($callback)) {
                return call_user_func_array($callback, $params);
            }
            
            if (is_array($callback) && count($callback) === 2) {
                $controllerClass = $callback[0];
                $methodName = $callback[1];

                if (class_exists($controllerClass)) {
                    $controller = $this->container->resolve($controllerClass);
                    if (method_exists($controller, $methodName)) {
                        return call_user_func_array([$controller, $methodName], $params);
                    }
                }
            }
        }

        // 404 Handling
        return \Aura\Core\Response::json([
            'error' => 'Not Found',
            'message' => "The requested endpoint '{$path}' does not exist.",
            'debug' => [
                'request_uri' => $_SERVER['REQUEST_URI'] ?? null,
                'script_name' => $_SERVER['SCRIPT_NAME'] ?? null,
                'parsed_path' => parse_url($requestUri, PHP_URL_PATH)
            ]
        ], 404);
    }
}
