<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/third_party/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

class Charts extends Common_Controller {

    public $data = "";

    function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth'));
        $this->load->helper(array('language'));
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
    }

    public function tracking_180() {
        $this->data['parent'] = "180_tracking";
        $this->data['title'] = "Dashboard Chart";
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->admin_render('180_tracking', $this->data, 'inner_script');
    }

    public function getMangerUser() {
        $organization_id = $this->input->post('organization_id');
        $assessment_type = $this->input->post('assessment_type');
        $option = array('table' => 'users_groups as ugroup',
            'select' => "user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name",
            'join' => array('users as user' => 'user.id=ugroup.user_id',
                'groups as gp' => 'gp.id=ugroup.group_id',
                'user_assessment as UA' => 'UA.user_id=user.id'),
            'where' => array('ugroup.organization_id' => $organization_id, 'ugroup.group_id' => 3, 'UA.assessment_type' => $assessment_type),
            'group_by' => 'user.id'
        );
        $managerUser = $this->common_model->customGet($option);
        $htm = "<option value=''>Select User</option>";
        if (!empty($managerUser)) {
            foreach ($managerUser as $user) {
                $htm .= "<option value='$user->id'>$user->name</option>";
            }
        }
        echo $htm;
    }

    public function getLeaderUser() {
        $organization_id = $this->input->post('organization_id');
        $assessment_type = $this->input->post('assessment_type');
        $manager_id = $this->input->post('manager_id');
        $option = array('table' => 'users_groups as ugroup',
            'select' => "user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name",
            'join' => array('users as user' => 'user.id=ugroup.user_id',
                'groups as gp' => 'gp.id=ugroup.group_id',
                'user_assessment as UA' => 'UA.user_id=user.id'),
            'where' => array('ugroup.organization_id' => $organization_id, 'ugroup.group_id' => 4, 'UA.assessment_type' => $assessment_type),
            'group_by' => 'user.id'
        );
        if (!empty($manager_id)) {
            $option['join']['user_hierarchy as UHA'] = "UHA.child_user_id=user.id";
            $option['where']['UHA.user_id'] = $manager_id;
        }
        $Users = $this->common_model->customGet($option);
        $htm = "<option value=''>Select User</option>";
        if (!empty($Users)) {
            foreach ($Users as $user) {
                $htm .= "<option value='$user->id'>$user->name</option>";
            }
        }
        echo $htm;
    }

    public function getSalesRepUser() {
        $organization_id = $this->input->post('organization_id');
        $assessment_type = $this->input->post('assessment_type');
        $leader_id = $this->input->post('leader_id');
        $option = array('table' => 'users_groups as ugroup',
            'select' => "user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name",
            'join' => array('users as user' => 'user.id=ugroup.user_id',
                'groups as gp' => 'gp.id=ugroup.group_id',
                'user_assessment as UA' => 'UA.user_id=user.id'),
            'where' => array('ugroup.organization_id' => $organization_id, 'ugroup.group_id' => 5, 'UA.assessment_type' => $assessment_type),
            'group_by' => 'user.id'
        );
        if (!empty($leader_id)) {
            $option['join']['user_hierarchy as UHA'] = "UHA.child_user_id=user.id";
            $option['where']['UHA.user_id'] = $leader_id;
        }
        if (!empty($assessment_type)) {
            $option['where']['UA.assessment_type'] = $assessment_type;
        }
        $Users = $this->common_model->customGet($option);
        $htm = "<option value=''>Select User</option>";
        if (!empty($Users)) {
            foreach ($Users as $user) {
                $htm .= "<option value='$user->id'>$user->name</option>";
            }
        }
        echo $htm;
    }

    public function generateReportDashboard() {
        $allUsers = array();
        $allUsersSelf = array();
        $organization_id = $this->input->post('organization_id');
        $manager_id = $this->input->post('manager_id');
        $leader_id = $this->input->post('leader_id');
        $self_id = $this->input->post('self_id');
        $where = "";
        $whereLeader = "";
        if (!empty($manager_id)) {
            $where = "AND UH.user_id = $manager_id";
        }
        if (!empty($leader_id)) {
            $whereLeader = "AND UH.child_user_id = $leader_id";

            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leader_id GROUP BY user.id"
                    . "";
            $leaderMangerUser = $this->common_model->customQuery($sql);
            if (!empty($leaderMangerUser)) {
                $id = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $id";
            }
        }
        $whereSelf = "";
        if (!empty($self_id)) {
            $whereSelf = "AND UH.child_user_id = $self_id";
            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 4 AND UH.child_user_id = $self_id GROUP BY user.id"
                    . "";
            $leaderUSerRole = $this->common_model->customQuery($sql);
            if (!empty($leaderUSerRole)) {
                $leaderId = $leaderUSerRole[0]->id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leaderId GROUP BY user.id"
                        . "";
                $leaderMangerUser = $this->common_model->customQuery($sql);
                if (!empty($leaderMangerUser)) {
                    $id = $leaderMangerUser[0]->id;
                    $where = "AND UH.user_id = $id";
                }
                $managerId = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $managerId";
            }
        }
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                // . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 $where GROUP BY user.id"
                . "";
        $managerUsers = $this->common_model->customQuery($sql);
        if (!empty($managerUsers)) {
            foreach ($managerUsers as $user) {
                $temp['id'] = $user->id;
                $temp['name'] = $user->name;
                $temp['role_id'] = $user->role_id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                        . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND gr.id = 4 AND UH.user_id = $user->id $whereLeader GROUP BY user.id"
                        . "";
                $leaderUsers = $this->common_model->customQuery($sql);
                $temp['leader'] = array();
                if (!empty($leaderUsers)) {
                    foreach ($leaderUsers as $rows) {
                        $temp2['id'] = $rows->id;
                        $temp2['name'] = $rows->name;
                        $temp2['role_id'] = $rows->role_id;
                        $temp2['sales'] = array();
                        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                                . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                                . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND gr.id = 5 AND UH.user_id = $rows->id $whereSelf GROUP BY user.id"
                                . "";
                        $salesUsers = $this->common_model->customQuery($sql);
                        if (!empty($salesUsers)) {
                            foreach ($salesUsers as $sales) {
                                $temp3['id'] = $sales->id;
                                $temp3['name'] = $sales->name;
                                $temp3['role_id'] = $sales->role_id;
                                $temp2['sales'][] = $temp3;
                            }
                        }
                        $temp['leader'][] = $temp2;
                    }
                }
                $allUsers[] = $temp;
            }
        }
        $this->data['allUsers'] = $allUsers;
        $this->data['allUsersSelf'] = $allUsersSelf;
        $this->data['organization_id'] = $organization_id;
        $this->load->view('180_tracking_table', $this->data);
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

    public function exportInExcel($exportData, $organization_id) {
        $this->load->library('PHPExcel');
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);

        if (!empty($exportData)) {
            $exportData = decoding($exportData);
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getProperties()->setCreator("Santanna")
                    ->setLastModifiedBy("Maarten Balliauw")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");

            $styleArray = array(
                'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => '000000'),
                    'size' => 10,
                    'name' => 'Verdana'
            ));
            $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
            $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(22);
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('0088C7');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Company Name:-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $organization->name);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Assessment Type:-');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', '180-Assessment');

            $rowId = 0;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A2", 'Sales Rep')
                    ->setCellValue("B2", 'Self');
            $allCountsUser = array();
            if (is_array($exportData)) {
                foreach ($exportData as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            $allCountsUser[] = $leader['id'];
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . '2', $leader['name']);
                            $objPHPExcel->getActiveSheet()->getColumnDimension(alphaRows($rowId))->setWidth(25);
                            $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . '2')->applyFromArray($styleArray);
                            $rowId++;
                        }
                    }

                    $allCountsUser[] = $user['id'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . '2', $user['name']);
                    $objPHPExcel->getActiveSheet()->getColumnDimension(alphaRows($rowId))->setWidth(25);
                    $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . '2')->applyFromArray($styleArray);
                    $rowId++;
                }
            }

            $x = 4;

            if (!empty($exportData)) {
                foreach ($exportData as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            if (!empty($leader['sales'])) {
                                foreach ($leader['sales'] as $sales) {
                                    $txtStr = is_assessment_current_export($organization_id, $sales['id']);
                                    $objPHPExcel->setActiveSheetIndex(0)
                                            ->setCellValue("A$x", $sales['name'])
                                            ->setCellValue("B$x", $txtStr);
                                    $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('5484C6');
                                    if ($txtStr == "Completed") {
                                        $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('58B47E');
                                    }
                                    if ($txtStr == "Not Completed") {
                                        $objPHPExcel->getActiveSheet()->getStyle("B$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('FF1F1F');
                                    }
                                    $rowId = 0;
                                    foreach ($allCountsUser as $countUser) {
                                        if ($leader['id'] == $countUser) {
                                            $txt = is_assessment_submission_export($organization_id, $sales['id'], $leader['id']);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . "$x", $txt);
                                            if ($txt == "Completed") {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('58B47E');
                                            }
                                            if ($txt == "Not Completed") {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('FF1F1F');
                                            }
                                        }
                                        if ($user['id'] == $countUser) {
                                            $txt = is_assessment_submission_export($organization_id, $sales['id'], $user['id']);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . "$x", $txt);
                                            if ($txt == "Completed") {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('58B47E');
                                            }
                                            if ($txt == "Not Completed") {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('FF1F1F');
                                            }
                                        }
                                        $rowId++;
                                    }
                                    $x++;
                                }
                            }
                        }
                    }
                }
            }
            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle('180-Assessment Reports');
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="180-assessment-tracking-reports.xls"');
            header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');
