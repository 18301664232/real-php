<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/logon.css"/>
<div class="logonHead clearfix">
    <p>
        <a href="javascript:;" class="logonHistoryBack">返回</a>
    </p>
    <p>
            <a href="<?php echo U('user/register/indexs') ?>">还没有帐号，从这里<span>注册<span></a>
    </p>
</div>
<div class="logonDivider">
    <img class="img-response" src="<?php echo STATICS ?>images/rtLogoSmall.png"/>
</div>
<div class="logonBody">
    <p class="logonTitle">登录您的&nbsp;RealApp&nbsp;账号</p>
    <div class="logonForm">
        <div class="logonBaseSec logonUserName clearfix">
            <input type="text" name="username" placeholder="输入手机号码&nbsp;/&nbsp;邮箱&nbsp;"/>
            <p>请输入账号</p>
        </div>
        <div class="logonBaseSec logonUserPassWord clearfix">
            <input type="password" name="password" placeholder="输入密码"/>
            <p>请输入密码</p>
        </div>
        <div class="logonBaseSec logonVerifySec  clearfix">
            <input type="text" placeholder="输入验证码"/>
            <button class="logonVerImgSec">
                <img class="logonVerImgSecImage" src="<?php echo U('common/ValidateCod/user') ?>"/>
            </button>
            <p>请输入验证码</p>
        </div>
        <div class="logonOthers clearfix">
            <input type="checkbox" class="logonLongTime" />
            <p>
                <span>保持登录</span>
                <a href="<?php echo U('user/retpwd/check') ?>">找回密码</a>
            </p>
        </div>
        <div class="logonSubmit">
            <button class="btn btn-default">立即登录</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    var logonUserNameIsTrue = true;//账号是否有误
    var logonVerifySecIsTrue = true;//图片验证码输入是否正确
    var logonUserPassWordIsTrue = true;//密码输入是否正确
    var logonVerifySecIsShow = false;//提交时验证码是否显示
    var logonSubmitWithVerifySec = false;//是否带验证码提交

    $(document).ready(function () {//页面预加载
        var url = '<?php echo U('user/login/IsCheckValidateCodes') ?>';
        $.ajax({
            type: "POST",
            url: url,
            async: false,
            dataType: "json",
            data: {},
            success: function (data) {
                if (data.code == 'show') {
                    logonVerifySecIsShow = true;
                    RefreshlogonVerImgSec();
                    $('.logonVerifySec').css('display', 'block');
                    $('.logonVerifySec > input').val('');
                }
                if (data.code == 'check') {
                    logonVerifySecIsShow = true;
                    logonSubmitWithVerifySec = true;
                    RefreshlogonVerImgSec();
                    $('.logonVerifySec').css('display', 'block');
                    $('.logonVerifySec > input').val('');
                }
            }
        });
    });

    //刷新验证码图片
    function RefreshlogonVerImgSec() {
        var ImgUrl = '<?php echo U('common/ValidateCod/user') ?>' + '&=' + Math.random();
        $('.logonVerImgSecImage').attr('src', ImgUrl);
    }
    $('.logonVerImgSec').on('click', function () {
        RefreshlogonVerImgSec();
    });

    //获得焦点的逻辑
    $('.logonUserName > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        if (!logonUserNameIsTrue) {
            $(this).val('');
        }
    });
    $('.logonUserPassWord > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        if (!logonUserPassWordIsTrue) {
            $(this).val('');
        }
    });
    $('.logonVerifySec > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        if (!logonVerifySecIsTrue) {
            $(this).val('');
        }
    });

    //登录按钮的逻辑
    var logonClickDoor = true;//提交时的门
    $('.logonSubmit > button').on('click', function () {
//		console.log($('.logonLongTime').prop("checked"));//这个是是否保持登录的逻辑值

        if ($('.logonUserName > input').val() === '') {
            $('.logonUserName > p').html('请输入账号');
            $('.logonUserName').addClass('logonResponse');
        }
        if ($('.logonUserPassWord > input').val() === '') {
            $('.logonUserPassWord > p').html('请输入密码');
            $('.logonUserPassWord').addClass('logonResponse');
        }

        if (logonClickDoor) {
            if (($('.logonUserName > input').val() !== '') && ($('.logonUserPassWord > input').val() !== '')) {
                //判断是否 显示/验证 验证码
                IsShowValidateCode();
                if (logonVerifySecIsShow && !logonSubmitWithVerifySec) {
                    RefreshlogonVerImgSec();
                    $('.logonVerifySec').css('display', 'block');
                    $('.logonVerifySec > input').val('');
                    return false;
                }

                if (logonVerifySecIsShow && logonSubmitWithVerifySec && $('.logonVerifySec > input').val() === '') {
                    $('.logonVerifySec > p').html('请输入验证码');
                    $('.logonVerifySec').addClass('logonResponse');
                    return false;
                }
                var username = $('.logonUserName > input').val();
                var password = $('.logonUserPassWord > input').val();
                var url = '<?php echo U('user/login/login') ?>';
                var is_login = $('.logonLongTime').prop("checked");
                var msg_code = $('.logonVerifySec > input').val();

                logonClickDoor = false;
                $(this).html('正在登录');
                $(this).addClass('logonBtnLoad');

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        username: username,
                        password: password,
                        is_login: is_login,
                        msg_code: msg_code
                    },
                    success: function (data) {
                        $('.logonSubmit > button').removeClass('logonBtnLoad').html('重新登录');
                        logonClickDoor = true;
                        if (data.code == '100010' || data.code == '100011') {
                            if (data.code == '100010') {
                                RefreshlogonVerImgSec();
                            }
                            logonVerifySecIsTrue = false;
                            $('.logonVerifySec > p').html(data.msg);
                            $('.logonVerifySec').addClass('logonResponse');
                            return false;
                        }
                        logonVerifySecIsTrue = true;
                        if (data.code == '100007' || data.code == '100003' || data.code == '100004') {
                            logonUserNameIsTrue = false;
                            $('.logonUserName > p').html('账号与密码不匹配');
                            $('.logonUserName').addClass('logonResponse');
                            return false;
                        }
                        logonUserNameIsTrue = true;
                        if (data.code == '100002') {
                            logonUserPassWordIsTrue = false;
                            $('.logonUserPassWord > p').html('密码错误');
                            $('.logonUserPassWord').addClass('logonResponse');
                            return false;
                        }
                        logonUserPassWordIsTrue = true;
                        if (data.code == '100006') {
                            logonClickDoor = false;
                            $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnError').html('网络异常');
                            setTimeout(function () {
                                $('.logonSubmit > button').removeClass('logonBtnError').html('重新登录');
                                logonClickDoor = true;
                            }, 100);
                            return false;
                        }
                        if (data.code == '0') {
                            var pay = '<?php $rs = isset($_GET['token']) ? $_GET['token'] : 'false';  echo $rs;?>';
                            if (pay != 'pay') {
                                window.location.href = '<?php echo U('product/product/index') ?>';
                            } else {
                                window.location.href = '<?php echo U('finance/pay/select') ?>';
                            }

                        }
                    }
                });
            }
        }

        function IsShowValidateCode() {
            var url = '<?php echo U('user/login/IsCheckValidateCode') ?>';
            $.ajax({
                type: "POST",
                url: url,
                async: false,
                dataType: "json",
                data: {},
                success: function (data) {
                    if (data.code == 'show') {
                        logonVerifySecIsShow = true;
                    }
                    if (data.code == 'check') {
                        logonVerifySecIsShow = true;
                        logonSubmitWithVerifySec = true;
                    }
                }
            });
        }

    })

    $(document).keypress(function (event) {
        if (event.keyCode == 13) {
            $('.logonSubmit > button').click();
        }
    })
</script>