<?php
namespace Aura\Core;

class Response {
    protected $content;
    protected $statusCode;
    protected $headers = [];

    public function __construct($content = '', $statusCode = 200, $headers = []) {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $defaultHeaders = [
            'Content-Type' => 'text/html; charset=UTF-8',
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0'
        ];
        $this->headers = array_merge($defaultHeaders, $headers);
    }

    public function setContent($content) {
        $this->content = $content;
        return $this;
    }

    public function setStatusCode($statusCode) {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function setHeader($name, $value) {
        $cleanName = str_replace(["\r", "\n"], '', $name);
        $cleanValue = str_replace(["\r", "\n"], '', $value);
        $this->headers[$cleanName] = $cleanValue;
        return $this;
    }

    public function send() {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }

    public static function json($data, $statusCode = 200) {
        return new static(json_encode($data), $statusCode, ['Content-Type' => 'application/json']);
    }
}
