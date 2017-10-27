<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'/>
        <title>RealApp-更高效的传播设计工具-免费H5创意设计-微信营销利器</title>
        <link rel='stylesheet' type='text/css' href='<?php echo STATICS ?>css/bootstrap.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo STATICS ?>css/realh5base.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo STATICS ?>css/jquery.scrollbar.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo STATICS ?>css/realh5index.css'/>
        <link rel='stylesheet' type='text/css' href='<?php echo STATICS ?>css/realh5download.css'/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/bill-mode.css"/>
        <script type="text/javascript" src="<?php echo STATICS ?>js/c.js"></script>
        <link rel='icon' href='<?php echo STATICS ?>images/favicon.ico'/>
         <script type="text/javascript" src="<?php echo STATICS?>js/jq.js"></script>
    </head>
    <body>
        <div class="wrapper scrollbar-macosx">
            <div class="scroll-box">
                <!-- 头部 -->

                <div class='head'>
                    <div class="headInner clearfix">
                        <a class="headLogoLink" href="<?php echo U('site/index/index') ?>">
                            <img class="logo" src="<?php echo STATICS ?>images/index-logo.png"/>
                        </a>
                        <ul class="headList clearfix">
                            <li><a href="<?php echo U('site/index/index') ?>" <?php if ($this->action->id == 'index'): ?> class="active" <?php endif; ?>>首页</a></li>
                            <li class="toolDownload"><a href="<?php echo U('site/index/download') ?>" <?php if ($this->action->id == 'download'): ?> class="active" <?php endif; ?>>工具下载</a></li>
                            <li class="itemShow"><a href="<?php echo U('site/index/building') ?>">项目广场</a></li>
                            <li class="billingPlan"><a href="<?php echo U('site/index/mode')  ?>" <?php if ($this->action->id == 'mode'): ?> class="active" <?php endif; ?>>计费模式</a></li>
                            <li class="helpCenter"><a href="<?php echo U('site/index/help') ?>" <?php if ($this->action->id == 'help'): ?> class="active" <?php endif; ?>>帮助中心</a></li>
                            <?php if (isset(Yii::app()->session['user'])): ?>
                                <li class="reisterLogon logoned clearfix">

                                    <a class="nav-userLink" href="<?php echo U('product/product/index') ?>">
                                        <?php if (empty(Yii::app()->session['user']['headimg'])): ?>
                                            <img class="nav-userImg" src="<?php echo STATICS ?>images/realh5-nav-user.png"/>
                                        <?php else: ?>
                                            <img class="nav-userImg" src="<?php echo Yii::app()->session['user']['headimg'] ?>"/>
                                        <?php endif; ?>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="reisterLogon notLogon clearfix">
                                    <a class="register" href="<?php echo U('user/register/indexs') ?>">注册新用户</a>
                                    <a class="logon" href="<?php echo U('user/login/login') ?>">登录</a>

                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <?php echo $content; ?>
                <!-- 底部 -->
                <div class="footer">
                    <div class="index-footer-logo"></div>
                    <p class="index-footer-connect clearfix">
                        <span class="index-footer-phone">联系电话：010-85862024</span>
                        <span class="index-footer-email">邮箱：realapp@moneplus.cn</span>
                    </p>
                    <p class="index-footer-info">
                        <span class="index-footer-company">©2014-2017&nbsp;北京动壹科技有限公司&nbsp;版权所有</span>
                        <span class="index-footer-record">京ICP备11017824号-4&nbsp;/&nbsp;京ICP证130164号</span>
                    </p>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jq.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jquery.scrollbar.min.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/realh5index.js"></script>
        <script>
            $(function () {
                var contentWidth = $('.scroll-box').height();
                var windowsHeight = $(window).height();
                if (contentWidth < windowsHeight) {
                    $('.footer').css({
                        position: 'fixed',
                        bottom: '0',
                        width: '100%'
                    });
                   $('body').css('background', '#ecf1f5');
                }
            })
        </script>
    </body>
</html>