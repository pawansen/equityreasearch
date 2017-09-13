<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 * [get user ]
 */
if (!function_exists('getUser')) {

    function getUser($id = "") {
        $CI = & get_instance();
        return $CI->common_model->customGet(array('table' => 'users', 'where' => array('id' => $id), 'single' => true));
    }

}

/**
 * [common query ]
 */
if (!function_exists('commonGetHelper')) {

    function commonGetHelper($option) {
        $ci = get_instance();
        return $ci->common_model->customGet($option);
    }

}

/**
 * [get common configure ]
 */
if (!function_exists('getConfig')) {

    function getConfig($key) {
        $ci = get_instance();
        $option = array('table' => SETTING,
            'where' => array('option_name' => $key, 'status' => 1),
            'single' => true,
        );
        $is_result = $ci->common_model->customGet($option);
        if (!empty($is_result)) {
            return $is_result->option_value;
        } else {
            return false;
        }
    }

}

/**
 * [Multidimensional Array Searching (Find key by specific value)]
 */
if (!function_exists('matchKeyValue')) {

    function matchKeyValue($products, $field, $value) {
        foreach ($products as $key => $product) {
            if ($product->$field === $value)
                return true;
        }
        return false;
    }

}

/**
 * [get role ]
 */
if (!function_exists('getRole')) {

    function getRole($id = "") {
        $CI = & get_instance();
        $option = array('table' => USERS . ' as user',
            'select' => 'group.name as group_name',
            'join' => array(array(USER_GROUPS . ' as ugroup', 'ugroup.user_id=user.id', 'left'),
                array(GROUPS . ' as group', 'group.id=ugroup.group_id', 'left')),
            'where' => array('user.id' => $id),
            'single' => true
        );
        $user = $CI->common_model->customGet($option);
        if (!empty($user)) {
            return ucwords($user->group_name);
        } else {
            return false;
        }
    }

}

/**
 * [get role position ]
 */
if (!function_exists('getRolePosition')) {

    function getRolePosition($organization_id, $limit, $offset) {
        $CI = & get_instance();
        $option = array('table' => HIERARCHY_ROLE_ORDER . ' as roles',
            'select' => 'role_id',
            'where' => array('roles.organization_id' => $organization_id
            ),
            'order' => array('roles.id' => 'desc'),
            'single' => true,
            'limit' => array($limit => $offset),
            'group_by' => array('roles.id')
        );

        $roles = $CI->common_model->customGet($option);
        if (!empty($roles)) {
            return $roles->role_id;
        } else {
            return false;
        }
    }

}


/**
 * [get common configure ]
 */
if (!function_exists('is_options')) {

    function is_options() {
        return array('admin_email', 'site_name', 'date_foramte', 'site_meta_title', 'site_meta_description', 'site_logo', 'google_captcha', 'data_sitekey', 'secret_key');
    }

}


/**
 * [print pre ]
 */
if (!function_exists('dump')) {

    function dump($data) {
        echo"<pre>";
        print_r($data);
        echo"</pre>";
        exit;
    }

}

/**
 * [Get year between Two Dates ]
 */
if (!function_exists('getYearBtTwoDate')) {

    function getYearBtTwoDate($datetime1, $datetime2) {
        //$datetime1 = new DateTime("$datetime1");
        //$datetime2 = new DateTime("$datetime2");

        $startDate = new DateTime($datetime1);
        $endDate = new DateTime($datetime2);

        $difference = $endDate->diff($startDate);

        return $difference->d; // This will print '12' die();
    }

}

/**
 * [To print last query]
 */
if (!function_exists('lq')) {

    function lq() {
        $CI = & get_instance();
        echo $CI->db->last_query();
        die;
    }

}

/**
 * [To get database error message]
 */
if (!function_exists('db_err_msg')) {

    function db_err_msg() {
        $CI = & get_instance();
        $error = $CI->db->error();
        if (isset($error['message']) && !empty($error['message'])) {
            return 'Database error - ' . $error['message'];
        } else {
            return FALSE;
        }
    }

}

/**
 * [To parse html]
 * @param string $str
 */
if (!function_exists('parseHTML')) {

    function parseHTML($str) {
        $str = str_replace('src="//', 'src="https://', $str);
        return $str;
    }

}

/**
 * [To get current datetime]
 */
if (!function_exists('datetime')) {

    function datetime($default_format = 'Y-m-d H:i:s') {
        $datetime = date($default_format);
        return $datetime;
    }

}

/**
 * [To convert date time format]
 * @param datetime $datetime
 * @param string $format
 */
