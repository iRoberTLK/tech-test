<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoriaModel;

class CategoriaController extends ResourceController
{
    // Arquitetura: Ao definir o modelName e o format
    // do model em $this->model e formata as respostas automaticamente.
    protected $modelName = CategoriaModel::class;
    protected $format    = 'json';

    /**
     * Return an array of resource objects, themselves in array format.
     * Retorna a lista de categorias no formato exigido pelo teste (id, nome e ativo).
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $categorias = $this->model
            ->select('cat_id as id, cat_nome as nome, cat_ativo as ativo')
            ->findAll();
            
        // Arquitetura: Casting explícito para garantir a tipagem correta no contrato da API (JSON).
        $categoriasFormatadas = array_map(function($cat) {
            return [
                'id'    => (int) $cat->id,
                'nome'  => $cat->nome,
                'ativo' => (bool) $cat->ativo
            ];
        }, $categorias);

        return $this->respond($categoriasFormatadas);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        return $this->failNotFound('Recurso não implementado.');
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        return $this->failNotFound('Recurso não implementado.');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        return $this->failNotFound('Recurso não implementado.');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        return $this->failNotFound('Recurso não implementado.');
    }
}