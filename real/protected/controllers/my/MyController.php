<?php

/**
 * Created by PhpStorm.
 * User: syl
 * Date: 2017/11/30
 * Time: 11:48
 */
class MyController extends CenterController
{
    public $num =99;

    public function actionEchonum(){
        $this->num++;
    }
    public function actionEchonum2(){
        $this->num+=1;
        echo  $this->num;
        echo MyController::actionEchonum();
    }


}