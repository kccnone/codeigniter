<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error extends CI_Controller
{
    public function index()
    {
        $data['header'] = $this->info_model->getheader();

        $this->load->view('404',$data);
    }
}