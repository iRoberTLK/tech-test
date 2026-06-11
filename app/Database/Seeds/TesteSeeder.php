<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\CategoriaModel;
use App\Models\ProdutoModel;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class TesteSeeder extends Seeder
{
    public function run()
    {
        // 1. Criar Usuário de Teste (Shield)
        $users = new UserModel();
        
        // Verifica se o usuário já existe para evitar duplicidade
        if (!$users->findByCredentials(['email' => 'avaliador@teste.com'])) {
            $user = new User([
                'username' => 'Avaliador',
                'email'    => 'avaliador@teste.com',
                'password' => '12345678',
            ]);
            $users->save($user);
            
            // Ativa o usuário se necessário (depende das configurações do Shield, por padrão já fica ativo)
        }

        // 2. Criar Categorias Iniciais
        $categoriaModel = new CategoriaModel();
        
        $categorias = [
            ['cat_nome' => 'Eletrônicos', 'cat_descricao' => 'Dispositivos eletrônicos em geral', 'cat_ativo' => 1],
            ['cat_nome' => 'Móveis', 'cat_descricao' => 'Móveis para escritório e casa', 'cat_ativo' => 1],
            ['cat_nome' => 'Informática', 'cat_descricao' => 'Computadores e periféricos', 'cat_ativo' => 1],
        ];

        foreach ($categorias as $cat) {
            if ($categoriaModel->where('cat_nome', $cat['cat_nome'])->countAllResults() == 0) {
                $categoriaModel->insert($cat);
            }
        }

        // 3. Criar Produtos Iniciais
        $produtoModel = new ProdutoModel();
        
        // Pega IDs reais inseridos para garantir integridade
        $catEletronicos = $categoriaModel->where('cat_nome', 'Eletrônicos')->first();
        $catInformatica = $categoriaModel->where('cat_nome', 'Informática')->first();

        if ($catEletronicos && $catInformatica) {
            $produtos = [
                ['pro_nome' => 'Smartphone XYZ', 'cat_id' => $catEletronicos->cat_id],
                ['pro_nome' => 'Smart TV 55', 'cat_id' => $catEletronicos->cat_id],
                ['pro_nome' => 'Notebook Pro', 'cat_id' => $catInformatica->cat_id],
                ['pro_nome' => 'Mouse Sem Fio', 'cat_id' => $catInformatica->cat_id],
            ];

            foreach ($produtos as $pro) {
                if ($produtoModel->where('pro_nome', $pro['pro_nome'])->countAllResults() == 0) {
                    $produtoModel->insert($pro);
                }
            }
        }
    }
}