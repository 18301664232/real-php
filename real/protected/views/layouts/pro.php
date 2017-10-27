<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>RealApp-更高效的传播设计工具-免费H5创意设计-微信营销利器</title>
        <meta name="keywords" contnet="kw"></meta>
        <meta name="description" contnet="des"></meta>
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0 minimum-scale=1.0,user-scalable=no"/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/bootstrap.css"/>
        <link rel="stylesheet" href="<?php echo STATICS ?>css/daterangepicker.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/base.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/mainNav2.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/worktable.css"/>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/preview.css"/>
        <link rel='icon' href='<?php echo STATICS ?>images/favicon.ico'/>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jq.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/c.js"></script>
        <script src="http://www.realplus.cc/lib/js/socket.io.js"></script>



    </head>
    <body>

        <div class="rhOutBox">
            <div class="rhInBox clearfix">
                <p class="rhLogo">
                    <a href="javascript:;">
                        <img src="<?php echo STATICS ?>images/realH5Logo.png"/>
                    </a>
                </p>
                <p class="rhHome">
                    <a href="<?php echo U('site/index/index') ?>"></a>
                </p>
                <ul class="rhItems clearfix">

                    <li <?php if (Yii::app()->controller->id == 'product/product'): ?> class="rhWorkTable rhItemsSelected" <?php endif; ?> ><a href="<?php echo U('product/product/index') ?>">企业工作台</a></li> 
                    <li <?php if (Yii::app()->controller->id == 'user/user'): ?> class="rhWorkTable rhItemsSelected" <?php endif; ?> ><a href="<?php echo U('user/user/info') ?>">账户中心</a></li>
                    <li  <?php if (Yii::app()->controller->id == 'finance/water'): ?> class="rhFinancialManagement rhItemsSelected" <?php endif; ?> ><a href="<?php echo U('finance/water/index') ?>">财务管理</a></li>
                    <li class="rhProjectShow"><a href="<?php echo U('product/product/building') ?>">项目广场</a></li>
                    <li class="rhHelpCenter"><a href="<?php echo U('site/index/help') ?>" <?php if ($this->action->id == 'help'): ?> class="active" <?php endif; ?>>帮助中心</a></li>
                    <!-- <div class="rhItemsSlipper"></div> -->
                </ul>
                <div class="logout"><a href="javascript:void(0)" class="rhUserExit">退出</a></div>
                <div class="rhHead">
                    <!-- <div class="rhHeadInfo">
                            <p class="rhHeadName">milan3243</p>
                            <div class="rhHeadBaseInfo clearfix">
                                    <div class="rhHeadFlow">
                                            <p>流量</p>
                                            <p><span class="rhHeadNum">0</span>&nbsp;<span>G</span></p>
                                    </div>
                                    <div class="rhHeadVer"></div>
                                    <div class="rhHeadPro">
                                            <p>项目</p>
                                            <p><span class="rhHeadNum">10</span>&nbsp;<span>个</span></p>
                                    </div>
                            </div>
                            <ul class="rhHeadMoreInfo clearfix">
                                    <li>
                                            <a href="javascript:;">个人资料</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">个人安全</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">我的收藏</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">我的发布</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">工单管理</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">费用管理</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">发票管理</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">合同管理</a>
                                            
                                    </li>
                                    
                                    <li>
                                            <a href="javascript:;">消息中心</a>
                                            <div class="rhHeadMessageIn"></div>
                                    </li>
                                    
                                    <li>
                                            <a class="rhUserExit" href="javascript:;">退出系统</a>
                                    </li>
                            </ul>
                    </div> -->
                    <a href="javascript:;">
                        <?php if (empty(Yii::app()->session['user']['headimg'])): ?>
                            <img src="<?php echo STATICS ?>images/realH5PersonalSpace.png"/>
                        <?php else: ?>
                            <img src="<?php echo Yii::app()->session['user']['headimg'] ?>"/>
                        <?php endif; ?>

                    </a>

                    <div class="user-list-realapp">
                        <p class="user-name-realapp"><span><?php echo Yii::app()->session['user']['nickname'] ?></span></p>
                        <ul>
                            <li class="my-order">我的订单
                                <i class="red-point active"></i>
                            </li>
                            <li class="message-center"><a href="<?php echo U('user/mail/MailIndex') ?>">消息中心</a>
                                <i class="red-point active"></i>
                            </li>
                            <li class="user-logout">退出登录
                                <i class="red-point"></i>
                            </li>
                        </ul>
                    </div>
                     <div class="rhHeadMessageOut"></div>
                </div>
                <a class="rh-flow-buy" href="<?php echo U('finance/pay/select') ?>">购买</a>
                <a class="rh-flow-last" href="<?php echo U('finance/water/index') ?>">
                    <span class="rh-flow-text">付费流量&nbsp;</span>
                    <span class="rh-flow-num"><?php echo Yii::app()->session['water_count'] ?></span>
                </a>
            </div>
        </div>

        <?php echo $content; ?>

        <!-- 反馈小滑块 -->
        <div class="wtSlideBlock">公开成功</div>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jq.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/bootstrap.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/moment.min.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jquery.daterangepicker.min.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/worktable.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/uploadPreview.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/clipboard.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/farbtastic.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/farbtastic.css"/>

    </body>
</html>
<script>
//用户退出登录的逻辑
    $('.rhUserExit').on('click', function () {
        var wtUserExit = confirm('确定退出？');
        if (wtUserExit == true) {
            url = '<?php echo U('user/login/loginout') ?>';
            $.ajax({
                type: "POST",
                url: url,
                async: false,
                dataType: "json",
                data: {},
                success: function (data) {
                    if (data.code == '0') {
                        window.location.href = '<?php echo REAL ?>';

                    } else {
                        alert('登出失败');
                    }
                }
            });
        }
    });



</script>