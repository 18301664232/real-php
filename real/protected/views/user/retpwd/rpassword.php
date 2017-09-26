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
    <p class="logonTitle">确认密码</p>
    <div class="logonForm">
        <div class="logonBaseSec logonUserPassWord logonUserPassWordNew clearfix">
            <input class="logonPasswordInput" type="password" placeholder="输入新密码"/>
            <p>请输入新密码</p>
            <button class="logonPasswordSwitch"></button>
        </div>
        <div class="logonBaseSec logonUserPassWord logonUserPassWordCertain clearfix">
            <input class="logonPasswordInput" type="password" placeholder="确认密码"/>
            <p>请再次输入新密码</p>
            <button class="logonPasswordSwitch"></button>
        </div>
        <div class="logonSubmit">
            <button class="btn btn-default">提交</button>
        </div>
    </div>
</div>
<script type="text/javascript">
    var Pwd1IsOk = false;//密码1
    var Pwd2IsOk = false;//密码2

    //获得焦点的逻辑
    $('.logonUserPassWordNew > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!Pwd1IsOk) {
            $(this).val('');
        }
    });
    $('.logonUserPassWordCertain > input').focus(function () {
        $(this).parent().removeClass('logonResponse');
        $('.logonExecSec').removeClass('logonResponse');
        if (!Pwd2IsOk) {
            $(this).val('');
        }
    });

    //失去焦点的逻辑
    $('.logonUserPassWordNew > input').blur(function () {
        Pwd1IsOk = false;
        if ($('.logonUserPassWordNew > input').val() === '') {
//			$('.logonUserPassWordNew > p').html('请输入新密码');
//			$('.logonUserPassWordNew').addClass('logonResponse');
        } else if (!$('.logonUserPassWordNew > input').val().match(logonPassWordReg)) {
            $('.logonUserPassWordNew > p').html('输入密码，6-16位数字、字母组合');
            $('.logonUserPassWordNew').addClass('logonResponse');
        } else {
            Pwd1IsOk = true;
            $(this).parent().removeClass('logonResponse');
            $('.logonExecSec').removeClass('logonResponse');
        }
    });
    $('.logonUserPassWordCertain > input').blur(function () {
        Pwd2IsOk = false;
        if ($('.logonUserPassWordCertain > input').val() === '') {
//			$('.logonUserPassWordCertain > p').html('请再次输入新密码');
//			$('.logonUserPassWordCertain').addClass('logonResponse');
        } else if (!$('.logonUserPassWordCertain > input').val().match(logonPassWordReg)) {
            $('.logonUserPassWordCertain > p').html('输入密码，6-16位数字、字母组合');
            $('.logonUserPassWordCertain').addClass('logonResponse');
        } else if ($('.logonUserPassWordCertain > input').val() !== $('.logonUserPassWordNew > input').val()) {
            $('.logonUserPassWordCertain > p').html('与新密码不一致');
            $('.logonUserPassWordCertain').addClass('logonResponse');
        } else {
            Pwd2IsOk = true;
            $(this).parent().removeClass('logonResponse');
            $('.logonExecSec').removeClass('logonResponse');
        }
    });

    //提交按钮的逻辑
    var logonClickDoor = true;
    $('.logonSubmit > button').on('click', function () {
        if (logonClickDoor) {
            Pwd1IsOk = false;
            if ($('.logonUserPassWordNew > input').val() === '') {
                $('.logonUserPassWordNew > p').html('请输入新密码');
                $('.logonUserPassWordNew').addClass('logonResponse');
            } else if (!$('.logonUserPassWordNew > input').val().match(logonPassWordReg)) {
                $('.logonUserPassWordNew > p').html('输入密码，6-16位数字、字母组合');
                $('.logonUserPassWordNew').addClass('logonResponse');
            } else {
                Pwd1IsOk = true;
            }

            if ($('.logonUserPassWordCertain > input').val() === '') {
                Pwd2IsOk = false;
                $('.logonUserPassWordCertain > p').html('请再次输入新密码');
                $('.logonUserPassWordCertain').addClass('logonResponse');
            }

            if ((!($('.logonUserPassWordNew > input').val() === '')) && (!($('.logonUserPassWordCertain > input').val() === ''))) {
                if ($('.logonUserPassWordNew > input').val().match(logonPassWordReg)) {
                    if ($('.logonUserPassWordNew > input').val() === $('.logonUserPassWordCertain > input').val()) {

                        if (!Pwd1IsOk || !Pwd2IsOk) {
                            return false;
                        }
                        logonClickDoor = false;
                        $(this).html('正在提交');
                        $(this).addClass('logonBtnLoad');

                        var password = $('.logonUserPassWordNew > input').val();
                        var rpassword = $('.logonUserPassWordCertain > input').val();
                        var code = '<?php echo!empty($_REQUEST['code']) ? $_REQUEST['code'] : '' ?>';
                        var url = '<?php echo U('user/retpwd/rpassword') ?>';
                        $.ajax({
                            type: "POST",
                            url: url,
                            dataType: "json",
                            data: {
                                password: password,
                                rpassword: rpassword,
                                code: code
                            },
                            success: function (data) {
                                $('.logonExecSec').html(data.msg);
                                $('.logonExecSec').addClass('logonResponse');
                                if (data.code == 0) {
                                    setTimeout(function () {
                                        $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnSuccess').html('提交成功');
                                        setTimeout(function () {
                                            window.location.href = '<?php echo U('user/login/login') ?>';
                                        }, 1000)
                                    }, 2000);
                                } else if (data.code == '100004') {
                                    setTimeout(function () {
                                        $('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnError').html('网络异常');
                                        setTimeout(function () {
                                            $('.logonSubmit > button').removeClass('logonBtnError').html('重新提交');
                                            logonClickDoor = true;
                                        }, 1000)
                                    }, 2000)
                                } else {
                                    Pwd1IsOk = false;
                                    Pwd2IsOk = false;
                                    $('.logonUserPassWordNew > p').html(data.msg);
                                    $('.logonUserPassWordNew').addClass('logonResponse');
                                    $('.logonUserPassWordCertain > p').html(data.msg);
                                    $('.logonUserPassWordCertain').addClass('logonResponse');
                                    setTimeout(function () {
//										$('.logonSubmit > button').removeClass('logonBtnLoad').addClass('logonBtnError').html('网络异常');
                                        setTimeout(function () {
                                            $('.logonSubmit > button').removeClass('logonBtnLoad').removeClass('logonBtnError').html('重新提交');
                                            logonClickDoor = true;
                                        }, 1000)
                                    }, 2000)
                                }
                            }
                        });

                    } else {
                        Pwd2IsOk = false;
                        $('.logonUserPassWordCertain > p').html('与新密码不一致');
                        $('.logonUserPassWordCertain').addClass('logonResponse');
                    }
                }
            }
        }
    });
</script>