<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * This Class used as REST API for user
 * @package   CodeIgniter
 * @category  Controller
 * @author    MobiwebTech Team
 */
class DailyAssessment extends Common_API_Controller {

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
        $response = array();
        // $response = array();
        // $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
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
                /*               $return['position'] = 0;
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
                  } else { */

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
                        $isUserAssessment = array();
                        if ($rows->role_id == 5) {
                            $sql = "SELECT `UA`.`id` as `user_assessment_id`
                                    FROM `user_assessment` as `UA`
                                    WHERE `UA`.`user_id` = " . $rows->user_id . "
                                    AND `UA`.`organization_id` = " . $organization_id . "
                                    AND `UA`.`assessment_type` = 360";
                            $isUserAssessment = $this->common_model->customQuery($sql);
                            if (!empty($isUserAssessment)) {
                                $temp1['user_id'] = $rows->user_id;
                                $temp1['first_name'] = $rows->first_name;
                                $temp1['last_name'] = $rows->last_name;
                                $temp1['role_name'] = $rows->role;
                                $temp1['role_id'] = $rows->role_id;
                                $temp1['profile_pic'] = (!empty($rows->profile_pic)) ? base_url() . $rows->profile_pic : base_url() . DEFAULT_NO_IMG_PATH;

                                $role_position = getRolePosition($organization_id, 1, 0);
                                $temp1['is_next'] = (!empty($role_position == $rows->role_id)) ? 0 : 1;

                                $response[] = $temp1;
                            }
                        } else {
                            $temp1['user_id'] = $rows->user_id;
                            $temp1['first_name'] = $rows->first_name;
                            $temp1['last_name'] = $rows->last_name;
                            $temp1['role_name'] = $rows->role;
                            $temp1['role_id'] = $rows->role_id;
                            $temp1['profile_pic'] = (!empty($rows->profile_pic)) ? base_url() . $rows->profile_pic : base_url() . DEFAULT_NO_IMG_PATH;

                            $role_position = getRolePosition($organization_id, 1, 0);
                            $temp1['is_next'] = (!empty($role_position == $rows->role_id)) ? 0 : 1;

                            $response[] = $temp1;
                        }
                    }
                    $return['status'] = 1;
                    $return['message'] = lang('api_role_list_success');
                    $return['response'] = $response;
                } else {
                    $return['status'] = 0;
                    $return['message'] = lang('api_role_list_failed');
                }
                /* }
                  } */
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

                $date = date('m/d/Y');
                /* $sql = "SELECT `UA`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA`.`start_date`, `UA`.`end_date`,"
                  . " `UA`.`bullets`, `UA`.`bullets_in_month_date` "
                  . "FROM `user_assessment` as `UA` JOIN `user_assessment_question` as `UAQ` "
                  . "ON `UAQ`.`user_assessment_id`=`UA`.`id` WHERE `UA`.`user_id` = " . $user_id . " "
                  . "AND `UA`.`organization_id` = " . $organization_id . " AND `UA`.`assessment_status` = 0 "
                  . "AND `UA`.`assessment_type` = 360 AND find_in_set('" . $date . "',UA.bullets_in_month_date)"; */

                $sql = "SELECT `UA`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA`.`start_date`, `UA`.`end_date`,"
                        . " `UA`.`bullets`, `UA`.`bullets_in_month_date`, `UA`.`bullets_submission` "
                        . "FROM `user_assessment` as `UA` JOIN `user_assessment_question` as `UAQ` "
                        . "ON `UAQ`.`user_assessment_id`=`UA`.`id` WHERE `UA`.`user_id` = " . $user_id . " "
                        . "AND `UA`.`organization_id` = " . $organization_id . " AND `UA`.`assessment_status` = 0 "
                        . "AND `UA`.`assessment_type` = 360";

                $user_assessment = $this->common_model->customQuery($sql);
                if (!empty($user_assessment)) {
                    $bullets_flag = true;
                    $bullets_submission = (int) $user_assessment[0]->bullets_submission;
                    $bullets = (int) $user_assessment[0]->bullets;
                    if ($bullets <= $bullets_submission) {
                        $bullets_flag = false;
                    }
                    if ($bullets_flag) {

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
                            $date_flag = true;
                            $bullets_in_month_date = $user_assessment[0]->bullets_in_month_date;
                            if (!empty($bullets_in_month_date)) {
                                $explode_date = explode(",", $bullets_in_month_date);
                                if (in_array($date, $explode_date)) {
                                    $date_flag = true;
                                } else {
                                    $date_flag = false;
                                }
                            }
                            if ($date_flag) {
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
                                $return['message'] = "Today don't have eligible assessment submission";
                            }
                        } else {
                            $return['status'] = 0;
                            $return['message'] = lang('api_assessment_question_error');
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = "Your assessment submission has been completed";
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = "No Daily Assessment is created yet";
                }
            } else {
                $date = date('m/d/Y');
                $sql = "SELECT `UA1`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA1`.`start_date`, `UA1`.`end_date`, `UA1`.`bullets`, `UA1`.`bullets_in_month_date`, `UA1`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA1`.`id`
                        WHERE `UA`.`user_id` = " . $user_id . "
                        AND `UA1`.`user_id` = " . $login_user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_status` =0
                        AND `UA`.`assessment_type` = 360";
                $user_assessment = $this->common_model->customQuery($sql);
                if (!empty($user_assessment)) {

                    $bullets_flag = true;
                    $bullets_submission = (int) $user_assessment[0]->bullets_submission;
                    $bullets = (int) $user_assessment[0]->bullets;
                    if ($bullets <= $bullets_submission) {
                        $bullets_flag = false;
                    }
                    if ($bullets_flag) {
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
                            $date_flag = true;
                            $bullets_in_month_date = $user_assessment[0]->bullets_in_month_date;
                            if (!empty($bullets_in_month_date)) {
                                $explode_date = explode(",", $bullets_in_month_date);
                                if (in_array($date, $explode_date)) {
                                    $date_flag = true;
                                } else {
                                    $date_flag = false;
                                }
                            }
                            if ($date_flag) {
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
                                $return['message'] = "Today don't have eligible assessment submission";
                            }
                        } else {
                            $return['status'] = 0;
                            $return['message'] = "No Daily Assessment is created yet";
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = "Your assessment submission has been completed";
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = "No Daily Assessment is created yet";
                }
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
                'select' => 'UAQ.question_id,UAQ.id,UA.bullets,UA.bullets_submission',
                'join' => array(USER_ASSESSMENT_QUESTION . ' as UAQ' => 'UAQ.user_assessment_id=UA.id'),
                'where' => array('UA.id' => $user_assessment_id,
                    'UA.assessment_status' => 0),
            );
            $user_assessments = $this->common_model->customGet($options);
            if (!empty($user_assessments)) {
                $bullets = $user_assessments[0]->bullets;
                $bullets_submission = $user_assessments[0]->bullets_submission;
                if ($bullets_submission != $bullets) {

                    $options = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as UA',
                        'select' => 'UA.id',
                        'where' => array('UA.user_assessment_id' => $user_assessment_id,
                            'UA.submission_date' => date('Y-m-d')),
                    );
                    $assessments_exists = $this->common_model->customGet($options);
                    if (empty($assessments_exists)) {


                        $user_assessment = array_column($user_assessments, 'question_id');
                        $diff_valid = array_diff($user_assessment, $questions);
                        if (!empty($diff_valid)) {
                            $return['status'] = 0;
                            $return['message'] = "Please fill up all question answer";
                        } else {
                            foreach ($answers as $ans) {
                                $options = array('table' => DAILY_ASSESSMENT_SUBMISSION,
                                    'data' => array('user_assessment_id' => $user_assessment_id,
                                        'user_assessment_question_id' => search_exif_return($user_assessments, 'question_id', $ans->question_id),
                                        'question_id' => $ans->question_id,
                                        'select_option_id' => $ans->option_id,
                                        'submission_date' => date('Y-m-d'),
                                        'submission_datetime' => date('Y-m-d H:i:s')
                                    ),
                                );
                                $this->common_model->customInsert($options);
                            }
                            $sql = "UPDATE " . USER_ASSESSMENT . " SET bullets_submission = bullets_submission + 1 WHERE id = $user_assessment_id";
                            $this->db->query($sql);

                            $options = array('table' => USER_ASSESSMENT . ' as UA',
                                'select' => 'UA.id,UA.bullets,UA.bullets_submission',
                                'where' => array('UA.id' => $user_assessment_id),
                                'single' => true
                            );
                            $assessmentBullets = $this->common_model->customGet($options);
                            if (!empty($assessmentBullets)) {
                                if ($assessmentBullets->bullets == $assessmentBullets->bullets_submission) {
                                    $options = array('table' => USER_ASSESSMENT,
                                        'data' => array('assessment_status' => 1),
                                        'where' => array('id' => $assessmentBullets->id),
                                    );
                                    $this->common_model->customUpdate($options);
                                }
                            }
                            $return['status'] = 1;
                            $return['message'] = "Your assessment successfully has been submitted";
                        }
                    } else {
                        $return['status'] = 0;
                        $return['message'] = "Today assessment have already submitted";
                    }
                } else {
                    $return['status'] = 0;
                    $return['message'] = "Your assessment submission has been completed";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = "Your assessment submission has been completed";
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: get_assessment_duration
     * Description:   To Get assessment duration in month
     */
    function get_assessment_duration_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('user_id', 'user_id', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $user_id = extract_value($data, 'user_id', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $options = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'UA.start_date,UA.end_date',
                'where' => array('UA.user_id' => $user_id,
                    'UA.assessment_status' => 0,
                    'UA.organization_id' => $organization_id),
                'single' => true
            );
            $user_assessments = $this->common_model->customGet($options);
            if (!empty($user_assessments)) {
                $start = (new DateTime($user_assessments->start_date))->modify('first day of this month');
                $end = (new DateTime($user_assessments->end_date))->modify('first day of next month');
                $interval = DateInterval::createFromDateString('1 month');
                $period = new DatePeriod($start, $interval, $end);
                $months = array();
                foreach ($period as $dt) {
                    $temp['MonthInt'] = $dt->format("m");
                    $temp['MonthStr'] = $dt->format("M");
                    $months[] = $temp;
                }
                if (!empty($months)) {
                    $return['status'] = 1;
                    $return['message'] = "Assessment duration found";
                    $return['response'] = $months;
                } else {
                    $return['status'] = 0;
                    $return['message'] = "Assessment not found";
                }
            } else {
                $return['status'] = 0;
                $return['message'] = "Assessment not found";
            }
        }
        $this->response($return);
    }

    /**
     * Function Name: user_assessment_hierarchy
     * Description:   To Get user assessment hierahcy records
     */
    function user_assessment_hierarchy_old_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('users', 'users', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('month', 'Month', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $users = extract_value($data, 'users', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $month = extract_value($data, 'month', '');
            $users = json_decode($users);
            $response_hierarchy = array();
            $temp = array();
            $temp['submission_dates'] = array();
            if (!empty($users)) {
                $keys = array_keys($users);
                $lastKey = $keys[count($keys) - 1];

                foreach ($users as $user) {
                    $temp['user_id'] = $user->user_id;
                    $temp['role'] = getRole($user->user_id);
                    $temp['role_id'] = $user->role_id;
                    if ($users[$lastKey]->user_id != $user->user_id) {
                        $sql = "SELECT `UA1`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA1`.`start_date`, `UA1`.`end_date`, `UA1`.`bullets`, `UA1`.`bullets_in_month_date`, `UA1`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA1`.`id`
                        WHERE `UA`.`user_id` = " . $users[$lastKey]->user_id . "
                        AND `UA1`.`user_id` = " . $user->user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 360";
                    } else {
                        $sql = "SELECT `UA`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA`.`start_date`, `UA`.`end_date`, `UA`.`bullets`, `UA`.`bullets_in_month_date`, `UA`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user->user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 360";
                    }
                    $user_assessment = $this->common_model->customQuery($sql);
                    $temp['questions'] = array();
                    foreach ($user_assessment as $rows) {
                        $option = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as DAS',
                            'select' => 'DAS.submission_date,QA.question,QA.title,DAS.question_id,DAS.select_option_id,QO.point',
                            'join' => array(QUESTIONS . ' as QA' => 'QA.id=DAS.question_id',
                                QUESTIONS_OPTION . ' as QO' => 'QO.id=DAS.select_option_id'),
                            'where' => array('DAS.user_assessment_id' => $rows->user_assessment_id,
                                'MONTH(DAS.submission_date)' => $month,
                                'DAS.question_id' => $rows->question_id),
                            'order' => array('DAS.submission_date' => 'ASC'));
                        $allSubmissions = $this->common_model->customGet($option);
                        $temp2['dates'] = array();
                        $temp2 = array();

                        $temp['assign_date'] = array();
                        $assignDates = explode(',', $rows->bullets_in_month_date);
                        foreach ($assignDates as $assdates) {
                            $option = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as UA',
                                'select' => 'UA.id',
                            );
                            $option['where']['UA.submission_date'] = date('Y-m-d', strtotime($assdates));
                            $option['where']['UA.user_assessment_id'] = $rows->user_assessment_id;
                            $is_done = $this->common_model->customGet($option);
                            $tmp5['date'] = date('Y-m-d', strtotime($assdates));
                            $tmp5['is_complete'] = (!empty($is_done)) ? 1 : 0;
                            $temp['assign_date'][] = $tmp5;
                        }


                        $temp['submission_dates'] = array();
                        if (!empty($allSubmissions)) {
                            foreach ($allSubmissions as $allrows) {
                                $dt = array();
                                $temp2['question_id'] = $allrows->question_id;
                                $temp2['question'] = $allrows->question;
                                $temp2['title'] = $allrows->title;
                                $temp3['submission_date'] = $allrows->submission_date;
                                $temp3['option_id'] = $allrows->select_option_id;
                                $temp3['point'] = $allrows->point;
                                $temp3['month'] = date('M', strtotime($allrows->submission_date));
                                $temp3['day'] = date('D', strtotime($allrows->submission_date));
                                $temp2['dates'][] = $temp3;
                                $dt['date'] = $allrows->submission_date;
                                $dt['month'] = date('M', strtotime($allrows->submission_date));
                                $dt['day'] = date('D', strtotime($allrows->submission_date));
                                $temp['submission_dates'][] = $dt;
                            }
                            $temp['questions'][] = $temp2;
                        }
                    }
                    $response_hierarchy[] = $temp;
                }
                $return['status'] = 1;
                $return['message'] = "User Submission Record found successfully";
                $return['response'] = $response_hierarchy;
            } else {
                $return['status'] = 0;
                $return['message'] = "User Submission Record not found";
            }
        }
        $this->response($return);
    }

    function user_assessment_hierarchy_post() {
        $data = $this->input->post();
        $return['code'] = 200;
        $return['response'] = array();
        $this->form_validation->set_rules('login_session_key', 'Login session key', 'trim|required|callback__validate_login_session_key');
        $this->form_validation->set_rules('users', 'users', 'trim|required');
        $this->form_validation->set_rules('organization_id', 'Organization Id', 'trim|required');
        $this->form_validation->set_rules('month', 'Month', 'trim|required|numeric');
        if ($this->form_validation->run() == FALSE) {
            $error = $this->form_validation->rest_first_error_string();
            $return['status'] = 0;
            $return['message'] = $error;
        } else {
            $users = extract_value($data, 'users', '');
            $organization_id = extract_value($data, 'organization_id', '');
            $month = extract_value($data, 'month', '');
            $users = json_decode($users);
            $response_hierarchy = array();
            $temp = array();
            $temp['submission_dates'] = array();
            if (!empty($users)) {
                $selfUser[] = end($users);
                $user_id = $selfUser[0]->user_id;
                $role_id = $selfUser[0]->role_id;
                $allUsers = array();
                $sql = "SELECT `UA`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA`.`start_date`, `UA`.`end_date`, `UA`.`bullets`, `UA`.`bullets_in_month_date`, `UA`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 360";
                $user_assessment = $this->common_model->customQuery($sql);
                $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                    'select' => 'user_hierarchy.user_id,ugroup.group_id as role_id',
                    'join' => array(USER_GROUPS . ' as ugroup' => 'ugroup.user_id=user_hierarchy.user_id',
                        GROUPS . ' as group' => 'group.id=ugroup.group_id'),
                    'where' => array('user_hierarchy.child_user_id' => $user_id,
                        'user_hierarchy.organization_id' => $organization_id, 'group.id' => 4));

                $upperUsers = $this->common_model->customGet($option);
                if (!empty($upperUsers)) {
                    $option = array('table' => USER_HIERARCHY . ' as user_hierarchy',
                        'select' => 'user_hierarchy.user_id,ugroup.group_id as role_id',
                        'join' => array(USER_GROUPS . ' as ugroup' => 'ugroup.user_id=user_hierarchy.user_id',
                            GROUPS . ' as group' => 'group.id=ugroup.group_id'),
                        'where' => array('user_hierarchy.child_user_id' => $upperUsers[0]->user_id,
                            'user_hierarchy.organization_id' => $organization_id, 'group.id' => 3));

                    $topUpperUsers = $this->common_model->customGet($option);
                    $selfUser = array_merge($topUpperUsers, $upperUsers, $selfUser);
                }

                $keys = array_keys($selfUser);
                $lastKey = $keys[count($keys) - 1];
                $userAssessmentID="";
                foreach ($selfUser as $user) {
                    $temp['user_id'] = $user->user_id;
                    $temp['role'] = getRole($user->user_id);
                    $temp['role_id'] = $user->role_id;
                    if ($selfUser[$lastKey]->user_id != $user->user_id) {
                        $sql = "SELECT `UA1`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA1`.`start_date`, `UA1`.`end_date`, `UA1`.`bullets`, `UA1`.`bullets_in_month_date`, `UA1`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA1`.`id`
                        WHERE `UA`.`user_id` = " . $selfUser[$lastKey]->user_id . "
                        AND `UA1`.`user_id` = " . $user->user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 360 AND MONTH(`UA1`.`start_date`) <= $month AND MONTH(`UA1`.`end_date`) >= $month";
                    } else {
                        $sql = "SELECT `UA`.`id` as `user_assessment_id`, `UAQ`.`question_id`, `UA`.`start_date`, `UA`.`end_date`, `UA`.`bullets`, `UA`.`bullets_in_month_date`, `UA`.`bullets_submission`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment_question` as `UAQ` ON `UAQ`.`user_assessment_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user->user_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 360 AND MONTH(`UA`.`start_date`) <= $month AND MONTH(`UA`.`end_date`) >= $month";
                    }
                    $user_assessment = $this->common_model->customQuery($sql);
                    $temp['questions'] = array();
                    foreach ($user_assessment as $rows) {
                        $userAssessmentID = $rows->user_assessment_id;
                        $option = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as DAS',
                            'select' => 'DAS.submission_date,QA.question,QA.title,DAS.question_id,DAS.select_option_id,QO.point',
                            'join' => array(QUESTIONS . ' as QA' => 'QA.id=DAS.question_id',
                                QUESTIONS_OPTION . ' as QO' => 'QO.id=DAS.select_option_id'),
                            'where' => array('DAS.user_assessment_id' => $rows->user_assessment_id,
                                'MONTH(DAS.submission_date)' => $month,
                                'DAS.question_id' => $rows->question_id),
                            'order' => array('DAS.submission_date' => 'ASC'));
                        $allSubmissions = $this->common_model->customGet($option);
                        $temp2['dates'] = array();
                        $temp2 = array();
                        $temp21['dates'] = array();
                        $temp21 = array();
                        $temp['start_date'] = $rows->start_date;
                        $temp['end_date'] = $rows->end_date;
                        $temp['assign_date'] = array();

                        if (!empty($rows->bullets_in_month_date)) {
                            $assignDates = explode(',', $rows->bullets_in_month_date);
                            foreach ($assignDates as $assdates) {
                                $option = array('table' => DAILY_ASSESSMENT_SUBMISSION . ' as UA',
                                    'select' => 'UA.id',
                                );
                                $option['where']['UA.submission_date'] = date('Y-m-d', strtotime($assdates));
                                $option['where']['UA.user_assessment_id'] = $rows->user_assessment_id;
                                $is_done = $this->common_model->customGet($option);
                                $tmp5['date'] = date('Y-m-d', strtotime($assdates));
                                $tmp5['is_complete'] = (!empty($is_done)) ? 1 : 0;
                                $temp['assign_date'][] = $tmp5;
                            }
                        }


                        $temp['submission_dates'] = array();
                        if (!empty($allSubmissions)) {
                            foreach ($allSubmissions as $allrows) {
                                $dt = array();
                                $temp2['question_id'] = $allrows->question_id;
                                $temp2['question'] = $allrows->question;
                                $temp2['title'] = $allrows->title;
                                $temp3['submission_date'] = $allrows->submission_date;
                                $temp3['option_id'] = $allrows->select_option_id;
                                $temp3['point'] = (float)$allrows->point;
                                $temp3['month'] = date('M', strtotime($allrows->submission_date));
                                $temp3['day'] = date('D', strtotime($allrows->submission_date));
                                $temp2['dates'][] = $temp3;
                                $dt['date'] = $allrows->submission_date;
                                $dt['month'] = date('M', strtotime($allrows->submission_date));
                                $dt['day'] = date('D', strtotime($allrows->submission_date));
                                $temp['submission_dates'][] = $dt;
                            }
                            $temp['questions'][] = $temp2;
                        }
                    }
                    if (empty($temp['questions'])) {
                        $option = array('table' => USER_ASSESSMENT_QUESTION . ' as UAQ',
                            'select' => 'QA.question,QA.title,UAQ.question_id,',
                            'join' => array(QUESTIONS . ' as QA' => 'QA.id=UAQ.question_id'),
                            'where' => array('UAQ.user_assessment_id' => $userAssessmentID),
                        );
                        $allSubmissionss = $this->common_model->customGet($option);
                        if (!empty($allSubmissionss)) {
                            foreach ($allSubmissionss as $allrowss) {
                                $dt = array();
                                $temp21['question_id'] = $allrowss->question_id;
                                $temp21['question'] = $allrowss->question;
                                $temp21['title'] = $allrowss->title;
                                $temp3['submission_date'] = "";
                                $temp3['option_id'] = "";
                                $temp3['point'] = 0;
                                $temp3['month'] = "";
                                $temp3['day'] = "";
                                $temp21['dates'] = array();
                                $dt['date'] = "";
                                $dt['month'] = "";
                                $dt['day'] = "";
                                $temp['submission_dates'] = array();
                                $temp['questions'][] = $temp21;
                            }
                            
                        }
                    }
                    $response_hierarchy[] = $temp;
                }
                $return['status'] = 1;
                $return['message'] = "User Submission Record found successfully";
                $return['response'] = $response_hierarchy;
            } else {
                $return['status'] = 0;
                $return['message'] = "User Submission Record not found";
            }
        }
        $this->response($return);
    }

}

/* End of file Assessment.php */
/* Location: ./application/controllers/api/v1/Assessment.php */
?>