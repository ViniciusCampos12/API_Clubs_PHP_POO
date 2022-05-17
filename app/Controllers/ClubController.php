<?php

namespace App\Controllers;

use App\Models\Club;

class ClubController extends Controller
{
    /**
     * Instancia e injeta o Model nos métodos.
     */
    public function __construct()
    {
        $this->club = new Club();
    }


    /**
     * Exibe todos os clubes existentes
     */
    public function index()
    {
        $return = $this->club->all();
        return $this->response(200, $return);
    }

    /**
     * Insire um novo clube no banco de dados.
     * @param array $data
     * @return json
     */
    public function store($data = [])
    {
        $return = $this->club->insert($data);

        if($return != null)
        {
            return $this->response(200,$return);
        }
    }

    /**
     * Exibe um clube selecionado pelo cliente.
     * @param int $id
     * @return json
     */
    public function show($id)
    {
    
        $return = $this->club->findAndView($id);

        if ($return != null) 
        {
            return $this->response(200, $return);
        }

        return $this->response(404, ["erro" => "O id informado não existe!"]);
       
    }

    /**
     *  Atualiza dados de um clube.
     *
     * @param int $id
     * @param array $data
     * @return json
     */
    public function update(int $id, $data = [])
    {
       $return = $this->club->update($id, $data);

       if($return != null)
       {
           return $this->response(200,$return);
       }

       return $this->response(404,['erro' => 'O id informado não existe!']);
    }

    /**
     *  Deleta um clube do banco de dados.
     *
     * @param int $id
     * @return json
     */
    public function destroy(int $id)
    {
        $return = $this->club->delete($id);

        if ($return == true)
        {
            return $this->response(200, ['sucesso' => 'O clube foi deletado com sucesso!']);
        }
        
        return $this->response(404, ['erro' => 'O id informado não existe!']);
    }
}
