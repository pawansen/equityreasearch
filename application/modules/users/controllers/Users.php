<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends Common_Controller {

    public $data = array();
    public $file_data = "";

    public function __construct() {
        parent::__construct();
        $this->is_auth_admin();
    }

    /**
     * @method index
     * @description listing display
     * @return array
     */
    public function index() {
        $this->data['parent'] = "User";
        $role_name = $this->input->post('role_name');
        $this->data['roles'] = array(
            'role_name' => $role_name
        );

        if (!empty($role_name)) {

            $option = array('table' => USERS . ' as user',
                'select' => 'user.*,org.name as org_name,group.name as group_name',
                'join' => array(array(USER_GROUPS . ' as ugroup', 'ugroup.user_id=user.id', 'left'),
                    array(GROUPS . ' as group', 'group.id=ugroup.group_id', 'left'),
                    array(ORGANIZATION . ' as org', 'org.id=ugroup.organization_id', 'left')),
                'order' => array('user.id' => 'ASC'),
                'where' => array('ugroup.organization_id' => $role_name),
                'where_not_in' => array('group.id' => array(1)));
        } else {
            $option = array('table' => USERS . ' as user',
                'select' => 'user.*,org.name as org_name,group.name as group_name',
                'join' => array(array(USER_GROUPS . ' as ugroup', 'ugroup.user_id=user.id', 'left'),
                    array(GROUPS . ' as group', 'group.id=ugroup.group_id', 'left'),
                    array(ORGANIZATION . ' as org', 'org.id=ugroup.organization_id', 'left')),
                'order' => array('user.id' => 'ASC'),
                'where_not_in' => array('group.id' => array(1)));
        }

        $this->data['list'] = $this->common_model->customGet($option);
        $this->data['title'] = "Users";
        $this->load->admin_render('list', $this->data, 'inner_script');
    }

    /**
     * @method open_model
     * @description load model box
     * @return array
     */
    function open_model() {
        $this->data['title'] = lang("add_user");
        $option = array('table' => ORGANIZATION,
            'select' => 'name,id'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->view('add', $this->data);
    }

    function getCompanyRole() {
        $organization_id = $this->input->post('organization_id');

        $option = array('table' => GROUPS . ' as groups',
            'select' => 'groups.id,groups.name',
            'join' => array(HIERARCHY . ' as hierarcy' => 'hierarcy.role_id=groups.id'),
            'where' => array('hierarcy.organization_id' => $organization_id, 'hierarcy.applicable_status' => 1)
        );
        $roles = $this->common_model->customGet($option);
        if (!empty($roles)) {
            $htm = "";
            $htm .= "<option value=''>" . lang('choose_role') . "</option>";
            foreach ($roles as $role) {
                $htm .= "<option value='" . $role->id . "'>" . ucwords($role->name) . "</option>";
            }
            $response = array('status' => 1, 'roles' => $htm);
        } else {
            $response = array('status' => 0);
        }
        echo json_encode($response);
    }

    public function getAssissmentQuestion() {
        $assessment_id = $this->input->post('assessment_id');

        $option = array('table' => ASS_CATEGORY . ' as as_cat',
            'select' => 'que.id,que.question',
            'join' => array(QUESTIONS . ' as que' => 'que.category_id=as_cat.category_id'),
            'where' => array('as_cat.assessment_id' => $assessment_id, 'que.active' => 1)
        );
        $questions = $this->common_model->customGet($option);
        if (!empty($questions)) {
            $htm = "";
            foreach ($questions as $role) {
                $htm .= "<option value='" . $role->id . "'>" . ucwords($role->question) . "</option>";
            }
            $response = array('status' => 1, 'roles' => $htm);
        } else {
            $response = array('status' => 0);
        }
        echo json_encode($response);
    }

    /**
     * @method users_add
     * @description add dynamic rows
     * @return array
     */
    public function users_add() {
        $tables = $this->config->item('tables', 'ion_auth');
        $identity_column = $this->config->item('identity', 'ion_auth');
        $this->data['identity_column'] = $identity_column;
        // validate form input
        $this->form_validation->set_rules('first_name', lang('first_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('user_email', lang('user_email'), 'required|trim|xss_clean|is_unique[users.email]');
        $this->form_validation->set_rules('password', lang('password'), 'trim|required|xss_clean|min_length[6]|max_length[14]');
        $this->form_validation->set_rules('company_name', lang('company'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('role_id', lang('role'), 'trim|required|xss_clean');
        if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $this->input->post('password'))) {
            $response = array('status' => 0, 'message' => "The Password Should be required alphabetic and numeric");
            echo json_encode($response);
            exit;
        }
        if ($this->form_validation->run() == true) {

            $this->filedata['status'] = 1;
            $image = "";
            if (!empty($_FILES['user_image']['name'])) {
                $this->filedata = $this->commonUploadImage($_POST, 'users', 'user_image');
                if ($this->filedata['status'] == 1) {
                    $image = 'uploads/users/' . $this->filedata['upload_data']['file_name'];
                }
            }
            if ($this->filedata['status'] == 0) {
                $response = array('status' => 0, 'message' => $this->filedata['error']);
            } else {
                $email = strtolower($this->input->post('user_email'));
                $identity = ($identity_column === 'email') ? $email : $this->input->post('user_email');
                $password = $this->input->post('password');
                $username = explode('@', $this->input->post('user_email'));
                $organization_id = $this->input->post('company_name');
                $group_id = $this->input->post('role_id');
                $group = array($group_id);
                $additional_data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name' => $this->input->post('last_name'),
                    'username' => $username[0],
                    'date_of_birth' => (!empty($this->input->post('date_of_birth'))) ? date('Y-m-d', strtotime($this->input->post('date_of_birth'))) : "0000-00-00",
                    'gender' => $this->input->post('user_gender'),
                    'profile_pic' => $image,
                    'phone' => $this->input->post('phone_no'),
                    'email_verify' => 1,
                    'is_pass_token' => $password,
                    'created_on' => strtotime(datetime())
                );
                if ($insert_id = $this->ion_auth->register($identity, $password, $email, $additional_data, $group)) {
                    $options = array('table' => USER_GROUPS,
                        'data' => array('organization_id' => $organization_id),
                        'where' => array('user_id' => $insert_id, 'group_id' => $group_id));
                    $this->common_model->customUpdate($options);
                    $from = getConfig('admin_email');
                    $subject = "Self Assessment Registration Login Credentials";
                    $title = "Self Assessment Registration";
                    $data['name'] = ucwords($this->input->post('first_name') . ' ' . $this->input->post('last_name'));
                    $data['content'] = "Self Assessment account login Credentials"
                            . "<p>username: " . $email . "</p><p>Password: " . $password . "</p>";
                    $template = $this->load->view('user_signup_mail', $data, true);
                    $this->send_email($email, $from, $subject, $template, $title);
                    $response = array('status' => 1, 'message' => lang('user_success'), 'url' => base_url('users'));
                } else {
                    $response = array('status' => 0, 'message' => lang('user_failed'));
                }
            }
        } else {
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        echo json_encode($response);
    }

    /**
     * @method user_edit
     * @description edit dynamic rows
     * @return array
     */
    public function user_edit() {
        $this->data['title'] = lang("edit_user");
        $id = decoding($this->input->post('id'));
        $option = array('table' => ORGANIZATION,
            'select' => 'name,id'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        if (!empty($id)) {
            $option = array(
                'table' => USERS . ' as user',
                'select' => 'user.*,group.name as group_name,org.id as org_id,group.id as g_id',
                'join' => array(USER_GROUPS . ' u_group' => 'u_group.user_id=user.id',
                    GROUPS . ' group' => 'group.id=u_group.group_id',
                    ORGANIZATION . ' org' => 'org.id=u_group.organization_id'),
                'where' => array('user.id' => $id),
                'single' => true
            );
            $results_row = $this->common_model->customGet($option);
            if (!empty($results_row)) {
                $this->data['results'] = $results_row;
                $option = array('table' => GROUPS . ' as groups',
                    'select' => 'groups.id,groups.name',
                    'join' => array(HIERARCHY . ' as hierarcy' => 'hierarcy.role_id=groups.id'),
                    'where' => array('hierarcy.organization_id' => $results_row->org_id, 'hierarcy.applicable_status' => 1)
                );
                $this->data['roles'] = $this->common_model->customGet($option);
                $this->load->view('edit', $this->data);
            } else {
                $this->session->set_flashdata('error', lang('not_found'));
                redirect('users');
            }
        } else {
            $this->session->set_flashdata('error', lang('not_found'));
            redirect('users');
        }
    }

    /**
     * @method user_update
     * @description update dynamic rows
     * @return array
     */
    public function user_update() {

        $this->form_validation->set_rules('first_name', lang('first_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('last_name', lang('last_name'), 'required|trim|xss_clean');
        $this->form_validation->set_rules('user_email', lang('user_email'), 'required|trim|xss_clean');
        $newpass = $this->input->post('new_password');
        $user_email = $this->input->post('user_email');
        if ($newpass != "") {
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|xss_clean|min_length[6]|max_length[14]');
            //$this->form_validation->set_rules('confirm_password1', 'Confirm Password', 'trim|required|xss_clean|matches[new_password]');
            if (!preg_match('/(?=.*[a-z])(?=.*[0-9]).{6,}/i', $this->input->post('new_password'))) {
                $response = array('status' => 0, 'message' => "The Password Should be required alphabetic and numeric");
                echo json_encode($response);
                exit;
            }
        }

        $where_id = $this->input->post('id');
        if ($this->form_validation->run() == FALSE):
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        else:

            $option = array(
                'table' => USERS,
                'select' => 'email',
                'where' => array('email' => $user_email, 'id !=' => $where_id)
            );
            $is_unique_email = $this->common_model->customGet($option);

            if (empty($is_unique_email)) {

                $this->filedata['status'] = 1;
                $image = $this->input->post('exists_image');

                if (!empty($_FILES['user_image']['name'])) {
                    $this->filedata = $this->commonUploadImage($_POST, 'users', 'user_image');

                    if ($this->filedata['status'] == 1) {
                        $image = 'uploads/users/' . $this->filedata['upload_data']['file_name'];
                        unlink_file($this->input->post('exists_image'), FCPATH);
                    }
                }
                if ($this->filedata['status'] == 0) {
                    $response = array('status' => 0, 'message' => $this->filedata['error']);
                } else {

                    if (empty($newpass)) {
                        $currentPass = $this->input->post('current_password');
                    } else {
                        $currentPass = $newpass;
                    }

                    $options_data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name' => $this->input->post('last_name'),
                        'date_of_birth' => (!empty($this->input->post('date_of_birth'))) ? date('Y-m-d', strtotime($this->input->post('date_of_birth'))) : "0000-00-00",
                        'gender' => $this->input->post('user_gender'),
                        'phone' => $this->input->post('phone_no'),
                        'profile_pic' => $image,
                        'email' => $user_email,
                        'is_pass_token' => $currentPass,
                    );

                    $this->ion_auth->update($where_id, $options_data);
                    if ($newpass != "") {
                        $pass_new = $this->common_model->encryptPassword($this->input->post('new_password'));
                        $this->common_model->customUpdate(array('table' => 'users', 'data' => array('password' => $pass_new), 'where' => array('id' => $where_id)));
                    }

                    $organization_id = $this->input->post('company_name');
                    $group_id = $this->input->post('role_id');
                    $options = array('table' => USER_GROUPS,
                        'data' => array('organization_id' => $organization_id, 'group_id' => $group_id),
                        'where' => array('user_id' => $where_id));
                    $this->common_model->customUpdate($options);

                    $response = array('status' => 1, 'message' => lang('user_success_update'), 'url' => base_url('users/user_edit'), 'id' => encoding($this->input->post('id')));
                }
            } else {
                $response = array('status' => 0, 'message' => "The email address already exists");
            }

        endif;

        echo json_encode($response);
    }

    public function export_user() {

        $option = array(
            'table' => USERS,
            'select' => '*'
        );
        $users = $this->common_model->customGet($option);

        // $userslist = $this->Common_model->getAll(USERS,'name','ASC');
        $print_array = array();
        $i = 1;
        foreach ($users as $value) {


            $print_array[] = array('s_no' => $i, 'name' => $value->name, 'email' => $value->email);
            $i++;
        }

        $filename = "user_email_csv.csv";
        $fp = fopen('php://output', 'w');

        header('Content-type: application/csv');
        header('Content-Disposition: attachment; filename=' . $filename);
        fputcsv($fp, array('S.no', 'User Name', 'Email'));

        foreach ($print_array as $row) {
            fputcsv($fp, $row);
        }
    }

    public function reset_password() {
        $user_id_encode = $this->uri->segment(3);

        $data['id_user_encode'] = $user_id_encode;

        if (!empty($_POST) && isset($_POST)) {

            $user_id_encode = $_POST['user_id'];

            if (!empty($user_id_encode)) {

                $user_id = base64_decode(base64_decode(base64_decode(base64_decode($user_id_encode))));


                $this->form_validation->set_rules('new_password', 'Password', 'required');
                $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

                if ($this->form_validation->run() == FALSE) {
                    $this->load->view('reset_password', $data);
                } else {


                    $user_pass = $_POST['new_password'];

                    $data1 = array('password' => md5($user_pass));
                    $where = array('id' => $user_id);

                    $out = $this->common_model->updateFields(USERS, $data1, $where);



                    if ($out) {

                        $this->session->set_flashdata('passupdate', 'Password Successfully Changed.');
                        $data['success'] = 1;
                        $this->load->view('reset_password', $data);
                    } else {

                        $this->session->set_flashdata('error_passupdate', 'Password Already Changed.');
                        $this->load->view('reset_password', $data);
                    }
                }
            } else {

                $this->session->set_flashdata('error_passupdate', 'Unable to Change Password, Authentication Failed.');
                $this->load->view('reset_password');
            }
        } else {
            $this->load->view('reset_password', $data);
        }
    }

    public function get_user_ajax() {
        $search = $this->input->get('search');
        $organization_id = $this->input->get('id');
        $user_id_upper = $this->input->get('user_id_upper');
        if (empty($organization_id)) {
            echo json_encode(array());
            exit;
        }
        $option = array('table' => HIERARCHY_ROLE_ORDER . ' as roles',
            'select' => 'role_id',
            'where' => array('roles.organization_id' => $organization_id
            ),
            'order' => array('roles.id' => 'desc'),
            'single' => true,
            'group_by' => array('roles.id')
        );
        $roles = $this->common_model->customGet($option);
        $option = array('table' => USER_GROUPS . ' as groups',
            'select' => 'user.id,groups.group_id',
            'join' => array(USERS . ' as user' => 'user.id=groups.user_id'),
            'where' => array('groups.group_id' => $roles->role_id, 'groups.organization_id' => $organization_id)
        );
        $user_roles = $this->common_model->customGet($option);
        $usr = 1;
        if (!empty($user_roles)) {
            foreach ($user_roles as $user) {
                $usr .= "," . $user->id;
            }
        }
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                . " WHERE UH.user_id='" . $user_id_upper . "' AND  user.`id` IN(" . $usr . ") AND ug.organization_id  = '" . $organization_id . "'  AND user.`first_name` LIKE '%" . $search . "%' "
                . "";
        $users = $this->common_model->customQuery($sql);
        echo json_encode($users);
    }

    public function assessment() {
        $this->data['title'] = lang("user_assessment");
        $this->data['parent'] = "UA";
        $user_id = decoding($this->uri->segment(3));
        $option = array('table' => USER_ASSESSMENT . ' as ua',
            'select' => 'ua.assessment_type,ua.assessment_status,ua.create_date,ua.id as user_assessment_id,ua.start_date,ua.end_date,ua.active,first_name,last_name,assessment.assessment_name,user.id as user_id',
            'join' => array(USERS . ' as user' => 'user.id=ua.user_id',
                ASSESSMENT . ' as assessment' => 'assessment.id=ua.assessment_id'),
            'where' => array('ua.child_upper_id' => 0),
            'order' => array('ua.id' => 'ASC')
        );
        if (!empty($this->uri->segment(3))) {
            $option['where']['user.id'] = $user_id;
        }
        $this->data['list'] = $this->common_model->customGet($option);
        $this->load->admin_render('user_assessment_list', $this->data, 'inner_script');
    }

    public function getUpperOrganizationRole() {
        $organization_id = $this->input->post('organization_id');
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id  = 3"
                . "";
        $roles = $this->common_model->customQuery($sql);
        $option = array('table' => GROUPS,
            'select' => 'id,name',
            'where' => array('id' => 3),
            'single' => true
        );
        $positionName = $this->common_model->customGet($option);
        $htm = "<option>Upper user not found</option>";
        if (!empty($roles)) {
            $htm = "<option value=''>Select User</option>";
            foreach ($roles as $role) {
                $htm .="<option value='" . $role->id . "'>" . $role->name . "</option>";
            }
            $response = array('status' => 1, 'roles' => $htm, 'positionName' => $positionName->name);
        } else {
            $response = array('status' => 0, 'roles' => $htm, 'positionName' => $positionName->name);
        }
        echo json_encode($response);
    }

    public function getUpperLowerOrganizationRole() {
        $organization_id = $this->input->post('organization_id');
        $upperPositionUser = $this->input->post('upperPositionUser');
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id)"
                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                . " WHERE UH.user_id='" . $upperPositionUser . "'  AND ug.organization_id  = '" . $organization_id . "' AND gr.id  = 4"
                . "";
        $roles = $this->common_model->customQuery($sql);
        $option = array('table' => GROUPS,
            'select' => 'id,name',
            'where' => array('id' => 4),
            'single' => true
        );
        $positionName = $this->common_model->customGet($option);
        $htm = "<option>Upper user not found</option>";
        if (!empty($roles)) {
            $htm = "<option value=''>Select User</option>";
            foreach ($roles as $role) {
                $htm .="<option value='" . $role->id . "'>" . $role->name . "</option>";
            }
            $response = array('status' => 1, 'roles' => $htm, 'positionName' => $positionName->name);
        } else {
            $response = array('status' => 0, 'roles' => $htm, 'positionName' => $positionName->name);
        }
        echo json_encode($response);
    }

    public function add_assessment() {
        $this->data['title'] = lang("user_add_assessment");
        $this->data['parent'] = "UA";
        if (isset($_POST) && empty($_POST)) {
            $option = array('table' => ASSESSMENT,
                'select' => 'id,assessment_name'
            );
            $this->data['assessment'] = $this->common_model->customGet($option);
            $option = array('table' => ORGANIZATION,
                'select' => 'id,name'
            );
            $this->data['organization'] = $this->common_model->customGet($option);
            $this->load->admin_render('user_assessment_add', $this->data, 'inner_script');
        } else {
            $assessment_type = $this->input->post('select_question');
            $this->form_validation->set_rules('user_id', lang('user'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('assessment_id', lang('assessment'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('end_date', lang('end_date'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('organization_id', lang('organization'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('question_id[]', 'Questions', 'trim|required|xss_clean');
            if ($assessment_type == 360) {
                $this->form_validation->set_rules('bullets', lang('bullets'), 'trim|required|xss_clean');
                $this->form_validation->set_rules('bullets_in_month', lang('bullets_in_month'), 'trim|required|xss_clean');
            }
            if ($this->form_validation->run() == true) {

                $user_id = $this->input->post('user_id');
                $assessment_id = $this->input->post('assessment_id');
                $start_date = $this->input->post('start_date');
                $end_date = $this->input->post('end_date');
                $bullets = (!empty($this->input->post('bullets'))) ? $this->input->post('bullets') : 0;
                $bullets_in_month = $this->input->post('bullets_in_month');
                $question_id = $this->input->post('question_id');
                $bullets_in_month_array = explode(',', $bullets_in_month);
                $bullets = count($bullets_in_month_array);

                $upper_level_user = $this->input->post('upper_level_user');
                $bullets_upper = $this->input->post('bullets_upper');
                $bullets_in_month_upper = $this->input->post('bullets_in_month_upper');
                if ($assessment_type == 360) {
                    $ct_upper = count($upper_level_user);
                    for ($j = 0; $j < $ct_upper; $j++) {
                        if (empty($bullets_upper[$j])) {
                            $messages = 'Upper Lavel User Bullets field must requireds';
                            $response = array('status' => 0, 'message' => $messages);
                            echo json_encode($response);
                            exit;
                        }
                    }
                }

                $users = explode(",", $user_id);
                if ($assessment_type == 180) {
                    foreach ($users as $user) {
                        $options = array('table' => USER_ASSESSMENT . ' as UA',
                            'select' => 'UA.id,user.first_name,user.last_name,',
                            'join' => array(USERS . ' as user' => 'user.id=UA.user_id'),
                            'where' => array('UA.user_id' => $user, 'UA.assessment_type' => 180, 'UA.organization_id' => $this->input->post('organization_id')),
                            'single' => true
                        );
                        $exists_assessment = $this->common_model->customGet($options);
                        if (!empty($exists_assessment)) {
                            $response = array('status' => 0, 'message' => ucfirst($exists_assessment->first_name . " " . $exists_assessment->last_name) . " have already assessment");
                            echo json_encode($response);
                            exit;
                        }
                    }
                }

                if ($assessment_type == 360) {
                    foreach ($users as $user) {
                        $options = array('table' => USER_ASSESSMENT . ' as UA',
                            'select' => 'UA.id,user.first_name,user.last_name,UA1.id as ass_id,UA.assessment_status,UA1.assessment_status as ass_status',
                            'join' => array(USERS . ' as user' => 'user.id=UA.user_id',
                                USER_ASSESSMENT . ' as UA1' => 'UA1.child_upper_id=UA.id'),
                            'where' => array('UA.user_id' => $user, 'UA.assessment_type' => 180, 'UA.organization_id' => $this->input->post('organization_id'))
                        );
                        $exists_assessment = $this->common_model->customGet($options);
                        if (!empty($exists_assessment)) {
                            foreach ($exists_assessment as $rows) {
                                if ($rows->assessment_status != 1) {
                                    $response = array('status' => 0, 'message' => ucfirst($rows->first_name . " " . $rows->last_name) . " have pending 180 assessment please complete first 180 assessment after assign daily assessment");
                                    echo json_encode($response);
                                    exit;
                                }
                                if ($rows->ass_status != 1) {
                                    $response = array('status' => 0, 'message' => ucfirst($rows->first_name . " " . $rows->last_name) . " have upper level user pending 180 assessment please complete first 180 assessment after assign daily assessment");
                                    echo json_encode($response);
                                    exit;
                                }
                            }
                        }

                        $options = array('table' => USER_ASSESSMENT . ' as UA',
                            'select' => 'UA.id,user.first_name,user.last_name,UA.bullets,UA.bullets_submission,UA1.id as ass_id,UA.assessment_status,UA1.assessment_status as ass_status,UA1.bullets as ass_bullets,UA1.bullets_submission as ass_billets_submission',
                            'join' => array(USERS . ' as user' => 'user.id=UA.user_id',
                                USER_ASSESSMENT . ' as UA1' => 'UA1.child_upper_id=UA.id'),
                            'where' => array('UA.user_id' => $user, 'UA.assessment_type' => 360, 'UA.organization_id' => $this->input->post('organization_id'))
                        );

                        $existsDailyAssessment = $this->common_model->customGet($options);
                        if (!empty($existsDailyAssessment)) {

                            foreach ($existsDailyAssessment as $rows) {

                                if ($rows->bullets != $rows->bullets_submission) {
                                    $response = array('status' => 0, 'message' => ucfirst($rows->first_name . " " . $rows->last_name) . " have pending daily assessment please complete first after reassign");
                                    echo json_encode($response);
                                    exit;
                                }

                                if ($rows->ass_bullets != $rows->ass_billets_submission) {
                                    $response = array('status' => 0, 'message' => ucfirst($rows->first_name . " " . $rows->last_name) . " have upper level user pending daily assessment please complete first after reassign");
                                    echo json_encode($response);
                                    exit;
                                }
                            }

                        }
                    }
                }

                foreach ($users as $user) {

                    $options = array('table' => USER_ASSESSMENT . ' as UA',
                        'select' => 'UA.id,user.first_name,user.last_name,UA.start_date,UA.end_date',
                        'join' => array(USERS . ' as user' => 'user.id=UA.user_id'),
                        'where' => array('UA.user_id' => $user, 'UA.assessment_status' => 0),
                        'single' => true
                    );

                    $is_assessment = $this->common_model->customGet($options);
                    if (!empty($is_assessment)) {

                        $flag = false;
                        $currdate = date('Y-m-d');
                        if ($currdate >= $is_assessment->start_date) {
                            $flag = true;
                            if ($currdate <= $is_assessment->end_date) {
                                $flag = true;
                            } else {
                                $flag = false;
                            }
                        }
                        if ($flag) {
                            $response = array('status' => 0, 'message' => ucfirst($is_assessment->first_name . " " . $is_assessment->last_name) . " have already assessment");
                            echo json_encode($response);
                            exit;
                        }
                    }

                    $options_data = array(
                        'user_id' => $user,
                        'assessment_id' => $assessment_id,
                        'organization_id' => $this->input->post('organization_id'),
                        'start_date' => date('Y-m-d', strtotime($start_date)),
                        'end_date' => date('Y-m-d', strtotime($end_date)),
                        'assessment_type' => $assessment_type,
                        'bullets' => $bullets,
                        'bullets_in_month_date' => $bullets_in_month,
                        'active' => 1,
                        'create_date' => datetime()
                    );
                    $option = array('table' => USER_ASSESSMENT, 'data' => $options_data);
                    $insert_id = $this->common_model->customInsert($option);
                    foreach ($question_id as $que) {
                        $opt_data = array(
                            'user_assessment_id' => $insert_id,
                            'assessment_id' => $assessment_id,
                            'question_id' => $que
                        );
                        $options = array('table' => USER_ASSESSMENT_QUESTION, 'data' => $opt_data);
                        $this->common_model->customInsert($options);
                    }

                    if (!empty($upper_level_user)) {
                        $i = 0;
                        foreach ($upper_level_user as $upper_user) {
                            $options_data = array(
                                'child_upper_id' => $insert_id,
                                'organization_id' => $this->input->post('organization_id'),
                                'user_id' => $upper_user,
                                'assessment_id' => $assessment_id,
                                'start_date' => date('Y-m-d', strtotime($start_date)),
                                'end_date' => date('Y-m-d', strtotime($end_date)),
                                'assessment_type' => $assessment_type,
                                'active' => 1,
                                'create_date' => datetime()
                            );
                            if ($assessment_type == 360) {
                                $options_data['bullets'] = (isset($bullets_upper[$i])) ? $bullets_upper[$i] : 0;
                                $options_data['bullets_in_month_date'] = (isset($bullets_in_month_upper[$i])) ? $bullets_in_month_upper[$i] : 0;
                            }

                            $option = array('table' => USER_ASSESSMENT, 'data' => $options_data);
                            $last_id = $this->common_model->customInsert($option);
                            foreach ($question_id as $que) {
                                $opt_data = array(
                                    'user_assessment_id' => $last_id,
                                    'assessment_id' => $assessment_id,
                                    'question_id' => $que
                                );
                                $options = array('table' => USER_ASSESSMENT_QUESTION, 'data' => $opt_data);
                                $this->common_model->customInsert($options);
                            }
                            $i++;
                        }
                    }
                }
                $response = array('status' => 1, 'message' => lang('user_assessment_success'), 'url' => base_url('users/assessment'));
            } else {
                $messages = (validation_errors()) ? validation_errors() : '';
                $response = array('status' => 0, 'message' => $messages);
            }
            echo json_encode($response);
        }
    }

    public function edit_assessment($id) {
        $this->data['title'] = lang("user_assessment");
        $this->data['parent'] = "UA";
        if (!empty($id)) {

            $option = array('table' => USER_ASSESSMENT . ' as ua',
                'select' => 'ua.bullets_submission,ua.assessment_status,ua.user_id,ua.id as user_ass_id,ua.organization_id,ua.assessment_id,ua.bullets_in_month_date,ua.bullets,ua.assessment_type,ua.create_date,ua.id as user_assessment_id,ua.start_date,ua.end_date,ua.active,first_name,last_name,assessment.assessment_name',
                'join' => array(USERS . ' as user' => 'user.id=ua.user_id',
                    ASSESSMENT . ' as assessment' => 'assessment.id=ua.assessment_id'),
                'where' => array('ua.id' => decoding($id)),
                'single' => true
            );
            $this->data['results'] = $results = $this->common_model->customGet($option);

            $option = array('table' => ASSESSMENT,
                'select' => 'id,assessment_name'
            );
            $this->data['assessment'] = $this->common_model->customGet($option);

            $option = array('table' => ORGANIZATION,
                'select' => 'id,name',
                'where' => array('id' => $results->organization_id)
            );
            $this->data['organization'] = $this->common_model->customGet($option);


            $option = array('table' => USER_ASSESSMENT . ' as ua',
                'select' => 'ua.bullets_submission,ua.assessment_status,ua.user_id,ua.id as user_ass_id,ua.organization_id,ua.assessment_id,ua.bullets_in_month_date,ua.bullets,ua.assessment_type,ua.create_date,ua.id as user_assessment_id,ua.start_date,ua.end_date,ua.active,first_name,last_name,assessment.assessment_name',
                'join' => array(USERS . ' as user' => 'user.id=ua.user_id',
                    ASSESSMENT . ' as assessment' => 'assessment.id=ua.assessment_id'),
                'where' => array('ua.child_upper_id' => decoding($id))
            );
            $this->data['upper_lavel'] = $this->common_model->customGet($option);
            $option = array('table' => USER_ASSESSMENT_QUESTION . ' as UAQ',
                'select' => 'UAQ.question_id,QUE.question',
                'join' => array(QUESTIONS . ' as QUE' => 'QUE.id=UAQ.question_id'),
                'where' => array('UAQ.user_assessment_id' => $this->data['results']->user_ass_id)
            );
            $this->data['questionList'] = $this->common_model->customGet($option);

            $this->load->admin_render('user_assessment_edit', $this->data, 'inner_script');
        } else {
            $this->session->set_flashdata('error', 'Record not found');
            redirect('users/assessment');
        }
    }

    public function view_assessment() {
        $this->data['title'] = lang("view_user_assessment");
        $this->data['parent'] = "UA";
        $id = $this->input->post('id');
        $option = array('table' => USER_ASSESSMENT . ' as ua',
            'select' => 'ua.assessment_id,ua.organization_id,ua.bullets_in_month_date,ua.bullets,ua.assessment_type,ua.create_date,ua.id as user_assessment_id,ua.start_date,ua.end_date,ua.active,first_name,last_name,assessment.assessment_name,org.name,user.id as user_id',
            'join' => array(USERS . ' as user' => 'user.id=ua.user_id',
                ASSESSMENT . ' as assessment' => 'assessment.id=ua.assessment_id',
                ORGANIZATION . ' as org' => 'org.id=ua.organization_id'),
            'where' => array('ua.id' => decoding($id)),
            'single' => true
        );
        $results_row = $this->common_model->customGet($option);
        $this->data['result'] = $results_row;
        $option = array('table' => USER_ASSESSMENT . ' as ua',
            'select' => 'ua.id as user_ass_id,ua.organization_id,ua.assessment_id,ua.bullets_in_month_date,ua.bullets,ua.assessment_type,ua.create_date,ua.id as user_assessment_id,ua.start_date,ua.end_date,ua.active,first_name,last_name,assessment.assessment_name,user.id as user_id',
            'join' => array(USERS . ' as user' => 'user.id=ua.user_id',
                ASSESSMENT . ' as assessment' => 'assessment.id=ua.assessment_id'),
            'where' => array('ua.child_upper_id' => decoding($id))
        );
        $this->data['upper_lavel'] = $this->common_model->customGet($option);


        $option1 = array('table' => USER_ASSESSMENT_QUESTION . ' as assess_ques',
            'select' => 'assess_ques.id as user_ass_ques_id,assess_ques.question_id,ques.question',
            'join' => array(QUESTIONS . ' as ques' => 'ques.id=assess_ques.question_id'),
            'where' => array('assess_ques.user_assessment_id' => decoding($id))
        );
        $this->data['questions'] = $this->common_model->customGet($option1);
        //print_r($this->data['question']);die;
        $this->load->view('view_assessment', $this->data);
    }

    public function assessment_del() {
        $response = "";
        $id = decoding($this->input->post('id')); // delete id
        $table = $this->input->post('table'); //table name
        $id_name = $this->input->post('id_name'); // table field name
        if (!empty($table) && !empty($id) && !empty($id_name)) {
            $options = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'AU.id as upper_id',
                'join' => array(USER_ASSESSMENT . ' as AU' => 'AU.child_upper_id=UA.id'),
                'where' => array('UA.id' => $id)
            );

            $all_assessment = $this->common_model->customGet($options);

            if (true) {
                if (!empty($all_assessment)) {
                    foreach ($all_assessment as $val) {
                        $option = array(
                            'table' => USER_ASSESSMENT_QUESTION,
                            'where' => array('user_assessment_id' => $val->upper_id)
                        );
                        $this->common_model->customDelete($option);
                    }
                }

                $option = array(
                    'table' => $table,
                    'where' => array($id_name => $id)
                );
                $delete = $this->common_model->customDelete($option);

                $option = array(
                    'table' => USER_ASSESSMENT_QUESTION,
                    'where' => array('user_assessment_id' => $id)
                );
                $this->common_model->customDelete($option);
                $option = array(
                    'table' => USER_ASSESSMENT,
                    'where' => array('child_upper_id' => $id)
                );
                $this->common_model->customDelete($option);
                $response = 200;
            } else
                $response = 400;
        }else {
            $response = 400;
        }
        echo $response;
    }

    public function getUpperLavel() {
        $organization_id = $this->input->post('organization_id');
        $user_id = $this->input->post('user_id');
        if (!empty($organization_id) && !empty($user_id)) {

            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($user_id)));
            $in_hierarcy_user = $this->common_model->customGet($option);

            $u1 = (isset($in_hierarcy_user[0]->user_id) && !empty($in_hierarcy_user[0]->user_id)) ? $in_hierarcy_user[0]->user_id : 0;
            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($u1)));
            $in_hierarcy_user_or = $this->common_model->customGet($option);

            $u2 = (isset($in_hierarcy_user_or[0]->user_id) && !empty($in_hierarcy_user_or[0]->user_id)) ? $in_hierarcy_user_or[0]->user_id : 0;
            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($u2)));
            $in_hierarcy_user_more = $this->common_model->customGet($option);


            $output = array_merge($in_hierarcy_user, $in_hierarcy_user_or);
            if (!empty($in_hierarcy_user_more)) {
                $output = array_merge($output, $in_hierarcy_user_more);
            }
            $usr = "";
            if (!empty($output)) {
                foreach ($output as $user) {
                    $usr .= $user->user_id . ",";
                }
            }
            $usr = substr($usr, 0, -1);
            if (!empty($usr)) {
                $assessment_type = $this->input->post('assessment_type');
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " WHERE user.`id` IN(" . $usr . ") AND ug.organization_id  = '" . $organization_id . "'";
                $data['users'] = $this->common_model->customQuery($sql);
                if (!empty($data['users'])) {
                    $data['key_id'] = rand(1, 999);
                    if ($assessment_type == 180) {
                        $this->load->view('upper_lavel_user', $data);
                    } else {
                        $this->load->view('upper_lavel_user_bullets', $data);
                    }
                } else {
                    echo 1;
                }
            } else {
                echo "<div class='col-md-offset-3 text-danger'>The organization hierarchy not found</div>";
            }
        } else {
            echo "<div class='col-md-offset-3 text-danger'>Please select one organization user</div>";
        }
    }

    public function getUpperLavelEdit() {
        $organization_id = $this->input->post('organization_id');
        $user_id = $this->input->post('user_id');
        if (!empty($organization_id) && !empty($user_id)) {

            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($user_id)));
            $in_hierarcy_user = $this->common_model->customGet($option);

            $u1 = (isset($in_hierarcy_user[0]->user_id) && !empty($in_hierarcy_user[0]->user_id)) ? $in_hierarcy_user[0]->user_id : 0;
            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($u1)));
            $in_hierarcy_user_or = $this->common_model->customGet($option);

            $u2 = (isset($in_hierarcy_user_or[0]->user_id) && !empty($in_hierarcy_user_or[0]->user_id)) ? $in_hierarcy_user_or[0]->user_id : 0;
            $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                'select' => 'user_hierarchy.user_id',
                'where' => array('user_hierarchy.organization_id' => $organization_id),
                'where_in' => array('user_hierarchy.child_user_id' => array($u2)));
            $in_hierarcy_user_more = $this->common_model->customGet($option);


            $output = array_merge($in_hierarcy_user, $in_hierarcy_user_or);
            if (!empty($in_hierarcy_user_more)) {
                $output = array_merge($output, $in_hierarcy_user_more);
            }
            $usr = "";
            if (!empty($output)) {
                foreach ($output as $user) {
                    $usr .= $user->user_id . ",";
                }
            }
            $usr = substr($usr, 0, -1);
            if (!empty($usr)) {
                $assessment_type = $this->input->post('assessment_type');
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " WHERE user.`id` IN(" . $usr . ") AND ug.organization_id  = '" . $organization_id . "'";
                $data['users'] = $this->common_model->customQuery($sql);
                if (!empty($data['users'])) {
                    $upper_level_user = $this->input->post('upper_level_user');
                    if (!empty($upper_level_user)) {
                        foreach ($data['users'] as $key => $product) {
                            if ($product->id === $upper_level_user) {
                                unset($data['users'][$key]);
                            }
                        }
                    }
                    $data['key_id'] = rand(1, 999);
                    if ($assessment_type == 180) {
                        $this->load->view('upper_lavel_user', $data);
                    } else {
                        $this->load->view('upper_lavel_user_bullets', $data);
                    }
                } else {
                    echo 1;
                }
            } else {
                echo "<div class='col-md-offset-3 text-danger'>The organization hierarchy not found</div>";
            }
        } else {
            echo "<div class='col-md-offset-3 text-danger'>Please select one organization user</div>";
        }
    }

    public function update_assessment() {
        $this->data['title'] = lang("user_add_assessment");
        $this->data['parent'] = "UA";
        $where_id = $this->input->post('id');
        $assessment_type = $this->input->post('select_question');
        $this->form_validation->set_rules('user_id[]', lang('user'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('assessment_id', lang('assessment'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('start_date', lang('start_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('end_date', lang('end_date'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('organization_id', lang('organization'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('question_id[]', 'Questions', 'trim|required|xss_clean');
        if ($assessment_type == 360) {
            $this->form_validation->set_rules('bullets', lang('bullets'), 'trim|required|xss_clean');
            $this->form_validation->set_rules('bullets_in_month', lang('bullets_in_month'), 'trim|required|xss_clean');
        }
        if ($this->form_validation->run() == true) {
            $user_id = $this->input->post('user_id');
            $assessment_id = $this->input->post('assessment_id');
            $start_date = $this->input->post('start_date');
            $end_date = $this->input->post('end_date');
            $bullets = (!empty($this->input->post('bullets'))) ? $this->input->post('bullets') : 0;
            $bullets_in_month = $this->input->post('bullets_in_month');
            $question_id = $this->input->post('question_id');
            $bullets_in_month_array = explode(',', $bullets_in_month);
            $bullets = count($bullets_in_month_array);

            $upper_level_user = $this->input->post('upper_level_user');
            $bullets_upper = $this->input->post('bullets_upper');
            $bullets_in_month_upper = $this->input->post('bullets_in_month_upper');
            if ($assessment_type == 360) {
                $ct_upper = count($upper_level_user);
                for ($j = 0; $j < $ct_upper; $j++) {
                    if (empty($bullets_upper[$j])) {
                        $messages = 'Upper Lavel User Bullets field must requireds';
                        $response = array('status' => 0, 'message' => $messages);
                        echo json_encode($response);
                        exit;
                    }
                }
            }

            foreach ($user_id as $user) {

                $options_data = array(
                    'assessment_id' => $assessment_id,
                    'organization_id' => $this->input->post('organization_id'),
                    'start_date' => date('Y-m-d', strtotime($start_date)),
                    'end_date' => date('Y-m-d', strtotime($end_date)),
                    'assessment_type' => $assessment_type,
                    'bullets' => $bullets,
                    'bullets_in_month_date' => $bullets_in_month,
                    'active' => 1,
                    'create_date' => datetime()
                );
                $option = array('table' => USER_ASSESSMENT,
                    'data' => $options_data,
                    'where' => array('id' => $where_id)
                );

                $this->common_model->customUpdate($option);

                $options = array('table' => USER_ASSESSMENT_QUESTION,
                    'where' => array('user_assessment_id' => $where_id)
                );
                $this->common_model->customDelete($options);

                foreach ($question_id as $que) {
                    $opt_data = array(
                        'user_assessment_id' => $where_id,
                        'assessment_id' => $assessment_id,
                        'question_id' => $que
                    );
                    $options = array('table' => USER_ASSESSMENT_QUESTION,
                        'data' => $opt_data);
                    $this->common_model->customInsert($options);
                }

                if (!empty($upper_level_user)) {
                    $i = 0;
                    foreach ($upper_level_user as $upper_user) {

                        $options = array('table' => USER_ASSESSMENT,
                            'where' => array('child_upper_id' => $where_id,
                                'user_id' => $upper_user)
                        );
                        $isAssessment = $this->common_model->customGet($options);
                        if (!empty($isAssessment)) {
                            $options_data = array(
                                'organization_id' => $this->input->post('organization_id'),
                                'assessment_id' => $assessment_id,
                                'start_date' => date('Y-m-d', strtotime($start_date)),
                                'end_date' => date('Y-m-d', strtotime($end_date)),
                                'assessment_type' => $assessment_type,
                                'active' => 1,
                                'create_date' => datetime()
                            );
                            if ($assessment_type == 360) {
                                $options_data['bullets'] = (isset($bullets_upper[$i])) ? $bullets_upper[$i] : 0;
                                $options_data['bullets_in_month_date'] = (isset($bullets_in_month_upper[$i])) ? $bullets_in_month_upper[$i] : 0;
                            }

                            $option = array('table' => USER_ASSESSMENT,
                                'data' => $options_data,
                                'where' => array('child_upper_id' => $where_id,
                                    'user_id' => $upper_user)
                            );
                            $this->common_model->customUpdate($option);

                            $options = array('table' => USER_ASSESSMENT,
                                'select' => 'id',
                                'where' => array('child_upper_id' => $where_id,
                                    'user_id' => $upper_user),
                                'single' => true
                            );
                            $upper_assessment_id_where = $this->common_model->customGet($options);
                            $options = array('table' => USER_ASSESSMENT_QUESTION,
                                'where' => array('user_assessment_id' => $upper_assessment_id_where->id)
                            );
                            $this->common_model->customDelete($options);
                            foreach ($question_id as $que) {
                                $opt_data = array(
                                    'user_assessment_id' => $upper_assessment_id_where->id,
                                    'assessment_id' => $assessment_id,
                                    'question_id' => $que
                                );
                                $options = array('table' => USER_ASSESSMENT_QUESTION, 'data' => $opt_data);
                                $this->common_model->customInsert($options);
                            }
                            $i++;
                        } else {
                            $options_data = array(
                                'child_upper_id' => $where_id,
                                'organization_id' => $this->input->post('organization_id'),
                                'user_id' => $upper_user,
                                'assessment_id' => $assessment_id,
                                'start_date' => date('Y-m-d', strtotime($start_date)),
                                'end_date' => date('Y-m-d', strtotime($end_date)),
                                'assessment_type' => $assessment_type,
                                'active' => 1,
                                'create_date' => datetime()
                            );
                            if ($assessment_type == 360) {
                                $options_data['bullets'] = (isset($bullets_upper[$i])) ? $bullets_upper[$i] : 0;
                                $options_data['bullets_in_month_date'] = (isset($bullets_in_month_upper[$i])) ? $bullets_in_month_upper[$i] : 0;
                            }

                            $option = array('table' => USER_ASSESSMENT, 'data' => $options_data);
                            $last_id = $this->common_model->customInsert($option);
                            foreach ($question_id as $que) {
                                $opt_data = array(
                                    'user_assessment_id' => $last_id,
                                    'assessment_id' => $assessment_id,
                                    'question_id' => $que
                                );
                                $options = array('table' => USER_ASSESSMENT_QUESTION, 'data' => $opt_data);
                                $this->common_model->customInsert($options);
                            }
                        }
                    }
                }
            }
            $response = array('status' => 1, 'message' => lang('user_assessment_success'), 'url' => base_url('users/assessment'));
        } else {
            $messages = (validation_errors()) ? validation_errors() : '';
            $response = array('status' => 0, 'message' => $messages);
        }
        echo json_encode($response);
    }

    public function delUsers() {
        $response = "";
        $id = decoding($this->input->post('id')); // delete id
        $table = $this->input->post('table'); //table name
        $id_name = $this->input->post('id_name'); // table field name
        if (!empty($table) && !empty($id) && !empty($id_name)) {

            $option = array(
                'table' => $table,
                'where' => array($id_name => $id)
            );
            $delete = $this->common_model->customDelete($option);
            if ($delete) {
                $option = array(
                    'table' => USERS_DEVICE_HISTORY,
                    'where' => array('user_id' => $id)
                );
                $this->common_model->customDelete($option);
                $option = array(
                    'table' => USER_GROUPS,
                    'where' => array('user_id' => $id)
                );
                $this->common_model->customDelete($option);
                $option = array(
                    'table' => USER_HIERARCHY,
                    'where' => array('user_id' => $id)
                );
                $this->common_model->customDelete($option);

                $option = array(
                    'table' => USER_HIERARCHY,
                    'where' => array('child_user_id' => $id)
                );
                $this->common_model->customDelete($option);

                $options = array('table' => USER_ASSESSMENT . ' as UA',
                    'select' => 'UA.id',
                    'where' => array('UA.user_id' => $id, 'child_upper_id' => 0),
                    'single' => true
                );
                $assessment = $this->common_model->customGet($options);
                if (!empty($assessment)) {
                    $option = array(
                        'table' => USER_ASSESSMENT_QUESTION,
                        'where' => array('user_assessment_id' => $assessment->id)
                    );
                    $this->common_model->customDelete($option);
                    $option = array(
                        'table' => DAILY_ASSESSMENT_SUBMISSION,
                        'where' => array('user_assessment_id' => $assessment->id)
                    );
                    $this->common_model->customDelete($option);
                    $option = array(
                        'table' => USER_ASSESSMENT_QUESTION_SUBMISSION,
                        'where' => array('user_assessment_id' => $assessment->id)
                    );
                    $this->common_model->customDelete($option);
                    $options = array('table' => USER_ASSESSMENT . ' as UA',
                        'select' => 'AU.id as upper_id',
                        'join' => array(USER_ASSESSMENT . ' as AU' => 'AU.child_upper_id=UA.id'),
                        'where' => array('UA.id' => $assessment->id)
                    );
                    $all_assessment = $this->common_model->customGet($options);
                    if (!empty($all_assessment)) {
                        foreach ($all_assessment as $val) {
                            $option = array(
                                'table' => USER_ASSESSMENT_QUESTION,
                                'where' => array('user_assessment_id' => $val->upper_id)
                            );
                            $this->common_model->customDelete($option);
                            $option = array(
                                'table' => DAILY_ASSESSMENT_SUBMISSION,
                                'where' => array('user_assessment_id' => $val->upper_id)
                            );
                            $this->common_model->customDelete($option);
                            $option = array(
                                'table' => USER_ASSESSMENT_QUESTION_SUBMISSION,
                                'where' => array('user_assessment_id' => $val->upper_id)
                            );
                            $this->common_model->customDelete($option);
                        }
                    }
                    $option = array(
                        'table' => USER_ASSESSMENT,
                        'where' => array('child_upper_id' => $assessment->id)
                    );
                    $this->common_model->customDelete($option);
                    $option = array(
                        'table' => USER_ASSESSMENT,
                        'where' => array('id' => $assessment->id)
                    );
                    $this->common_model->customDelete($option);
                } else {
                    $options = array('table' => USER_ASSESSMENT . ' as UA',
                        'select' => 'UA.id',
                        'where' => array('UA.user_id' => $id),
                        'single' => true
                    );
                    $assessment = $this->common_model->customGet($options);
                    if (!empty($assessment)) {
                        $option = array(
                            'table' => USER_ASSESSMENT_QUESTION,
                            'where' => array('user_assessment_id' => $assessment->id)
                        );
                        $this->common_model->customDelete($option);

                        $option = array(
                            'table' => DAILY_ASSESSMENT_SUBMISSION,
                            'where' => array('user_assessment_id' => $assessment->id)
                        );
                        $this->common_model->customDelete($option);
                        $option = array(
                            'table' => USER_ASSESSMENT_QUESTION_SUBMISSION,
                            'where' => array('user_assessment_id' => $assessment->id)
                        );
                        $this->common_model->customDelete($option);
                        $option = array(
                            'table' => USER_ASSESSMENT,
                            'where' => array('id' => $assessment->id)
                        );
                        $this->common_model->customDelete($option);
                    }
                }


                $response = 200;
            } else
                $response = 400;
        }else {
            $response = 400;
        }
        echo $response;
    }

    public function viewAssessmentCategory($id = "") {
        if (!empty($id)) {
            $assessmentId = decoding($id);
            $this->data['title'] = "Assessment Category";
            $this->data['parent'] = "UA";
            $option = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'ACA.id as cat_id,ACA.category_name,UAQS.question_id,ACA.id as category_id,QSA.question,UA.assessment_type',
                'join' => array(USER_ASSESSMENT_QUESTION . ' as UAQS' => 'UAQS.user_assessment_id=UA.id',
                    QUESTIONS . ' as QSA' => 'QSA.id=UAQS.question_id',
                    ASSESSMENT_CATEGORY . ' as ACA' => 'ACA.id=QSA.category_id'),
                'where' => array('UA.id' => $assessmentId),
            );
            $assessmentCategory = $this->common_model->customGet($option);
            $categorys = array();
            if (!empty($assessmentCategory)) {
                foreach ($assessmentCategory as $rows) {
                    $temp['category_name'] = $rows->category_name;
                    $temp['question_id'] = $rows->question_id;
                    $temp['question'] = $rows->question;
                    $temp['assessment_type'] = $rows->assessment_type;
                    $categorys[$rows->category_name][] = $temp;
                }
            }
            $this->data['assessmentCategory'] = $categorys;
            $this->data['assessmentId'] = $assessmentId;
            $this->load->admin_render('assessment_category', $this->data, 'inner_script');
        } else {
            redirect('users/assessment');
        }
    }

    public function removeUpperAssessment() {
        $assessmentId = $this->input->post('assessmentId');
        $option = array(
            'table' => 'user_assessment',
            'where' => array('id' => $assessmentId)
        );
        $delete = $this->common_model->customDelete($option);
        if ($delete) {
            $option = array(
                'table' => USER_ASSESSMENT_QUESTION,
                'where' => array('user_assessment_id' => $assessmentId)
            );
            $this->common_model->customDelete($option);
        }
        echo 1;
    }

}
