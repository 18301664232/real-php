<div class="logonHead clearfix">
    <p>
        <a href="javascript:;" class="logonHistoryBack">返回</a>
    </p>
    <p>
        <a href="<?php echo U('user/login/login') ?>">想起密码，从这里<span>登录</span></a>
    </p>
</div>
<div class="logonDivider">
    <img class="img-response" src="<?php echo STATICS ?>images/rtLogoSmall.png"/>
</div>
<div class="logonBody">
    <p class="logonTitle">重置密码</p>
    <div class="logonForm">
        <div class="logonBaseSec logonUserName clearfix">
            <input type="text" placeholder="输入手机/邮箱"/>
            <p>手机/邮箱不能为空</p>
        </div>
        <div class="logonBaseSec logonVerifySec clearfix">
            <input type="text" placeholder="输入验证码"/>
            <button class="btn logonVerifyBtn btn-default">发送验证码</button>
            <p>验证码不能为空</p>
        </div>
        <div class="logonSubmit">
            <button class="btn btn-default">下一步</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    //该页面不进行实时验证
    var logonUserNameStr = '';//手机/邮箱文本框内容
    var logonUserNameIsOk = true;//手机/邮箱是否可用
    var logonVerifySecStr = '';//验证码文本框内容
    var logonVerifySecIsOk = true;//验证码是否可用
    var url = '';//ajax请求接口地址

    //失去焦点
    $('.logonUserName > input').blur(function () {//账号失去焦点
        var logonUserNameStr = $(this).val();
        if (logonUserNameStr === '') {
//			$(this).parent().addClass('logonResponse');
//			$(this).parent().find('p').html('请输入手机号/邮箱地址');
        } else if ((!(logonUserNameStr.match(logonEmailReg))) && (!(logonUserNameStr.match(logonPhoneReg)))) {
            $(this).parent().addClass('logonResponse');
            $(this).parent().find('p').html('格式不正确');
        }
    });

    //获得焦点
    $('.logonUserName > input').focus(function () {//账号获得焦点
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!logonUserNameIsOk) {
            $(this).val('');
        }
    });
    $('.logonVerifySec > input').focus(function () {//验证码获得焦点
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!logonVerifySecIsOk) {
            $(this).val('');
        }
    });

    //验证码按钮
    $('.logonVerifyBtn').on('click', function () {
        logonUserNameIsOk = false;
        logonVerifySecIsOk = false;
        url = '<?php echo U('common/ValidateCod/msgcodetime') ?>';
        $.ajax({//检查验证码发送时间
            type: "POST",
            url: url,
            async: false,
            dataType: "json",
            data: {},
            success: function (data) {
                if (data.code == '100002') {
                    regCountDown('.logonVerifyBtn', data.result);
                    //此处还会继续往下执行
                }
            }
        });
//		alert(22);

        logonUserNameStr = $('.logonUserName > input').val();
        url = '<?php echo U('common/ValidateCod/msgcode') ?>';
        $.ajax({//发送验证码
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                username: logonUserNameStr,
                status: 2
            },
            success: function (data) {
                if (data.code == 100001 || data.code == 100004) {
                    $('.logonUserName').removeClass('logonResponse');
                    $('.logonVerifySec').removeClass('logonResponse');
                    regCountDown('.logonVerifyBtn');//倒计时
                    logonUserNameIsOk = true;
                } else if (data.code == 100002 || data.code == 100005) {
                    $('.logonVerifySec > p').html(data.msg);
                    $('.logonVerifySec').addClass('logonResponse');
                } else if (data.code == 100003 || data.code == 100008 || data.code == 100009 || data.code == 100004) {
                    $('.logonUserName').addClass('logonResponse');
                    $('.logonUserName > p').html(data.msg);
                }

            }
        });
    });

    //下一步按钮
    var logonClickDoor = true;
    $('.logonSubmit > button').on('click', function () {
        if (logonClickDoor) {
            logonUserNameStr = $('.logonUserName > input').val();
            logonVerifySecStr = $('.logonVerifySec > input').val();
            logonUserNameIsOk = false;
            logonVerifySecIsOk = false;
            //判断账号文本框内容
            if (logonUserNameStr === '') {
                $('.logonUserName').addClass('logonResponse');
                $('.logonUserName > p').html('手机/邮箱不能为空');
            } else if ((!(logonUserNameStr.match(logonEmailReg))) && (!(logonUserNameStr.match(logonPhoneReg)))) {
                $('.logonUserName').addClass('logonResponse');
                $('.logonUserName > p').html('格式错误');
            } else {//判断账号是否存在
                url = '<?php echo U('user/register/usernameisok') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    async: false,
                    data: {
                        username: logonUserNameStr
                    },
                    success: function (data) {
                        if (data.code == 0) {
                            $('.logonUserName > input').parent().addClass('logonResponse');
                            $('.logonUserName > input').parent().find('p').html('手机/邮箱不存在');
                        } else {
                            logonUserNameIsOk = true;
                        }
                    }
                });
            }

            //判断验证码文本框内容
            if (logonVerifySecStr === '') {
                $('.logonVerifySec').addClass('logonResponse');
                $('.logonVerifySec').find("p").html('验证码不能为空');
            } else {
                url = '<?php echo U('common/ValidateCod/msgcodeisok') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    async: false,
                    data: {
                        username: logonUserNameStr,
                        msgcode: logonVerifySecStr,
                        status: 2
                    },
                    success: function (data) {
                        if (data.code == 0) {
                            $('.logonVerifySec').removeClass('logonResponse');
                            logonVerifySecIsOk = true;
                        } else {
                            $('.logonVerifySec > p').html(data.msg);
                            $('.logonVerifySec').addClass('logonResponse');
                        }
                    }
                });
            }

            if (!logonUserNameIsOk || !logonVerifySecIsOk) {
                return false;
            }

            //提交
            logonClickDoor = false;
            $(this).html('正在跳转');
            $(this).addClass('logonBtnLoad');

            url = '<?php echo U('user/retpwd/check') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    username: logonUserNameStr,
                    msg_code: logonVerifySecStr
                },
                success: function (data) {
                    $('.logonExecSec').html(data.msg);
                    $('.logonExecSec').addClass('logonResponse');
                    if (data.code == 0) {
                        setTimeout(function () {
                            $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnSuccess').html('跳转成功');
                            setTimeout(function () {
                                window.location.href = '<?php echo U('user/retpwd/rpassword') ?>&code=' + data.result.data.code + '&key=' + data.result.data.key;
                            }, 1000)
                        }, 2000)
                    } else {
                        setTimeout(function () {
                            $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnError').html('网络异常');
                            setTimeout(function () {
                                $('.logonSubmit > button').removeClass('logonBtnError').html('下一步');
                                logonClickDoor = true;
                            }, 1000)
                        }, 2000);
                    }
                }
            });
        }
    })
</script>