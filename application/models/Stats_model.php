<?php

  class Stats_model extends CI_Model
  {
      public function __construct()
      {
          $this->load->database();
      }

      // add stats
      public function add($data)
      {
          $success = $this->db->insert('stats', $data);
          if($success)
          {
              return true;
          } else
          {
              return false;
          }
      }

      // delete stats by id
      public function delete($id)
      {
          $this->db->where('player_id', $id);
          if($this->db->delete('stats'))
          {
              return true;
          }
          else
          {
              return false;
          }
      }
  }
