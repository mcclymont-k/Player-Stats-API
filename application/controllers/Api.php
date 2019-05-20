<?php
header('Access-Control-Allow-Origin: *');
defined('BASEPATH') OR exit ('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';

class Api extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('player_model');
        $this->load->model('location_model');
        $this->load->model('stats_model');
        $this->load->library('form_validation');
    }
    // add player to database
    public function player_post()
    {
        foreach($_FILES as $key => $value)
        {
            // parse .json file
            $file = file_get_contents($value['tmp_name']);
            $type = $value['type'];
            $decodedFile = json_decode($file, true);
            //  check file uploaded is .json
            if($type === 'application/json')
            {
                foreach ($decodedFile['players'] as $player)
                {
                    $validated = array(
                      'name' => $player['name'],
                      'age' => $player['age'],
                      'city' => $player['location']['city'],
                      'province' => $player['location']['province'],
                      'country' => $player['location']['country']
                    );
                    $this->form_validation->set_data($validated);
                    $this->form_validation->set_rules('name', 'name', 'required|alpha');
                    $this->form_validation->set_rules('age', 'Age', 'required|numeric|max_length[100]');
                    $this->form_validation->set_rules('city', 'City', 'required|alpha|max_length[85]');
                    $this->form_validation->set_rules('country', 'Country', 'required|alpha|max_length[74]');
                    $this->form_validation->set_rules('province', 'Province', 'required|alpha|max_length[100]');

                    // id validation succeeds
                    if($this->form_validation->run())
                    {
                        $locationResponse = $this->location_model->add($validated['city'], $validated['country'], $validated['province']);
                        if($locationResponse === 0)
                        {
                            $this->response("Error whilst saving - please try again.");
                        }
                        else
                        {
                            $player_id = $this->player_model->add(array(
                                'name' => $validated['name'],
                                'age' => $validated['age'],
                                'location_id' => $locationResponse
                            ));

                            if($player_id)
                            {
                                // check if stats were sent in the request
                                if($player['stats'])
                                {
                                $success = $this->stats_model->add(array(
                                    'endurance' => $player['stats']['endurance'],
                                    'speed' => $player['stats']['speed'],
                                    'agility' => $player['stats']['agility'],
                                    'power' => $player['stats']['power'],
                                    'flexibility' => $player['stats']['flexibility'],
                                    'player_id' => $player_id
                                ));

                                    if($success)
                                    {
                                        $this->response('Successfully added a new player', 200);
                                    }
                                    else
                                    {
                                        $this->response('Error whilst saving the player, please try again', 404);
                                    }
                                }
                                else
                                {
                                    $this->response('Successfully added a new player', 200);
                                }
                            }
                            else
                            {
                               $this->response('Error whilst saving the player, please try again', 404);
                            }
                        }
                    }
                    // failed validation - return errors
                    else
                    {
                        $this->response($this->form_validation->error_array(), 404);
                    }
                }
            }
            // send error if file is not json
            else
            {
                $this->response(['You can only upload a .json'], 404);
            }
        }
    }

    // get all players
    public function players_get()
    {
        $result = $this->player_model->getallplayers();
        if($result)
        {
            $this->response($result, 200);
        }
        else
        {
            $this->response('No players in the database', 404);
        }
    }

    // get single player by id
    public function player_get()
    {
        $id = $this->get('id');
        if(!$id)
        {
            $this->response('No Player ID specified', 400);
        }
        $result = $this->player_model->getPlayerById($id);
        if($result)
        {
            $this->response($result, 200);
        }
        else
        {
            $this->response('Invalid Player ID', 404);
        }
    }

    // delete player by id
    public function delete_get()
    {
        $id = $this->get('id');
        if($id)
        {
            if($this->player_model->delete($id))
            {
              if($this->stats_model->delete($id))
              {
                  $this->response('You have deleted a patient successfully', 200);
              }
            }
        }
        else
        {
            $this->response('Failute to delete player, retirement will never strike', 404);
        }
    }
}