if (!function_exists('convertDateTime')) {

    function convertDateTime($datetime, $format = 'd M Y h:i A') {
        $convertedDateTime = date($format, strtotime($datetime));
        return $convertedDateTime;
    }

}

/**
 * [To encode string]
 * @param string $str
 */
if (!function_exists('encoding')) {

    function encoding($str) {
        $one = serialize($str);
        $two = @gzcompress($one, 9);
        $three = addslashes($two);
        $four = base64_encode($three);
        $five = strtr($four, '+/=', '-_.');
        return $five;
    }

}

/**
 * [To decode string]
 * @param string $str
 */
if (!function_exists('decoding')) {

    function decoding($str) {
        $one = strtr($str, '-_.', '+/=');
        $two = base64_decode($one);
        $three = stripslashes($two);
        $four = @gzuncompress($three);
        if ($four == '') {
            return "z1";
        } else {
            $five = unserialize($four);
            return $five;
        }
    }

}
/**
 * [To generate random token]
 * @param string $length
 */
if (!function_exists('generateToken')) {

    function generateToken($length) {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max)];
        }
        return $token;
    }

}

/**
 * [To check null value]
 * @param string $value
 */
if (!function_exists('null_checker')) {

    function null_checker($value, $custom = "") {
        $return = "";
        if ($value != "" && $value != NULL) {
            $return = ($value == "" || $value == NULL) ? $custom : $value;
            return $return;
        } else {
            return $return;
        }
    }

}

/**
 * [To get default image if file not exist]
 * @param  [string] $filename
 * @param  [string] $filepath
 */
if (!function_exists('display_image')) {

    function display_image($filename, $filepath) {
        /* Send image path last slash */
        $file_path_name = $filepath . $filename;
        if (!empty($filename) && @file_exists($file_path_name)) {
            return urlencode(base_url() . $file_path_name);
        } else {
            return urlencode(base_url() . DEFAULT_NO_IMG_PATH);
        }
    }

}

/**
 * [To delete file from directory]
 * @param  [string] $filename
 * @param  [string] $filepath
 */
