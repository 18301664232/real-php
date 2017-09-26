<?php
//------------------------讨论后取消此功能----------------------
//项目视频 
class VideoController extends CenterController {

    //查询
    public function actionSelect() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        if (empty($product_id))
            $this->out('100005', '数据不能为空');
        $rs = ProductServer::slectVideo(array('product_id' => $product_id));
        if ($rs['code'] == 0) {
            $this->out('0', 'ok', $rs['data']);
        }
        $this->out('100001', 'error');
    }

    //添加
    public function actionAdd() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $video = !empty($_REQUEST['video']) ? $_REQUEST['video'] : '';
        if (empty($product_id) || empty($video) || !is_array($video))
            $this->out('100005', '数据不能为空');
        foreach ($video as $k => $v) {
            $rs = ProductServer::addVideo(array('product_id' => $product_id, 'video' => $v, 'addtime' => time()));
            if ($rs['code'] != 0)
                $this->out('100001', 'error');
        }

        $this->out('0', 'ok');
    }

    //删除
    public function actionDel() {
        $product_id = !empty($_REQUEST['product_id']) ? $_REQUEST['product_id'] : '';
        $video = !empty($_REQUEST['video']) ? $_REQUEST['video'] : '';
        if (empty($product_id) || empty($video))
            $this->out('100005', '数据不能为空');
        $rs = ProductServer::delVideo(array('product_id' => $product_id, 'video' => $video));
        if ($rs['code'] == 0)
            $this->out('0', 'ok');
        else
            $this->out('100001', 'error');
    }
	


}
