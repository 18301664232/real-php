<?php

/**
 * 放置一些以前的函数东东
 *
 */
class Tools {

    /**
     * 创建目录
     */
    public static function createDir($pathName) {
        if (!is_dir($pathName)) {
            if (mkdir($pathName, 0755, true)) {
                return true;
            } else {
                return false;
            }
        }
        return true;
    }

    //流量转换
    public static function formatBytes($size) {

        $units = array(' B', ' KB', ' MB', ' GB', ' TB');

        for ($i = 0; $size >= 1024 && $i < 4; $i++) {

            $size /= 1024;
        }

        return round($size, 2) . $units[$i];
    }

    /* //URL生成二维码图片

      $url; //二维码内容
      $outfile;//默认为否，不生成文件，只将二维码图片返回，否则需要给出存放生成二维码图片的路径
      $level;//容错级别
      $size;//生成图片大小
      $margin;//控制生成二维码的空白区域大小
     */

    public static function createImg($url, $outfile = false, $level = 'L', $size = 6, $margin = 2) {
        if (empty($url)) {
            echo 'error';
            exit;
        }
        //生成二维码图片 
        QRcode::png($url, $outfile, $level, $size, $margin);
    }

    /**
     * 验证身份证号码是否合法
     */
    public static function check_Idcode($idcode) {
        if (trim($idcode) === '') {
            return array('code' => '100001', 'message' => '身份证号码不能为空');
        }
        if (!validation_filter_id_card($idcode)) {
            return array('code' => '100002', 'message' => '身份证号码格式不正确');
        }
        return array('code' => '000000', 'message' => '');
    }

    /**
     * 密码加密
     */
    public static function setpwd($pwd) {
        $pwd = $pwd . PWDSTR;
        $rs = md5($pwd);
        return $rs;
    }

    /**
     * 获取IP
     */
    public static function getip() {
        $ip = getenv('REMOTE_ADDR');
        $ip_ = getenv('HTTP_X_FORWARDED_FOR');
        if (($ip_ != "") && ($ip_ != "unknown")) {
            $ip = $ip_;
        }
        return $ip;
    }


//图片缩放
    public static function ImageToJPG($srcFile, $dstFile, $towidth, $toheight) {
        $quality = 80;
        $data = @GetImageSize($srcFile);
        switch ($data['2']) {
            case 1:
                $im = imagecreatefromgif($srcFile);
                break;
            case 2:
                $im = imagecreatefromjpeg($srcFile);
                break;
            case 3:
                $im = imagecreatefrompng($srcFile);
                break;
            case 6:
                $im = imagecreatefromBMP($srcFile);
                break;
        }
        // $dstX=$srcW=@ImageSX($im);   
        // $dstY=$srcH=@ImageSY($im);   
        $srcW = @ImageSX($im);
        $srcH = @ImageSY($im);
        //$towidth,$toheight  
        if (@$toheight / $srcW > @$towidth / $srcH) {
            @$b = $toheight / $srcH;
        } else {
            @$b = $towidth / $srcW;
        }
        //计算出图片缩放后的宽高  
        // floor 舍去小数点部分，取整  
        $new_w = floor($srcW * $b);
        $new_h = floor($srcH * $b);
        $dstX = $new_w;
        $dstY = $new_h;
        $ni = @imageCreateTrueColor($dstX, $dstY);
        //分配颜色 + alpha，将颜色填充到新图上  
        $alpha = imagecolorallocatealpha($ni, 0, 0, 0, 127);
        imagefill($ni, 0, 0, $alpha);

        @ImageCopyResampled($ni, $im, 0, 0, 0, 0, $dstX, $dstY, $srcW, $srcH);
        @imagesavealpha($ni, true);
        imagepng($ni, $dstFile);
        @imagedestroy($im);
        @imagedestroy($ni);

    }

    /*
     * 对象转数组
     */

    public static function objarray($obj) {
        $rs = json_decode(json_encode($obj), true);
        return $rs;
    }

