<?php

  class Location_model extends CI_Model
  {
      public function __construct()
      {
          $this->load->database();
      }

      public function add($city, $country, $province)
      {
          $location = array(
              'city' => $city,
              'province' => $province,
              'country' => $country
          );
          $this->db->select('city, province, country, id');
          $this->db->from('locations');
          $this->db->where($location);
          $query = $this->db->get();
          if(count($query->result_array()) !== 0)
          {
              return $query->row()->id;
          }
          else
          {
              $success = $this->db->insert('locations', $location);
              $id = $this->db->insert_id();
              if($success)
              {
                  return $id;
              } else
              {
                  return false;
              }
          }

      }
  }
