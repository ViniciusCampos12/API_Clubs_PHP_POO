<?php

require __DIR__ . ('/vendor/autoload.php');

use App\Services\Club;
use App\Database\Connection;

$method = $_SERVER['REQUEST_METHOD'];




switch($method)
{
    case 'GET';

    $pdo = new Club();

    if(!$_GET['id'])
    {
        $pdo->index();

        die();
    }

    if(is_numeric($_GET['id']))
    {
        $id = $_GET['id'];

        $pdo->show($id);

    }else{  

        echo json_encode(['erro' => 'O id deve ser númerico']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
    }


    break;
/*---------------------------------------------------------------------------------------------------------------------*/
    case 'POST';


    $data = $_POST;


    $pdo = new Club();

    $pdo->store($data);

    break;

/*---------------------------------------------------------------------------------------------------------------------*/
    case 'PUT';
   

    if(!$_GET['id'])
    {
        echo json_encode(['erro' => 'O id não foi informado']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');

        die();
    }

    if(is_numeric($_GET['id']))
    {
        $method = "PUT";

        $data = [];
        parse_str(file_get_contents('php://input'), $data);
        
        $id = $_GET['id'];
        
        $pdo = new Club();

        $pdo->update($method,$data,$id);

    }else{  

        echo json_encode(['erro' => 'O id deve ser númerico']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
    }

    


    break;

/*---------------------------------------------------------------------------------------------------------------------*/
    case 'PATCH';
    

    if(!$_GET['id'])
    {
        echo json_encode(['erro' => 'O id não foi informado']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');

        die();
    }

    if(is_numeric($_GET['id']))
    {
        $method = "PATCH";

        $data = [];
        parse_str(file_get_contents('php://input'), $data);
        
        $id = $_GET['id'];
        
        $pdo = new Club();

        $pdo->update($method,$data,$id);

    }else{  

        echo json_encode(['erro' => 'O id deve ser númerico']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
    }
    

    break;

/*---------------------------------------------------------------------------------------------------------------------*/
    case 'DELETE';

    if(!$_GET['id'])
    {
        echo json_encode(['erro' => 'O id não foi informado']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');

        die();
    }

    if(is_numeric($_GET['id']))
    {
        $id = $_GET['id'];
    
        $pdo = new Club();

        $pdo->destroy($id);

    }else{  

        echo json_encode(['erro' => 'O id deve ser númerico']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
    }


    break;
}

