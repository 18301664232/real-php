
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="UTF-8">
        <title>cms管理系统</title>

        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/login.css">
        <script src="<?php echo STATICSADMIN ?>js/jquery.min.js"></script>
        <script src="<?php echo STATICSADMIN ?>js/bootstrap.min.js"></script>

        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/style.css">
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/dermadefault.css">
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/toggle_column.css">
        <script src="<?php echo STATICSADMIN ?>ueditor/utf8/ueditor.config.js"></script>
        <script src="<?php echo STATICSADMIN ?>ueditor/utf8/ueditor.all.min.js"></script>
        <script src="<?php echo STATICSADMIN ?>ueditor/utf8/lang/zh-cn/zh-cn.js"></script>
        <script src="<?php echo STATICSADMIN ?>js/common.js"></script>
        <script src='<?php echo STATICSADMIN ?>js/header-nav.js'></script>
        <script src='<?php echo STATICSADMIN ?>js/toggle_column.js'></script>
        <script src='<?php echo STATICSADMIN ?>javascript/product_common_url.js'></script>
        <script src='<?php echo STATICSADMIN ?>javascript/DateFormat.js'></script>
    </head>
    <body>
        <nav class="nav navbar-default navbar-mystyle navbar-fixed-top">
            <div class="navbar-header">
                <button class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                    <span class="icon-bar"></span> 
                </button>
                <a class="navbar-brand mystyle-brand"><span class="glyphicon glyphicon-home"></span></a> </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="li-border"><a class="mystyle-color" href="javascript:void(0)">管理控制台</a></li>
                </ul>

                <ul class="nav navbar-nav pull-right">
                    <li class="dropdown li-border"><a href="javascript:void(0)" class="dropdown-toggle mystyle-color" data-toggle="dropdown"><?php echo Yii::app()->session['admin']['username'] ?><span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a id="loginout" href="javascript:void(0)">退出</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="down-main">
            <div class="left-main left-full">
                <div class="subNavBox">
                    <div class="sBox">
                        <div class="subNav subNav0 sublist-down "><span class="title-icon glyphicon"></span><span class="sublist-title "><a href="<?php echo U('admin/index/index') ?>">网站分析</a></span>
                        </div>
                    </div>
                </div>


                <div class="subNavBox <?php if (($this->checkAuth('admin/user/list')) && ($this->checkAuth('admin/user/edit')) && ($this->checkAuth('admin/user/data'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav1 sublist-down"><span class="title-icon glyphicon"></span><span class="sublist-title"><a href="<?php echo U('admin/user/list') ?>">用户管理</a></span>
                        </div>
                    </div>
                </div>

                <div class="subNavBox <?php if (($this->checkAuth('admin/switchover/add')) && ($this->checkAuth('admin/switchover/edit'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav11 sublist-down">
                            <span class="title-icon glyphicon glyphicon-chevron-down"></span>
                            <span class="sublist-title">效果配置</span>
                        </div>
                        <ul class="navContent navContent0 " style="display:none">
                            <li class="selfli0">
                                <a href="<?php echo U('admin/switchover/list') ?>"><span class="sub-title">切换栏目</span></a>
                            </li>
                            <li class="selfli1">
                                <a href="<?php echo U('admin/music/list') ?>"><span class="sub-title">音效栏目</span></a>
                            </li>


                        </ul>
                    </div>
                </div>
                <div class="subNavBox <?php if (($this->checkAuth('admin/auth/edit')) && ($this->checkAuth('admin/auth/list')) && ($this->checkAuth('admin/auth/add'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav2 sublist-down">
                            <span class="title-icon glyphicon glyphicon-chevron-down"></span>
                            <span class="sublist-title">员工管理</span>
                        </div>
                        <ul class="navContent navContent11 " style="display:none">
                            <li class="selfli2">
                                <a href="<?php echo U('admin/Auth/list') ?>"><span class="sub-title">帐号管理</span></a>
                            </li>
                            <li class="selfli3">
                                <a href="<?php echo U('admin/Role/list') ?>"><span class="sub-title">角色管理</span></a>
                            </li>


                        </ul>
                    </div>
                </div>

                <div class="subNavBox <?php if (($this->checkAuth('admin/product/edit')) && ($this->checkAuth('admin/product/list'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav3 sublist-down"><span class="title-icon glyphicon glyphicon-chevron-down"></span><span class="sublist-title">项目管理</span>
                        </div>
                        <ul class="navContent navContent2" style="display:none">
                            <li class="selfli4">
                                <a href="<?php echo U('admin/product/list') ?>"><span class="sub-title">查看项目</span></a>
                            </li>
                            <li class="selfli5">
                                <a href="<?php echo U('admin/video/list') ?>"><span class="sub-title">项目审核</span></a>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="subNavBox <?php if (($this->checkAuth('admin/order/list')) && ($this->checkAuth('admin/order/edit'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav4 sublist-down"><span class="title-icon glyphicon"></span><span class="sublist-title"><a href="<?php echo U('admin/order/list', array('type' => '会员账号', 'status' => 1)) ?>">工单管理</a></span>
                        </div>
                    </div>
                </div>
                <div class="subNavBox  <?php if (($this->checkAuth('admin/flow/edit')) && ($this->checkAuth('admin/flow/add'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav5 sublist-down"><span class="title-icon glyphicon"></span><span class="sublist-title"><a href="<?php echo U('admin/flow/list') ?>">流量包管理</a></span>
                        </div>
                    </div>
                </div>
                <div class="subNavBox  <?php if (($this->checkAuth('admin/mail/list')) && ($this->checkAuth('admin/mail/edit')) && ($this->checkAuth('admin/mail/add'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav6 sublist-down"><span class="title-icon glyphicon"></span><span class="sublist-title"><a href="<?php echo U('admin/mail/list') ?>">消息管理</a></span>
                        </div>
                    </div>
                </div>
                <div class="subNavBox <?php if (($this->checkAuth('admin/help/list')) && ($this->checkAuth('admin/help/edit')) && ($this->checkAuth('admin/help/add'))){echo 'hide';}?>">
                    <div class="sBox">
                        <div class="subNav subNav7 sublist-down"><span class="title-icon glyphicon"></span><span class="sublist-title"><a href="<?php echo U('admin/help/list') ?>">帮助中心管理</a></span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="right-product my-index right-full">

            <?php echo $content; ?>
        </div>   
    </div>