// If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
        }
    }

    public function exportInPdf($exportData, $organization_id) {

        $dompdf = new Dompdf();

        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);
        //$logo = $_SERVER["DOCUMENT_ROOT"] . '/self_assessment/' . getConfig('site_logo');
        $logo = $_SERVER["DOCUMENT_ROOT"] . '/' . getConfig('site_logo');
        $table = "";
        if (!empty($exportData)) {
            $allUsers = decoding($exportData);
            if (is_array($allUsers)) {

                $table .= '<table>
                            <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>Self</th>';
                if (!empty($allUsers)) {
                    $allCountsUser = array();
                    foreach ($allUsers as $user) {
                        if (!empty($user['leader'])) {
                            foreach ($user['leader'] as $leader) {
                                $allCountsUser[] = $leader['id'];
                                $table .= '<th>' . $leader['name'] . '</th>';
                            }
                        }
                        $allCountsUser[] = $user['id'];
                        $table .= '<th>' . $user['name'] . '</th>';
                    }
                    $table .= '</tr></thead><tbody>';

                    foreach ($allUsers as $user) {
                        if (!empty($user['leader'])) {
                            foreach ($user['leader'] as $leader) {
                                if (!empty($leader['sales'])) {
                                    foreach ($leader['sales'] as $sales) {
                                        $table .= '<tr>';
                                        $table .= '<td>' . $sales['name'] . '</td>';
                                        $table .= '<td>' . is_assessment_current($organization_id, $sales['id']) . '</td>';
                                        foreach ($allCountsUser as $countUser) {
                                            $flag = true;
                                            $txt = "";
                                            if ($leader['id'] == $countUser) {
                                                $txt = is_assessment_submission($organization_id, $sales['id'], $leader['id']);
                                                $flag = false;
                                            }
                                            if ($user['id'] == $countUser) {
                                                $txt = is_assessment_submission($organization_id, $sales['id'], $user['id']);
                                                $flag = false;
                                            }
                                            $classColor = "";
                                            if ($flag) {
                                                $classColor = "empty-td";
                                            }
                                            $table .= '<td class="' . $classColor . '">' . $txt . '</td>';
                                        }
                                        $table .= '</tr>';
                                    }
                                }
                            }
                        }
                    }


                    $table .= '</tbody></table>';
                }
            }
        }

        $html = '
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <style>
    .table { display: table; width: 100%; border-collapse: collapse; }
    .table-row { display: table-row; }
    .table-cell { display: table-cell; border: 1px solid black; padding: 1em; }
    .table-cell img {width:100px;}
    .empty-td { background-color: rgba(213, 213, 213, 0.7);}
    table {
    border-collapse: collapse;width: 100%;
}

