<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/register.css"/>
<div class="logonHead clearfix">
    <p>
        <a href="javascript:;" class="logonHistoryBack">返回</a>
    </p>
    <p>
        <a href="<?php echo U('user/login/login') ?>">已有账户，从这里<span>登录</span></a>
    </p>
</div>
<div class="logonDivider">
    <img class="img-response" src="<?php echo STATICS ?>images/rtLogoSmall.png"/>
</div>
<div class="logonBody">
    <p class="logonTitle">注册您的&nbsp;RealApp&nbsp;账号</p>
    <div class="logonForm">
        <div class="logonBaseSec logonUserName clearfix">
            <input type="text" placeholder="输入手机/邮箱"/>
            <p>请输入手机号码/邮箱</p>
        </div>
        <div class="logonBaseSec logonVerifySec  clearfix">
            <input type="text" placeholder="输入验证码"/>
            <button class="btn logonVerifyBtn btn-default">发送验证码</button>
            <p>请输入验证码</p>
        </div>
        <div class="logonBaseSec logonUserPassWord clearfix">
            <input class="logonPasswordInput" type="password" placeholder="输入密码，6-16位数字、字母组合"/>
            <p>输入密码，6-16位数字、字母组合</p>
            <button class="logonPasswordSwitch"></button>
        </div>
        <div class="logonOthers clearfix">
            <input type="checkbox" class="logonAgreement" checked/>
            <p>我已阅读并同意&nbsp;<a href="<?php echo STATICS.'用户协议.pdf'?>" target="_blank">《用户协议》</a></p>
        </div>
        <div class="logonSubmit">
            <button class="btn btn-default">提交</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    //该页面要进行实时验证
    var logonUserNameStr = '';//账号文本框内容
    var logonUserNameIsOk = false;//手机/邮箱是否可用
    var logonVerifySecStr = '';//验证码本框内容
    var logonVerifySecIsOk = false;//验证码是否可用
    var url = '';//ajax请求的地址

    $(document).ready(function () {//页面预加载
    });

    //失去焦点的逻辑
    $('.logonUserName > input').blur(function () {
        logonUserNameStr = $('.logonUserName > input').val();
        logonUserNameIsOk = false;
        if ($(this).val() === '') {
//			$(this).parent().addClass('logonResponse');
//			$(this).parent().find('p').html('请输入手机号/邮箱地址');
        } else if ((!($(this).val().match(logonEmailReg))) && (!($(this).val().match(logonPhoneReg)))) {
            $(this).parent().addClass('logonResponse');
            $(this).parent().find('p').html('格式不正确');
        } else {//判断手机或邮箱是否存在
            url = '<?php echo U('user/register/usernameisok') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    username: logonUserNameStr
                },
                success: function (data) {
                    if (data.code == 0) {
                        logonUserNameIsOk = true;
                    } else {
                        $('.logonUserName > input').parent().addClass('logonResponse');
                        $('.logonUserName > input').parent().find('p').html('已存在');
                    }
                }
            });
        }
    });

    $('.logonVerifySec > input').blur(function () {
        logonUserNameStr = $('.logonUserName > input').val();
        logonVerifySecStr = $(this).val();
        logonVerifySecIsOk = false;
        if ($(this).val() === '') {
//			$(this).parent().addClass('logonResponse');
//			$(this).parent().find('p').html('请输入邮箱地址');
        } else {//判断验证码是否正确
            url = '<?php echo U('common/ValidateCod/msgcodeisok') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    msgcode: logonVerifySecStr,
                    username: logonUserNameStr
                },
                success: function (data) {
                    if (data.code == 0) {
                        $('.logonVerifySec').removeClass('logonResponse');
                        logonVerifySecIsOk = true;
                    } else if (data.code == '100012') {//验证码不存在
                    } else {
                        $('.logonVerifySec > p').html(data.msg);
                        $('.logonVerifySec').addClass('logonResponse');
                    }
                }
            });
        }
    });
    $('.logonUserPassWord > input').blur(function () {
        if ($(this).val() == '') {
            return false;
        }
        ValidatePasswordFormat();
    });

    //获得焦点的逻辑
    $('.logonUserName > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!logonUserNameIsOk) {
            $(this).val('');
        }
    });
    $('.logonVerifySec > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!logonVerifySecIsOk) {
            $(this).val('');
        }
    });
    $('.logonUserPassWord > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!$('.logonUserPassWord > input').val().match(logonPassWordReg)) {
            $(this).val('');
        }
    });

    //验证码按钮的逻辑
    $('.logonVerifyBtn').on('click', function () {
        if (!logonUserNameIsOk) {
            return false;
        }//判断邮箱是否正确
        logonUserNameStr = $('.logonUserName > input').val();
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

//		alert(2);
        var type = 1;
        url = '<?php echo U('common/ValidateCod/msgcode') ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            data: {
                username: logonUserNameStr,
                type: type
            },
            success: function (data) {
                if (data.code == 100001 || data.code == 100004) {
                    $('.logonUserName').removeClass('logonResponse');
                    $('.logonVerifySec').removeClass('logonResponse');
                    regCountDown('.logonVerifyBtn');//倒计时
                    logonVerifySecIsOk = true;
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

    //复选框勾选用户协议的逻辑
    $('.logonAgreement').on('change', function () {
        if ($(this).prop('checked')) {
            $('.logonSubmit > button').removeClass('btnForbiddenClick')
        } else {
            $('.logonSubmit > button').addClass('btnForbiddenClick');
        }
    });

    //提交按钮的逻辑
    var logonClickDoor = true;
    $('.logonSubmit > button').on('click', function () {
        //最外层判断用户是否勾选用户协议用的
        if ($('.logonAgreement').prop('checked')) {
            if (logonClickDoor) {
                logonUserNameStr = $('.logonUserName > input').val();
                logonVerifySecStr = $('.logonVerifySec > input').val();
                logonUserNameIsOk = false;
                logonVerifySecIsOk = false;
                if (logonUserNameStr === '') {
                    $('.logonUserName').addClass('logonResponse');
                    $('.logonUserName > p').html('请输入手机号/邮箱地址');
                } else if ((!(logonUserNameStr.match(logonEmailReg))) && (!(logonUserNameStr.match(logonPhoneReg)))) {
                    $('.logonUserName').addClass('logonResponse');
                    $('.logonUserName > p').html('格式不正确');
                } else {
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
                                logonUserNameIsOk = true;
                            } else {
                                $('.logonUserName > input').parent().addClass('logonResponse');
                                $('.logonUserName > input').parent().find('p').html('已存在');
                            }
                        }
                    });
                }

                if (logonVerifySecStr === '') {//判断验证码是否正确
                    $('.logonVerifySec > p').html('请输入验证码');
                    $('.logonVerifySec').addClass('logonResponse');
                } else {
                    url = '<?php echo U('common/ValidateCod/msgcodeisok') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        async: false,
                        data: {
                            msgcode: logonVerifySecStr,
                            username: logonUserNameStr
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                $('.logonVerifySec').removeClass('logonResponse');
                                logonVerifySecIsOk = true;
                            } else if (data.code == '100012') {//验证码不存在
                            } else {
                                $('.logonVerifySec > p').html(data.msg);
                                $('.logonVerifySec').addClass('logonResponse');
                            }
                        }
                    });
                }

                ValidatePasswordFormat();
                if (!logonUserNameIsOk || !logonVerifySecIsOk) {
                    return false;
                }

                if (($('.logonUserName > input').val() !== '') && (($('.logonUserName > input').val().match(logonEmailReg)) || ($('.logonUserName > input').val().match(logonPhoneReg))) && ($('.logonVerifySec > input').val() !== '') && ($('.logonUserPassWord > input').val() !== '') && ($('.logonUserPassWord > input').val().length >= 6) && ($('.logonUserPassWord > input').val().match(logonPassWordReg))) {

                    logonClickDoor = false;
                    $(this).html('正在提交');
                    $(this).addClass('logonBtnLoad');

                    var username = $('.logonUserName > input').val();
                    var password = $('.logonUserPassWord > input').val();
                    var msg_code = $('.logonVerifySec > input').val();
                    var is_read = 1;
                    var type = 1;
                    var url = '<?php echo U('user/register/indexs') ?>';

                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            username: username,
                            password: password,
                            msg_code: msg_code,
                            is_read: is_read,
                            type: type
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                setTimeout(function () {
                                    $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnSuccess').html('提交成功');
                                    setTimeout(function () {
                                        window.location.href = '<?php echo U('product/product/index') ?>';
                                    }, 1000)
                                }, 2000);
                            } else {
                                $('.logonExecSec').html(data.msg);
                                $('.logonExecSec').addClass('logonResponse');
                                setTimeout(function () {
                                    $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnError').html('网络异常');
                                    setTimeout(function () {
                                        $('.logonSubmit > button').removeClass('logonBtnError').html('重新提交');
                                        logonClickDoor = true;
                                    }, 1000)
                                }, 2000)
                            }

                        }
                    });

                }
            }
        }

    })

    $(document).keypress(function (event) {
        if (event.keyCode == 13) {
            $('.logonSubmit > button').click();
        }
    })

</script>