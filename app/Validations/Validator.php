<?php

namespace App\Validations;

class Validator
{
    /**
     * Verifica se o foi informado um id e se ele é numerico
     *
     * @param int $id
     * @return mixed
     */
    public function validateId($id)
    {
        if (isset($id) && is_numeric($id))
        {
            return true;
        }

        http_response_code(404);
        echo json_encode(['erro' => 'Informe um id válido!']);
        return header('Content-Type: application/json;charset=utf-8');
    }

    /**
     * Verifica se o usuário preenchou todos os campos necessarios
     *
     * @param array $data
     * @return mixed
     */
    public function validateData(array $data)
    {
        if (!empty($data['name']) && !empty($data['color']) && !empty($data['state']))
        {
            return true;
        }

        http_response_code(404);
        echo json_encode(['erro' => 'Todos os campos devem ser informados!']);
        return header('Content-Type: application/json;charset=utf-8');
    }
}