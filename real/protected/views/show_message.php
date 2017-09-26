<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Realh5</title>
        <meta charset="UTF-8" />
    </head>
    <?php if (!$isAjax): ?>
        <!--#logo_area.over-->  
        <style type="text/css">
            .zz_changePage{padding:60px 0;text-align:center;}
            .zz_changePage .wd{padding-bottom:10px;margin-bottom:10px;background:url(<?php echo STATICS ?>portal/images/changePage.gif) center 100% no-repeat;font-size:14px;font-weight:bold;font-family:'Microsoft YaHei';}
        </style>
        <div class="zz_changePage w960" style="margin:0 auto;  padding: 20px;  text-align: center; font-size: 14px;">
            <p class="message wd" style="padding: 20px;"><?php echo $msg['content']; ?></p>
            <?php if ($msg['url'] == 'goback' || $msg['url'] == ''): ?>
                <p>
                    <a href="<?php echo Yii::app()->request->getUrlReferrer(); ?>">返回上一页</a> | <a href="<?php echo U('site/index') ?>">返回首页</a>
                </p>
            <?php else: ?>

                <script type="text/javascript">
                    setTimeout("window.location.href ='<?php echo $msg['url']; ?>'", '<?php echo $msg['time']; ?>');
                </script>
            <?php endif; ?>
        </div>
        <!--#footer-->


    <?php else: ?>
        <style type="text/css">
            .zz_changePage{padding:60px 0;text-align:center;}
            .zz_changePage .wd{padding-bottom:10px;margin-bottom:10px;background:url(<?php echo STATICS ?>portal/images/changePage.gif) center 100% no-repeat;font-size:14px;font-weight:bold;font-family:'Microsoft YaHei';}
        </style>
        <div class="zz_changePage" style="margin:0 auto;  padding: 20px;  text-align: center; font-size: 14px; width:250px">
            <p class="message wd" style="padding: 20px;"><?php echo $msg['content']; ?></p>
        </div>
    <?php endif; ?>