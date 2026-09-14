<?php
namespace Aura\Core;

class View {
    protected $layout = 'main';

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $data = []) {
        // Extract data to variables
        extract($data);

        // Render the view content
        ob_start();
        $viewFile = __DIR__ . "/../Views/{$view}.php";
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            echo "View '{$view}' not found.";
        }
        $content = ob_get_clean();

        // If no layout, return content directly
        if (!$this->layout) {
            return $content;
        }

        // Render the layout and inject content
        ob_start();
        $layoutFile = __DIR__ . "/../Views/layouts/{$this->layout}.php";
        if (file_exists($layoutFile)) {
            include $layoutFile;
        } else {
            echo $content;
        }
        return ob_get_clean();
    }
}
