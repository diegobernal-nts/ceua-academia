<?php
namespace Aura\Settings;

class Data {
    public function __construct(){}
    
    public function getData(){
        $data = @parse_ini_file(__DIR__ . '/.data');
        if (!$data) {
            return [];
        }
        return $data;
    }
    
    public function getURL() {
        $data = $this->getData();
        return rtrim($data['WEB_URL'] ?? '', '/');
    }

    public function getApiURL() {
        $data = $this->getData();
        return rtrim($data['API_URL'] ?? '', '/');
    }
}
?>