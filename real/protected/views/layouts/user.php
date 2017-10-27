
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RealApp-更高效的传播设计工具-免费H5创意设计-微信营销利器</title>
        <meta name="keywords" contnet="kw"></meta>
        <meta name="description" contnet="des"></meta>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0 minimum-scale=1.0,user-scalable=no"/>		
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/bootstrap.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/logonPublic.css"/>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jq.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/logonPublic.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/c.js"></script>
        <link rel='icon' href='<?php echo STATICS ?>images/favicon.ico'/>
    </head>
    <body>

        <?php echo $content; ?>


    </body>
    <script>
        //左上角回退按钮的逻辑
        $('.logonHistoryBack').on('click', function () {
            window.history.back();
        });

        //密码输入框控制密码明文和暗纹的逻辑
        $('.logonPasswordSwitch').focus(function () {
            if ($(this).parent().hasClass('logonResponse')) {
                $(this).parent().removeClass('logonResponse');
            } else {

            }
            $(this).parent().removeClass('logonResponse');
        });

        $('.logonPasswordSwitch').on('click', function () {
            if ($(this).parent().find('.logonPasswordInput').attr('type') === 'password') {
                $(this).parent().find('.logonPasswordInput').attr('type', 'text');
                $(this).css('background-image', 'url("<?php echo STATICS ?>/images/logonPasswordShow.png")');
                $(this).css('background-position', '2px 4px');
            } else {
                $(this).parent().find('.logonPasswordInput').attr('type', 'password');
                $(this).css('background-image', 'url("<?php echo STATICS ?>/images/logonPasswordHidden.png")');
                $(this).css('background-position', '1px 3px');
            }
        });
    </script>
</html>
