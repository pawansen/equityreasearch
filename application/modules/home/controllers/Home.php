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

    public function cash(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('cash');
    }

     public function future(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('future');
    }

     public function mcx(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('mcx');
    }

     public function indexfutureoption(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('index_future_option');
    }

     public function option(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('option');
    }

    public function btststbt(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('btst_stbt');
    }

    public function pricing(){
          $this->data['parent'] = "Equity Reasearch";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('pricing');
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

    public function buy_now(){

        $this->load->view ( 'pay' );
    }

        /**
     * **************Secure Buy Package method*************
     */
    public function secureCheckOut() {
            $aid = base64_decode ( base64_decode ( $this->uri->segment ( 3 ) ) );
            $data ['package'] = $this->package_model->getPackage ( array (
                    'aid' => $aid 
            ) );
            $data ['user'] = $this->authentication_model->getUser ( array (
                    'emp_id' => $this->authentication_model->isEMpId () 
            ) );
            $data ['userInfo'] = $this->userdetail_model->getDetail ( array (
                    'emp_id' => $this->authentication_model->isEMpId () 
            ) );
            $this->load->view ( 'user/pay_money_checkout', $data );
    }
    /**
     * **************Secure Buy Package transaction success method*************
     */
    public function paySuccess() {
        $status = $_POST ["status"];
        $firstname = $_POST ["firstname"];
        $amount = $_POST ["amount"];
        $txnid = $_POST ["txnid"];
        $posted_hash = $_POST ["hash"];
        $key = $_POST ["key"];
        $productinfo = $_POST ["productinfo"];
        $email = $_POST ["email"];
        $salt = "GQs7yium";
        
        If (isset ( $_POST ["additionalCharges"] )) {
            $additionalCharges = $_POST ["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash ( "sha512", $retHashSeq );
        
        if ($hash != $posted_hash) {
            $this->session->set_flashdata ( 'error', 'Invalid Transaction. Please try again' );
            redirect ( 'home/myPackages' );
        } else {
            
            $package = $this->package_model->getPackage ( array (
                    'aid' => $productinfo 
            ) );
            $soldId = strtolower ( $package ['0']->plan_name ) . rand ( 0, 999999 );
            $sold = array (
                    'emp_id' => $this->authentication_model->isEMpId (),
                    'emp_code' => $this->authentication_model->isUserId (),
                    'txnid' => $txnid,
                    'hash_key' => $key,
                    'plan_name' => $package ['0']->plan_name,
                    'package_sold_id' => $soldId,
                    'package_aid' => $package ['0']->aid,
                    'price' => $package ['0']->price,
                    'plan_periods_month' => $package ['0']->plan_periods_month,
                    'buy_date' => standard_date ( 'DATE_MYSQL', time () ),
                    'status' => 1,
                    'active' => 1,
                    'create_date' => standard_date ( 'DATE_MYSQL', time () ) 
            );
            if ($this->package_model->setPackageSold ( $sold )) {
                $this->session->set_flashdata ( 'message', 'Conguratilation Your Package Successfully Buyer ! Thank You' );
                redirect ( 'home/myPackages' );
            } else {
                $this->session->set_flashdata ( 'error', 'Failed Buy! Please Try again' );
                redirect ( 'home/myPackages' );
            }
        }
    }
    /**
     * **************Secure Buy Package transaction failed method*************
     */
    public function payFailed() {
        $status = $_POST ["status"];
        $firstname = $_POST ["firstname"];
        $amount = $_POST ["amount"];
        $txnid = $_POST ["txnid"];
        
        $posted_hash = $_POST ["hash"];
        $key = $_POST ["key"];
        $productinfo = $_POST ["productinfo"];
        $email = $_POST ["email"];
        $salt = "GQs7yium";
        
        If (isset ( $_POST ["additionalCharges"] )) {
            $additionalCharges = $_POST ["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash ( "sha512", $retHashSeq );
        
        if ($hash != $posted_hash) {
            $this->session->set_flashdata ( 'error', 'Invalid Transaction. Please try again' );
            // redirect ( 'home/myPackages' );
        } else {
            
            $this->session->set_flashdata ( 'error', "Your order status is " . $status . "" );
            redirect ( 'home/myPackages' );
        }
    }

}
