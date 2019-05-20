<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Migration_Add_locations extends CI_Migration
{
    public function up()
    {
        $this->dbforge->add_field(
            array(
                'id' => array(
                   'type' => 'INT',
                   'constraint' => 5,
                   'auto_increment' => true
                ),
                'city' => array(
                   'type' => 'VARCHAR',
                   'constraint' => '100'
                ),
                'province' => array(
                   'type' => 'VARCHAR',
                   'constraint' => '100'
                ),
                'country' => array(
                    'type' => 'VARCHAR',
                    'constraint' => '100'
                )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('locations');
    }

    public function down()
    {
        $this->dbforge->drop_table('locations');
    }
}