if (!function_exists('unlink_file')) {

    function unlink_file($filename, $filepath) {
        /* Send file path last slash */
        $file_path_name = $filepath . $filename;
        if (!empty($filename) && @file_exists($file_path_name) && @unlink($file_path_name)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
/**
 * [To auto generate password]
 * @param  [string] $filename
 */
if (!function_exists('randomPassword')) {

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ#@&!';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 6; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        $pass[] = rand(1, 100);
        return implode($pass); //turn the array into a string
    }

}

/**
 * [To add point]
 */
if (!function_exists('all_points')) {

    function all_points($point = 5, $value = "") {
        $htm = "";
        for ($i = 1; $i <= $point; $i +=0.5) {
            $select = (!empty($value)) ? ($value == $i) ? "selected" : "" : "";
            $htm .= "<option value='" . $i . "' " . $select . ">" . $i . "</option>";
        }
        return $htm;
    }

}

/**
 * [To add point]
 */
if (!function_exists('search_exif')) {

    function search_exif($exif, $field, $val) {
        if (!empty($exif)) {
            foreach ($exif as $data) {
                if ($data->$field == $val) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }

}

/**
 * [To add point]
 */
if (!function_exists('search_exif_return')) {

    function search_exif_return($exif, $field, $val) {
        if (!empty($exif)) {
            foreach ($exif as $key => $data) {
                if ($data->$field == $val) {
                    return $data->id;
                }
            }
        } else {
            return false;
        }
    }

}

/**
 * [To check current user complete assessment]
 */
if (!function_exists('is_assessment_current')) {

    function is_assessment_current($organization_id, $user_lower_id) {
        $ci = get_instance();
        $sql = "SELECT `UA`.`id`,`UA`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180 LIMIT 1";
        $isSubmissions = $ci->common_model->customQuery($sql, TRUE);
        $txt = "";
        if (!empty($isSubmissions)) {

            if ($isSubmissions->assessment_status == 1) {
                $txt = "<div style='text-align: center;font-weight:900;color:#53aa53;' title='The Assessment is done'>Completed<div>";
            } else {
                $txt = "<div style='text-align: center;font-weight:900;color:#ff0000;' title='The Assessment is still not done'>Not Completed<div>";
            }
        } else {
            $txt = "";
        }
        return $txt;
    }

}

if (!function_exists('is_assessment_current_export')) {

    function is_assessment_current_export($organization_id, $user_lower_id) {
        $ci = get_instance();
        $sql = "SELECT `UA`.`id`,`UA`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180 LIMIT 1";
        $isSubmissions = $ci->common_model->customQuery($sql, TRUE);
        $txt = "";
        if (!empty($isSubmissions)) {

            if ($isSubmissions->assessment_status == 1) {
                $txt = "Completed";
            } else {
                $txt = "Not Completed";
            }
        }
        return $txt;
    }

}

if (!function_exists('is_assessment_current_app')) {

    function is_assessment_current_app($organization_id, $user_lower_id) {
        $ci = get_instance();
        $sql = "SELECT `UA`.`id`,`UA`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180 LIMIT 1";
        $isSubmissions = $ci->common_model->customQuery($sql, TRUE);
        $txt = "";
        if (!empty($isSubmissions)) {

            if ($isSubmissions->assessment_status == 1) {
                $txt = "Completed";
            } else {
                $txt = "Not Completed";
            }
        } else {
            $txt = "";
        }
        return $txt;
    }

}

if (!function_exists('is_assessment_submission_export')) {

    function is_assessment_submission_export($organization_id, $user_lower_id, $user_upper_id) {
        $ci = get_instance();
        $sql = "SELECT `UA1`.`id`,`UA1`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA1`.`user_id` = " . $user_upper_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180";
        $isSubmission = $ci->common_model->customQuery($sql, TRUE);
        $txt = "";
        if (!empty($isSubmission)) {
            if ($isSubmission->assessment_status == 1) {
                $txt = "Completed";
            } else {
                $txt = "Not Completed";
            }
        } else {
            $txt = "";
        }
        return $txt;
    }

}



/**
 * [To check upper lavel user complete assessment]
 */
if (!function_exists('is_assessment_submission')) {

    function is_assessment_submission($organization_id, $user_lower_id, $user_upper_id) {
        $ci = get_instance();
        $sql = "SELECT `UA1`.`id`,`UA1`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA1`.`user_id` = " . $user_upper_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180";
        $isSubmission = $ci->common_model->customQuery($sql, TRUE);
        $txt = "";
        if (!empty($isSubmission)) {
            if ($isSubmission->assessment_status == 1) {
                $txt = "<div style='text-align: center;font-weight:900;color:#18a532;' title='The Assessment is done'>Completed<div>";
            } else {
                $txt = "<div style='text-align: center;font-weight:900;color:#ff0000;' title='The Assessment is still not done'>Not Completed<div>";
            }
        } else {
            $txt = "";
        }
        return $txt;
    }

}

if (!function_exists('is_assessment_submission_app')) {

    function is_assessment_submission_app($organization_id, $user_lower_id, $user_upper_id) {
        $ci = get_instance();
        $sql = "SELECT `UA1`.`id`,`UA1`.`assessment_status`
                        FROM `user_assessment` as `UA`
                        JOIN `user_assessment` as `UA1` ON `UA1`.`child_upper_id`=`UA`.`id`
                        WHERE `UA`.`user_id` = " . $user_lower_id . "
                        AND `UA1`.`user_id` = " . $user_upper_id . "
                        AND `UA`.`organization_id` = " . $organization_id . "
                        AND `UA`.`assessment_type` = 180";
        $isSubmission = $ci->common_model->customQuery($sql, TRUE);
        $txt = "N/A";
        if (!empty($isSubmission)) {
            if ($isSubmission->assessment_status == 1) {
                $txt = "Completed";
            } else {
                $txt = "Not Completed";
            }
        } else {
            $txt = "N/A";
        }
        return $txt;
    }

}

if (!function_exists('alphaRows')) {
    function alphaRows($key) {
        $alphaArray = array('B','C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N',
            'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA',
            'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 
            'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW',
            'AX', 'AY', 'AZ','BA','BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK', 'BL', 
            'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW',
            'BX', 'BY', 'BZ','CA','CB', 'CC', 'CD', 'CE', 'CF', 'CG', 'CH', 'CI', 'CJ', 'CK', 'CL', 
            'CM', 'CN', 'CO', 'CP', 'CQ', 'CR', 'CS', 'CT', 'CU', 'CV', 'CW',
            'CX', 'CY', 'CZ','DA','DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH', 'DI', 'DJ', 'DK', 'DL', 
            'DM', 'DN', 'DO', 'DP', 'DQ', 'DR', 'DS', 'DT', 'DU', 'DV', 'DW',
            'DX', 'DY', 'DZ','EA','EB', 'EC', 'ED', 'EE', 'EF', 'EG', 'EH', 'EI', 'EJ', 'EK', 'EL', 
            'EM', 'EN', 'EO', 'EP', 'EQ', 'ER', 'ES', 'ET', 'EU', 'EV', 'EW',
            'EX', 'EY', 'EZ','FA','FB', 'FC', 'FD', 'FE', 'FF', 'FG', 'FH', 'FI', 'FJ', 'FK', 'FL', 
            'FM', 'FN', 'FO', 'FP', 'FQ', 'FR', 'FS', 'FT', 'FU', 'FV', 'FW',
            'FX', 'FY', 'FZ');
        return (isset($alphaArray[$key])) ? $alphaArray[$key] : "";
    }
}

if (!function_exists('category180Report')) {

    function category180Report($userId = "", $user_assessment_id = "", $roleId = "") {
        $ci = get_instance();
        if (!empty($userId)) {
            $categoryAverageBySelf = array();
            $categoryAverageByLeader = array();
            $categoryAverageByManager = array();
            $option = array('table' => USER_ASSESSMENT . ' as UA',
                'select' => 'ACA.id as cat_id,ACA.category_name',
                'join' => array(USER_ASSESSMENT_QUESTION_SUBMISSION . ' as UAQS' => 'UAQS.user_assessment_id=UA.id',
                    QUESTIONS . ' as QSA' => 'QSA.id=UAQS.question_id',
                    ASSESSMENT_CATEGORY . ' as ACA' => 'ACA.id=QSA.category_id'),
                'where' => array('UA.user_id' => $userId),
                'group_by' => array('ACA.id')
            );
            $assessmentQuestionCategory = $ci->common_model->customGet($option);
            foreach ($assessmentQuestionCategory as $ass_cat) {
                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA"
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.user_id = $userId AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageBySelf[$ass_cat->cat_id] = $ci->common_model->customQuery($sql, TRUE);
            }
            foreach ($assessmentQuestionCategory as $ass_cat) {
                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=3 AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageByManager[$ass_cat->cat_id] = $ci->common_model->customQuery($sql, TRUE);

                $sql = "SELECT QAS.category_id,ROUND(AVG(QAP.point),2) as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=4 AND QAS.category_id = $ass_cat->cat_id AND UA.assessment_type=180";

                $categoryAverageByLeader[$ass_cat->cat_id] = $ci->common_model->customQuery($sql, TRUE);
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
                if (!empty($assessmentQuestionCategory)) {
                    $response = array('status' => 1, 'category' => $assessmentQuestionCategory, 'self' => $categoryAverageBySelf, 'leader' => $categoryAverageByLeader, 'userId' => $userId, 'manager' => $categoryAverageByManager);
                } else {
                    return false;
                }
                return $response;
            } else {
                if (!empty($assessmentQuestionCategory)) {
                    $response = array('status' => 1, 'label' => $chartLabel, 'self' => $selfAvg, 'leader' => $leaderAvg, 'manager' => $managerAvg);
                } else {
                    return false;
                }
                return $response;
            }
        } else {
            return false;
        }
    }

}

if (!function_exists('statement180Report')) {

    function statement180Report($userId = "", $catId = "", $statement = "", $user_assessment_id = "") {
        $ci = get_instance();

        $option = array('table' => USER_ASSESSMENT . ' as UA',
            'select' => 'QSA.id as que_id,QSA.question,QSA.title,UAQS.select_option_id,QAP.point',
            'join' => array(USER_ASSESSMENT_QUESTION_SUBMISSION . ' as UAQS' => 'UAQS.user_assessment_id=UA.id',
                QUESTIONS . ' as QSA' => 'QSA.id=UAQS.question_id',
                'questions_option as QAP' => 'QAP.id=UAQS.select_option_id'),
            'where' => array('UA.user_id' => $userId, 'QSA.category_id' => $catId, 'UA.assessment_type' => 180)
        );
        $assessmentStatementSelf = $ci->common_model->customGet($option);
        if (!empty($assessmentStatementSelf)) {
            $assessmentStatementLeader = array();
            $assessmentStatementManager = array();
            foreach ($assessmentStatementSelf as $assessment) {
                $sql = "SELECT QAS.id as que_id,QAS.question,QAS.title,ASB.select_option_id,QAP.point as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=4 AND QAS.category_id = $catId AND UA.assessment_type=180 AND QAS.id = $assessment->que_id";

                $assessmentStatementLeader[] = $ci->common_model->customQuery($sql, TRUE);
                $sql = "SELECT QAS.id as que_id,QAS.question,QAS.title,ASB.select_option_id,QAP.point as avg_point FROM user_assessment as UA "
                        . " INNER JOIN users_groups as ugroup ON (ugroup.user_id=UA.user_id) "
                        . " INNER JOIN assessment_submission as ASB ON (ASB.user_assessment_id=UA.id)"
                        . " INNER JOIN questions as QAS ON (QAS.id=ASB.question_id)"
                        . " INNER JOIN questions_option as QAP ON (QAP.id=ASB.select_option_id)"
                        . " WHERE UA.child_upper_id=$user_assessment_id AND ugroup.group_id=3 AND QAS.category_id = $catId AND UA.assessment_type=180 AND QAS.id = $assessment->que_id";

                $assessmentStatementManager[] = $ci->common_model->customQuery($sql, TRUE);
            }
            $managerPoint = array();
            $managerPointTable = array();
            if (!empty($assessmentStatementManager)) {
                foreach ($assessmentStatementManager as $manager) {
                    $managerPoint[] = $manager->avg_point;
                    $managerPointTable[] = $manager->avg_point;
                }
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
                $managerPoint[1] = $managerPoint[0];
                $managerPoint[0] = null;
                $managerPoint[2] = null;
            }
            $option = array('table' => 'category',
                'select' => 'id,category_name',
                'where' => array('id' => $catId),
                'single' => true
            );
            $category_name = $ci->common_model->customGet($option);

            if ($statement == 1) {
                if (!empty($assessmentStatementSelf)) {
                    $response = array('status' => 1, 'statement' => $labelsTable, 'self' => $selfPointsTable, 'leader' => $leaderPointTable, 'category_name' => $category_name->category_name, 'manager' => $managerPointTable);
                } else {
                    return false;
                }
                return $response;
            } else {
                $response = array('status' => 1, 'labels' => $labels, 'self' => $selfPoints, 'leader' => $leaderPoint, 'category_name' => $category_name->category_name, 'manager' => $managerPoint);
            }
            return $response;
        } else {
            return false;
        }
    }

}

if (!function_exists('dailyTrackingCheckAssessmentBulletIn')) {

    function dailyTrackingCheckAssessmentBulletIn($userId = "", $user_assessment_id = "", $date = "") {
        $ci = get_instance();
        if (!empty($userId)) {
            $htm="NC";
             $sql = "SELECT id FROM daily_assessment_submission as UA"
                    . " WHERE UA.user_assessment_id = $user_assessment_id AND UA.submission_date='".$date."'";

            $isSubmission = $ci->common_model->customQuery($sql,TRUE);
            if(!empty($isSubmission)){
                $htm = "<span style='color:#009900'>C</span>";
            }else{
                $htm = "<span style='color:#e60000'>NC</span>";
            }
            return $htm;
            
        } else {
            return false;
        }
    }

}

if (!function_exists('dailyTrackingCheckAssessmentBulletOut')) {

    function dailyTrackingCheckAssessmentBulletOut($userId = "", $user_assessment_id = "", $date = "") {
        $ci = get_instance();
        if (!empty($userId)) {
            $htm="-";
            $sql = "SELECT id FROM daily_assessment_submission as UA"
                    . " WHERE UA.user_assessment_id = $user_assessment_id AND UA.submission_date='".$date."'";

            $isSubmission = $ci->common_model->customQuery($sql,TRUE);
            if(!empty($isSubmission)){
                $htm = "<span style='color:#009900'>C</span>";
            }else{
                $htm = "-";
            }
            return $htm;
            
        } else {
            return false;
        }
    }

}

if (!function_exists('dailyTrackingCheckAssessmentBulletInExport')) {

    function dailyTrackingCheckAssessmentBulletInExport($userId = "", $user_assessment_id = "", $date = "") {
        $ci = get_instance();
        if (!empty($userId)) {
            $htm="NC";
             $sql = "SELECT id FROM daily_assessment_submission as UA"
                    . " WHERE UA.user_assessment_id = $user_assessment_id AND UA.submission_date='".$date."'";

            $isSubmission = $ci->common_model->customQuery($sql,TRUE);
            if(!empty($isSubmission)){
                $htm = "C";
            }else{
                $htm = "NC";
            }
            return $htm;
            
        } else {
            return false;
        }
    }

}

if (!function_exists('dailyTrackingCheckAssessmentBulletOutExport')) {

    function dailyTrackingCheckAssessmentBulletOutExport($userId = "", $user_assessment_id = "", $date = "") {
        $ci = get_instance();
        if (!empty($userId)) {
            $htm="-";
            $sql = "SELECT id FROM daily_assessment_submission as UA"
                    . " WHERE UA.user_assessment_id = $user_assessment_id AND UA.submission_date='".$date."'";

            $isSubmission = $ci->common_model->customQuery($sql,TRUE);
            if(!empty($isSubmission)){
                $htm = "C";
            }else{
                $htm = "-";
            }
            return $htm;
            
        } else {
            return false;
        }
    }

}