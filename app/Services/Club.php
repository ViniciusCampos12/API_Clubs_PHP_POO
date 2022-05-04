<?php

namespace App\Services;

use App\Database\Connection;


class Club
{

    /**
     * Guarda a instancia do objeto Connection
     *
     * @var [object] $pdo
     */
    private $pdo;


    /**
     * Injeta nos métodos a instancia do Connection
     */
    public function __construct()
    {
      $this->pdo = new Connection();
    }

    /**
     * Exibe todos os registros do banco
     *
     * @return void
     */
    public function index()
    {
      $this->pdo->index();

      echo json_encode($this->pdo->result);
      http_response_code(200);
      return header('Content-Type: application/json;charset=utf-8');
    }


    /**
     * Insere um data no banco
     *
     * @param [array] $data - recebe os dados enviados no body da requisicao
     * @return void
     */
    public function store($data)
    {
      if (isset($data['name']) and !empty($data['name']) and isset($data['color']) and !empty($data['color']) and isset($data['state']) and !empty($data['state'])) {
          
        $this->pdo->insert($data);
        echo json_encode($this->pdo->result);
        http_response_code(200);
        return header('Content-Type: application/json;charset=utf-8');

      } else {
        echo json_encode(['erro' => 'Todos os campos devem ser preenchidos!']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
      }
    }

    /**
     * Exibe um registro especifico 
     *
     * @param integer $id - recebe o id que usuario deseja ver
     * @return void
     */
    public function show(int $id)
    {
      $this->pdo->show($id);

      if($this->pdo->result != null)
      {
        echo json_encode($this->pdo->result);
        http_response_code(200);
        return header('Content-Type: application/json;charset=utf-8');

      }else{

        echo json_encode(['erro' => 'O campo id não foi encontrado!']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
      }
      
    }


    /**
     * Atualiza os dados de um determinado registro
     *
     * @param [integer] $id - recebe o id que usuario deseja atualizar
     * @return void
     */
    public function update($method,$data, $id)
    {
      if($method === "PUT")
        if(isset($data['name']) and !empty($data['name']) and isset($data['color']) and !empty($data['color']) and isset($data['state']) and !empty($data['state'])){
           
            $this->pdo->update($data,$id);

            if($this->pdo->result != null){

              echo json_encode($this->pdo->result);
              http_response_code(200);
              return header('Content-Type: application/json;charset=utf-8');

            }else{
              echo json_encode(['erro' => 'O campo id não foi encontrado!']);
              http_response_code(404);
              return header('Content-Type: application/json;charset=utf-8');
            }
            
            

      }else {
        echo json_encode(['erro' => 'Todos os campos devem ser preenchidos!']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
      }

      if($method === "PATCH"){

            $this->pdo->update($data,$id);

            if($this->pdo->result != null){

              echo json_encode($this->pdo->result);
              http_response_code(200);
              return header('Content-Type: application/json;charset=utf-8');
              
            }else{
              echo json_encode(['erro' => 'O campo id não foi encontrado!']);
              http_response_code(404);
              return header('Content-Type: application/json;charset=utf-8');
            }
            
      }
    }

    /**
     * Delete um registro do banco de dados
     *
     * @param [integer] $id - recebe o id que usuario deseja deletar
     * @return void
     */
    public function destroy(int $id)
    {
      if($this->pdo->delete($id) === true){

        echo json_encode(['sucesso' => 'O registro foi deletado com sucesso!']);
        http_response_code(200);
        return header('Content-Type: application/json;charset=utf-8');

      }else{
        echo json_encode(['erro' => 'O campo id não foi encontrado!']);
        http_response_code(404);
        return header('Content-Type: application/json;charset=utf-8');
      }
    }

}
