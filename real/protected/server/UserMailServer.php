<?php
/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017-08-25 05:38:24
 */
class UserMailServer extends BaseServer
{


    //获取用户与邮件关联数据表数据
    public static function getUserMail($params = array())
    {

        $param = self::comParams2($params);

        //$model = new UserMail();
        //$result = PersonUser::model()->dbConnection->createCommand()->queryAll();
        //$rs = UserMail::model()->dbConnection->createCommand()->queryAll();
        //$model = Yii::app()->db->createCommand()
        // $criteria = new CDbCriteria;
        // $criteria->select = '*';
        // $criteria->condition = $param['con'];
        // $criteria->params = $param['par'];
        // $criteria->join='left join `r_mail` ON t.mail_id = `r_mail`.id';
        // //$criteria->with='mail';
         //$criteria->order = 'sendtime DESC';
        //$rs = $model->findAll();

        $rs = Yii::app()->db->createCommand()
            ->select('t.id,t.status,m.title,m.type,m.status as send_status,m.contents,m.sendtime,m.addtime')
            ->from('r_user_mail t')
            ->join('r_mail m', 't.mail_id=m.id')
            ->where($param['con'], $param['par'])
            ->queryAll();
        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => []);
        }

    }

    //删除用户与邮件关联数据表表数据
    public static function delUserMail($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = UserMail::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加用户与邮件关联数据表表数据
    public static function addUserMail($params)
    {
        $model = new UserMail();
        $model->attributes = $params;
        $rs = $model->save();
        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功');
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

   //修改用户与邮件关联数据表表数据
    public static function updateUserMail($attr, $condition)
    {

        $con= self::comParams($condition);
        $rs = UserMail::model()->updateAll($attr, $con);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }
///////////////////////////////M//////////////////////////////表方法分离线
    //获取邮件数据表数据
    public static function getMail($mailid,$type,$status,$like)
    {

       //    $param = self::comParams2($params);
             $model = new Mail();
        if(!empty($mailid)){
            $rs = $model->findByPk($mailid);

        }else{
            $criteria = new CDbCriteria;
            $criteria->select = '*';
//          $criteria->condition = $param['con'];
//          $criteria->params = $param['par'];
            if(!empty($type)){
                $criteria->addCondition("type=$type");
            }
            if(!empty($status)){
                $criteria->addCondition("status=$status");
            }
            if(!empty($like)){
                $criteria->addSearchCondition('title',$like);
            }
            $criteria->order = 'sendtime DESC';
            $rs = $model->findAll($criteria);

        }

        if ($rs) {
            return array('code' => '0', 'data' => $rs);
        } else {
            return array('code' => '100001', 'data' => '');
        }

    }


    //删除邮件数据表表数据
    public static function delMail($params)
    {
        $param = self::comParams($params);
        $criteria = new CDbCriteria;
        $criteria->condition = $param;
        $rs = Mail::model()->deleteAll($criteria);
        if ($rs) {
            return array('code' => '0', 'msg' => '删除成功');
        } else {
            return array('code' => '100001', 'msg' => '删除失败');
        }
    }

    //增加邮件数据表表数据
    public static function addMail($params)
    {

        $model = new Mail();
        $model->attributes = $params;
        $rs = $model->save();

        if ($rs) {
            return array('code' => '0', 'msg' => '添加成功','lastid'=>Yii::app()->db->getLastInsertID());
        } else {
            return array('code' => '100001', 'msg' => '添加失败');
        }
    }

    //修改邮件数据表表数据
    public static function updateMail($condition,$params)
    {

        $param = self::comParams($condition);
        $rs = Mail::model()->updateAll($params, $param);
        if ($rs) {
            return array('code' => '0', 'msg' => '修改成功');
        } else {
            return array('code' => '100001', 'msg' => '修改失败');
        }

    }
    //给用户发送邮件
    public static function SendMail($user_list,$lastid){

        $flag=true;
        foreach ($user_list['data'] as $k=>$v){
            $user_mail_model = new UserMail();
            $attr['user_id'] = $v->user_id;
            $attr['mail_id'] = $lastid;
            $user_mail_model->attributes = $attr;
            $rs = $user_mail_model->save();
            if(!$rs){
                $flag=false;
                break;
            }
        }
        if($flag){
            return array('code' => '0', 'msg' => '发送成功');
        }
        return array('code' => '100001', 'msg' => '发送失败');

    }

    //给用户发送邮箱
    public static function SendInternetEmail($address,$body){

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
        $mail->Body = $body; //邮件内容
        $mail->AddAddress($address, "RealApp"); //添加收件人（地址，昵称）
        $mail->Send();

    }



}