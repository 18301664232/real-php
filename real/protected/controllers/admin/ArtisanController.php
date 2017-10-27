<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/8/23
 * Time: 14:56
 */
class ArtisanController extends CenterController
{
    public $layout='admin';

    private $modelname;
    private $modelextends;
    private $pulicstr;
    private $pulicstrarr;
    private $tablenamecase;
    private $safestr;

    private $controllername;
    private $entendsname;

    private $getdatatypearr;
    private $getdatatypestr;
    private $addmethdarr;
    private $addmethdstr;
    private $addmethdstr2='if(';
    private $updatemethdarr;
    private $updatemethdstr;
    private $updatemethdstr2='if(';
    private $selfservername;

    private $serverextends;

    private $china;
    private $nowtime;


    public function actionIndex(){

        $this->render('list');
    }

    public function actionGetTree(){
        $tname = !empty($_REQUEST['tname']) ? $_REQUEST['tname'] : '';
        if($tname){
            $sql = "select * from information_schema.columns  where table_name='$tname'";
            $res = Yii::app()->db->createCommand($sql)->query();
            foreach ($res as $k=>$v){
              $arr[] =array($v['COLUMN_COMMENT'],$v['COLUMN_NAME'],$v['COLUMN_TYPE']);
            }
        $this->out('666','成功',$arr);
        }else{
            $this->out('401','失败');
        }

    }

    public function actionStart(){
       var_dump($_REQUEST);
       $this->modelname=!empty($_REQUEST['modelname']) ? $_REQUEST['modelname'] : '此处有错误！！';
       $this->modelextends=!empty($_REQUEST['modelextends']) ? $_REQUEST['modelextends'] : 'CActiveRecord';
       $this->tablenamecase=!empty($_REQUEST['tablecasename']) ? $_REQUEST['tablecasename'] : '此处有错误！！';
       $this->controllername=!empty($_REQUEST['conname']) ? $_REQUEST['conname'] : '此处有错误！！';
       $this->entendsname=!empty($_REQUEST['conextends']) ? $_REQUEST['conextends'] : 'CenterController';
       $this->selfservername=!empty($_REQUEST['servername']) ? $_REQUEST['servername'] : '此处有错误！！';
       $this->serverextends=!empty($_REQUEST['serverextends']) ? $_REQUEST['serverextends'] : 'BaseServer';
       $this->pulicstrarr=!empty($_REQUEST['tnameval']) ? $_REQUEST['tnameval'] : [];
       $this->getdatatypearr=!empty($_REQUEST['type']) ? $_REQUEST['type'] : [];
       $this->addmethdarr=!empty($_REQUEST['coloneval']) ? $_REQUEST['coloneval'] : [];
       $this->updatemethdarr=!empty($_REQUEST['coltwoval']) ? $_REQUEST['coltwoval'] : [];
       $this->china=!empty($_REQUEST['china']) ? $_REQUEST['china'] :'此处有错误！！';
       $this->nowtime=date('Y-m-d h:i:s',time());


        //
        foreach ( $this->getdatatypearr as $k=>$v){

            $this->getdatatypestr.='  if ($params[\'type\'] == \''."$v[0]".'\' || $params[\'type\'] == \'\') {
            $'."$v[0]".'_list ='."$v[1]".'::'."$v[2]".'(array());
             if ($'."$v[0]".'_list[\'code\'] == 0) {
               $list[\''."$v[0]".'\'] = $'."$v[0]".'_list[\'data\'];
                  }
                }'."\r\n";
        }

        foreach ( $this->addmethdarr as $k=>$v) {

            $this->addmethdstr.='$params[\''."$v".'\'] = !empty($_REQUEST[\''."$v".'\']) ? $_REQUEST[\''."$v".'\'] : \'\';'."\r\n";
            $this->addmethdstr2.='empty($params[\''."$v".'\']) || ';

        }
        $this->addmethdstr2.='empty(2))';

        foreach ( $this->updatemethdarr as $k=>$v) {

            $this->updatemethdstr.='$params[\''."$v".'\'] = !empty($_REQUEST[\''."$v".'\']) ? $_REQUEST[\''."$v".'\'] : \'\';'."\r\n";
            $this->updatemethdstr2.='empty($params[\''."$v".'\']) || ';

        }
        $this->updatemethdstr2.='empty(2))';

        foreach ( $this->pulicstrarr as $k=>$v) {

            $this->pulicstr.='public $'.$v.';'."\r\n";

            $this->safestr.=$v.',';
        }

        $model_content=file_get_contents('C:/wamp/www/real-copy/real/_aatem/model.php');
        $model_content=str_replace('_MODELNAME_',$this->modelname,$model_content);
        $model_content=str_replace('_MODELEXTENDS_',$this->modelextends,$model_content);
        $model_content=str_replace('_TABLENAMECASE_',$this->tablenamecase,$model_content);
        $model_content=str_replace('_SAFESTR_',$this->safestr,$model_content);
        $model_content=str_replace('_PUBLICSTR_',$this->pulicstr,$model_content);
        $model_content=str_replace('_TIME_',$this->nowtime,$model_content);
        $model_content=str_replace('_HAHA_',$this->china,$model_content);




        $controller_content=file_get_contents('C:/wamp/www/real-copy/real/_aatem/controller.php');
        $controller_content=str_replace('_MODELNAME_',$this->modelname,$controller_content);
        $controller_content=str_replace('_CONTROLLERNAME_',$this->controllername,$controller_content);
        $controller_content=str_replace('_EXTENDSNAME_',$this->entendsname,$controller_content);
        $controller_content=str_replace('_GETDATATYPE_',$this->getdatatypestr,$controller_content);
        $controller_content=str_replace('_ADDMETHODONE_',$this->addmethdstr,$controller_content);
        $controller_content=str_replace('_ADDMETHODTWO_',$this->addmethdstr2,$controller_content);
        $controller_content=str_replace('_UPDATEMETHODONE_',$this->updatemethdstr,$controller_content);
        $controller_content=str_replace('_UPDATEMETHODTWO_',$this->updatemethdstr2,$controller_content);
        $controller_content=str_replace('_SELFSERVERNAME_',$this->selfservername,$controller_content);
        $controller_content=str_replace('_TIME_',$this->nowtime,$controller_content);
        $controller_content=str_replace('_HAHA_',$this->china,$controller_content);


        $server_content=file_get_contents('C:/wamp/www/real-copy/real/_aatem/server.php');
        $server_content=str_replace('_SELFSERVERNAME_',$this->selfservername,$server_content);
        $server_content=str_replace('_MODELNAME_',$this->modelname,$server_content);
        $server_content=str_replace('_SERVEREXTENDS_',$this->serverextends,$server_content);
        $server_content=str_replace('_TIME_',$this->nowtime,$server_content);
        $server_content=str_replace('_HAHA_',$this->china,$server_content);

        $res1= file_put_contents('C:/wamp/www/real-copy/real/_aaadata/'.$this->modelname.'.php',$model_content);
        $res2= file_put_contents('C:/wamp/www/real-copy/real/_aaadata/'.$this->controllername.'Controller.php',$controller_content);
        $res3= file_put_contents('C:/wamp/www/real-copy/real/_aaadata/'.$this->selfservername.'Server.php',$server_content);

        if($res1 && $res2 && $res3){
            $this->out('0','成功');
        }
        $this->out('44444','失败');

    }
}