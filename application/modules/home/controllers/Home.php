<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Common_Controller { 
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
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('home');
    }
    
    public function aboutUs() {
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('about_us');
    }
    
    public function contactUs() {
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('contact_us');
    }
    
    public function leadership() {
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('leadership');
    }

}
