<?php

class Migrate extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->input->is_cli_request()
            or exit('Execute via command line, please!!');
        $this->load->library('migration');
    }
    public function index()
    {
        if ($this->migration->current() === FALSE)
        {
            show_error($this->migration->error_string());
        }
    }
}
