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
        if(isset($_POST) && !empty($_POST)){
            $this->form_validation->set_rules('name', 'Full Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            if ($this->form_validation->run() == false) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                 $this->load->front_render('contact_us'); 
            }else{
                   $options_data = array(
                       
                        'name'       => $this->input->post('name'),
                        'email'      => $this->input->post('email'),
                        'subject'    => $this->input->post('subject'),
                        'message'    => $this->input->post('message')
                    );
                    $option = array('table' => 'contact', 'data' => $options_data);
                    if ($this->common_model->customInsert($option)) {
                       $this->session->set_flashdata('success','Thank you for your message,we will contact you soon.');
                       redirect('contact-us');
                    }
                     redirect('contact-us');
            }
        }else{
           $this->load->front_render('contact_us'); 
        }
        
    }
    
    public function leadership() {
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('leadership');
    }

}