table, th, td {
    border: 1px solid black;
}
  </style>
</head>
<body>
  <div class="table">
    <div class="table-row">
      <div class="table-cell"><img src=' . $logo . ' /></div>
      <div class="table-cell"><b>Company: </b> ' . $organization->name . '</div>
    </div>
    <div class="table-row">
      <div class="table-cell" colspan="2"> <b>Assessment Type:</b>180 Assessment</div>
    </div>
    <div class="table-row">
      <div class="table-cell" colspan="2">
      ' . $table . '
     </div>
    </div>
  </div>
</body>
</html>
';
        $dompdf->load_html($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('180-assessment');
    }

    public function reports_180() {
        $this->data['parent'] = "180_reports";
        $this->data['title'] = "Dashboard Chart";
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->admin_render('180-reports', $this->data, 'inner_script');
    }

    public function exportsReport180Assessment() {
        $allUsers = array();
        $allUsersSelf = array();
        $organization_id = $this->input->post('organization_id');
        $manager_id = $this->input->post('manager_user');
        $leader_id = $this->input->post('leader_user');
        $self_id = $this->input->post('sales_rep_user');
        $levels = $this->input->post('levels');
        $where = "";
        $whereLeader = "";
        $salesRepData = array();
        if (!empty($manager_id)) {
            $where = "AND UH.user_id = $manager_id";
        }
        if (!empty($leader_id)) {
            $whereLeader = "AND UH.child_user_id = $leader_id";

            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leader_id GROUP BY user.id"
                    . "";
            $leaderMangerUser = $this->common_model->customQuery($sql);
            if (!empty($leaderMangerUser)) {
                $id = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $id";
            }
        }
        $whereSelf = "";
        if (!empty($self_id)) {
            $whereSelf = "AND UH.child_user_id = $self_id";
            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 4 AND UH.child_user_id = $self_id GROUP BY user.id"
                    . "";
            $leaderUSerRole = $this->common_model->customQuery($sql);
            if (!empty($leaderUSerRole)) {
                $leaderId = $leaderUSerRole[0]->id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leaderId GROUP BY user.id"
                        . "";
                $leaderMangerUser = $this->common_model->customQuery($sql);
                if (!empty($leaderMangerUser)) {
                    $id = $leaderMangerUser[0]->id;
                    $where = "AND UH.user_id = $id";
                }
                $managerId = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $managerId";
            }
        }
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                // . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 $where GROUP BY user.id"
                . "";
        $managerUsers = $this->common_model->customQuery($sql);
        if (!empty($managerUsers)) {
            foreach ($managerUsers as $user) {
                $temp['id'] = $user->id;
                $temp['name'] = $user->name;
                $temp['role_id'] = $user->role_id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                        . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND gr.id = 4 AND UH.user_id = $user->id $whereLeader GROUP BY user.id"
                        . "";
                $leaderUsers = $this->common_model->customQuery($sql);
                $temp['leader'] = array();
                if (!empty($leaderUsers)) {
                    foreach ($leaderUsers as $rows) {
                        $temp2['id'] = $rows->id;
                        $temp2['name'] = $rows->name;
                        $temp2['role_id'] = $rows->role_id;
                        $temp2['sales'] = array();
                        $sql = "SELECT UA.id as user_assessment_id,user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                                . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                                . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND UA.assessment_status = 1 AND gr.id = 5 AND UH.user_id = $rows->id $whereSelf GROUP BY user.id"
                                . "";
                        $salesUsers = $this->common_model->customQuery($sql);
                        if (!empty($salesUsers)) {
                            foreach ($salesUsers as $sales) {
                                $temp3['id'] = $sales->id;
                                $temp3['name'] = $sales->name;
                                $temp3['role_id'] = $sales->role_id;
                                $temp3['user_assessment_id'] = $sales->user_assessment_id;

                                $sql = "SELECT id,assessment_status FROM user_assessment WHERE child_upper_id = $sales->user_assessment_id";
                                $is_complete_assessment = $this->common_model->customQuery($sql);
                                $flag = true;
                                if (!empty($is_complete_assessment)) {
                                    foreach ($is_complete_assessment as $value) {
                                        if ($value->assessment_status != 1) {
                                            $flag = false;
                                        }
                                    }
                                }
                                if ($flag) {
                                    $temp2['sales'][] = $temp3;
                                    $salesRepData[] = $temp3;
                                }
                            }
                        }
                        $temp['leader'][] = $temp2;
                    }
                }
                $allUsers[] = $temp;
            }
        }
        $allUsersImport = $allUsers;
        foreach ($allUsers as $index => $rows) {
            if (!empty($rows['leader'])) {
                foreach ($rows['leader'] as $key => $leader) {
                    if (empty($leader['sales'])) {
                        unset($allUsersImport[$index]['leader'][$key]);
                    }
                }
            }
        }
        $allUsers = $allUsersImport;
        foreach ($allUsersImport as $index => $rows) {
            if (empty($rows['leader'])) {
                unset($allUsers[$index]);
            }
        }
        if (!empty($allUsers)) {
            $this->exportReportsInPdf($allUsers, $organization_id, $levels, $salesRepData);
        } else {
            $this->session->set_flashdata('error', 'Records not available for this selection');
            redirect('charts/reports_180');
        }
    }

    public function exportReportsInPdf($exportData, $organization_id, $levels, $salesRepData) {
        $this->load->helper(array('file'));
        $dompdf = new Dompdf();
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);
        //$logo = $_SERVER["DOCUMENT_ROOT"] . '/self_assessment/' . getConfig('site_logo');
        $logo = $_SERVER["DOCUMENT_ROOT"] . '/' . getConfig('site_logo');
        $table = "";
        $title = "";
        if (!empty($exportData)) {
            if ($levels == 'self') {
                $table = $this->generateSelf($exportData, $organization_id);
                $title = "Self by category";
            } else if ($levels == 'self_leader') {
                $table = $this->generateSelfLeader($exportData, $organization_id);
                $title = "Self vs Leader by category";
            } else if ($levels == 'self_leader_manager') {
                $table = $this->generateSelfLeaderManager($exportData, $organization_id);
                $title = "Self vs Leader vs Manager by category";
            }
        }

        $dataResult['table'] = $table;
        $dataResult['logo'] = $logo;
        $dataResult['organization'] = $organization->name;
        $dataResult['title'] = $title;
        $dataResult['salesRepData'] = $salesRepData;
        $dataResult['isView'] = $levels;
        ob_start();
        $html = $this->load->view('180-assessment-reports-graph', $dataResult);
        $dompdf->load_html(ob_get_clean());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('180-assessment');
    }

    public function generateSelfLeaderManager($allUsers, $organization_id) {
        $table = "";
        if (is_array($allUsers)) {

            $table .= '<table>
                            <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>Self</th>';
            if (!empty($allUsers)) {
                $allCountsUser = array();
                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            $allCountsUser[] = $leader['id'];
                            $table .= '<th>' . $leader['name'] . '</th>';
                        }
                    }
                    $allCountsUser[] = $user['id'];
                    $table .= '<th>' . $user['name'] . '</th>';
                }
                $table .= '</tr></thead><tbody>';

                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            if (!empty($leader['sales'])) {
                                foreach ($leader['sales'] as $sales) {
                                    $table .= '<tr>';
                                    $table .= '<td>' . $sales['name'] . '</td>';
                                    $table .= '<td>' . is_assessment_current($organization_id, $sales['id']) . '</td>';
                                    foreach ($allCountsUser as $countUser) {
                                        $flag = true;
                                        $txt = "";
                                        if ($leader['id'] == $countUser) {
                                            $txt = is_assessment_submission($organization_id, $sales['id'], $leader['id']);
                                            $flag = false;
                                        }
                                        if ($user['id'] == $countUser) {
                                            $txt = is_assessment_submission($organization_id, $sales['id'], $user['id']);
                                            $flag = false;
                                        }
                                        $classColor = "";
                                        if ($flag) {
                                            $classColor = "empty-td";
                                        }
                                        $table .= '<td class="' . $classColor . '">' . $txt . '</td>';
                                    }
                                    $table .= '</tr>';
                                }
                            }
                        }
                    }
                }


                $table .= '</tbody></table>';
            }
        }
        return $table;
    }

    public function generateSelfLeader($allUsers, $organization_id) {
        $table = "";
        if (is_array($allUsers)) {

            $table .= '<table>
                            <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>Self</th>';
            if (!empty($allUsers)) {
                $allCountsUser = array();
                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            $allCountsUser[] = $leader['id'];
                            $table .= '<th>' . $leader['name'] . '</th>';
                        }
                    }
                    // $allCountsUser[] = $user['id'];
                    // $table .= '<th>' . $user['name'] . '</th>';
                }
                $table .= '</tr></thead><tbody>';

                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            if (!empty($leader['sales'])) {
                                foreach ($leader['sales'] as $sales) {
                                    $table .= '<tr>';
                                    $table .= '<td>' . $sales['name'] . '</td>';
                                    $table .= '<td>' . is_assessment_current($organization_id, $sales['id']) . '</td>';
                                    foreach ($allCountsUser as $countUser) {
                                        $flag = true;
                                        $txt = "";
                                        if ($leader['id'] == $countUser) {
                                            $txt = is_assessment_submission($organization_id, $sales['id'], $leader['id']);
                                            $flag = false;
                                        }
                                        // if ($user['id'] == $countUser) {
                                        //    $txt = is_assessment_submission($organization_id, $sales['id'], $user['id']);
                                        //    $flag = false;
                                        // }
                                        $classColor = "";
                                        if ($flag) {
                                            $classColor = "empty-td";
                                        }
                                        $table .= '<td class="' . $classColor . '">' . $txt . '</td>';
                                    }
                                    $table .= '</tr>';
                                }
                            }
                        }
                    }
                }


                $table .= '</tbody></table>';
            }
        }
        return $table;
    }

    public function generateSelf($allUsers, $organization_id) {
        $table = "";
        if (is_array($allUsers)) {

            $table .= '<table>
                            <thead>
                                <tr>
                                    <th>Sales Rep</th>
                                    <th>Self</th>';
            if (!empty($allUsers)) {
                $allCountsUser = array();
                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            // $allCountsUser[] = $leader['id'];
                            // $table .= '<th>' . $leader['name'] . '</th>';
                        }
                    }
                    // $allCountsUser[] = $user['id'];
                    // $table .= '<th>' . $user['name'] . '</th>';
                }
                $table .= '</tr></thead><tbody>';

                foreach ($allUsers as $user) {
                    if (!empty($user['leader'])) {
                        foreach ($user['leader'] as $leader) {
                            if (!empty($leader['sales'])) {
                                foreach ($leader['sales'] as $sales) {
                                    $table .= '<tr>';
                                    $table .= '<td>' . $sales['name'] . '</td>';
                                    $table .= '<td>' . is_assessment_current($organization_id, $sales['id']) . '</td>';
                                    foreach ($allCountsUser as $countUser) {
                                        $flag = true;
                                        $txt = "";
                                        //if ($leader['id'] == $countUser) {
                                        //     $txt = is_assessment_submission($organization_id, $sales['id'], $leader['id']);
                                        //     $flag = false;
                                        // }
                                        // if ($user['id'] == $countUser) {
                                        //    $txt = is_assessment_submission($organization_id, $sales['id'], $user['id']);
                                        //    $flag = false;
                                        //}
                                        $classColor = "";
                                        if ($flag) {
                                            $classColor = "empty-td";
                                        }
                                        $table .= '<td class="' . $classColor . '">' . $txt . '</td>';
                                    }
                                    $table .= '</tr>';
                                }
                            }
                        }
                    }
                }


                $table .= '</tbody></table>';
            }
        }
        return $table;
    }

    public function category180Report($userId = "", $user_assessment_id = "", $roleId = "") {
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

                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=3 AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageByManager[$ass_cat->cat_id] = $this->common_model->customQuery($sql);

                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=4 AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageByLeader[$ass_cat->cat_id] = $this->common_model->customQuery($sql);
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

            $managerAvg = array();
            foreach ($categoryAverageByManager as $row) {
                $managerAvg[] = $row->avg_point;
            }

            if (count($chartLabel) == 2) {
                $chartLabel[] = "";
                $selfAvg[] = null;
                $leaderAvg[] = null;
                $managerAvg[] = null;
            } elseif (count($chartLabel) == 1) {
                $chartLabel[] = "";
                $chartLabel[] = "";
                $selfAvg[] = null;
                $selfAvg[] = null;
                $leaderAvg[] = null;
                $leaderAvg[] = null;
                $managerAvg[] = null;
            }


            if (empty($roleId)) {
                $this->data['category'] = $assessmentQuestionCategory;
                $this->data['self'] = $categoryAverageBySelf;
                $this->data['leader'] = $categoryAverageByLeader;
                $this->data['userId'] = $userId;
                if (!empty($assessmentQuestionCategory)) {
                    $response = array('status' => 1, 'category' => $assessmentQuestionCategory, 'self' => $categoryAverageBySelf, 'leader' => $categoryAverageByLeader, 'userId' => $userId);
                } else {
                    return false;
                }
                return $response;
            } else {
                if (!empty($assessmentQuestionCategory)) {
                    $response = array('status' => 1, 'label' => $chartLabel, 'self' => $selfAvg, 'leader' => $leaderAvg);
                } else {
                    return false;
                }
                return $response;
            }
        } else {
            return false;
        }
    }

    public function daily_tracking() {
        $this->data['parent'] = "daily_tracking";
        $this->data['title'] = "Dashboard Chart";
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name'
        );
        $this->data['organization'] = $this->common_model->customGet($option);
        $this->load->admin_render('daily_tracking', $this->data, 'inner_script');
    }

    public function dailyTrackingDashboard() {
        $allUsers = array();
        $allUsersSelf = array();
        $organization_id = $this->input->post('organization_id');
        $manager_id = $this->input->post('manager_id');
        $leader_id = $this->input->post('leader_id');
        $self_id = $this->input->post('self_id');
        $datesfrom = $this->input->post('datesfrom');
        $datesto = $this->input->post('datesto');
        $levels = $this->input->post('levels');
        $whereSales = "";
        $whereLeader = "";
        $whereManager = "";
        if (empty($datesfrom)) {
            echo 1;
            exit;
        } else if (empty($datesto)) {
            echo 1;
            exit;
        }
        if (!empty($datesfrom) && !empty($datesto)) {
            if (strtotime($datesfrom) > strtotime($datesto)) {
                echo 2;
                exit;
            }
        }
        if (!empty($self_id)) {
            $whereSales = " AND user.id = $self_id";
        }
        if (!empty($leader_id)) {
            $whereLeader = " AND user.id = $leader_id";
        }
        if (!empty($manager_id)) {
            $whereManager = " AND user.id = $manager_id";
        }
        $sql = "SELECT UA.bullets_in_month_date,UA.start_date,UA.end_date,UA.id as assessment_id,user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 360 AND gr.id = 5 $whereSales GROUP BY user.id"
                . "";
        $salesUsers = $this->common_model->customQuery($sql);
        if (!empty($salesUsers)) {
            foreach ($salesUsers as $sales) {
                $temp['id'] = $sales->id;
                $temp['name'] = $sales->name;
                $temp['organization_id'] = $sales->organization_id;
                $temp['role_id'] = $sales->role_id;
                $temp['assessment_id'] = $sales->assessment_id;
                $temp['start_date'] = $sales->start_date;
                $temp['end_date'] = $sales->end_date;
                $temp['bullets_in_month_date'] = explode(",", $sales->bullets_in_month_date);
                $temp['leader'] = array();
                $temp['manager'] = array();
                $sql = "SELECT UA.bullets_in_month_date,UA.id as assessment_id,user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                        . " WHERE UA.child_upper_id = $sales->assessment_id AND ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 360 AND gr.id = 4 $whereLeader GROUP BY user.id"
                        . "";
                $leaderUsers = $this->common_model->customQuery($sql, TRUE);
                $temp['leader'] = $leaderUsers;
                $usrId = "";
                if (!empty($leaderUsers)) {
                    $usrId = $leaderUsers->id;
                } else {
                    $usrId = $sales->id;
                }
                $sql = "SELECT UA.bullets_in_month_date,UA.id as assessment_id,user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                        . " WHERE UA.child_upper_id = $sales->assessment_id AND ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 360 AND gr.id = 3 $whereManager GROUP BY user.id"
                        . "";
                $managerUsers = $this->common_model->customQuery($sql, TRUE);
                $temp['manager'] = $managerUsers;
                if (!empty($leader_id)) {
                    if (empty($leaderUsers)) {
                        $temp = array();
                    }
                }
                if (!empty($manager_id)) {
                    if (empty($managerUsers)) {
                        $temp = array();
                    }
                }
                if ($levels == "self") {
                    unset($temp['leader']);
                    unset($temp['manager']);
                } else if ($levels == "self_leader") {
                    unset($temp['manager']);
                }
                $allUsers[] = $temp;
            }
        }
        $this->data['allUsers'] = $allUsers;
        //dump($allUsers);
        $this->data['fromDate'] = $datesfrom;
        $this->data['toDate'] = $datesto;
        $allDates = array();
        $begin = new DateTime($datesfrom);
        $end = new DateTime($datesto);
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);

        foreach ($daterange as $date) {
            $allDates[] = $date->format("Y-m-d");
        }
        $allDates[] = date('Y-m-d', strtotime($datesto));
        $this->data['allDates'] = $allDates;
        $this->data['organization_id'] = $organization_id;
        $this->load->view('daily_tracking_table', $this->data);
    }

    public function dailyTrackingExportInPdf($exportData, $allDates, $organization_id) {
        $dompdf = new Dompdf();

        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);
        //$logo = $_SERVER["DOCUMENT_ROOT"] . '/self_assessment/' . getConfig('site_logo');
        $logo = $_SERVER["DOCUMENT_ROOT"] . '/' . getConfig('site_logo');
        if (!empty($exportData) && !empty($allDates)) {
            $allUsers = decoding($exportData);
            $allDates = decoding($allDates);
            if (is_array($allUsers) && is_array($allDates)) {

                $dataResult['logo'] = $logo;
                $dataResult['organization'] = $organization->name;
                $dataResult['allUsers'] = $allUsers;
                $dataResult['allDates'] = $allDates;
                ob_start();
                $html = $this->load->view('daily-assessment-tracking-pdf-exports', $dataResult);
                $dompdf->load_html(ob_get_clean());
                $dompdf->setPaper(array(0, 0, 1012.00, 1008.00));
                $dompdf->render();
                $dompdf->stream('daily-assessment');
            }
        }
    }

    public function dailyTrackingExportInExcel($exportData, $allDates, $organization_id) {
        $this->load->library('PHPExcel');
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);
        if (!empty($exportData) && !empty($allDates)) {
            $allUsers = decoding($exportData);
            $allDates = decoding($allDates);
            if (is_array($allUsers) && is_array($allDates) && !empty($allUsers)) {
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->getProperties()->setCreator("Santanna")
                        ->setLastModifiedBy("Maarten Balliauw")
                        ->setTitle("Office 2007 XLSX Test Document")
                        ->setSubject("Office 2007 XLSX Test Document")
                        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                        ->setKeywords("office 2007 openxml php")
                        ->setCategory("Test result file");

                $styleArray = array(
                    'font' => array(
                        'bold' => true,
                        'color' => array('rgb' => '000000'),
                        'size' => 10,
                        'name' => 'Verdana'
                ));
                
                $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(22);
                $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(22);
                $objPHPExcel->getActiveSheet()->getStyle("A1")->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("C1")->applyFromArray($styleArray);
                $objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('0088C7');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', 'Company Name:-');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', $organization->name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', 'Assessment Type:-');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', 'Daily-Assessment');
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
                $rowId = 0;
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue("A2", 'Users Assessment');
                foreach ($allDates as $dates) {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . '2', date('d M', strtotime($dates)));
                    $objPHPExcel->getActiveSheet()->getColumnDimension(alphaRows($rowId))->setWidth(6);
                    $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . '2')->applyFromArray($styleArray);
                    $rowId++;
                }

                $x = 4;

                foreach ($allUsers as $users) {
                    if (isset($users['name']) && !empty($users['name'])) {
                        $leader = (isset($users['leader']) && !empty($users['leader'])) ? $users['leader'] : "";
                        $manager = (isset($users['manager']) && !empty($users['manager'])) ? $users['manager'] : "";
                        $bullets_in_month_date = $users['bullets_in_month_date'];
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $users['name']);
                        $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('5484C6');
                        if (!empty($allDates)) {
                            $rowId = 0;
                            foreach ($allDates as $dates) {
                                if (in_array(date('m/d/Y', strtotime($dates)), $bullets_in_month_date)) {
                                    $isDone = dailyTrackingCheckAssessmentBulletInExport($users['id'], $users['assessment_id'], $dates);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . "$x", $isDone);
                                    if ($isDone == 'C') {
                                        $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                    } else {
                                        $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                    }
                                } else {
                                    $isDone = dailyTrackingCheckAssessmentBulletOutExport($users['id'], $users['assessment_id'], $dates);
                                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowId) . "$x", $isDone);
                                    if ($isDone == 'C') {
                                        $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                    } else {
                                        $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowId) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                    }
                                }
                                $rowId++;
                            }
                        }
                        if (!empty($leader)) {
                            $x++;
                            $leader_bullets = $leader->bullets_in_month_date;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $leader->name . " - " . $users['name']);
                            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('F4418B');
                            if (!empty($allDates)) {
                                $rowIdLeader = 0;
                                foreach ($allDates as $dates) {
                                    if (!empty($leader_bullets)) {
                                        $leader_bullet = explode(",", $leader_bullets);
                                        if (in_array(date('m/d/Y', strtotime($dates)), $leader_bullet)) {
                                            $isDone = dailyTrackingCheckAssessmentBulletInExport($leader->id, $leader->assessment_id, $dates);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdLeader) . "$x", $isDone);
                                            if ($isDone == 'C') {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                            } else {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                            }
                                        } else {
                                            $isDone = dailyTrackingCheckAssessmentBulletOutExport($leader->id, $leader->assessment_id, $dates);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdLeader) . "$x", $isDone);

                                            if ($isDone == 'C') {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                            } else {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                            }
                                        }
                                    } else {
                                        $isDone = dailyTrackingCheckAssessmentBulletOutExport($leader->id, $leader->assessment_id, $dates);
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdLeader) . "$x", $isDone);

                                        if ($isDone == 'C') {
                                            $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                        } else {
                                            $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdLeader) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                        }
                                    }
                                    $rowIdLeader++;
                                }
                            }
                        }

                        if (!empty($manager)) {
                            $x++;
                            $manager_bullets = $manager->bullets_in_month_date;
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A$x", $manager->name . " - " . $users['name']);
                            $objPHPExcel->getActiveSheet()->getStyle("A$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                            if (!empty($allDates)) {
                                $rowIdmanager = 0;
                                foreach ($allDates as $dates) {

                                    if (!empty($manager_bullets)) {
                                        $manager_bullet = explode(",", $manager_bullets);
                                        if (in_array(date('m/d/Y', strtotime($dates)), $manager_bullet)) {
                                            $isDone = dailyTrackingCheckAssessmentBulletInExport($manager->id, $manager->assessment_id, $dates);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdmanager) . "$x", $isDone);
                                            if ($isDone == 'C') {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                            } else {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                            }
                                        } else {
                                            $isDone = dailyTrackingCheckAssessmentBulletOutExport($manager->id, $manager->assessment_id, $dates);
                                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdmanager) . "$x", $isDone);

                                            if ($isDone == 'C') {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                            } else {
                                                $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                            }
                                        }
                                    } else {
                                        $isDone = dailyTrackingCheckAssessmentBulletOutExport($manager->id, $manager->assessment_id, $dates);
                                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue(alphaRows($rowIdmanager) . "$x", $isDone);

                                        if ($isDone == 'C') {
                                            $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('2F9900');
                                        } else {
                                            $objPHPExcel->getActiveSheet()->getStyle(alphaRows($rowIdmanager) . "$x")->getFont()->setBold(true)->setName('Verdana')->setSize(10)->getColor()->setRGB('E90000');
                                        }
                                    }


                                    $rowIdmanager++;
                                }
                            }
                        }
                    }
                    $x++;
                }


                // Rename worksheet
                $objPHPExcel->getActiveSheet()->setTitle('Daily-Assessment Reports');
                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);
                // Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="daily-assessment-tracking-reports.xls"');
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');
                // If you're serving to IE over SSL, then the following may be needed
                header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
                header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header('Pragma: public'); // HTTP/1.0
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter->save('php://output');
            }else{
                $this->session->set_flashdata('error', 'Records not available for this selection');
                redirect('charts/daily_tracking');
            }
        }
    }
    
    
    public function exportsReport180AssessmentGraphView() {
        $allUsers = array();
        $allUsersSelf = array();
        $organization_id = $this->input->post('organization_id');
        $manager_id = $this->input->post('manager_user');
        $leader_id = $this->input->post('leader_user');
        $self_id = $this->input->post('sales_rep_user');
        $levels = $this->input->post('levels');
        $where = "";
        $whereLeader = "";
        $salesRepData = array();
        if (!empty($manager_id)) {
            $where = "AND UH.user_id = $manager_id";
        }
        if (!empty($leader_id)) {
            $whereLeader = "AND UH.child_user_id = $leader_id";

            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leader_id GROUP BY user.id"
                    . "";
            $leaderMangerUser = $this->common_model->customQuery($sql);
            if (!empty($leaderMangerUser)) {
                $id = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $id";
            }
        }
        $whereSelf = "";
        if (!empty($self_id)) {
            $whereSelf = "AND UH.child_user_id = $self_id";
            $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                    . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                    . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                    . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                    . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 4 AND UH.child_user_id = $self_id GROUP BY user.id"
                    . "";
            $leaderUSerRole = $this->common_model->customQuery($sql);
            if (!empty($leaderUSerRole)) {
                $leaderId = $leaderUSerRole[0]->id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 AND UH.child_user_id = $leaderId GROUP BY user.id"
                        . "";
                $leaderMangerUser = $this->common_model->customQuery($sql);
                if (!empty($leaderMangerUser)) {
                    $id = $leaderMangerUser[0]->id;
                    $where = "AND UH.user_id = $id";
                }
                $managerId = $leaderMangerUser[0]->id;
                $where = "AND UH.user_id = $managerId";
            }
        }
        $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                . " INNER JOIN user_hierarchy as UH ON (UH.user_id=user.id)"
                // . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                . " WHERE ug.organization_id  = '" . $organization_id . "' AND gr.id = 3 $where GROUP BY user.id"
                . "";
        $managerUsers = $this->common_model->customQuery($sql);
        if (!empty($managerUsers)) {
            foreach ($managerUsers as $user) {
                $temp['id'] = $user->id;
                $temp['name'] = $user->name;
                $temp['role_id'] = $user->role_id;
                $sql = "SELECT user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                        . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                        . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                        . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                        . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                        . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND gr.id = 4 AND UH.user_id = $user->id $whereLeader GROUP BY user.id"
                        . "";
                $leaderUsers = $this->common_model->customQuery($sql);
                $temp['leader'] = array();
                if (!empty($leaderUsers)) {
                    foreach ($leaderUsers as $rows) {
                        $temp2['id'] = $rows->id;
                        $temp2['name'] = $rows->name;
                        $temp2['role_id'] = $rows->role_id;
                        $temp2['sales'] = array();
                        $sql = "SELECT UA.id as user_assessment_id,user.`id` as id, CONCAT(user.`first_name`,' ',user.`last_name`,' (',name,')') as name, ug.organization_id, gr.id as role_id FROM "
                                . "`users` as user INNER JOIN users_groups as ug ON ug.user_id=user.id "
                                . " INNER JOIN groups as gr ON (gr.id=ug.group_id) "
                                . " INNER JOIN user_hierarchy as UH ON (UH.child_user_id=user.id)"
                                . " INNER JOIN user_assessment as UA ON (UA.user_id = user.id)"
                                . " WHERE ug.organization_id  = '" . $organization_id . "' AND UA.assessment_type = 180 AND UA.assessment_status = 1 AND gr.id = 5 AND UH.user_id = $rows->id $whereSelf GROUP BY user.id"
                                . "";
                        $salesUsers = $this->common_model->customQuery($sql);
                        if (!empty($salesUsers)) {
                            foreach ($salesUsers as $sales) {
                                $temp3['id'] = $sales->id;
                                $temp3['name'] = $sales->name;
                                $temp3['role_id'] = $sales->role_id;
                                $temp3['user_assessment_id'] = $sales->user_assessment_id;

                                $sql = "SELECT id,assessment_status FROM user_assessment WHERE child_upper_id = $sales->user_assessment_id";
                                $is_complete_assessment = $this->common_model->customQuery($sql);
                                $flag = true;
                                if (!empty($is_complete_assessment)) {
                                    foreach ($is_complete_assessment as $value) {
                                        if ($value->assessment_status != 1) {
                                            $flag = false;
                                        }
                                    }
                                }
                                if ($flag) {
                                    $temp2['sales'][] = $temp3;
                                    $salesRepData[] = $temp3;
                                }
                            }
                        }
                        $temp['leader'][] = $temp2;
                    }
                }
                $allUsers[] = $temp;
            }
        }
        $allUsersImport = $allUsers;
        foreach ($allUsers as $index => $rows) {
            if (!empty($rows['leader'])) {
                foreach ($rows['leader'] as $key => $leader) {
                    if (empty($leader['sales'])) {
                        unset($allUsersImport[$index]['leader'][$key]);
                    }
                }
            }
        }
        $allUsers = $allUsersImport;
        foreach ($allUsersImport as $index => $rows) {
            if (empty($rows['leader'])) {
                unset($allUsers[$index]);
            }
        }
        if (!empty($allUsers)) {
            $this->exportReportsInPdfGraphView($allUsers, $organization_id, $levels, $salesRepData);
        }else{
            echo "<div class='alert alert-danger'>Records not available for this selection</div>";
        }
    }

    public function exportReportsInPdfGraphView($exportData, $organization_id, $levels, $salesRepData) {
        $this->load->helper(array('file'));
        $dompdf = new Dompdf();
        $option = array('table' => ORGANIZATION,
            'select' => 'id,name',
            'where' => array('id' => $organization_id),
            'single' => true
        );
        $organization = $this->common_model->customGet($option);
        //$logo = $_SERVER["DOCUMENT_ROOT"] . '/self_assessment/' . getConfig('site_logo');
        $logo = $_SERVER["DOCUMENT_ROOT"] . '/' . getConfig('site_logo');
        $table = "";
        $title = "";
        if (!empty($exportData)) {
            if ($levels == 'self') {
                $table = $this->generateSelf($exportData, $organization_id);
                $title = "Self by category";
            } else if ($levels == 'self_leader') {
                $table = $this->generateSelfLeader($exportData, $organization_id);
                $title = "Self vs Leader by category";
            } else if ($levels == 'self_leader_manager') {
                $table = $this->generateSelfLeaderManager($exportData, $organization_id);
                $title = "Self vs Leader vs Manager by category";
            }
        }
        $dataResult['title'] = "Dashboard";
        $dataResult['parent'] = "Dashboard";
        $dataResult['table'] = $table;
        $dataResult['logo'] = $logo;
        $dataResult['organization'] = $organization->name;
        $dataResult['title'] = $title;
        $dataResult['salesRepData'] = $salesRepData;
        $dataResult['isView'] = $levels;
        $this->load->view('180-assessment-graph-view', $dataResult);
    }

}