    /**
     * 判断email格式是否正确
     * #email	邮箱
     * @author wlei
     * @copyright 2013-7-8
     * @return bool
     */
    public static function isEmail($email) {
        return preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email);
    }

    //检查密码
    public static function isPwd($pwd) {

        return preg_match('/^(?=.*\d)(?=.*[a-zA-Z])/', $pwd);
    }

    /**
     * 判断手机号码phone格式是否正确
     * #phone	手机号
     * @author wlei
     * @copyright 2013-7-8
     * @return bool
     */
    public static function isPhone($phone) {
        return strlen($phone) == 11 && preg_match('/^1[34578]\d{9}$/', $phone);
    }

    //时间类型转换为时间戳
    public static function typetime($type) {
        switch ($type) {
            case 'today':
                $starttime = strtotime(date('Y-m-d'), time());
                $endtime = time();
                break;
            case 'ttoday':
                $starttime = strtotime(date('Ymd', strtotime('-1 day')));
                $endtime = strtotime(date('Ymd', time()));
                break;
            case 'tttoday':
                $starttime = time() - 48 * 3600;
                $endtime = time();
                break;
            case 't7today':
                $starttime = strtotime('-7 day');
                $endtime = time();
                break;
            case 't30today':
                $starttime = strtotime('-30 day');
                $endtime = time();
                break;
            default :
                $starttime = '';
                $endtime = '';
        }
        return array('starttime' => $starttime, 'endtime' => $endtime);
    }

    /**
     * 密码合法性检测----长度，空格，是否一致
     * $params	array
     * 			psw		密码----不传入不验证,注册时可使用
     * 			oldpsw	原密码--不传入不验证,修改密码时使用
     * 			newpsw	新密码--不传入不验证,修改密码时使用
     * 			repwd	重输密码-根据上面条件验证
     * 			minlen	最小密码长度,不传默认6
     * 			maxlen	最大密码长度，不传默认20
     * @author wlei
     * @copyright 2013-7-8
     * return array 
     * 			code=>000000验证通过
     * 			message=>''描述
     */
    public static function checkPsw($params = array()) {
        $reg = '/^.*(\s)+.*$/'; //不能有空格
        $minlen = isset($params['minlen']) ? intval($params['minlen']) : 6;
        $maxlen = isset($params['maxlen']) ? intval($params['maxlen']) : 20;
        $msg = array('code' => '000000', 'message' => '');

        if (isset($params['psw']) && isset($params['repwd'])) {
            if ($params['psw'] === '') {
                $msg = array('code' => '100001', 'message' => '密码需要填写');
            } elseif (preg_match($reg, $params['psw'])) {
                $msg = array('code' => '100002', 'message' => '密码不能含有空格');
            } elseif (strlen($params['psw']) < $minlen || strlen($params['psw']) > $maxlen) {
                $msg = array('code' => '100003', 'message' => '密码长度只能在' . $minlen . '-' . $maxlen . '位字符之间');
            } elseif ($params['psw'] !== $params['repwd']) {
                $msg = array('code' => '100004', 'message' => '重输密码不一致');
            }
        } elseif (isset($params['oldpsw']) && isset($params['newpsw']) && isset($params['repwd'])) {
            if ($params['oldpsw'] === '') {
                $msg = array('code' => '100001', 'message' => '原密码需要填写');
            } elseif ($params['newpsw'] === '') {
                $msg = array('code' => '100002', 'message' => '新密码需要填写');
            } elseif (strlen($params['newpsw']) < $minlen || strlen($params['newpsw']) > $maxlen) {
                $msg = array('code' => '100003', 'message' => '密码长度只能在' . $minlen . '-' . $maxlen . '位字符之间');
            } elseif (preg_match($reg, $params['newpsw'])) {
                $msg = array('code' => '100004', 'message' => '密码不能含有空格');
            } elseif ($params['newpsw'] !== $params['repwd']) {
                $msg = array('code' => '100005', 'message' => '重输密码不一致');
            }
        } else {
            $msg = array('code' => '100000', 'message' => '参数不正确');
        }
        return $msg;
    }

    /**
     * 获取输入的密码等级--以后可扩展验证
     * $psw	密码（密码长度默认是6-20）
     * 			等级规则：
     * 					数字+1;字母+1;符号+1;10位长度+1；16位长度+1
     * @author wlei
     * @copyright 2013-7-8
     * @return int 等级 
     */
    public static function getPswLevel($psw) {
        $level = 0;
        $reg1 = '/^.*([\W_])+.*$/';
        $reg2 = '/^.*([a-zA-Z])+.*$/';
        $reg3 = '/^.*([0-9])+.*$/';
        if (preg_match($reg1, $psw)) {
            $level++;
        }
        if (preg_match($reg2, $psw)) {
            $level++;
        }
        if (preg_match($reg3, $psw)) {
            $level++;
        }
        if ($level > 1) {
            if (strlen($psw) >= 10) {
                $level++;
            }
            if (strlen($psw) >= 16) {
                $level++;
            }
        }

        return $level;
    }

    /**
     * 检测姓名是否合法----姓名应为2-10位中文
     * $name
     * @author wlei
     * @copyright 2013-7-24
     * return array 
     * 			code=>000000验证通过
     * 			message=>''描述
     */
    public static function checkName($name) {
        $nameLen = mb_strlen($name, 'utf-8');
        if ($nameLen < 2 || $nameLen > 10 || !self::checkCNAll($name)) {
            return array('code' => '100000', 'message' => '用户真实姓名应为2-10位中文');
        }
        return array('code' => '000000', 'message' => '');
    }

    /**
     * 检测是否为纯中文----utf8
     * @author wlei
     * @copyright 2013-7-24
     * return bool
     */
    public static function checkCNAll($str) {
        return preg_match("/^[\x{4e00}-\x{9fa5}]+$/u", $str);
    }

    /**
     * 检测账号是否合法----用户名应以字母开头,6-20位字符
     * $name
     * @author wlei
     * @copyright 2013-7-24
     * return array
     * 			code=>000000验证通过
     * 			message=>''描述
     */
    public static function checkAccount($account) {
        if (!preg_match('/^[A-Z][a-z\d\_]{5,19}$/i', $account)) {
            return array('code' => '100000', 'message' => '用户名应以字母开头,6-20位字符');
        }
        return array('code' => '000000', 'message' => '');
    }

    /**
     * 判断email格式是否正确
     * @param $email
     * @author wlei
     * @copyright 2013-7-24
     * return array
     * 			code=>000000验证通过
     * 			message=>''描述
     */
    public static function checkEmail($email) {
        if (strlen($email) < 6 || strlen($email) > 50) {
            return array('code' => '100000', 'message' => '邮箱长度应为6-50位字符');
        } elseif (!preg_match('/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/', $email)) {
            return array('code' => '100001', 'message' => '邮箱格式不正确');
        }
        return array('code' => '000000', 'message' => '');
    }

    /**
     * 字符截取 支持UTF8/GBK
     * @param $string
     * @param $length
     * @param $dot
     * @param $type 是否需要去掉头部空白
     */
    public static function str_cut($string, $length, $dot = '...', $type = "") {
        if (strlen($string) <= $length) {
            return $string;
        }
        $string = strip_tags($string, '<img>');

        $pre = chr(1);
        $end = chr(1);
        $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), $string);
        if ($type == "1") {
            $string = str_replace("&nbsp;", " ", $string);
            $string = ltrim($string);
        }
        $strcut = '';
        if (1) {
            $n = $tn = $noc = 0;
            while ($n < strlen($string)) {

                $t = ord($string[$n]);
                if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1;
                    $n++;
                    $noc++;
                } elseif (194 <= $t && $t <= 223) {
                    $tn = 2;
                    $n += 2;
                    $noc += 2;
                } elseif (224 <= $t && $t <= 239) {
                    $tn = 3;
                    $n += 3;
                    $noc += 2;
                } elseif (240 <= $t && $t <= 247) {
                    $tn = 4;
                    $n += 4;
                    $noc += 2;
                } elseif (248 <= $t && $t <= 251) {
                    $tn = 5;
                    $n += 5;
                    $noc += 2;
                } elseif ($t == 252 || $t == 253) {
                    $tn = 6;
                    $n += 6;
                    $noc += 2;
                } else {
                    $n++;
                }

                if ($noc >= $length) {
                    break;
                }
            }
            if ($noc > $length) {
                $n -= $tn;
            }

            $strcut = substr($string, 0, $n);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
            }
        }
        $strcut = str_replace(array($pre . '&' . $end, $pre . '"' . $end, $pre . '<' . $end, $pre . '>' . $end), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

        $pos = strrpos($strcut, chr(1));
        if ($pos !== false) {
            $strcut = substr($strcut, 0, $pos);
        }
        $strcut = strip_tags($strcut);
        return $strcut . $dot;
    }

    /**
     * 字符加密
     * wlei
     * 2013-10-11
     * @param $string
     * @return $string
     */
    public static function authcode($string, $operation = 'DECODE', $key = 'user_sercretkey', $expiry = 0) {
        $ckey_length = 1; //note 随机密钥长度 取值 0-32;
        //note 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
        //note 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
        //note 当此值为 0 时，则不产生随机密钥

        $key = md5($key ? $key : 1234);
        $keya = md5(substr($key, 0, 16));
        $keyb = md5(substr($key, 16, 16));
        $keyc = 'a';
        $cryptkey = $keya . md5($keya . $keyc);
        $key_length = strlen($cryptkey);

        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry : 0) . substr(md5($string . $keyb), 0, 16) . $string;
        $string_length = strlen($string);

        $result = '';
        $box = range(0, 255);

        $rndkey = array();
        for ($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }

        for ($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }

        for ($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
        }

        if ($operation == 'DECODE') {
            if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            return $keyc . str_replace('=', '', base64_encode($result));
        }
    }

    /**
     * 友好时间 
     * @param number $time
     * @author wlei
     * @copyright 2013-8-19
     * @return	string 
     */
    public static function fdate($time) {
        if (!$time)
            return false;
        if (!empty($time->sec)) {
            $time = $time->sec;
        }
        $fdate = '';
        $d = time() - intval($time);
        $byd = time() - mktime(0, 0, 0, date('m'), date('d') - 2, date('Y')); //前天
        $yd = time() - mktime(0, 0, 0, date('m'), date('d') - 1, date('Y')); //昨天
        $dd = time() - mktime(0, 0, 0, date('m'), date('d'), date('Y')); //今天  
        if ($d < 500) {
            $fdate = '刚刚';
        } else {
            switch ($d) {
                case $d < 3600 :
                    $fdate = floor($d / 60) . '分钟前';
                    break;
                case $d < $dd :
                    $fdate = floor($d / 3600) . '小时前';
                    break;
                case $d < $yd :
                    $fdate = '昨天' . date('H:i', $time);
                    break;
                case $d < $byd :
                    $fdate = '前天' . date('H:i', $time);
                    break;
                case intval($time) > mktime(0, 0, 0, 0, 0, date('Y')): //今年
                    $fdate = date('m-d H:i', $time);
                    break;
                default :
                    $fdate = date('Y-m-d H:i', $time);
                    break;
            }
        }
        return $fdate;
    }

    /**
     * 检查日期是否合法日期
     * @param string $date
     * @author wlei
     * @copyright 2013-9-10
     * @return	string 
     */
    public static function isDate($date) {
        $dateArr = explode("-", $date);
        if (is_numeric($dateArr[0]) && is_numeric($dateArr[1]) && is_numeric($dateArr[2])) {
            return checkdate($dateArr[1], $dateArr[2], $dateArr[0]);
        }
        return false;
    }

    /**
     * 剔除传入的空格
     * @param string/array $params
     * @author wlei
     * @copyright 2013-9-14
     * @return	string/array 
     */
    public static function getNoBlank($params) {
        if (is_array($params)) {
            foreach ($params as $k => $v) {
                if (is_string($v)) {
                    $params[$k] = preg_replace('/[\s\n\r]*/', '', $v);
                } else {
                    self::getNoBlank($v);
                }
            }
        } elseif (is_string($params)) {
            $params = preg_replace('/[\s\n\r]*/', '', $params);
        }
        return $params;
    }

    /**
     * 程序执行时间
     *
     * @return	int	单位ms
     */
    public static function execute_time($start = '') {
        if (!defined('SYS_START_TIME')) {
            define('SYS_START_TIME', microtime());
        }
        $stime = $start ? explode(' ', $start) : explode(' ', SYS_START_TIME);
        $etime = explode(' ', microtime());
        return number_format(($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6);
    }

    /**
     * 程序当前时间
     *
     * @return	int	单位ms
     */
    public static function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /*
     * 截取字符串，适用于文本编辑器中有表情的内容截取
     * $content	内容
     * $len	截取长度
     * */

    public static function text_cut_content($content, $len = 0) {
        preg_match_all('/\<img.*?src=([\'"])(.*?)\\1[^>]*>/i', self::chars_to_html($content), $matchall);
        $match = array_filter($matchall);
        if (!empty($match)) {
            $chars = preg_split('/\<img.*?src=([\'"])(.*?)\\1[^>]*>/i', self::chars_to_html($content), -1, PREG_SPLIT_OFFSET_CAPTURE);
            $str = '';
            $crr_len = 0;
            foreach ($chars as $k => $v) {
                $str_nohtml = strip_tags(self::chars_to_html($v[0]));
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
            $str = mb_substr(strip_tags(self::chars_to_html($content)), 0, $len, 'utf-8');
        }
        return $str;
    }

    /**
     * 过滤字符中的html格式
     * @return str
     */
    public static function new_html_tags($string) {
        if (!is_array($string))
            return self::html_to_chars($string);
        foreach ($string as $key => $val)
            $string[$key] = self::new_html_tags($val);
        return $string;
    }

    /**
     * 将格式化的html反编译为html格式
     * @return str
     */
    public static function chars_to_html($string) {
        $string = str_replace('&amp;', '&', $string);
        $string = str_replace('&#039;', '\'', $string);
        $string = str_replace('&quot;', '"', $string);
        $string = str_replace('&lt;', '<', $string);
        $string = str_replace('&gt;', '>', $string);
        $string = preg_replace("/<\s*?script[^>]*?>.*?<\\/\s*?script>/si", '', $string);
        $string = preg_replace("/<\s*?script[^>]*?>.*?/si", '', $string);
        $string = preg_replace("/<\s*?link[^>]*?>/si", '', $string);

        $string = str_replace('&uuml;', '', $string);
        $string = str_replace('&Uuml;', '', $string);
        $string = str_replace('&auml;', '', $string);
        $string = str_replace('&Auml;', '', $string);
        $string = str_replace('&ouml;', '', $string);
        $string = str_replace('&Ouml;', '', $string);
        return $string;
    }

    /**
     * 将编辑器的内容格式化html
     * @return str
     */
    public static function html_to_chars($string) {
        $string = stripslashes($string);

        $string = str_replace('&lt;', '<', $string);
        $string = str_replace('&gt;', '>', $string);
        $string = preg_replace("/<\s*?script[^>]*?>.*?<\\/[^>]*?script>/si", '', $string);
        $string = preg_replace("/<\s*?script[^>]*?>.*?/si", '', $string);
        $string = preg_replace("/<\s*?link[^>]*?>/si", '', $string);

        $string = str_replace('&', '&amp;', $string);
        $string = str_replace('\'', '&#039;', $string);
        $string = str_replace('"', '&quot;', $string);

        $string = str_replace('<', '&lt;', $string);
        $string = str_replace('>', '&gt;', $string);
        return $string; //htmlspecialchars($string,ENT_QUOTES,'utf-8');
    }

    //截取中文字符串
    function msubstr($str, $start, $len) {
        $tmpstr = "";
        $strlen = $start + $len;
        for ($i = 0; $i < $strlen; $i++) {
            if (ord(substr($str, $i, 1)) > 0xa0) {
                $tmpstr .= substr($str, $i, 2);
                $i++;
            } else
                $tmpstr .= substr($str, $i, 1);
        }
        return $tmpstr;
    }

    /**
     * 二维数组去重
     * @param $arr 要去重的数组 ; $key 检测重复的数组key值
     * @author xkduan
     * @copyright 2014-3-4
     *
     */
    function assoc_unique($arr, $key) {
        $tmp_arr = array();
        foreach ($arr as $k => $v) {
            if (in_array($v[$key], $tmp_arr)) {
                unset($arr[$k]);
            } else {
                $tmp_arr[] = $v[$key];
            }
        }
        return $arr;
    }

    /**
     * 等宽等像素值截取字符串
     * @author wzq
     * @copyright 2014-5-8
     */
    public static function mb_sub($str, $len, $encode = 'utf8', $start = 0) {
        if ($encode != 'utf8') {
            $str = mb_convert_encoding($str, 'utf8', $encode);
        }
        $osLen = mb_strlen($str);
        if ($osLen <= $len) {
            return $str;
        }
        $string = mb_substr($str, $start, $len, 'utf8');
        $sLen = mb_strlen($string, 'utf8');
        $bLen = strlen($string);
        $sCharCount = (3 * $sLen - $bLen) / 2;
        if ($osLen <= $sCharCount + $len) {
            $arr = preg_split('/(?<!^)(?!$)|([0-9])|(\s)/u', mb_substr($str, $len + 1, $osLen, 'utf8')); //将中英混合字符串分割成数组（UTF8下有效）
        } else {
            $arr = preg_split('/(?<!^)(?!$)|([0-9])|(\s)/u', mb_substr($str, $len + 1, $sCharCount, 'utf8'));
        }
        foreach ($arr as $value) {
            if (ord($value) < 128 && ord($value) > 0) {
                $sCharCount = $sCharCount - 1;
            } else {
                $sCharCount = $sCharCount - 2;
            }
            if ($sCharCount <= 0) {
                break;
            }
            $string.=$value;
        }
        return $string;
    }

    /**
     * 验证联系电话
     * @author wzq
     */
    public static function isLinkTel($linktel) {
        //手机号
        $isMob = "/^1[3-5,8]{1}[0-9]{9}$/";
        //座机号
        $isTel = "/^([0-9]{3,4}-)?[0-9]{7,8}$/";
        if (!preg_match($isMob, $linktel) && !preg_match($isTel, $linktel)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * 浏览器函数
     * @author yufan	 
     * @date 2014-06-23
     */
    static function browser() {
        $agent = $_SERVER["HTTP_USER_AGENT"];
        if (strpos($agent, "rv:11.0"))
            return "IE11";
        if (strpos($agent, "MSIE 10.0"))
            return "IE10";
        if (strpos($agent, "MSIE 9.0"))
            return "IE9";
        if (strpos($agent, "MSIE 8.0"))
            return "IE8";
        else if (strpos($agent, "MSIE 7.0"))
            return "IE7";
        else if (strpos($agent, "MSIE 6.0"))
            return "IE6";
        else if (strpos($agent, "Firefox/3"))
            return "Firefox3";
        else if (strpos($agent, "Firefox/2"))
            return "Firefox2";
        else if (strpos($agent, "Chrome"))
            return "Chrome";
        else if (strpos($agent, "Safari"))
            return "Safari";
        else if (strpos($agent, "Opera"))
            return "Opera";
        else
            return $agent;
    }

    /* 移动端判断 */

    static function isMobile() {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }

}

?>