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
        $this->data['parent'] = "home";
        $this->data['title'] = "Equity Reasearch";
        $this->load->front_render('home',$this->data);
    }

    public function aboutUs() {
        $this->data['parent'] = "about";
        $this->data['title'] = "About Us";
        $this->load->front_render('about_us',$this->data);
    }

    public function payment() {
        $this->data['parent'] = "payment";
        $this->data['title'] = "Payment Detail";
        $this->load->front_render('payment_gateway_list',$this->data);
    }

    public function contactUs() {
        $this->data['parent'] = "contact";
        $this->data['title'] = "Contact Us";
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
            $this->load->front_render('contact_us',$this->data);
        }
    }

    public function cash() {
        $this->data['parent'] = "cash";
        $this->data['title'] = "Cash Service";
        $this->load->front_render('cash',$this->data);
    }

    public function future() {
        $this->data['parent'] = "future";
        $this->data['title'] = "Future Service";
        $this->load->front_render('future',$this->data);
    }

    public function mcx() {
        $this->data['parent'] = "mcx";
        $this->data['title'] = "MCX Service";
        $this->load->front_render('mcx',$this->data);
    }

    public function indexfutureoption() {
        $this->data['parent'] = "futureoption";
        $this->data['title'] = "Index Future Option Service";
        $this->load->front_render('index_future_option',$this->data);
    }

    public function option() {
        $this->data['parent'] = "option";
        $this->data['title'] = "Option Service";
        $this->load->front_render('option',$this->data);
    }

    public function btststbt() {
        $this->data['parent'] = "btst";
        $this->data['title'] = "BTST & STBT Service";
        $this->load->front_render('btst_stbt',$this->data);
    }

    public function pricing() {
        $this->data['parent'] = "pricing";
        $this->data['title'] = "Pricing";
        $this->load->front_render('pricing',$this->data);
    }

    public function sureShot() {
        $this->data['parent'] = "sure";
        $this->data['title'] = "Sure Shot Service";
        $this->load->front_render('sure_shot',$this->data);
    }

    public function circuitCall() {
        $this->data['parent'] = "circuit";
        $this->data['title'] = "Circuit Call Service";
        $this->load->front_render('circuit_call',$this->data);
    }

    public function premium() {
        $this->data['parent'] = "premium";
        $this->data['title'] = "Premium Service";
        $this->load->front_render('premium',$this->data);
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
                'message' => "Null",
                'mobile' => $this->input->post('mobiles')
            );
            $option = array('table' => 'free_trial', 'data' => $options_data);
            $last_id = $this->common_model->customInsert($option);
            if ($last_id) {
                $this->session->set_flashdata('success', 'Thank you for your message,we will contact you soon.');
                $response = array('status' => 1, 'message' => "Thank you for your message,we will contact you soon.");
            } else {
                $response = array('status' => 0, 'message' => "Error Please try again.");
            }
        }
        echo json_encode($response);
    }

    public function buy_now() {
        $this->data['parent'] = "payment";
        $this->data['title'] = "Payment Now";
        $this->load->front_render('payment',$this->data);
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
        $phone = $_POST ["phone"];
        $city = $_POST ["city"];
        $service = $_POST ["udf1"];
        $zipcode = $_POST ["zipcode"];
        $salt = "3bEsI15gjM";

        If (isset($_POST ["additionalCharges"])) {
            $additionalCharges = $_POST ["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $this->session->set_flashdata('error', 'Invalid Transaction. Please try again');
            redirect('pricing');
        } else {

            $package = $this->package_model->getPackage(array(
                'aid' => $productinfo
                    ));
            $soldId = strtolower($package ['0']->plan_name) . rand(0, 999999);
            $options_data = array(
                'name' => $firstname,
                'email' => $email,
                'phone' => $phone,
                'txnid' => $txnid,
                'hash_key' => $key,
                'city' => $city,
                'service' => $service,
                'zipcode' => $zipcode,
                'price' => $package ['0']->price,
                'buy_date' => date('Y-m-d H:i:s'),
                'create_date' => date('Y-m-d H:i:s'),
            );
            $option = array('table' => 'payment', 'data' => $options_data);
            if ($this->common_model->customInsert($option)) {
                $this->session->set_flashdata('success', 'Conguratilation Your Package Successfully Buyer ! Thank You');
                redirect('pricing');
            } else {
                $this->session->set_flashdata('error', 'Failed Buy! Please Try again');
                redirect('pricing');
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
        $salt = "3bEsI15gjM";

        If (isset($_POST ["additionalCharges"])) {
            $additionalCharges = $_POST ["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $this->session->set_flashdata('error', 'Invalid Transaction. Please try again');
            redirect('pricing');
        } else {

            $this->session->set_flashdata('error', "Your order status is " . $status . "");
            redirect('pricing');
        }
    }

}
