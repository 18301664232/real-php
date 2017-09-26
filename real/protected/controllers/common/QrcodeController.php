<?php

//生成二维码
class QrcodeController extends BaseController {

    //生成二维码
    public function actionCode() {
        $url = !empty($_REQUEST['url']) ? $_REQUEST['url'] : '';
        $type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : '';
        $name = time() . rand(1, 9999) . '.png';
        $QR = UPLOAD_PATH . '/qrcode/' . $name;
        $filepath = UPLOAD_PATH . '/qrcode/';
        if (Tools::createDir($filepath)) {
            //生成不带图片二维码
            Tools::createImg($url, $QR, 'L', 4, 1);

            if (!empty($type)) {
                if ($type == 'wx') {
                    $logo = UPLOAD_PATH . '/qr/wx.png';
                    $QR = imagecreatefromstring(file_get_contents($QR));
                    $logo = imagecreatefromstring(file_get_contents($logo));
                    $QR_width = imagesx($QR);
                    $QR_height = imagesy($QR);
                    $logo_width = imagesx($logo);
                    $logo_height = imagesy($logo);
                    $logo_qr_width = $QR_width / 5;
                    $scale = $logo_width / $logo_qr_width;
                    $logo_qr_height = $logo_height / $scale;
                    $from_width = ($QR_width - $logo_qr_width) / 2;
                    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height, $logo_width, $logo_height);
                }
                header('content-type:image/png');
                imagepng($QR);
            }
        } else {
            $this->out('100002', '创建文件夹失败');
        }
    }

}
