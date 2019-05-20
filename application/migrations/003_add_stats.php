<?php

defined('BASEPATH') OR exit ('No direct script access allowed');

class Migration_Add_stats extends CI_Migration
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
                'player_id' => array(
                   'type' => 'INT',
                   'constraint' => 5
                ),
                'speed' => array(
                   'type' => 'INT',
                   'constraint' => 10
                ),
                'agility' => array(
                   'type' => 'INT',
                   'constraint' => 10
                ),
                'power' => array(
                    'type' => 'INT',
                    'constraint' => 10
                ),
                'endurance' => array(
                    'type' => 'INT',
                    'constraint' => 10
                ),
                'flexibility' => array(
                    'type' => 'INT',
                    'constrain' => 10
                )
           )
        );

        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('stats');
    }

    public function down()
    {
        $this->dbforge->drop_table('stats');
    }
}
