<?php

namespace App\Controllers;

class Controller
{
    /**
     * Método responsavel por fornecer a resposta da API
     *
     * @param integer $code
     * @param array $data
     * @return mixed
     */
    public function response(int $code, $data = [])
    {
        http_response_code($code);
        echo json_encode($data);
        return header('Content-Type: application/json;charset=utf-8');
    }
}
