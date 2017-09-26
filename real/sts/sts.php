<?php

/*
 * 在您使用STS SDK前，请仔细阅读RAM使用指南中的角色管理部分，并阅读STS API文档
 *
 */


include_once __DIR__ . '/aliyun-php-sdk-core/Config.php';

use Sts\Request\V20150401 as Sts;

// 你需要操作的资源所在的region，STS服务目前只有杭州节点可以签发Token，签发出的Token在所有Region都可用
// 只允许子用户使用角色
$iClientProfile = DefaultProfile::getProfile("cn-beijing", "LTAItWlqOFkTOHFc", "exWv651cxCv8KUni36cTSf2T0hAdPX");
$client = new DefaultAcsClient($iClientProfile);

// 角色资源描述符，在RAM的控制台的资源详情页上可以获取
$roleArn = "acs:ram::1821039973820491:role/ramadobeceprw";


// 在扮演角色(AssumeRole)时，可以附加一个授权策略，进一步限制角色的权限；
// 详情请参考《RAM使用指南》
// 此授权策略表示读取所有OSS的只读权限
$policy = <<<POLICY
{
  "Version": "1",
  "Statement": [
    {
      "Effect": "Allow",
      "Action": [
        "oss:DeleteObject",
        "oss:ListParts",
        "oss:AbortMultipartUpload",
        "oss:PutObject"
      ],
      "Resource": [
        "acs:oss:*:*:realadobe",
        "acs:oss:*:*:realadobe/*"
      ]
    }
  ]
}
POLICY;

$request = new Sts\AssumeRoleRequest();
// RoleSessionName即临时身份的会话名称，用于区分不同的临时身份
// 您可以使用您的客户的ID作为会话名称
$request->setRoleSessionName("client_name");

$request->setRoleArn($roleArn);
$request->setPolicy($policy);
$request->setDurationSeconds(1800);
$response = $client->doAction($request);
$response = json_decode($response, true);

$arr['AccessKeyId'] = $response['Credentials']['AccessKeyId'];
$arr['AccessKeySecret'] = $response['Credentials']['AccessKeySecret'];
$arr['SecurityToken'] = $response['Credentials']['SecurityToken'];
$arr['region'] = 'oss-cn-beijing';
$arr['bucket'] = 'realadobe';
//$sha1_product_id = SHA1($_REQUEST['product_id']);
// $sha1_product_id ='7dbaf8039661b0ea479a93a228727f3922ab6195';
//$arr['dir'] = isset($_REQUEST['product_id'])?date('Ym',time()).'/'.$sha1_product_id:'';
header("Content-type: text/html; charset=utf-8");
$connection = new mysqli("10.161.28.82", "root", "MoneplusDataBs11", "real_test");
$connection->set_charset('utf8');
$query = "select * from r_product where `product_id` = '$_REQUEST[product_id]'";
$result = $connection->query($query);
if ($result->num_rows == 0) {
    $restul['code'] = 100001;
    $restul['msg'] = 'id不存在';
    echo json_encode($restul);
    exit;
}
$data = $result->fetch_assoc();

if ($data['cloud'] == 'no') {
    $restul['code'] = 100002;
    $restul['msg'] = '云端已关闭';
    echo json_encode($restul);
    exit;
}
$arr['dir'] = $data['path'];
echo json_encode(array('code' => 0, 'data' => $arr));
exit;
?>
