<?php

//配置文件(后台)
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'alias.php'); //加载别名文件
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.DIRECTORY_SEPARATOR.'libs'.DIRECTORY_SEPARATOR.'function'.DIRECTORY_SEPARATOR.'global.func.php'); //加载全局函数

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'realh5',
	'defaultController'=>'site/index/index',  //默认控制器
	'language' => 'zh_cn',
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.server.*', //逻辑类
		'application.interfaces.*', //接口类
		'application.libs.base.*',
		'application.libs.*',
		'application.libs.tools.*',
		'ext.mailer.EMailer',  
		'ext.YiiMongoDbSuite.*',           		//引入mongodb插件		
		'ext.oss.samples.*',           		//引入oss
		'ext.AliMsg.top.*',           		//引入AliMsg短信
		'ext.AliMsg.top.request.*',           		//引入AliMsg大于短信
		'ext.PHPExcel.PHPExcel'  ,     			//excel报表
		'ext.api_demo.*',           		//引入阿里云短信
	),


	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'urlManager'=>array(
			'caseSensitive'=>true,//大小写不敏感
			'showScriptName' => false,//隐藏INDEX.PHP
			/* 'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			), */
		),

		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.161.28.82;dbname=real_test',
			'emulatePrepare' => true,
			'username' =>'root',
			'password' => 'MoneplusDataBs11',
			'charset' => 'utf8',
			'tablePrefix' => 'r_'
		), 
		
			//redis 缓存  调用方法 Yii::app()->redis->set();
		'redis'=>array(
		        'class'=>'ext.YiiRedis.ARedisConnection',
	            "hostname" => "10.161.28.82",
                "port" => 6379,
                "database" => 0,  //redis 数据存放在 redis库 1中 默认为0
                "prefix" => "mone.redis.",
				'password' => 'reDisPassword@7.Mp'
		),
		
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		

	/* 	'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				array(
                            'class'=>'CWebLogRoute',
                            'levels'=>'trace',     //级别为trace
                            'categories'=>'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句
                    )
			
			),
		), */
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		//'adminEmail'=>'webmaster@example.com',
	),
);