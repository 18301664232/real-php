<?php

//验证码挂件
class ValidateCodController extends BaseController {

    public $GetMsgCodeTime = 60; //再次点击获取验证码间隔时间   60秒

    public function actionUser() {
        $cod = new ValidateCode(116, 48);
        $cod->doimg();
        Yii::app()->session['user_code'] = json_encode(['code' => $cod->getCode(), 'time' => time()]); //验证码保存到SESSION中
    }

    public function actionAdmin() {
        $cod = new ValidateCode(116, 48);
        $cod->doimg();
        Yii::app()->session['admin_code'] = $cod->getCode(); //验证码保存到SESSION中
    }

    //手机短信/邮箱验证码
    public function actionMsgcode() {
        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 1;  //用于判断是否需要验证手机/邮箱已存在(1.用于注册，2用于找回密码,3项目下线)
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : ''; //用于注册时判断用户名
        if (empty($username))
            $this->out('100003', '手机号/邮箱不能为空');
        //判断时间
        $r_time = $this->GetMsgCodeTime; //过期时间
        $code = rand(100000, 999999);
        //获取cookie
        if ($status == 1)
            $key = 'r1_code';
        if ($status == 2)
            $key = 'r2_code';
        if ($status == 3)
            $key = 'r3_code';
        $cookie = Yii::app()->request->cookies[$key];
        if (isset($cookie))
            $value = $cookie->value;
        else
            $value = 0;
        if (time() - $value < $r_time)
            $this->out('100002', '请稍等');
        //判断是发送手机短信还是邮箱
        $data = array();
        if (!Tools::isPhone($username) && !Tools::isEmail($username))
            $this->out('100009', '手机/邮箱不合规');
        if (Tools::isPhone($username))
            $data['tel'] = $username;
        if (Tools::isEmail($username))
            $data['email'] = $username;
        //判断是否存在手机和邮箱
        $user_rs = UserServer::checkUsername($username);
        if ($status == 1) {
            if ($user_rs['code'] == 0)
                $this->out('100008', '手机/邮箱已存在');
            $code_key = $this->user_register_code;
        }elseif ($status == 2) {
            if ($user_rs['code'] != 0)
                $this->out('100008', '手机/邮箱不存在');
            $code_key = $this->user_retpwd_code;
        }elseif ($status == 3) {
            if ($user_rs['code'] != 0)
                $this->out('100008', '手机/邮箱不存在');
            $code_key = $this->user_product_code;
        }
        //发送短信验证码
        if (isset($data['tel']) && $type != 2) {
            //发送短信接口
            $rs = CommonInterface::sendAliyunMsg($data['tel'], array('code'=>$code));
            //$rs['code'] =000000;
            if ($rs['code'] == 000000) {
//                        Yii::app()->session[$code_key] = $code;
                Yii::app()->session[$code_key] = json_encode(['username' => $username, 'code' => $code, 'time' => time()]);
                //把用户信息保存在cookie里防止重复发
                $this->setCookie($key, time(), $r_time);
                $this->out('100001', '手机验证码已发送');
            } else
                $this->out('100005', '发送失败');
        }
        //发送邮箱验证码
        if (isset($data['email'])) {
            $mail = new EMailer(); //建立邮件发送类
            $mail->IsSMTP(); // 使用SMTP方式发送
            $mail->Host = "smtp.exmail.qq.com"; // 您的企业邮局域名
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->CharSet = "UTF-8"; //字符集
            $mail->Encoding = "base64"; //编码方式
            $mail->SMTPAuth = true; // 启用SMTP验证功能
            $mail->Username = "realh5@moneplus.cn"; // 邮局用户名(请填写完整的email地址)
            $mail->Password = "QWqw123"; // 邮局密码
            $mail->From = 'realh5@moneplus.cn'; //邮件发送者email地址
            $mail->FromName = "RealApp";
            $mail->Subject = "邮箱验证码"; //邮件标题
            $mail->Body = '您好,您的邮箱验证码是 ' . $code . ' (注意保管,请勿泄露) 【RealApp】'; //邮件内容
            $address = $data['email']; //收件人email
            $mail->AddAddress($address, "RealApp"); //添加收件人（地址，昵称）
            if (!$mail->Send()) {
                $this->out('100005', '发送失败');
            } else {
//                        Yii::app()->session[$code_key] = $code;
                Yii::app()->session[$code_key] = json_encode(['username' => $username, 'code' => $code, 'time' => time()]);
                //把用户信息保存在cookie里防止重复发邮件
                $this->setCookie($key, time(), $r_time);
                $this->out('100004', '邮箱验证码已发送');
            }
        }
        $this->out('100005', '发送失败');
    }

