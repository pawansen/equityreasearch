<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Common_Controller {

    public $data = "";

    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        $this->load->helper(array('language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

    public function index() {
        $this->data['parent'] = "Dashboard";
        if (!$this->ion_auth->logged_in()) {
            //$this->session->set_flashdata('message', 'Your session has been expired');
            redirect('admin/login', 'refresh');
        } else {
            if (!$this->ion_auth->is_admin()) {
                $this->session->set_flashdata('message', 'You are not authorised to access administration');
                redirect('admin/login', 'refresh');
            } else {
                $this->data['title'] = "Dashboard";
                $option = array('table' => ORGANIZATION,
                    'select' => 'id,name'
                );
                $this->data['organization'] = $this->common_model->customGet($option);
                //$this->load->admin_render('dashboard', $this->data, 'inner_script');
                redirect('charts/tracking_180');
            }
        }
    }

    public function generateReportDashboard() {
        $allUsers = array();
        $organization_id = $this->input->post('organization_id');
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 5 AND UA.assessment_type=180 GROUP BY user.id"
                . "";
        $lowerUsers = $this->common_model->customQuery($sql);
        if (!empty($lowerUsers)) {
            $temp = "";
            foreach ($lowerUsers as $usr) {
                $temp .= $usr->id . ",";
            }
            $temp1 = rtrim($temp, ',');
            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE UH.child_user_id IN ($temp1) AND ug.organization_id  = '" . $organization_id . "' GROUP BY user.id "
                    . "";
            $lowerUsersAll = $this->common_model->customQuery($sql);
            if (!empty($lowerUsersAll)) {
                $temp2 = "";
                foreach ($lowerUsersAll as $usr) {
                    $temp2 .= $usr->id . ",";
                }
                $temp3 = rtrim($temp2, ',');
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " WHERE UH.child_user_id IN ($temp3) AND ug.organization_id  = '" . $organization_id . "' GROUP BY user.id "
                        . "";
                $upperUsersAll = $this->common_model->customQuery($sql);
                if (!empty($upperUsersAll)) {
                    $allUsers = array_merge($lowerUsers, $lowerUsersAll, $upperUsersAll);
                } else {
                    $allUsers = array_merge($lowerUsers, $lowerUsersAll);
                }
            } else {
                $allUsers = $lowerUsers;
            }
        }

        $this->data['allUsers'] = $allUsers;
        $this->data['organization_id'] = $organization_id;
        $this->load->view('dashboard_report', $this->data);
    }

    public function categoryAssessmentReport() {
        $userId = $this->input->post('userId');
        $roleId = $this->input->post('roleId');
        $this->data['parent'] = "Dashboard";
        $this->data['title'] = "Dashboard";
        if (!empty($userId)) {
            $categoryAverageBySelf = array();
            $categoryAverageByLeader = array();
            $option = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'ACA.id as cat_id,ACA.category_name',
                'join' => array(USER_ASSESSMENT_QUESTION_SUBMISSION . ' as UAQS' => 'UAQS.user_assessment_id=UA.id',
                    QUESTIONS . ' as QSA' => 'QSA.id=UAQS.question_id',
                    ASSESSMENT_CATEGORY . ' as ACA' => 'ACA.id=QSA.category_id'),
                'where' => array('UA.user_id' => $userId),
                'group_by' => array('ACA.id')
            );
            $assessmentQuestionCategory = $this->common_model->customGet($option);
            foreach ($assessmentQuestionCategory as $ass_cat) {
                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA"
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.user_id = $userId AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageBySelf[$ass_cat->cat_id] = $this->common_model->customQuery($sql, TRUE);
            }
            foreach ($assessmentQuestionCategory as $ass_cat) {
                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA"
                        . " INNER JOIN user_assessment as UA1 ON (UA1.child_upper_id=UA.id)"
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA1.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.user_id = $userId AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageByLeader[$ass_cat->cat_id] = $this->common_model->customQuery($sql, TRUE);
            }

            $selfAvg = array();
            foreach ($categoryAverageBySelf as $rows) {
                $selfAvg[] = $rows->avg_point;
            }
            $leaderAvg = array();
            foreach ($categoryAverageByLeader as $row) {
                $leaderAvg[] = $row->avg_point;
            }
            $chartLabel = array();
            foreach ($assessmentQuestionCategory as $cat) {
                $chartLabel[] = $cat->category_name;
            }

            if (count($chartLabel) == 2) {
                $chartLabel[] = "";
                $selfAvg[] = null;
                $leaderAvg[] = null;
            } elseif (count($chartLabel) == 1) {
                $chartLabel[] = "";
                $chartLabel[] = "";
                $selfAvg[] = null;
                $selfAvg[] = null;
                $leaderAvg[] = null;
                $leaderAvg[] = null;
            }


            if (empty($roleId)) {
                $this->data['category'] = $assessmentQuestionCategory;
                $this->data['self'] = $categoryAverageBySelf;
                $this->data['leader'] = $categoryAverageByLeader;
                $this->data['userId'] = $userId;
                if (!empty($assessmentQuestionCategory)) {
                    $this->load->view('category_chart', $this->data);
                } else {
                    echo "";
                }
            } else {
                if (!empty($assessmentQuestionCategory)) {
                    $response = array('status' => 1, 'label' => $chartLabel, 'self' => $selfAvg, 'leader' => $leaderAvg);
                } else {
                    $response = array('status' => 0, 'label' => array(), 'self' => array(), 'leader' => array());
                }
                echo json_encode($response);
            }
        } else {
            redirect('admin');
        }
    }

    public function caregoryStatementChart() {
        $userId = $this->input->post('userId');
        $catId = $this->input->post('catId');
        $statement = $this->input->post('statement');
        $this->data['parent'] = "Dashboard";
        $this->data['title'] = "Dashboard";

        $option = array('table' => USER_ASSESSMENT . ' as UA',
            'select' => 'QSA.id as que_id,QSA.question,QSA.title,UAQS.select_option_id,QAP.point',
            'join' => array(USER_ASSESSMENT_QUESTION_SUBMISSION . ' as UAQS' => 'UAQS.user_assessment_id=UA.id',
                QUESTIONS . ' as QSA' => 'QSA.id=UAQS.question_id',
                'questions_option as QAP' => 'QAP.id=UAQS.select_option_id'),
            'where' => array('UA.user_id' => $userId, 'QSA.category_id' => $catId, 'UA.assessment_type' => 180)
        );
        $assessmentStatementSelf = $this->common_model->customGet($option);
        if (!empty($assessmentStatementSelf)) {
            $assessmentStatementLeader = array();
            foreach ($assessmentStatementSelf as $assessment) {
                $sql = "SELECT QAS.id as que_id,QAS.question,QAS.title,ASB.select_option_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA"
                        . " INNER JOIN user_assessment as UA1 ON (UA1.child_upper_id=UA.id)"
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA1.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.user_id = $userId AND QAS.category_id = $catId AND UA.assessment_type=180 AND QAS.id = $assessment->que_id";

                $assessmentStatementLeader[] = $this->common_model->customQuery($sql, TRUE);
            }
            $leaderPoint = array();
            $leaderPointTable = array();
            if (!empty($assessmentStatementLeader)) {
                foreach ($assessmentStatementLeader as $leader) {
                    $leaderPoint[] = $leader->avg_point;
                    $leaderPointTable[] = $leader->avg_point;
                }
            }
            $labels = array();
            $labelsTable = array();
            foreach ($assessmentStatementSelf as $rows) {
                $labels[] = $rows->title;
                $labelsTable[] = $rows->title;
            }

            $selfPoints = array();
            $selfPointsTable = array();
            foreach ($assessmentStatementSelf as $rows) {
                $selfPoints[] = $rows->point . '0';
                $selfPointsTable[] = $rows->point . '0';
            }

            if (count($labels) == 1) {
                $labels[1] = $labels[0];
                $labels[0] = "";
                $labels[2] = "";
                $selfPoints[1] = $selfPoints[0];
                $selfPoints[0] = null;
                $selfPoints[2] = null;
                $leaderPoint[1] = $leaderPoint[0];
                $leaderPoint[0] = null;
                $leaderPoint[2] = null;
            }
            $option = array('table' => 'category',
                'select' => 'id,category_name',
                'where' => array('id' => $catId),
                'single' => true
            );
            $category_name = $this->common_model->customGet($option);

            if ($statement == 1) {
                $this->data['statement'] = $labelsTable;
                $this->data['self'] = $selfPointsTable;
                $this->data['leader'] = $leaderPointTable;
                $this->data['category_name'] = $category_name->category_name;
                if (!empty($assessmentStatementSelf)) {
                    $this->load->view('category_statement_chart', $this->data);
                } else {
                    echo "";
                }
            } else {
                $response = array('status' => 1, 'labels' => $labels, 'self' => $selfPoints, 'leader' => $leaderPoint, 'category_name' => $category_name->category_name);
                echo json_encode($response);
                exit;
            }
        } else {
            $response = array('status' => 0, 'label' => array(), 'self' => array(), 'leader' => array());
            echo json_encode($response);
            exit;
        }
    }

    /**
     * @method login
     * @description login authentication
     * @return array
     */
    public function login() {
        $this->data['title'] = $this->lang->line('login_heading');
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if (strtolower(getConfig('google_captcha')) == 'on') {
            $this->form_validation->set_rules('g-recaptcha-response', 'Google recaptcha', 'required');
        }

        if ($this->form_validation->run() == true) {

            $is_captcha = true;
            if (strtolower(getConfig('google_captcha')) == 'on') {
                if (isset($_POST['g-recaptcha-response']) && !empty($_POST['g-recaptcha-response'])) {
                    $secret = getConfig('secret_key');
                    $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $_POST['g-recaptcha-response']);
                    $responseData = json_decode($verifyResponse);
                    $is_captcha = $responseData->success;
                }
            }

            if ($is_captcha) {

                $remember = (bool) $this->input->post('remember');

                if ($this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember)) {

                    $this->session->set_flashdata('message', $this->ion_auth->messages());

                    redirect('admin', 'refresh');
                } else {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                    redirect('admin/login', 'refresh'); // use redirects instead of loading views for compatibility with MY_Controller libraries
                }
            } else {
                $this->session->set_flashdata('message', "Robot verification failed, please try again");
                redirect('admin/login', 'refresh');
            }
        } else {
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'type' => 'text',
                'value' => $this->form_validation->set_value('identity'),
                'placeholder' => 'Identity'
            );
            $this->data['password'] = array('name' => 'password',
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password'
            );
            $this->load->view('login', $this->data);
        }
    }

    /**
     * @method logout
     * @description logout
     * @return array
     */
    public function logout() {
        $this->data['title'] = "Logout";
        $logout = $this->ion_auth->logout();
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        $response = array('status' => 1, 'message' => $this->ion_auth->messages());
        echo json_encode($response);
    }

    /**
     * @method profile
     * @description profile display
     * @return array
     */
    public function profile() {
        $this->data['parent'] = "Profile";
        $this->adminIsAuth();
        $option = array(
            'table' => 'users',
            'where' => array('id' => $this->session->userdata('user_id')),
            'single' => true
        );
        $this->data['user'] = $this->common_model->customGet($option);
        $this->data['title'] = "Profile";
        $this->load->admin_render('profile', $this->data);
    }

    /**
     * @method updateProfile
     * @description user profile update
     * @return array
     */
    public function updateProfile() {
        $this->adminIsAuth();
        $this->form_validation->set_rules('first_name', 'First Name', 'required');
        $this->form_validation->set_rules('last_name', "Last Name", 'required');
        if ($this->form_validation->run() == true) {

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name')
            );
            if ($this->ion_auth->update($this->session->userdata('user_id'), $additional_data)) {
                $this->session->set_flashdata('message', 'your profile account has been updated successfully');
                redirect('admin/profile');
            } else {
                $this->session->set_flashdata('message', 'your profile account has been updated successfully');
                redirect('admin/profile');
            }
        } else {
            $requireds = strip_tags($this->form_validation->error_string());
            $result = explode("\n", trim($requireds, "\n"));
            $this->session->set_flashdata('error', $result);
            redirect('admin/profile/');
        }
    }

    /**
     * @method password
     * @description change password dispaly
     * @return array
     */
    public function password() {
        $this->data['parent'] = "Password";
        $this->adminIsAuth();
        $this->data['error'] = "";
        $this->data['message'] = "";
        $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
        $this->data['old_password'] = array(
            'name' => 'old',
            'id' => 'old',
            'type' => 'password',
            'class' => 'form-control'
        );
        $this->data['new_password'] = array(
            'name' => 'new',
            'id' => 'new',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            'class' => 'form-control'
        );
        $this->data['new_password_confirm'] = array(
            'name' => 'new_confirm',
            'id' => 'new_confirm',
            'type' => 'password',
            'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
            'class' => 'form-control'
        );
        $this->data['user_id'] = array(
            'name' => 'user_id',
            'id' => 'user_id',
            'type' => 'hidden',
            'value' => $this->session->userdata('user_id'),
        );
        $this->data['title'] = "Password";
        $this->load->admin_render('changePassword', $this->data);
    }

    /**
     * @method change_password
     * @description change password
     * @return array
     */
    public function change_password() {
        $data['parent'] = "Password";
        $this->adminIsAuth();

        $data['title'] = "Password";
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[6]|max_length[14]|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in()) {
            redirect('admin/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false) {

            $data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $data['old_password'] = array(
                'name' => 'old',
                'id' => 'old',
                'type' => 'password',
                'class' => 'form-control'
            );
            $data['new_password'] = array(
                'name' => 'new',
                'id' => 'new',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                'class' => 'form-control'
            );
            $data['new_password_confirm'] = array(
                'name' => 'new_confirm',
                'id' => 'new_confirm',
                'type' => 'password',
                'pattern' => '^.{' . $data['min_password_length'] . '}.*$',
                'class' => 'form-control'
            );
            $data['user_id'] = array(
                'name' => 'user_id',
                'id' => 'user_id',
                'type' => 'hidden',
                'value' => $this->session->userdata('user_id'),
            );
            $this->load->admin_render('changePassword', $data);
        } else {

            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change) {
                //if the password was successfully changed
                $this->session->set_flashdata('message', "The new password has been saved successfully.");
                redirect('admin/password');
            } else {
                $this->session->set_flashdata('error', "The old password you entered was incorrect");
                redirect('admin/change_password');
            }
        }
    }

    /**
     * @method forgot_password
     * @description forgot password
     * @return array
     */
    public function forgot_password() {
        $this->data['parent'] = "Forgot Password";
        if ($this->config->item('identity', 'ion_auth') != 'email') {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        } else {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }
        if ($this->form_validation->run() == false) {
            $this->data['type'] = $this->config->item('identity', 'ion_auth');

            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
                'placeholder' => 'Email',
                'class' => 'form-control'
            );

            if ($this->config->item('identity', 'ion_auth') != 'email') {
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            } else {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }


            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->load->view('forgot_password', $this->data);
        } else {
            $identity_column = $this->config->item('identity', 'ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if (empty($identity)) {

                if ($this->config->item('identity', 'ion_auth') != 'email') {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                } else {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("admin/forgot_password", 'refresh');
            }


            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten) {

                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("admin/login", 'refresh'); //we should display a confirmation 
            } else {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("admin/forgot_password", 'refresh');
            }
        }
    }

    /**
     * @method reset_password
     * @description reset password
     * @return array
     */
    public function reset_password($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {


            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[6]|max_length[14]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $this->input->post('new'))) {
                $this->data['message'] = "The Password Should be required alphabetic and numeric";
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password', $this->data);
            } else if ($this->form_validation->run() == false) {

                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password', $this->data);
            } else {

                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {


                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {

                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change) {

                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("admin/login", 'refresh');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('admin/reset_password/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', "Token has been expired");
            redirect("admin/forgot_password", 'refresh');
        }
    }

    public function resetPasswordApp($code = NULL) {
        if (!$code) {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user) {


            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[6]|max_length[14]|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false) {

                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password_app', $this->data);
            } else if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $this->input->post('new'))) {
                $this->data['message'] = "The Password Should be required alphabetic and numeric";
                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id' => 'new',
                    'type' => 'password',
                    'placeholder' => 'New Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['new_password_confirm'] = array(
                    'name' => 'new_confirm',
                    'id' => 'new_confirm',
                    'type' => 'password',
                    'placeholder' => 'Confirm Password',
                    'pattern' => '^.{' . $this->data['min_password_length'] . '}.*$',
                );
                $this->data['user_id'] = array(
                    'name' => 'user_id',
                    'id' => 'user_id',
                    'type' => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;


                $this->load->view('admin/reset_password_app', $this->data);
            } else {

                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id')) {


                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));
                } else {
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};
                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));
                    if ($change) {

                        $options = array('table' => USERS,
                            'data' => array('is_pass_token' => $this->input->post('new')),
                            'where' => array('id' => $user->id));
                        $this->common_model->customUpdate($options);


                        $this->session->set_flashdata('success', $this->ion_auth->messages());
                        redirect('admin/passConfirmAuth/');
                    } else {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('admin/resetPasswordApp/' . $code, 'refresh');
                    }
                }
            }
        } else {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', "Reset Password link has been expired");
            redirect("admin/forgot_password", 'refresh');
        }
    }

    public function passConfirmAuth() {
        $this->load->view('admin/success_view');
    }

    /**
     * @method _get_csrf_nonce
     * @description generate csrf
     * @return array
     */
    public function _get_csrf_nonce() {
        $this->load->helper('string');
        $key = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    /**
     * @method _valid_csrf_nonce
     * @description valid csrf
     * @return array
     */
    public function _valid_csrf_nonce() {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
