<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaModel extends Model
{
    protected $table            = 'tab_categoria';
    protected $primaryKey       = 'cat_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;

    protected $allowedFields    = [
        'cat_nome', 
        'cat_descricao', 
        'cat_ativo'
    ];

    // Mapeamento de timestamps para português
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'cat_criado_em';
    protected $updatedField  = 'cat_alterado_em';
    protected $deletedField  = 'cat_excluido_em';

    // Regras de validação
    protected $validationRules      = [
        'cat_nome' => 'required|min_length[3]|max_length[100]|is_unique[tab_categoria.cat_nome,cat_id,{cat_id}]'
    ];
    
    protected $validationMessages   = [
        'cat_nome' => [
            'required'   => 'O campo Nome é obrigatório.',
            'min_length' => 'O Nome deve ter no mínimo 3 caracteres.',
            'max_length' => 'O Nome não pode exceder 100 caracteres.',
            'is_unique'  => 'Já existe uma categoria cadastrada com este nome.'
        ]
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $beforeDelete = ['verificarProdutosVinculados', 'inativarCategoria'];

    /**
     * Arquitetura: A regra que impede a exclusão/inativação de categoria 
     * com produtos vinculados reside no Model via callback.
     * Isso garante que a regra seja respeitada independente de onde a chamada se origine (API, Web, CLI).
     */
    protected function verificarProdutosVinculados(array $data)
    {
        if (!isset($data['id'])) {
            return $data;
        }

        $produtoModel = new ProdutoModel();
        
        $ids = is_array($data['id']) ? $data['id'] : [$data['id']];

        foreach ($ids as $id) {
            $totalProdutos = $produtoModel->where('cat_id', $id)->countAllResults();
            if ($totalProdutos > 0) {
                // Lança exceção para ser capturada no Controller/Service e retornar mensagem amigável
                throw new \RuntimeException('Não é possível desativar esta categoria pois existem produtos vinculados.');
            }
        }

        return $data;
    }

    /**
     * Arquitetura: Para atender ao requisito de usar SoftDelete NATIVO E 
     * alterar 'cat_ativo' para 0 simultaneamente, usamos este callback.
     */
    protected function inativarCategoria(array $data)
    {
        if (isset($data['id']) && $this->useSoftDeletes) {
            $ids = is_array($data['id']) ? $data['id'] : [$data['id']];
            $this->db->table($this->table)
                     ->whereIn($this->primaryKey, $ids)
                     ->update(['cat_ativo' => 0]);
        }

        return $data;
    }
}