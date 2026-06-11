<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTabProduto extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'pro_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'pro_nome' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
            ],
            'cat_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ]);

        $this->forge->addKey('pro_id', true);
        
        $this->forge->addForeignKey('cat_id', 'tab_categoria', 'cat_id', 'RESTRICT', 'RESTRICT');
        
        $this->forge->createTable('tab_produto');
    }

    public function down()
    {
        $this->forge->dropTable('tab_produto');
    }
}