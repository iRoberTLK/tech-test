<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CategoriaModel;
use CodeIgniter\HTTP\ResponseInterface;

class CategoriaController extends BaseController
{
    protected $categoriaModel;

    public function __construct()
    {
        $this->categoriaModel = new CategoriaModel();
    }

    public function index()
    {
        return view('categorias/index');
    }

    /**
     * Processamento Server-Side do DataTables.
     * Arquitetura: Mantida a extração dos dados aqui para não sujar o Model com regras específicas de lib de frontend.
     */
    public function datatable()
    {
        $request = service('request');
        
        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $search = $request->getGet('search')['value'] ?? '';
        
        $builder = $this->categoriaModel->builder();
        
        // Filtro nativo da caixa de busca da tabela
        if (!empty($search)) {
            $builder->like('cat_nome', $search);
        }

        $totalRecords = $this->categoriaModel->countAllResults(false);
        $records = $builder->limit($length, $start)->orderBy('cat_id', 'DESC')->get()->getResult();

        $data = [];
        foreach ($records as $row) {
            $data[] = [
                'id'       => $row->cat_id,
                'nome'     => $row->cat_nome,
                'status'   => $row->cat_ativo == 1 ? '<span class="badge badge-success">Ativo</span>' : '<span class="badge badge-danger">Inativo</span>',
                'cadastro' => date('d/m/Y H:i', strtotime($row->cat_criado_em)),
                'acoes'    => view('categorias/_acoes', ['id' => $row->cat_id])
            ];
        }

        return $this->response->setJSON([
            'draw'            => intval($request->getGet('draw')),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data'            => $data
        ]);
    }

    public function create()
    {
        return view('categorias/form');
    }

    public function store()
    {
        $dados = $this->request->getPost();
        
        if (!$this->categoriaModel->insert($dados)) {
            return redirect()->back()->withInput()->with('erros', $this->categoriaModel->errors());
        }

        return redirect()->to('/categorias')->with('sucesso', 'Categoria cadastrada com sucesso!');
    }

    public function edit(int $id)
    {
        $categoria = $this->categoriaModel->find($id);
        
        if (!$categoria) {
            return redirect()->to('/categorias')->with('erro', 'Categoria não encontrada.');
        }

        return view('categorias/form', ['categoria' => $categoria]);
    }

    public function update(int $id)
    {
        $dados = $this->request->getPost();
        
        if (!$this->categoriaModel->update($id, $dados)) {
            return redirect()->back()->withInput()->with('erros', $this->categoriaModel->errors());
        }

        return redirect()->to('/categorias')->with('sucesso', 'Categoria atualizada com sucesso!');
    }

    public function delete(int $id)
    {
        try {
            // A validação de produtos vinculados e o soft delete estão encapsulados no Model (callbacks).
            $this->categoriaModel->delete($id);
            return $this->response->setJSON(['status' => 'success', 'mensagem' => 'Categoria excluída com sucesso.']);
        } catch (\RuntimeException $e) {
            // Captura a exceção lançada pelo callback "verificarProdutosVinculados"
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'mensagem' => $e->getMessage()]);
        }
    }

    /**
     * Endpoint para carregamento AJAX via Select2.
     */
    public function buscarAjax()
    {
        $termo = $this->request->getGet('q');
        
        $categorias = $this->categoriaModel
            ->select('cat_id as id, cat_nome as text')
            ->where('cat_ativo', 1)
            ->like('cat_nome', $termo ?? '')
            ->limit(10)
            ->findAll();

        return $this->response->setJSON(['results' => $categorias]);
    }
}