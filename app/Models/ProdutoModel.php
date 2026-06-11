<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutoModel extends Model
{
    protected $table            = 'tab_produto';
    protected $primaryKey       = 'pro_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;

    protected $allowedFields    = [
        'pro_nome', 
        'cat_id'
    ];

    protected $validationRules      = [
        'pro_nome' => 'required|min_length[3]|max_length[255]',
        'cat_id'   => 'required|is_not_unique[tab_categoria.cat_id]'
    ];

    protected $validationMessages   = [
        'pro_nome' => [
            'required'   => 'O campo Nome do Produto é obrigatório.',
            'min_length' => 'O Nome do Produto deve ter no mínimo 3 caracteres.',
        ],
        'cat_id' => [
            'required'      => 'A seleção de uma Categoria é obrigatória.',
            'is_not_unique' => 'A Categoria informada não existe ou é inválida.'
        ]
    ];
}