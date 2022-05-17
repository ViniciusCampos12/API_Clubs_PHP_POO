<?php

namespace App\Controllers;

class Controller
{
    public function response(int $code, $data = [])
    {
        http_response_code($code);
        echo json_encode($data);
        return header('Content-Type: application/json;charset=utf-8');
    }
}
