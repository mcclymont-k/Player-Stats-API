<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Migration_Add_players extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(
            array(
                'id' => array(
                   'type' => 'INT',
                   'constraint' => 5,
                   'unsigned' => true,
                   'auto_increment' => true
                ),
                'name' => array(
                   'type' => 'VARCHAR',
                   'constraint' => '100',
                ),
                'age' => array(
                   'type' => 'INT',
                   'constrain' => '100'
                ),
                'location_id' => array(
                    'type' => 'INT',
                    'unsigned' => true
                )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('players');
    }

    public function down()
    {
        $this->dbforge->drop_table('players');
    }
}