    //检查手机或邮箱的验证码是否正确
    public function actionMsgcodeisok() {
        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $msgcode = !empty($_REQUEST['msgcode']) ? $_REQUEST['msgcode'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 1;  //用于判断是否需要验证手机/邮箱已存在(1.用于注册，2用于找回密码,3项目下线)
        $code_key = $this->user_register_code;
        if ($status == 2)
            $code_key = $this->user_retpwd_code;
        if ($status == 3)
            $code_key = $this->user_product_code;
        $code = Yii::app()->session[$code_key];
        $code = json_decode($code, true);
        if ($code) {
            if ($msgcode != $code['code'] || $username != $code['username'])
                $this->out('100010', '验证码错误');
            if (time() - $this->ValidateCodeExpTimes * 60 > $code['time'])
                $this->out('100011', '验证码已过期');
            $this->out('0', 'ok');
        }
        $this->out('100012', '验证码不存在');
    }

    //检查是否可以再次获取验证码
    public function actionMsgcodetime() {
        $r_time = $this->GetMsgCodeTime; //过期时间
        //获取cookie
        $key = 'r_code';
        $cookie = Yii::app()->request->cookies[$key];
        if (isset($cookie) && time() - $cookie->value < $r_time)
            $this->out('100002', '请稍等', $r_time - (time() - $cookie->value));
        $this->out('0', 'ok', 0);
    }

    //检查手机或邮箱的验证码是否正确,用于账户安全
    public function actionMsgcoderead() {
        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $msgcode = !empty($_REQUEST['msgcode']) ? $_REQUEST['msgcode'] : '';
        $status = !empty($_REQUEST['status']) ? $_REQUEST['status'] : 1;  //(1.安全第二步，2安全第一步)
        $code_key = $this->user_register_code;
        if ($status == 2)
            $code_key = $this->user_retpwd_code;
        $code = Yii::app()->session[$code_key];
        $code = json_decode($code, true);
        if ($code) {
            if ($msgcode != $code['code'] || $username != $code['username'])
                $this->out('100010', '验证码错误');
            if (time() - $this->ValidateCodeExpTimes * 60 > $code['time'])
                $this->out('100011', '验证码已过期');
            unset(Yii::app()->session[$code_key]);
            //修改数据库电话或者邮箱
            if ($status == 1) {
                if (Tools::isPhone($username)) {
                    $data['tel'] = $username;
                    $data['email'] = '';
                }
                if (Tools::isEmail($username)) {
                    $data['tel'] = '';
                    $data['email'] = $username;
                }
                if (isset(Yii::app()->session['user']['user_id'])) {
                    //个人
                    $params['_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
                    $params['pc_type'] = 1;
                    $update_data['user_id'] = !empty(Yii::app()->session['user']['user_id']) ? Yii::app()->session['user']['user_id'] : '';
                } else {
                    //企业
                    $params['_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
                    $params['pc_type'] = 2;
                    $update_data['company_id'] = !empty(Yii::app()->session['user']['company_id']) ? Yii::app()->session['user']['company_id'] : '';
                }
                $rs = UserServer::selUser($params);
                if ($rs['code'] != 0)
                    $this->out('100003', '修改失败');
                $rst = UserServer::updateUser($update_data, $data);
                if ($rst['code'] == 0) {
                    //清除cookie，停止自动登陆
                    $cookie_id = COOKIE_KEY;
                    unset(Yii::app()->request->cookies[$cookie_id]);
                    unset(Yii::app()->session['user']);
                    $this->out('0', '修改成功');
                } else {
                    $this->out('100001', '修改失败');
                }
            }
            $this->out('0', 'ok');
        }
        $this->out('100012', '验证码不存在');
    }

}
