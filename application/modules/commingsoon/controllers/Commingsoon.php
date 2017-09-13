<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Commingsoon extends Common_Controller { 
    public $data = array();
    public $file_data = "";
    public $_table = CMS;
    public function __construct() {
        parent::__construct();
    }
    
     /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        $this->data['parent'] = "Comming Soon";
        $this->data['title'] = "Comming Soon";
        $this->load->view('commingsoon');
    }

}
