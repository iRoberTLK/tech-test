<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProdutoModel;
use App\Models\CategoriaModel;

class ProdutoController extends BaseController
{
    protected $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
    }

    public function index()
    {
        return view('produtos/index');
    }

    public function datatable()
    {
        $request = service('request');
        $start  = $request->getGet('start');
        $length = $request->getGet('length');
        $search = $request->getGet('search')['value'] ?? '';
        
        // Arquitetura: Join com a tabela de categorias para exibir o nome da categoria na listagem
        $builder = $this->produtoModel->builder()
                        ->select('tab_produto.*, tab_categoria.cat_nome')
                        ->join('tab_categoria', 'tab_categoria.cat_id = tab_produto.cat_id', 'left');
        
        if (!empty($search)) {
            $builder->groupStart()
                    ->like('tab_produto.pro_nome', $search)
                    ->orLike('tab_categoria.cat_nome', $search)
                    ->groupEnd();
        }

        $totalRecords = $this->produtoModel->countAllResults(false);
        $records = $builder->limit($length, $start)->orderBy('pro_id', 'DESC')->get()->getResult();

        $data = [];
        foreach ($records as $row) {
            $data[] = [
                'id'        => $row->pro_id,
                'nome'      => $row->pro_nome,
                'categoria' => $row->cat_nome,
                'acoes'     => view('produtos/_acoes', ['id' => $row->pro_id])
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
        return view('produtos/form');
    }

    public function store()
    {
        $dados = $this->request->getPost();
        
        if (!$this->produtoModel->insert($dados)) {
            return redirect()->back()->withInput()->with('erros', $this->produtoModel->errors());
        }

        return redirect()->to('/produtos')->with('sucesso', 'Produto cadastrado com sucesso!');
    }

    public function edit(int $id)
    {
        $produto = $this->produtoModel->find($id);
        if (!$produto) {
            return redirect()->to('/produtos')->with('erro', 'Produto não encontrado.');
        }

        // Busca o nome da categoria para preencher o Select2 no modo edição
        $catModel = new CategoriaModel();
        $categoria = $catModel->find($produto->cat_id);

        return view('produtos/form', [
            'produto' => $produto, 
            'categoriaNome' => $categoria ? $categoria->cat_nome : 'Desconhecida'
        ]);
    }

    public function update(int $id)
    {
        $dados = $this->request->getPost();
        
        if (!$this->produtoModel->update($id, $dados)) {
            return redirect()->back()->withInput()->with('erros', $this->produtoModel->errors());
        }

        return redirect()->to('/produtos')->with('sucesso', 'Produto atualizado com sucesso!');
    }

    public function delete(int $id)
    {
        if ($this->produtoModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'mensagem' => 'Produto excluído com sucesso.']);
        }
        return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'mensagem' => 'Erro ao excluir.']);
    }
}