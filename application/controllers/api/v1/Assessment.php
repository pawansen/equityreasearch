<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for user
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class Assessment extends Common_API_Controller {

    function __construct() {
        parent::__construct();
        $tables = $this->config->item('tables', 'ion_auth');
        $this->lang->load('en', 'english');
    }

    /**
     * Function Name: get_roles
     * Description:   To Get user roles by hierarchy
     */
    function get_roles_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        // $response = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
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
                $return['position'] = 0;
                $last_position = getRolePosition($organization_id, 1, 0);
                if ($last_position == $role_id) {
                    $return['status'] = 1;
                    $return['position'] = 1; // last position in roles
                    $return['message'] = "Last Role";
                    $this->response($return);
                    exit;
                } else {
                    $second_last_position = getRolePosition($organization_id, 1, 1);
                    if ($second_last_position == $role_id) {
                        $return['status'] = 1;
                        $return['position'] = 2; // second last position in roles 
                        $return['message'] = "Second Last Role";
                        $this->response($return);
                        exit;
                    } else {

                        $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                            'select' => 'user.id as user_id,user.first_name,user.last_name,group.name as role,ugroup.group_id as role_id,user.profile_pic',
                            'join' => array(USERS . ' as user' => 'user.id=user_hierarchy.child_user_id',
                                USER_GROUPS . ' as ugroup' => 'ugroup.user_id=user.id',
                                GROUPS . ' as group' => 'group.id=ugroup.group_id'),
                            'where' => array('user_hierarchy.user_id' => $user_id,
                                'user_hierarchy.organization_id' => $organization_id));

                        $all_users = $this->common_model->customGet($option);
                        if (!empty($all_users)) {
                            foreach ($all_users as $rows) {
                                $temp1['user_id'] = $rows->user_id;
                                $temp1['first_name'] = $rows->first_name;
                                $temp1['last_name'] = $rows->last_name;
                                $temp1['role_name'] = $rows->role;
                                $temp1['role_id'] = $rows->role_id;
                                $temp1['profile_pic'] = (!empty($rows->profile_pic)) ? base_url() . $rows->profile_pic : base_url() . DEFAULT_NO_IMG_PATH;
                                $role_position = getRolePosition($organization_id, 1, 1);
                                $temp1['is_next'] = (!empty($role_position == $rows->role_id)) ? 0 : 1;
                                $response[] = $temp1;
                            }
                            $return['status'] = 1;
                            $return['message'] = lang('api_role_list_success');
                            $return['response'] = $response;
                        } else {
                            $return['status'] = 0;
                            $return['message'] = lang('api_role_list_failed');
                        }
                    }
                }
            } else {
                $return['status'] = 0;
                $return['message'] = lang('api_user_not_exists');
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: get_assessment
     * Description:   To Get user question assessment
     */
    function get_assessment_post() {

        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $user_id = extract_value($data, 'user_id', '');
            $login_user_id = extract_value($data, 'login_user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');

            if (empty($login_user_id)) {
                $option = array('table' => USER_ASSESSMENT . ' as UA',
                    'select' => 'UA.id as user_assessment_id,UAQ.question_id,UA.start_date,UA.end_date',
                    'join' => array(USER_ASSESSMENT_QUESTION . ' as UAQ' => 'UAQ.user_assessment_id=UA.id'),
                    'where' => array('UA.user_id' => $user_id,
                        'UA.organization_id' => $organization_id,
                        'UA.assessment_status' => 0,
                        'UA.assessment_type' => 180
                    ),
                );
                $user_assessment = $this->common_model->customGet($option);
            } else {
                $option = array('table' => USER_ASSESSMENT . ' as UA',
                    'select' => 'UA1.id as user_assessment_id,UAQ.question_id,UA1.start_date,UA1.end_date',
                    'join' => array(USER_ASSESSMENT . ' as UA1' => 'UA1.child_upper_id=UA.id',
                        USER_ASSESSMENT_QUESTION . ' as UAQ' => 'UAQ.user_assessment_id=UA1.id'),
                    'where' => array('UA.user_id' => $user_id,
                        'UA1.user_id' => $login_user_id,
                        'UA.organization_id' => $organization_id,
                        'UA1.assessment_status' => 0,
                        'UA.assessment_type' => 180
                    ),
                );
                $user_assessment = $this->common_model->customGet($option);
            }
            $questions = array();
            if (!empty($user_assessment)) {
                $flag = false;
                $currdate = date('Y-m-d');
                if ($currdate >= $user_assessment[0]->start_date) {
                    $flag = true;
                    if ($currdate <= $user_assessment[0]->end_date) {
                        $flag = true;
                    } else {
                        $flag = false;
                    }
                }
                if ($flag) {
                    $questions['user_assessment_id'] = $user_assessment[0]->user_assessment_id;
                    $questions['questions'] = array();

                    foreach ($user_assessment as $rows) {

                        $option = array('table' => QUESTIONS . ' as QU',
                            'select' => 'QU.id,QU.question,QU.option_type',
                            'where' => array('QU.active' => 1, 'QU.id' => $rows->question_id)
                        );

                        $ques = $this->common_model->customGet($option);
                        $temp12 = array();
                        if (!empty($ques)) {
                            foreach ($ques as $q) {
                                $temp1['question_id'] = $q->id;
                                $temp1['question'] = $q->question;
                                $temp1['option_type'] = $q->option_type;
                                if ($q->option_type != 2) {
                                    $option = array('table' => QUESTIONS_OPTION . ' as QO',
                                        'select' => 'QO.id as option_id,QO.label_option as option,',
                                        'where' => array('QO.question_id' => $q->id)
                                    );

                                    $options = $this->common_model->customGet($option);
                                    $temp3 = array();
                                    $temp23 = array();
                                    foreach ($options as $opt) {
                                        $temp3['option_id'] = $opt->option_id;
                                        $temp3['option'] = $opt->option;
                                        $temp23 [] = $temp3;
                                    }
                                }
                                $temp1['options'] = ($q->option_type != 2) ? $temp23 : array();
                                $temp12 = $temp1;
                            }
                        }

                        $questions['questions'][] = $temp12;
                        $return['status'] = 1;
                        $return['message'] = lang('api_assessment_question_success');
                        $return['response'] = $questions;
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = "No Assessment is created yet";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = "No Assessment is created yet";
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: user_assessment
     * Description:   To Get user last assessment
     */
    function user_assessment_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $top_user_id = extract_value($data, 'top_user_id', '');
            $user_id = extract_value($data, 'user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $role_id = extract_value($data, 'role_id', '');
            $exists_user = $this->common_model->getsingle(USERS, array('id' => $user_id));
            if (!empty($exists_user)) {

                $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                    'select' => 'user.id as user_id,user.first_name,user.last_name,group.name as role,ugroup.group_id as role_id,user.profile_pic',
                    'join' => array(USERS . ' as user' => 'user.id=user_hierarchy.child_user_id',
                        USER_GROUPS . ' as ugroup' => 'ugroup.user_id=user.id',
                        GROUPS . ' as group' => 'group.id=ugroup.group_id',
                        USER_ASSESSMENT . ' as UA' => 'UA.user_id=user.id'),
                    'where' => array('user_hierarchy.user_id' => $user_id,
                        'user_hierarchy.organization_id' => $organization_id),
                    'group_by' => 'user.id');

                $all_users = $this->common_model->customGet($option);
                if (!empty($all_users)) {
                    foreach ($all_users as $rows) {
                        $temp1['user_id'] = $rows->user_id;
                        $temp1['first_name'] = $rows->first_name;
                        $temp1['last_name'] = $rows->last_name;
                        $temp1['role_name'] = $rows->role;
                        $temp1['role_id'] = $rows->role_id;
                        $temp1['profile_pic'] = (!empty($rows->profile_pic)) ? base_url() . $rows->profile_pic : base_url() . DEFAULT_NO_IMG_PATH;

                        if (!empty($top_user_id)) {
                            $options = array('table' => USER_ASSESSMENT . ' as UA',
                                'select' => 'AU.id as upper_id,AU.assessment_status',
                                'join' => array(USER_ASSESSMENT . ' as AU' => 'AU.child_upper_id=UA.id'),
                                'where' => array('UA.user_id' => $rows->user_id,
                                    'AU.user_id' => $top_user_id),
                                'single' => true
                            );
                        } else {
                            $options = array('table' => USER_ASSESSMENT . ' as UA',
                                'select' => 'UA.id,UA.assessment_status',
                                'where' => array('UA.user_id' => $rows->user_id),
                                'single' => true
                            );
                        }
                        $is_submission = $this->common_model->customGet($options);
                        $temp1['status'] = (isset($is_submission->assessment_status)) ? $is_submission->assessment_status : 0;

                        if ($rows->role_id == 5) {
                            $sql = "SELECT `UA`.`id` as `user_assessment_id`
                                    FROM `user_assessment` as `UA`
                                    WHERE `UA`.`user_id` = " . $rows->user_id . "
                                    AND `UA`.`organization_id` = " . $organization_id . "
                                    AND `UA`.`assessment_type` = 180";
                            $isUserAssessment = $this->common_model->customQuery($sql);
                            if (!empty($isUserAssessment)) {
                                $response[] = $temp1;
                            }
                        } else {
                            $response[] = $temp1;
                        }
                    }
                    $return['status'] = 1;
                    $return['message'] = lang('api_assessment_user_success');
                    $return['response'] = $response;
                } else {
                    $return['status'] = 0;
                    $return['message'] = lang('api_assessment_user_error');
                }
            } else {
                $return['status'] = 0;
                $return['message'] = lang('api_user_not_exists');
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: assessment_submission
     * Description:   To submit assessment
     */
    function assessment_submission_post() {

        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_assessment_id', 'User Assessment Id', 'trim|required');
        $this->form_validation->set_rules('answer', 'Answers', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $user_assessment_id = extract_value($data, 'user_assessment_id', '');
            $answer = extract_value($data, 'answer', '');
            $answers = json_decode($answer);
            $questions = array_column($answers, 'question_id');

            $options = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'UAQ.question_id,UAQ.id',
                'join' => array(USER_ASSESSMENT_QUESTION . ' as UAQ' => 'UAQ.user_assessment_id=UA.id'),
                'where' => array('UA.id' => $user_assessment_id,
                    'UA.assessment_status' => 0),
            );
            $user_assessments = $this->common_model->customGet($options);
            if (!empty($user_assessments)) {
                $user_assessment = array_column($user_assessments, 'question_id');
                $diff_valid = array_diff($user_assessment, $questions);
                if (!empty($diff_valid)) {
                    $return['status'] = 0;
                    $return['message'] = "Please fill up all question answer";
                } else {
                    foreach ($answers as $ans) {
                        $options = array('table' => USER_ASSESSMENT_QUESTION_SUBMISSION,
                            'data' => array('user_assessment_id' => $user_assessment_id,
                                'user_assessment_question_id' => search_exif_return($user_assessments, 'question_id', $ans->question_id),
                                'question_id' => $ans->question_id,
                                'select_option_id' => $ans->option_id,
                                'submission_datetime' => date('Y-m-d H:i:s')
                            ),
                        );
                        $this->common_model->customInsert($options);
                    }

                    $options = array('table' => USER_ASSESSMENT,
                        'data' => array('assessment_status' => 1),
                        'where' => array('id' => $user_assessment_id),
                    );
                    $this->common_model->customUpdate($options);
                    $return['status'] = 1;
                    $return['message'] = "Your assessment successfully has been submitted";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = "Your assessment have already submitted";
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: get_assessment
     * Description:   To Get user question assessment
     */
    function is_assessment_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('login_user_id', 'Login User Id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('assessment_type', 'Assessment Type', 'trim|required|in_list[180,360]');
        $this->form_validation->set_rules('call_type', 'Call Type', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $login_user_id = extract_value($data, 'login_user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $assessment_type = extract_value($data, 'assessment_type', '');
            $call_type = extract_value($data, 'call_type', '');
            $user_id = extract_value($data, 'user_id', '');
            $login_role_id = extract_value($data, 'login_role_id', '');

            $option = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'UA.id as user_assessment_id,UA.bullets_in_month_date',
                'where' => array('UA.user_id' => $login_user_id,
                    'UA.organization_id' => $organization_id,
                    //'UA.assessment_status' => 0,
                    'UA.assessment_type' => $assessment_type
                ),
                'single' => true
            );
            $user_assessment = $this->common_model->customGet($option);
            if (!empty($user_assessment)) {
                if ($call_type == 2) {
                    if ($assessment_type == 360) {

                        if ($login_role_id != 5) {

                            $option1 = array('table' => USER_ASSESSMENT . ' as UA',
                                'select' => 'UA.id as user_assessment_id,UA.bullets_in_month_date,UA.assessment_status',
                                'join' => array(USER_ASSESSMENT . ' as UA2' => 'UA2.id=UA.child_upper_id'),
                                'where' => array('UA.user_id' => $login_user_id,
                                    'UA.organization_id' => $organization_id,
                                    //'UA.assessment_status' => 0,
                                    'UA.assessment_type' => $assessment_type,
                                    'UA2.user_id' => $user_id
                                ),
                                'order' => array('UA.id' => 'DESC'),
                                'single' => true
                            );
                            $user_assessment = $this->common_model->customGet($option1);
                            if (empty($user_assessment)) {
                                $return['status'] = 0;
                                $return['message'] = "Assessment not found";
                                $this->response($return);
                                exit;
                            } else {

                                if ($user_assessment->assessment_status == 1) {
                                    $return['status'] = 0;
                                    $return['message'] = "Your assessment has been completed for this user";
                                    $this->response($return);
                                    exit;
                                }
                            }
                        }

                        $option = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as UA',
                            'select' => 'UA.id',
                        );
                        if (!empty($user_assessment->bullets_in_month_date)) {
                            $bulletDates = explode(",", $user_assessment->bullets_in_month_date);
                            if (in_array(date('m/d/Y'), $bulletDates)) {
                                $option['where']['UA.user_assessment_id'] = $user_assessment->user_assessment_id;
                                $option['where']['UA.submission_date'] = date('Y-m-d');
                                $is_done = $this->common_model->customGet($option);

                                if (!empty($is_done)) {
                                    $return['status'] = 0;
                                    $return['message'] = "Today assessment have already submitted";
                                } else {
                                    $return['status'] = 1;
                                    $return['message'] = "Assessment found";
                                }
                            } else {
                                $return['status'] = 0;
                                $return['message'] = "You don't have assessment for today";
                            }
                        } else {
                            if ($login_role_id != 5) {

                                $option2 = array('table' => USER_ASSESSMENT . ' as UA',
                                    'select' => 'UA.id as user_assessment_id,UA.bullets_in_month_date,UA.assessment_status',
                                    'join' => array(USER_ASSESSMENT . ' as UA2' => 'UA2.id=UA.child_upper_id'),
                                    'where' => array('UA.user_id' => $login_user_id,
                                        'UA.organization_id' => $organization_id,
                                        //'UA.assessment_status' => 0,
                                        'UA.assessment_type' => $assessment_type,
                                        'UA2.user_id' => $user_id
                                    ),
                                    'order' => array('UA.id' => 'DESC'),
                                    'single' => true
                                );
                                $user_assessment = $this->common_model->customGet($option2);
                                if (empty($user_assessment)) {
                                    $return['status'] = 0;
                                    $return['message'] = "Assessment not found";
                                    $this->response($return);
                                    exit;
                                } else {

                                    if ($user_assessment->assessment_status == 1) {
                                        $return['status'] = 0;
                                        $return['message'] = "Your assessment has been completed for this user";
                                        $this->response($return);
                                        exit;
                                    }
                                }
                            }
                            $option['where']['UA.user_assessment_id'] = $user_assessment->user_assessment_id;
                            $option['where']['UA.submission_date'] = date('Y-m-d');
                            $is_done = $this->common_model->customGet($option);
                            if (!empty($is_done)) {
                                $return['status'] = 0;
                                $return['message'] = "Today assessment have already submitted";
                            } else {
                                $return['status'] = 1;
                                $return['message'] = "Assessment found";
                            }
                        }
                    } else {
                        $return['status'] = 1;
                        $return['message'] = "Assessment found";
                    }
                } else {
                    $return['status'] = 1;
                    $return['message'] = "Assessment found";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = "No Assessment is created yet";
            }
        }
        $this->response($return);
    }

    public function dashboardReport_post() {

        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        // $response = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('user_id', 'User Id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $allUsers = array();
            $user_id = extract_value($data, 'user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $role_id = extract_value($data, 'role_id', '');
            $isUser = $this->common_model->getsingle(USERS, array('id' => $user_id));
            if (!empty($isUser)) {
                $lastUser = array();

                if ($role_id != 5) {
                    $sql = "SELECT user.`id` as id,gr.name as role_name, CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM "
                            . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                            . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                            . " WHERE ug.organization_id  = '" . $organization_id . "' AND user.id = '" . $user_id . "'"
                            . "";
                    $loginUser = $this->common_model->customQuery($sql);
                    $sql = "SELECT user.`id` as id, gr.name as role_name,CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM "
                            . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                            . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                            . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                            . " WHERE ug.organization_id  = '" . $organization_id . "' AND UH.user_id = '" . $user_id . "' GROUP BY user.id"
                            . "";
                    $lowerUsers = $this->common_model->customQuery($sql);
                    if (!empty($lowerUsers)) {
                        $temp2 = "";
                        foreach ($lowerUsers as $usr) {
                            $temp2 .= $usr->id . ",";
                        }
                        $temp3 = rtrim($temp2, ',');
                        if ($lowerUsers[0]->role_id == 4) {
                            $sql = "SELECT user.`id` as id, gr.name as role_name,CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM "
                                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                                    . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                                    . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                                    . " WHERE UH.user_id IN ($temp3) AND ug.organization_id  = '" . $organization_id . "' AND gr.id = 5 AND UA.assessment_type=180 GROUP BY user.id"
                                    . "";
                            $lastUser = $this->common_model->customQuery($sql);
                            if (empty($lastUser)) {
                                $return['status'] = 0;
                                $return['message'] = "User assessment report record not found";
                                $this->response($return);
                                exit;
                            }
                            $allUsers = array_merge($lastUser, $lowerUsers, $loginUser);
                        } else if ($lowerUsers[0]->role_id == 5) {
                            $sql = "SELECT user.`id` as id,gr.name as role_name, CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM "
                                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                                    . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                                    . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                                    . " WHERE UH.child_user_id IN ($temp3) AND ug.organization_id  = '" . $organization_id . "' AND gr.id = 5 AND UA.assessment_type=180 GROUP BY user.id"
                                    . "";
                            $lastUser = $this->common_model->customQuery($sql);
                            if (empty($lastUser)) {
                                $return['status'] = 0;
                                $return['message'] = "User assessment report record not found";
                                $this->response($return);
                                exit;
                            }
                            $allUsers = array_merge($lastUser, $loginUser);
                        }
                    }
                } else {
                    $sql = "SELECT user.`id` as id, gr.name as role_name,CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM "
                            . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                            . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                            . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                            . " WHERE ug.organization_id  = '" . $organization_id . "' AND user.id = '" . $user_id . "' AND gr.id = 5 AND UA.assessment_type=180"
                            . "";
                    $loginUser = $this->common_model->customQuery($sql);
                    if (!empty($loginUser)) {
                        $sql = "SELECT UH.`user_id` as id ,gr.name as role_name, CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM user_hierarchy as UH"
                                . " INNER JOIN users_groups as ug ON ug.user_id=UH.user_id"
                                . " INNER JOIN groups as gr ON (gr.id=ug.group_id)"
                                . " INNER JOIN users as user ON (user.id=UH.user_id)"
                                . " WHERE UH.child_user_id IN ($user_id) AND UH.organization_id  = '" . $organization_id . "'"
                                . "";
                        $second = $this->common_model->customQuery($sql);
                        $temp4 = "";
                        foreach ($second as $usr) {
                            $temp4 .= $usr->id . ",";
                        }
                        $temp5 = rtrim($temp4, ',');
                        $sql = "SELECT UH.`user_id` as id ,gr.name as role_name, CONCAT(user.`first_name`,' ',user.`last_name`) as name, ug.organization_id, gr.id as role_id FROM user_hierarchy as UH"
                                . " INNER JOIN users_groups as ug ON ug.user_id=UH.user_id"
                                . " INNER JOIN groups as gr ON (gr.id=ug.group_id)"
                                . " INNER JOIN users as user ON (user.id=UH.user_id)"
                                . " WHERE UH.child_user_id IN ($temp5) AND UH.organization_id  = '" . $organization_id . "'"
                                . "";
                        $last = $this->common_model->customQuery($sql);
                        $allUsers = array_merge($second, $last, $loginUser);
                    } else {
                        $return['status'] = 0;
                        $return['message'] = "User assessment report record not found";
                        $this->response($return);
                        exit;
                    }
                }
                if (!empty($allUsers)) {
                    $reports = array();
                    foreach ($allUsers as $key => $usr) {
                        if ($usr->role_id == 5) {
                            $temp6['id'] = $usr->id;
                            $temp6['name'] = $usr->name;
                            $temp6['role_name'] = $usr->role_name;
                            $temp6['role_id'] = $usr->role_id;
                            $temp6['userStatus'] = array();
                            foreach ($allUsers as $u) {
                                $temp7['id'] = $u->id;
                                $temp7['name'] = $u->name;
                                $temp7['role_name'] = $u->role_name;
                                $temp7['role_id'] = $u->role_id;
                                if ($u->id == $usr->id) {
                                    $temp7['status'] = is_assessment_current_app($organization_id, $usr->id);
                                } else {
                                    $temp7['status'] = is_assessment_submission_app($organization_id, $usr->id, $u->id);
                                }
                                $temp6['userStatus'][] = $temp7;
                            }
                            $reports[] = $temp6;
                        }
                    }
                    $return['status'] = 1;
                    $return['response'] = $reports;
                    $return['message'] = "Report generated successfully";
                } else {
                    $return['status'] = 0;
                    $return['message'] = "User assessment report record not found";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = lang('api_user_not_exists');
            }
        }
        $this->response($return);
    }

}

/* End of file Assessment.php */
/* Location: ./application/controllers/api/v1/Assessment.php */
?>