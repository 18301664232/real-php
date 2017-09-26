<?php

/**
 * 项目全局函数
 * @author L.D.B
 * @version 2013-7-4
 */

/**
 * URL创建方法
 * @author L.D.B
 * @version 2013-7-4
 * ------------------------------------------
 * @param string $route      控制器id
 * @param array $params      参数 key=>value
 * @param string $ampersand  参数连接符
 * -------------------------------------------
 */
function U($route = 'portal/site/index', $params = array(), $ampersand = '&') {
    return Yii::app()->createUrl($route, $params, $ampersand);
}

// 浏览器友好的变量输出
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    } else
        return $output;
}

/*
 * 截取字符串，适用于文本编辑器中有表情的内容截取
 * $content	内容
 * $len	截取长度
 * */

//-----------------2014-6-27开始废弃这个函数，以后使用EduTools::text_cut_content
function text_cut_content($content, $len = 0) {
    preg_match_all('/\<img.*?src=([\'"])(.*?)\\1[^>]*>/i', EduTools::chars_to_html($content), $matchall);
    $match = array_filter($matchall);
    if (!empty($match)) {
        $chars = preg_split('/\<img.*?src=([\'"])(.*?)\\1[^>]*>/i', EduTools::chars_to_html($content), -1, PREG_SPLIT_OFFSET_CAPTURE);
        $str = '';
        $crr_len = 0;
        foreach ($chars as $k => $v) {
            $str_nohtml = strip_tags(EduTools::chars_to_html($v[0]));
            $crr_len += mb_strlen($str_nohtml, 'utf-8');
            if ($crr_len <= $len) {
                $img = $match[0][$k];
                preg_match_all('/src=([\'"])(.*)?\\1/', $img, $imgsrc);
                //如果不是头像，那么就过滤掉
                if (!preg_match('/emoticons/', $imgsrc[2][0])) {
                    $img = '';
                }
                $str .= $str_nohtml . $img;
            } else {
                $str .= mb_substr($str_nohtml, 0, $len - $crr_len, 'utf-8');
                break;
            }
        }
    } else {
        $str = mb_substr(strip_tags(EduTools::chars_to_html($content)), 0, $len, 'utf-8');
    }
    return $str;
}

/**
 * 返回字符长度，1个汉字只算一个，英文数字也都算一个
 * @param $string 需要计算字符串
 * @return int
 */
function get_mb_strlen($str) {
    $str = preg_replace('/\r\n/', '1', $str);
    return mb_strlen($str, 'utf-8');
}

/**
 * 返回编辑器中字符长度，1个汉字只算一个，英文数字也都算一个,图片算一个
 * @param $string 需要计算字符串
 * @return int
 */
function get_editor_mb_strlen($str) {
    //换算图片个数
    $str = preg_replace('/<img.*?>/i', '1', $str);
    $str = strip_tags($str);
    $str = trim($str);
    $str = preg_replace('/(&nbsp;)|(\r)|(\n)/', '', $str);
    return mb_strlen($str, 'utf-8');
}

/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
    $string = str_replace('%20', '', $string);
    $string = str_replace('%25', '', $string);
    $string = str_replace('%26', '', $string);
    $string = str_replace('%27', '', $string);
    $string = str_replace('%25%27', '', $string);
    $string = str_replace('*', '', $string);
    $string = str_replace('"', '&quot;', $string);
    $string = str_replace("'", '', $string);
    $string = str_replace('"', '', $string);
    $string = str_replace(';', '', $string);
    $string = str_replace('<', '&lt;', $string);
    $string = str_replace('>', '&gt;', $string);
    $string = str_replace("{", '', $string);
    $string = str_replace('}', '', $string);
    return $string;
}

//检测身份证号
function validation_filter_id_card($id_card) {
    if (strlen($id_card) == 18) {
        return idcard_checksum18($id_card);
    } elseif ((strlen($id_card) == 15)) {
        $id_card = idcard_15to18($id_card);
        return idcard_checksum18($id_card);
    } else {
        return false;
    }
}

// 计算身份证校验码，根据国家标准GB 11643-1999
function idcard_verify_number($idcard_base) {
    if (strlen($idcard_base) != 17) {
        return false;
    }
    //加权因子
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
    //校验码对应值
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
    $checksum = 0;
    for ($i = 0; $i < strlen($idcard_base); $i++) {
        $checksum += substr($idcard_base, $i, 1) * $factor[$i];
    }
    $mod = $checksum % 11;
    $verify_number = $verify_number_list[$mod];
    return $verify_number;
}

// 将15位身份证升级到18位
function idcard_15to18($idcard) {
    if (strlen($idcard) != 15) {
        return false;
    } else {
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false) {
            $idcard = substr($idcard, 0, 6) . '18' . substr($idcard, 6, 9);
        } else {
            $idcard = substr($idcard, 0, 6) . '19' . substr($idcard, 6, 9);
        }
    }
    $idcard = $idcard . idcard_verify_number($idcard);
    return $idcard;
}

// 18位身份证校验码有效性检查
function idcard_checksum18($idcard) {
    if (strlen($idcard) != 18) {
        return false;
    }
    $idcard_base = substr($idcard, 0, 17);
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))) {
        return false;
    } else {
        return true;
    }
}

/**
 * Convert all applicable characters to HTML entities
 */
function h($str) {
    return htmlentities($str, ENT_QUOTES, 'UTF-8');
}

/**
 * 删除目录  by lideliang 2014-8-8
 * Enter description here ...
 * @param unknown_type $dir
 */
function rmdirs($dir) {
    $dir = realpath($dir);
    if ($dir == '' || $dir == '/' || (strlen($dir) == 3 && substr($dir, 1) == '://')) {
        return false;
    }
    if (false !== ($dh = opendir($dir))) {
        while (false !== ($file = readdir($dh))) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                if (!rmdirs($path)) {
                    return false;
                }
            } else {
                unlink($path);
            }
        }
        closedir($dh);
        rmdir($dir);
        return true;
    } else {
        return false;
    }
}
