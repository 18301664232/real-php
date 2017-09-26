<?php
/**
 * 别名 常量定义文件
 * 路径文件皆为物理地址

 */
$baseDir = dirname(__FILE__);
$root = $baseDir.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
define('UPLOAD_PATH', $root.'/uploads'); 
define('UPLOAD', './uploads/photo/'); 
define('UPLOAD_HEADIMG', './uploads/headimg/'); 
define('PREVIEW', 'http://preview.realplus.cc/');  

//$siteUrl=Yii::app()->request->hostInfo;
$siteUrl='';
define('REAL', 'http://test.realplus.cc'); 
define('NODE', 'http://59.110.28.109:5080');  
define('STATICS', $siteUrl.'statics/user/');		//前台网站静态文件路径 css js images
define('STATICSADMIN', $siteUrl.'statics/admin/');		//后台网站静态文件路径 css js images
//define('STATICS', $siteUrl.'/statics/user/');		//前台网站静态文件路径 css js images
//define('STATICSADMIN', $siteUrl.'/statics/admin/');		//后台网站静态文件路径 css js images
define('WTEDITOR', 'http://test.realplus.cc/wteditor/wteditor.html');  
define('ROOT', $root);  //网站根目录  
define('HASH', 'real');		//表单令牌加密字符串
define('PWDSTR', 'real');		//密码加密字符串
define('COOKIE_KEY', 'real');		//key键
define('CHECK_REAL', 'real_check');		//key键
define('MSGNAME', '18610294886');		//短信账号
define('MSGPWD', 'monecys');		//短信密码

define('AliMSGNAME', '23496959');		                    //阿里大于短信账号
define('AliMSGPWD', 'abf741b966ad251e49d3b285b71d8380');	//阿里大于短信密码

//REAL
define('APPID', 'wxbc9b3c9c6accbf1c');		                   
define('APPSECRET', '46cf20147f9255c182dbd1e1a6d4eec0');
define('DOWNLOAD_MAC','http://test.realplus.cc/download/RealApp_mac.zip');
define('DOWNLOAD_PC','http://test.realplus.cc/download/RealApp_pc.zip');

//mail
define('EMAILUSERNAME', '18301664232@163.com');
define('EMAILPASSWORD', 'syl7250611');
define('EMAILHOST', 'smtp.163.com');
define('EMAILPORT', '25');
define('EMAILTIMEOUT', '20');