<?php
require __DIR__ . "/../vendor/autoload.php";

use App\Controllers\ClubController;
use App\Validations\Validator;

/**
 * Instancia as 2 dependencias da API
 */
$validator = new Validator();
$club = new ClubController();

/**
 * Guarda dentro da variavel o método HTTP selecionado pelo cliente.
 */
$method = $_SERVER['REQUEST_METHOD'];

/**
 * Caso o método HTTP selecionado seja GET, o cliente pode ver todos os clubes ou um clube especifico.
 */
if ($method == 'GET') 
{
    if (!$_GET['id'])
    {
        return $club->index();
    }

    if ($validator->validateId($_GET['id']) == true)
    {
        return $club->show($_GET['id']);
    }
} 

/**
 * Caso o método HTTP selecionado seja  POST, o cliente pode inserir um novo clube no banco de dados.
 */
if ($method == 'POST')
{   
    if ($validator->validateData($_POST) == true)
    {
        return $club->store($_POST);
    } 
}

/**
 * Caso o método HTTP selecionado seja  PUT, o cliente deve atualizar todos os campos de um clube.
 */
if ($method == 'PUT')
{
    $data = [];
    parse_str(file_get_contents('php://input'), $data);

    if ($validator->validateId($_GET['id']) == true && $validator->validateData($data) == true)
    {
        return $club->update($_GET['id'], $data);
    } 
}

/**
 * Caso o método HTTP selecionado seja  PATCH, o cliente pode atualizar os campos que dejesar de um clube.
 */
if ($method == 'PATCH')
{
    $data = [];
    parse_str(file_get_contents('php://input'), $data);

    if ($validator->validateId($_GET['id']) == true)
    {
        return $club->update($_GET['id'], $data);
    }
   
}

/**
 * Caso o método HTTP selecionado seja  DELETE, o cliente pode exluir um clube do banco de dados.
 */
if ($method == 'DELETE')
{
    if ($validator->validateId($_GET['id']) == true)
    {
        return $club->destroy($_GET['id']);
    }
}