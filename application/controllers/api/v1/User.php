<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for user
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class User extends Common_API_Controller {

    function __construct() {
        parent::__construct();
        $tables = $this->config->item('tables', 'ion_auth');
        $this->lang->load('en', 'english');
    }

    /**
     * Function Name: signup
     * Description:   To User Registration
     */
    function signup_post() {

        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email|is_unique[' . USERS . '.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|max_length[14]');
        $this->form_validation->set_rules('confm_pswd', 'Confirm Password', 'trim|required|min_length[6]|max_length[14]|matches[password]');
        $this->form_validation->set_rules('address', 'Address', 'trim|required');
        $this->form_validation->set_rules('date_of_birth', 'Date of Birth', 'trim|required|callback__validate_birthdate_format');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required|in_list[MALE,FEMALE]');
        $this->form_validation->set_rules('device_type', 'Device Type', 'trim|required|in_list[ANDROID,IOS]');
        $this->form_validation->set_rules('device_token', 'Device Token', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $this->data['identity_column'] = $identity_column;
            $identity = extract_value($data, 'email', '');
            $password = extract_value($data, 'password', '');
            $email = strtolower(extract_value($data, 'email', ''));
            $identity = ($identity_column === 'email') ? $email : extract_value($data, 'email', '');

            $dataArr = array();
            $dataArr['first_name'] = extract_value($data, 'first_name', '');
            $dataArr['last_name'] = extract_value($data, 'last_name', '');
            $dataArr['username'] = extract_value($data, 'username', '');
            $dataArr['street'] = extract_value($data, 'address', '');
            $dataArr['phone'] = extract_value($data, 'phone_number', '');
            $dataArr['gender'] = extract_value($data, 'gender', '');
            $dataArr['date_of_birth'] = extract_value($data, 'date_of_birth', '');
            $dataArr['login_session_key'] = get_guid();
            $dataArr['device_token'] = extract_value($data, 'device_token', '');
            $dataArr['device_type'] = extract_value($data, 'device_type', '');
            $dataArr['device_id'] = extract_value($data, 'device_id', '');
            $dataArr['is_pass_token'] = $password;
            $dataArr['email_verify'] = 1;
            $dataArr['created_on'] = time();
            $username = explode('@', $identity);
            $dataArr['username'] = $username[0];
            if (isset($_FILES['user_image']['name']) && !empty($_FILES['user_image']['name'])) {
                /* Upload user image */
                $image = fileUpload('user_image', 'users', 'png|jpg|jpeg|gif');
                if (isset($image['error'])) {
                    $return['status'] = 0;
                    $return['message'] = strip_tags($image['error']);
                    $this->response($return);
                    exit;
                } else {
                    $dataArr['profile_pic'] = 'uploads/users/' . $image['upload_data']['file_name'];
                }

                /* Create user image thumb */
                $dataArr['user_image_thumb'] = get_image_thumb($dataArr['profile_pic'], 'users', 250, 250);
            }
            $lid = $this->ion_auth->register($identity, $password, $email, $dataArr, array(2));
            /* Insert User Data Into Users Table */
            //$lid = $this->common_model->insertData(USERS, $dataArr);
            if ($lid) {
                /* Save user device history */
                save_user_device_history($lid, $dataArr['device_token'], $dataArr['device_type'], $dataArr['device_id']);

                //$email = $dataArr['email'];
                $token = encoding($email . "-" . $lid . "-" . time());

                /* Update user token */
                $tokenArr = array('user_token' => $token);
                $this->common_model->updateFields(USERS, $tokenArr, array('id' => $lid));

                /* Send verification mail to user */
                $link = base_url() . 'auth/verifyuser?email=' . $email . '&token=' . $token;
                $message = "";
                $message .= "<img style='width:200px' src='" . base_url() . getConfig('site_logo') . "' class='img-responsive'></br></br>";
                $message .= "<br><br> Hello, <br/><br/>";
                $message .= "Your " . getConfig('site_name') . " profile has been created. Please click on below link to verify your account. <br/><br/>";
                $message .= "Click here : <a href='" . $link . "'>Verify Your Email</a>";
                send_mail($message, '[' . getConfig('site_name') . '] Thank you for registering with us', $email, getConfig('admin_email'));
                /* Return success response */
                $return['status'] = 1;
                $return['message'] = 'User registered successfully';
            } else {
                $is_error = db_err_msg();
                if ($is_error == FALSE) {
                    $return['status'] = 1;
                    $return['message'] = 'User registered successfully';
                } else {
                    $return['status'] = 0;
                    $return['message'] = $is_error;
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: login
     * Description:   To User Login
     */
    function login_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        //$this->form_validation->set_rules('device_type', 'Device Type', 'trim|required|in_list[ANDROID,IOS]');
        // $this->form_validation->set_rules('device_token', 'Device Token', 'trim|required');
        //$this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $email = extract_value($data, 'email', '');
            $password = extract_value($data, 'password', '');
            $dataArr['email'] = extract_value($data, 'email', '');
            /* Get User Data From Users Table */
            $Status = $this->ion_auth->login($email, $password, FALSE);
            if ($Status) {
                $Status = $this->common_model->getsingle(USERS, $dataArr);
            }
            if (empty($Status)) {
                $return['status'] = 0;
                $return['message'] = 'Invalid Email-id or Password';
            } else if (!empty($Status) && $Status->email_verify == 0) {
                $return['status'] = 0;
                $return['message'] = 'Currently your profile is not verified, please verfiy your email id';
            } else if (!empty($Status) && $Status->is_blocked == 1) {
                $return['status'] = 0;
                $return['message'] = BLOCK_USER;
            } else if (!empty($Status) && $Status->active == 0) {
                $return['status'] = 0;
                $return['message'] = DEACTIVATE_USER;
            } else if ($Status->email_verify == 1 && $Status->is_blocked == 0 && $Status->active == 1) {




                /* Update User Data */
                $UpdateData = array();
                $UpdateData['device_type'] = extract_value($data, 'device_type', NULL);
                $UpdateData['device_token'] = extract_value($data, 'device_token', NULL);
                $UpdateData['device_id'] = extract_value($data, 'device_id', NULL);
                $UpdateData['is_logged_out'] = 0;
                $UpdateData['login_session_key'] = get_guid();
                $UpdateData['last_login'] = time();
                $this->common_model->updateFields(USERS, $UpdateData, array('id' => $Status->id));
                /* Save user device history */
                save_user_device_history($Status->id, $UpdateData['device_token'], $UpdateData['device_type'], $UpdateData['device_id']);

                $option = array('table' => USERS . ' as user',
                    'select' => 'user.*,org.id as org_id,org.name as org_name,group.id as group_id,group.name as group_name',
                    'join' => array(array(USER_GROUPS . ' as ugroup', 'ugroup.user_id=user.id', 'left'),
                        array(GROUPS . ' as group', 'group.id=ugroup.group_id', 'left'),
                        array(ORGANIZATION . ' as org', 'org.id=ugroup.organization_id', 'left')),
                    'order' => array('user.id' => 'DESC'),
                    'where' => array('user.id' => $Status->id),
                    'single' => true
                );
                $user_data = $this->common_model->customGet($option);
                if ($user_data->group_id == DIRECTOR_ROLE) {
                    $return['status'] = 0;
                    $return['message'] = 'Invalid Email-id or Password';
                    $this->response($return);
                    exit;
                }

                $option1 = array('table' => GROUPS . ' as groups',
                    'select' => 'groups.name as role_name,groups.id as role_id',
                    'join' => array(array(HIERARCHY_ROLE_ORDER . ' as roles' => 'roles.role_id=groups.id'),
                        array(HIERARCHY . ' as hierarchy' => 'hierarchy.role_id=groups.id')),
                    'where' => array('roles.organization_id' => $user_data->org_id,
                        'hierarchy.applicable_status' => 1
                    ),
                    'where_not_in' => array('groups.id' => array(DIRECTOR_ROLE)),
                    'order' => array('roles.id' => 'asc'),
                    'group_by' => array('roles.id')
                );

                $roles = $this->common_model->customGet($option1);


                /* Return Response */
                $response = array();

                if (!empty($Status->profile_pic)) {
                    $image = base_url() . $Status->profile_pic;
                } else {
                    /* set default image if empty */
                    $image = base_url() . 'backend_asset/images/no_image.jpg';
                }
                $response['user_id'] = null_checker($Status->id);
                $response['name'] = null_checker($Status->first_name) . ' ' . null_checker($Status->last_name);
                $response['email'] = null_checker($Status->email);
                $response['user_original_image'] = $image;
                $response['login_session_key'] = null_checker($user_data->login_session_key);
                $response['badges'] = null_checker($Status->badges);
                $response['role_id'] = $user_data->group_id;
                $response['role_name'] = $user_data->group_name;
                $response['organization_id'] = $user_data->org_id;
                $response['organization_name'] = $user_data->org_name;
                $response['submission_status'] = 0;
                $response['position'] = 0;
                $options = array('table' => USER_ASSESSMENT . ' as UA',
                    'select' => 'UA.id,UA.assessment_status',
                    'where' => array('UA.user_id' => $Status->id, 'assessment_status' => 1),
                    'order' => array('id' => 'desc'),
                    'single' => true
                );
                $is_submission = $this->common_model->customGet($options);
                if (!empty($is_submission)) {
                    $response['submission_status'] = 1;
                }
                $last_position = getRolePosition($user_data->org_id, 1, 0);
                if ($last_position == $user_data->group_id) {
                    $response['position'] = 1; // last position in roles
                } else {
                    $second_last_position = getRolePosition($user_data->org_id, 1, 1);
                    if ($second_last_position == $user_data->group_id) {
                        $response['position'] = 2; // second last position in roles  
                    }
                }
                $response['organization'] = $roles;
                $return['response'] = $response;
                $return['status'] = 1;
                $return['message'] = 'User logged in successfully';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: countries
     * Description:   To Get All Countries
     */
    function countries_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $countries = $this->common_model->getAll(COUNTRY, 'name', 'ASC');
            if ($countries['result']) {
                /* Return Response */
                $response = array();

                foreach ($countries['result'] as $r) {
                    $country_name = null_checker($r->name);
                    array_push($response, $country_name);
                }
                $return['status'] = 1;
                $return['response'] = $response;
                $return['message'] = 'success';
            } else {
                $return['status'] = 0;
                $return['message'] = 'Countries not found';
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: resend_verification_link
     * Description:   To Re-send User Verification Link
     */
    function resend_verification_link_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dataArr['email'] = extract_value($data, 'email', '');

            /* Get User Data From Users Table */
            $result = $this->common_model->getsingle(USERS, $dataArr);
            if (empty($result)) {
                $return['status'] = 0;
                $return['message'] = 'Email-id does not exist';
            } else {
                if ($result->email_verify == 0) {
                    if ($result->is_social_signup == 0) {
                        $user_id = $result->id;
                        $user_email = $result->email;
                        /* Update user token */
                        $token = encoding($user_email . "-" . $user_id . "-" . time());
                        $tokenArr = array('user_token' => $token);
                        $update_status = $this->common_model->updateFields(USERS, $tokenArr, array('id' => $user_id));
                        $link = base_url() . 'user/verifyuser?email=' . $user_email . '&token=' . $token;
                        $message = "";
                        $message .= "<img style='width:200px' src='" . base_url() . getConfig('site_logo') . "' class='img-responsive'></br></br>";
                        $message .= "<br><br> Hello, <br/><br/>";
                        $message .= "Your " . getConfig('site_name') . " profile has been created. Please click on below link to verify your account. <br/><br/>";
                        $message .= "Click here : <a href='" . $link . "'>Verify Your Email</a>";
                        $status = send_mail($message, '[' . getConfig('site_name') . '] Thank you for registering with us', $user_email, getConfig('admin_email'));

                        if ($status) {
                            $return['status'] = 1;
                            $return['message'] = 'An email has been sent. Please check your inbox';
                        } else {
                            $return['status'] = 0;
                            $return['message'] = EMAIL_SEND_FAILED;
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = 'Social User can not make request';
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = 'Profile already verified';
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: forgot_password
     * Description:   To User Forgot Password
     */
    function forgot_password_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('email', 'Email Id', 'trim|required|valid_email');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dataArr['email'] = extract_value($data, 'email', '');

            /* Get User Data From Users Table */
            $result = $this->common_model->getsingle(USERS, $dataArr);
            if (empty($result)) {
                $return['status'] = 0;
                $return['message'] = 'Email-id does not exist';
            } else {

                $identity_column = $this->config->item('identity', 'ion_auth');
                $identity = $this->ion_auth->where($identity_column, $this->input->post('email'))->users()->row();

                if (empty($identity)) {

                    if ($this->config->item('identity', 'ion_auth') != 'email') {
                        $error = "No record of that email address";
                    } else {
                        $error = "No record of that email address";
                    }
                    $return['status'] = 0;
                    $return['message'] = $error;
                    $this->response($return);
                    exit;
                }


                $forgotten = $this->ion_auth->forgotten_password_app($identity->{$this->config->item('identity', 'ion_auth')});

                if ($forgotten) {

                    $return['status'] = 1;
                    $return['message'] = strip_tags($this->ion_auth->messages());
                } else {
                    $return['status'] = 0;
                    $return['message'] = strip_tags($this->ion_auth->errors());
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: update_profile
     * Description:   To Update User Profile
     */
    function update_profile_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();

        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');


        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();
            $dateOfBirth = date('Y-m-d', strtotime(extract_value($data, 'date_of_birth', '')));
            $dataArr['first_name'] = extract_value($data, 'first_name', '');
            $dataArr['last_name'] = extract_value($data, 'last_name', '');
            $dataArr['date_of_birth'] = $dateOfBirth;

            /* Update User Data Into Users Table */
            $status = $this->common_model->updateFields(USERS, $dataArr, array('id' => $this->user_details->id));
            if ($status) {
                /* Return success response */
                $return['status'] = 1;
                $return['message'] = 'User details updated successfully';
            } else {
                $is_error = db_err_msg();
                $return['status'] = 0;
                if ($is_error == FALSE) {
                    $return['message'] = NO_CHANGES;
                } else {
                    $return['message'] = $is_error;
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: deactivate_account
     * Description:   To Deactivate User Account
     */
    function deactivate_account_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            if ($this->user_details->active == 0) {
                $return['status'] = 0;
                $return['message'] = 'Account already deactivated';
            } else if ($this->user_details->active == 1) {
                /* Update User Details */
                $status = $this->common_model->updateFields(USERS, array('is_deactivated' => 1), array('id' => $this->user_details->id));
                if ($status) {
                    $return['status'] = 1;
                    $return['message'] = 'Account deactivated successfully';
                } else {
                    $is_error = db_err_msg();
                    $return['status'] = 0;
                    if ($is_error == FALSE) {
                        $return['message'] = NO_CHANGES;
                    } else {
                        $return['message'] = $is_error;
                    }
                }
            }
        }
        $this->response($return);
    }

    /*
     * Function Name: profile_details
     * Description:   To Get User Profile Details
     */

    function profile_details_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* Return Response */
            $response = array();

            if (!empty($this->user_details->profile_pic)) {
                $image = base_url() . $this->user_details->profile_pic;
            } else {
                /* set default image if empty */
                $image = base_url() . DEFAULT_NO_IMG_PATH;
            }

            $response['login_session_key'] = null_checker($this->user_details->login_session_key);
            $response['first_name'] = null_checker($this->user_details->first_name);
            $response['last_name'] = null_checker($this->user_details->last_name);
            $response['email'] = null_checker($this->user_details->email);
            // $response['username'] = null_checker($this->user_details->username);
            //$response['address'] = null_checker($this->user_details->street);
            $response['phone_number'] = null_checker($this->user_details->phone);
            $response['gender'] = null_checker($this->user_details->gender);
            $response['date_of_birth'] = null_checker($this->user_details->date_of_birth);
            //$response['social_type'] = null_checker($this->user_details->social_type);
            $response['badges'] = (int) null_checker($this->user_details->badges);

            $response['user_image'] = $image;
            $return['status'] = 1;
            $return['response'] = $response;
            $return['message'] = 'success';
        }
        $this->response($return);
    }

    /**
     * Function Name: change_profile_image
     * Description:   To Change User Profile Image
     */
    function change_profile_image_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required');
        if (empty($_FILES['user_image']['name'])) {
            $this->form_validation->set_rules('user_image', 'User Image', 'required');
        }
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $dataArr = array();

            /* Upload user image */
            $image = fileUpload('user_image', 'users', 'png|jpg|jpeg|gif');
            if (isset($image['error'])) {
                $return['status'] = 0;
                $return['message'] = $image['error'];
            } else {
                $dataArr['profile_pic'] = 'uploads/users/' . $image['upload_data']['file_name'];

                /* Create user image thumb */
                $dataArr['user_image_thumb'] = get_image_thumb($dataArr['profile_pic'], 'users', 250, 250);

                /* Update User Details */
                $status = $this->common_model->updateFields(USERS, $dataArr, array('id' => $this->user_details->id));
                if ($status) {
                    /* Return Response */
                    $response = array();
                    $response['user_original_image'] = base_url() . $dataArr['profile_pic'];
                    // $response['user_thumb_image'] = base_url() . $dataArr['user_image_thumb'];
                    $return['response'] = $response;
                    $return['status'] = 1;
                    $return['message'] = 'Profile image updated successfully';
                } else {
                    $is_error = db_err_msg();
                    $return['status'] = 0;
                    if ($is_error == FALSE) {
                        $return['message'] = NO_CHANGES;
                    } else {
                        $return['message'] = $is_error;
                    }
                }
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: change_password
     * Description:   To Change User Password
     */
    function change_password_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required');
        $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|min_length[6]|max_length[14]|callback_is_secure_pass');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|min_length[6]|max_length[14]|matches[new_password]');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $current_password = extract_value($data, 'current_password', "");
            $new_password = extract_value($data, 'new_password', "");
            $confirm_password = extract_value($data, 'confirm_password', "");

            /* To check user current password */
            $identity = $this->user_details->email;
            $change = $this->ion_auth->change_password($identity, $current_password, $new_password);
            if (!empty($change)) {
                $options = array('table' => USERS,
                    'data' => array('is_pass_token' => $this->input->post('new_password')),
                    'where' => array('email' => $identity));
                $this->common_model->customUpdate($options);
                $return['status'] = 1;
                $return['message'] = 'The new password has been saved successfully';
            } else {
                $return['status'] = 0;
                $return['message'] = 'The old password you entered was incorrect';
            }
        }
        $this->response($return);
    }

    /*
     * Function Name: logout
     * Description:   To User Logout
     */

    function logout_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        $this->form_validation->set_rules('device_id', 'Device Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* User Data Array */
            $user_data = array();
            $user_data['device_id'] = extract_value($data, 'device_id', NULL);

            /* Update User logout status */
            $this->common_model->updateFields(USERS, array('is_logged_out' => 1), array('id' => $this->user_details->id));

            /* Delete User Device History */
            $this->common_model->deleteData(USERS_DEVICE_HISTORY, $user_data);

            $return['status'] = 1;
            $return['message'] = 'User logout successfully';
        }
        $this->response($return);
    }

    /**
     * Function Name: clear_badges
     * Description:   To Clear Notification Badges
     */
    function clear_badges_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* Update user badges */
            $this->common_model->updateFields(USERS, array('badges' => 0), array('id' => $this->user_details->id));

            $return['status'] = 1;
            $return['message'] = 'Badges cleared successfully';
        }
        $this->response($return);
    }

    /**
     * Function Name: get_badges
     * Description:   To Get Notification Badges
     */
    function get_badges_post() {
        $return['code'] = 200;
        $return['response'] = new stdClass();
        $data = $this->input->post();
        $this->form_validation->set_rules('login_session_key', 'Login Session Key', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            /* To get user badges */
            $badges = $this->common_model->getsingle(USERS, array('id' => $this->user_details->id));
            if (!empty($badges)) {
                $return['response'] = array('badges' => (int) null_checker($badges->badges));
            } else {
                $return['response'] = array('badges' => 0);
            }
            $return['status'] = 1;
            $return['message'] = 'Success';
        }
        $this->response($return);
    }

    /**
     * Function Name: get_roles
     * Description:   To Get user roles by hierarchy
     */
    function get_roles_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $response = array();
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $user_id = extract_value($data, 'user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $role_id = extract_value($data, 'role_id', '');
            $exists_user = $this->common_model->getsingle(USERS, array('id' => $user_id));
            if (!empty($exists_user)) {
                $option = array('table' => GROUPS . ' as groups',
                    'select' => 'groups.name as role_name,groups.id as role_id',
                    'join' => array(array(HIERARCHY_ROLE_ORDER . ' as roles' => 'roles.role_id=groups.id'),
                        array(HIERARCHY . ' as hierarchy' => 'hierarchy.role_id=groups.id')),
                    'where' => array('roles.organization_id' => $organization_id,
                        'hierarchy.applicable_status' => 1
                    ),
                    'order' => array('roles.id' => 'asc'),
                    'group_by' => array('roles.id')
                );

                $roles = $this->common_model->customGet($option);
                $u_role = array();
                foreach ($roles as $rows) {
                    $tmp['role_name'] = $rows->role_name;
                    $tmp['role_id'] = $rows->role_id;
                    $u_role[] = $tmp;
                }

                $key = array_search($role_id, array_column($u_role, 'role_id'));
                $user_roles = array();
                /* for ($i = $key + 1; $i < count($roles); $i++) {
                  $user_roles[] = $roles[$i]->role_id;
                  } */
                $user_roles[] = $roles[$key + 1]->role_id;
                if (!empty($user_roles)) {
                    $option = array('table' => USERS . ' as user',
                        'select' => 'user.id as user_id,user.first_name,user.last_name,group.name as role_name,group.id as role_id,'
                        . ' user.profile_pic',
                        'join' => array(USER_GROUPS . ' as ugroup' => 'ugroup.user_id=user.id',
                            GROUPS . ' as group' => 'group.id=ugroup.group_id'
                        ),
                        'where' => array('ugroup.organization_id' => $organization_id),
                        'where_in' => array('group.id' => $user_roles));
                    $users = $this->common_model->customGet($option);

                    foreach ($users as $rows) {
                        $temp1['user_id'] = $rows->user_id;
                        $temp1['first_name'] = $rows->first_name;
                        $temp1['last_name'] = $rows->last_name;
                        $temp1['role_name'] = $rows->role_name;
                        $temp1['role_id'] = $rows->role_id;
                        $temp1['profile_pic'] = (!empty($rows->profile_pic)) ? base_url() . $rows->profile_pic : base_url() . DEFAULT_NO_IMG_PATH;
                        $response[] = $temp1;
                    }
                    $return['status'] = 1;
                    $return['message'] = lang('api_role_list_success');
                    $return['response'] = $response;
                } else {
                    $return['status'] = 1;
                    $return['message'] = lang('api_role_list_success');
                    $return['response'] = $response;
                }
            } else {
                $return['status'] = 0;
                $return['message'] = lang('api_user_not_exists');
            }
        }
        $this->response($return);
    }

}

/* End of file User.php */
/* Location: ./application/controllers/api/v1/User.php */
?>