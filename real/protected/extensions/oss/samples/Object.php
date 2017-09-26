<?php
require_once __DIR__ . '/Common.php';

use OSS\OssClient;
use OSS\Core\OssException;
class Object {
	public function bucket(){
		$bucket = Common::getBucketName();
	}
	
	public function ossClient(){
		$ossClient = Common::getOssClient();
		if (is_null($ossClient)) exit(1);
		return $ossClient;
	}
}

?>