<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabCategoria extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'cat_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'cat_nome' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'unique'     => true,
            ],
            'cat_descricao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cat_ativo' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'cat_criado_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'cat_alterado_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'cat_excluido_em' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('cat_id', true);
        $this->forge->createTable('tab_categoria');
    }

    public function down()
    {
        $this->forge->dropTable('tab_categoria');
    }
}