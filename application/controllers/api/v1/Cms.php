<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for cms
 * @package   CodeIgniter
 * @category  Controller
 * @author    Developer
 */
class Cms extends Common_API_Controller {

    function __construct() {
        parent::__construct();
    }

    
    /**
     * Function Name: contact_us
     * Description:   To add contact details
     */
   function contact_us_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $insertArr = array();
           

            
            $insertArr['user_id'] = extract_value($data, 'user_id', '');
            $insertArr['message'] = extract_value($data, 'message', '');
            $insertArr['datetime'] = date('Y-m-d H:i:s');

            $options = array('table' => CONTACTS,
                'data' => $insertArr,
            );

            /* insert data into contacts table */
            $insert = $this->common_model->customInsert($options);
            if ($insert) {
                /* return success response */
                $return['status'] = 1;
                $return['message'] = 'Contact details successfully saved';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Contact details failed to saved';
            }
        }
        $this->response($return);
    }

}


/* End of file Cms.php */
/* Location: ./application/controllers/api/v1/Cms.php */
?>