<?php

  class Player_model extends CI_Model
  {
      public function __construct()
      {
          $this->load->database();
      }

      // add player
      public function add($data)
      {
          $success = $this->db->insert('players', $data);
          $id = $this->db->insert_id();
          if($success)
          {
              return $id;
          } else
          {
              return false;
          }
      }

      // get player, location and stats if avaialble by player id
      public function getPlayerById($id)
      {
          $this->db->select('p.*,
                             l.city, l.country, l.province,
                             s.player_id, s.speed, s.endurance, s.power, s.flexibility, s.agility'
                            );
          $this->db->from('players p, locations l, stats s');
          $this->db->where('p.id', $id);
          $this->db->where('p.location_id = l.id');
          $this->db->where('p.id = s.player_id');
          $query = $this->db->get();
          // if a query is returned
          if(sizeof($query->result_array()) > 0)
          {
              return $query->result_array();
          }
          // otherwise search again but without the stats
          else
          {
              $this->db->select('p.*, l.city, l.country, l.province');
              $this->db->from('players p, locations l');
              $this->db->where('p.id', $id);
              $this->db->where('p.location_id = l.id');
              $queryTwo = $this->db->get();

              if($queryTwo)
              {
                  return $queryTwo->result_array();
              }
              else
              {
                  return false;
              }
          }

      }

      // return all players and locations
      public function getallplayers()
      {
          $this->db->select ( 'players.*, locations.city, locations.country, locations.province' );
          $this->db->from ( 'players' );
          $this->db->join ( 'locations', 'players.location_id = locations.id' , 'left' );

          $query = $this->db->get();
          return $query->result_array();
      }

      // delete player by id
      public function delete($id)
      {
          $this->db->where('id', $id);
          if($this->db->delete('players'))
          {
              return true;
          }
          else
          {
              return false;
          }
      }
  }