</body>
</html>

<script>
//用户退出登录的逻辑
    $('#loginout').on('click', function () {
        var wtUserExit = confirm('确定退出？');
        if (wtUserExit == true) {
            url = '<?php echo U('admin/login/loginout') ?>';
            $.ajax({
                type: "POST",
                url: url,
                async: false,
                dataType: "json",
                data: {},
                success: function (data) {
                    if (data.code == '0') {
                        window.location.href = '<?php echo U('admin/login/login') ?>';

                    } else {
                        alert('登出失败');
                    }
                }
            });
        }
    });

    switch ('<?php echo $this->id ?>'){
        case 'admin/product':
            $('.selfli4').addClass('active').siblings().removeClass('active');
            $('.subNav3').addClass('sublist-up');
            $('.navContent2').show();
        break;
        case 'admin/video':
            $('.selfli5').addClass('active').siblings().removeClass('active');
            $('.subNav3').addClass('sublist-up');
            $('.navContent2').show();
            break;
        case 'admin/switchover':
            $('.selfli0').addClass('active').siblings().removeClass('active');
            $('.subNav11').addClass('sublist-up');
            $('.navContent0').show();
            break;
        case 'admin/music':
            $('.selfli1').addClass('active').siblings().removeClass('active');
            $('.subNav11').addClass('sublist-up');
            $('.navContent0').show();
            break;
        case 'admin/index':
            $('.subNav0').addClass('sublist-up');
            break;
        case 'admin/user':
            $('.subNav1').addClass('sublist-up');
            break;
        case 'admin/order':
            $('.subNav4').addClass('sublist-up');
            break;
        case 'admin/flow':
            $('.subNav5').addClass('sublist-up');
            break;
        case 'admin/mail':
            $('.subNav6').addClass('sublist-up');
            break;
        case 'admin/help':
            $('.subNav7').addClass('sublist-up');
            break;
        case 'admin/auth':
            $('.selfli2').addClass('active').siblings().removeClass('active');
            $('.subNav2').addClass('sublist-up');
            $('.navContent11').show();
            break;
        case 'admin/role':
            $('.selfli3').addClass('active').siblings().removeClass('active');
            $('.subNav2').addClass('sublist-up');
            $('.navContent11').show();
            break;
    }


</script>



