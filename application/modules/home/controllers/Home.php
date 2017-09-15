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
        if (isset($_POST) && !empty($_POST)) {
            $this->form_validation->set_rules('name', 'Full Name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
            if ($this->form_validation->run() == false) {
                $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
                $this->load->front_render('contact_us');
            } else {
                $options_data = array(
                    'name' => $this->input->post('name'),
                    'email' => $this->input->post('email'),
                    'subject' => $this->input->post('subject'),
                    'message' => $this->input->post('message'),
                    'mobile' => $this->input->post('mobile')
                );
                $option = array('table' => 'contact', 'data' => $options_data);
                if ($this->common_model->customInsert($option)) {
                    $this->session->set_flashdata('success', 'Thank you for your message,we will contact you soon.');
                    redirect('contact-us');
                }
                redirect('contact-us');
            }
        } else {
            $this->load->front_render('contact_us');
        }
    }

    public function leadership() {
        $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('leadership');
    }

    public function freetrials() {
        $this->form_validation->set_rules('names', 'Full Name', 'required');
        $this->form_validation->set_rules('emails', 'Email', 'required');
        $this->form_validation->set_rules('mobiles', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
        if ($this->form_validation->run() == false) {
            $this->form_validation->set_error_delimiters('<div class="error">', '</div>');
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        } else {
            $options_data = array(
                'name' => $this->input->post('names'),
                'email' => $this->input->post('emails'),
                'message' => $this->input->post('messages'),
                'mobile' => $this->input->post('mobiles')
            );
            $option = array('table' => 'free_trial', 'data' => $options_data);
            $last_id = $this->common_model->customInsert($option);
            if ($last_id) {
                $this->session->set_flashdata('success', 'Thank you for your message,we will contact you soon.');
                $response = array('status' => 1, 'message' => "Thank you for your message,we will contact you soon.");
            }else{
               $response = array('status' => 0, 'message' => "Error Please try again."); 
            }
        }
        echo json_encode($response);
    }

}
