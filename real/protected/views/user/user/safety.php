<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/account-center.css">
<body>
    <div class="title-sec">
        <div class="title-box clearfix">
            <p class="title-text">账户中心</p>
            <ul class="title-list">
                <li ><a href="<?php echo U('user/user/info') ?>">账户资料</a></li>
                <li  class="title-current"><a href="<?php echo U('user/user/safety') ?>">账户安全</a></li>
                <li><a href="<?php echo U('user/user/workorder') ?>">工单管理</a></li>
            </ul>
        </div>
    </div>
    <div class="sec-sec">
        <ul class="sec-title nav nav-tabs">
            <li role="presentation" class="active"><a href="#change-password" role="tab" data-toggle="tab">修改密码</a></li>
            <li role="presentation"><a href="#change-bind" role="tab" data-toggle="tab">更换绑定</a></li>
        </ul>
        <div class="sec-content tab-content">
            <div id="change-password" role="tabpanel" class="tab-pane active sec-pd">
                <div class="sec-pd-box">
                    <p class="base-p">旧密码:</p>
                    <div class="base-input-box clearfix">
                        <input type="password" placeholder="" class="base-input sec-old-pd">
                        <p class="base-input-fb">旧密码输入错误</p>
                    </div>
                    <p class="base-p">新密码:</p>
                    <div class="base-input-box clearfix">
                        <input type="password" placeholder="请输入6-16位密码" disabled class="base-input sec-new-pd">
                        <p class="base-input-fb">密码不合规</p>
                    </div>
                    <p class="base-p">确认密码:</p>
                    <div class="base-input-box clearfix">
                        <input type="password" placeholder="请输入6-16位密码" disabled class="base-input sec-new-certain">
                        <p class="base-input-fb">与新密码不一致</p>
                    </div>
                    <button class="base-btn sec-change-pd-btn">保存</button>
                </div>
            </div>
            <div id="change-bind" class="tab-pane sec-bind">
                <div class="sec-bind-step1">
                    <p class="sec-current-num">当前账号绑定：<?php echo $data ?></p>
                    <p class="base-p">输入验证码</p>
                    <div class="sec-bind-step1-box clearfix">
                        <input type="text" class="base-input sec-bind-step1-verify">
                        <button class="base-btn sec-bind-step1-btn">发送验证码</button>
                        <p class="base-input-fb">输入验证码有错误</p>
                    </div>
                    <button disabled class="base-btn base-btn-forbi sec-bind-step1-next">下一步</button>
                </div>
                <div class="sec-bind-step2">
                    <p class="base-p">输入新的手机号或邮箱</p>
                    <div class="base-input-box sec-bind-step2-phone clearfix">
                        <input type="text" class="base-input sec-bind-step2-phone-input">
                        <p class="base-input-fb"></p>
                    </div>
                    <p class="base-p">输入验证码</p>
                    <div class="base-input-box sec-bind-step2-verify clearfix">
                        <input type="text" class="base-input sec-bind-step2-verify-input">
                        <button class="base-btn sec-bind-step2-btn">发送验证码</button>
                        <p class="base-input-fb">验证码输入错误</p>
                    </div>
                    <button class="base-btn sec-bind-step2-save">保存</button>
                </div>
            </div>
        </div>
    </div>
    <div class="wtSlideBlock"></div>

    <script type="text/javascript">
        //获取和设置cookie的逻辑
        function setCookie(cname, cvalue, exdays) {
            var d = new Date();
            d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
            var expires = "expires=" + d.toGMTString();
            document.cookie = cname + "=" + cvalue + "; " + expires;
        }

        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i].trim();
                if (c.indexOf(name) == 0) {
                    return c.substring(name.length, c.length);
                }
            }
            return "";
        }
        //反馈小滑块
        var wtSlideBlockDoor = true;
        function wtSlideBlock(text, backgroundImgDoor) {
            if (wtSlideBlockDoor) {
                if (backgroundImgDoor) {
                    $('.wtSlideBlock').addClass('wtSlideBlockFalse');
                } else {
                    $('.wtSlideBlock').removeClass('wtSlideBlockFalse');
                }
                $('.wtSlideBlock').html(text);
                $('.wtSlideBlock').css('left', ((($(window).width() - $('.wtSlideBlock').width()) / 2) | 0) + 'px');
                wtSlideBlockDoor = false;
                $('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState1');
                setTimeout(function () {
                    $('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState2');
                    wtSlideBlockDoor = true;
                }, 1300);
            }
        }
        //计时器相关逻辑
        function RhaCountDown(btn, className) {
            this.defaultCount = 60;
            this.checkDoor = true;
            this.btn = btn;
            this.className = className;
        }
        RhaCountDown.prototype.begin = function (time, cb) {
            if (this.checkDoor) {
                this.checkDoor = false;
                this.count = time || this.defaultCount;
                $(this.btn).attr('disabled', 'disabled');
                $(this.btn).html(this.count + '秒');
                $(this.btn).addClass(this.className);
                this.timer = setInterval(function () {
                    --this.count;
                    $(this.btn).html(this.count + '秒');
                    setCookie('actime', this.count);
                    if (this.count === 0) {
                        this.checkDoor = true;
                        $(this.btn).attr('disabled', null);
                        clearInterval(this.timer);
                        $(this.btn).html('发送验证码');
                        this.count = time = this.defaultCount;
                        $(this.btn).removeClass(this.className);
                        if (cb) {
                            cb();
                        }
                    }
                }.bind(this), 1000);
            }
        }

        //账户安全的修改密码
        //验证旧密码的逻辑
        var checkNewPassWord = /^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{6,}$/;
        var door = true;//表示旧密码是否正确的布尔值
        $('.sec-old-pd').on('blur', function () {
            //ajax验证旧密码是否正确
            if (door) {
                $('.sec-new-pd').prop('disabled', null).focus();
                $('.sec-new-certain').prop('disabled', null);
            } else {
                $(this).parent().addClass('base-input-box-fb');
            }
        });

        $('.sec-new-pd').on('blur', function () {
            if ($('.sec-old-pd').val() === $('.sec-new-pd').val()) {
                $('.sec-new-pd').parent().addClass('base-input-box-fb');
            }
        });
        //保存按钮的逻辑
        $('.sec-change-pd-btn').on('click', function () {
            if (door) {
                var passWorldCorrect = false;
                var checkNewPassWordResult = checkNewPassWord.test($('.sec-new-pd').val());
                var checkNewPassWordResultAgain = checkNewPassWord.test($('.sec-new-certain').val());
                if (!checkNewPassWordResult) {
                    $('.sec-new-pd').parent().addClass('base-input-box-fb');
                }
                if ($('.sec-new-pd').val() === $('.sec-new-certain').val()) {
                    passWorldCorrect = true;
                } else {
                    $('.sec-new-certain').parent().addClass('base-input-box-fb');
                }

                if (checkNewPassWordResult && passWorldCorrect) {
                    //ajax发送
                    var url = '<?php echo U('user/user/Updatepwd') ?>';
                    var o_password = $('.sec-old-pd').val();
                    var n_password = $('.sec-new-pd').val();
                    var r_password = $('.sec-new-certain').val();
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            o_password: o_password,
                            n_password: n_password,
                            r_password: r_password,
                        },
                        success: function (data) {
                            $('.sec-old-pd').parent().removeClass('base-input-box-fb');
                            $('.sec-new-pd').parent().removeClass('base-input-box-fb');
                            $('.sec-new-certain').parent().removeClass('base-input-box-fb');

                            if (data.code == 0) {//ajax成功时
                                $('.sec-old-pd').val('');
                                $('.sec-new-pd').val('');
                                $('.sec-new-certain').val('');
                                wtSlideBlock('密码修改成功');
                            }
                            if (data.code == 100003) {
                                $('.sec-old-pd').parent().addClass('base-input-box-fb');
                            }
                            if (data.code == 100002) {
                                $('.sec-new-pd').parent().addClass('base-input-box-fb');
                                $('.sec-new-certain').parent().addClass('base-input-box-fb');
                            } else {//ajax失败的时候

                            }
                        }
                    });

                }
            }
        });
        //输入框获得焦点移除反馈状态
        $('.sec-old-pd,.sec-new-pd,.sec-new-certain').on('click', function () {
            $(this).parent().removeClass('base-input-box-fb');
        });
        //账户安全的更换绑定逻辑
        var step1VerifyBtn = new RhaCountDown('.sec-bind-step1-btn', 'base-btn-forbi');
        $('.sec-bind-step1-btn').on('click', function () {
            var url = '<?php echo U('common/ValidateCod/msgcode') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    username: '<?php echo $data ?>',
                    status: 2
                },
                success: function (data) {
                    if (data.code == 100001 || data.code == 100004) {
                        step1VerifyBtn.begin(60);
                    }
                }

            });
        });

        $('.sec-bind-step1-verify').on('blur', function () {
            var inputValue = $.trim($(this).val());
            if (inputValue.length !== 0) {

            } else {
                $(this).parent().addClass('base-input-box-fb');
            }
        });
        $('.sec-bind-step1-verify').on('focus', function () {
            $(this).parent().removeClass('base-input-box-fb');
        });
        $('.sec-bind-step1-verify').on('input', function () {
            var inputValue = $.trim($(this).val());
            if (inputValue.length !== 0) {
                $('.sec-bind-step1-next').removeClass('base-btn-forbi');
                $('.sec-bind-step1-next').prop('disabled', null);
            }
        });
        $('.sec-bind-step1-next').on('click', function () {
            //这里要发送ajax,把验证码发送到后台
            //success就进行下一步的操作
            //error就反馈错误
            var url = '<?php echo U('common/ValidateCod/Msgcoderead') ?>';
            var msgcode = $('.sec-bind-step1-verify').val();
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                async: false,
                data: {
                    msgcode: msgcode,
                    username: '<?php echo $data ?>',
                    status: 2
                },
                success: function (data) {
                    if (data.code == 0) {
                        $('.sec-bind-step1').hide();
                        $('.sec-bind-step2').show();
                    } else {
                        $('.sec-bind-step1-box').addClass('base-input-box-fb');
                    }
                }
            });

        });
        var acCheckEmail = /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
        var acCheckPhone = /^1[3|4|5|7|8][0-9]{9}$/;
        //更换绑定第二步逻辑
        var step2VerifyBtn = new RhaCountDown('.sec-bind-step2-btn', 'base-btn-forbi');
        $('.sec-bind-step2-btn').on('click', function () {
            //点击之后，ajax验证账号是否已经被使用
            //已经使用就反馈，没有使用开始倒计时
            if ((acCheckPhone.test($('.sec-bind-step2-phone-input').val())) || (acCheckEmail.test($('.sec-bind-step2-phone-input').val()))) {
                var url = '<?php echo U('common/ValidateCod/msgcode') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        username: $('.sec-bind-step2-phone-input').val(),
                        status: 1
                    },
                    success: function (data) {
                        if (data.code == 100001 || data.code == 100004) {
                            step2VerifyBtn.begin(60);
                        } else {
                            $('.sec-bind-step2-phone').addClass('base-input-box-fb');
                            $('.sec-bind-step2-phone > p').html('手机号码或邮箱已经使用');
                        }
                    }

                });
            } else {
                $('.sec-bind-step2-phone').addClass('base-input-box-fb');
                $('.sec-bind-step2-phone > p').html('请输入正确的手机号或邮箱');
            }
        });
        $('.sec-bind-step2-phone-input').on('blur', function () {
            if ((!acCheckPhone.test($(this).val())) && (!acCheckEmail.test($(this).val()))) {
                $(this).parent().addClass('base-input-box-fb');
                $('.sec-bind-step2-phone > p').html('请输入正确的手机号或邮箱');
            }
        });
        $('.sec-bind-step2-phone-input').on('focus', function () {
            $(this).parent().removeClass('base-input-box-fb');
        });
        $('.sec-bind-step2-phone-input').on('input', function () {
            if (acCheckPhone.test($(this).val())) {
                $('.sec-bind-step2-phone').append('<span class="sec-phone-pre">+86</span>');
                $('.sec-bind-step2-phone-input').css('text-indent', '49px');
            } else {
                $('.sec-bind-step2-phone > span').remove();
                $('.sec-bind-step2-phone-input').css('text-indent', '10px');
            }
        })
        //第二步保存按钮
        $('.sec-bind-step2-save').on('click', function () {
            if ((acCheckPhone.test($('.sec-bind-step2-phone-input').val())) || (acCheckEmail.test($('.sec-bind-step2-phone-input').val()))) {
                if ($.trim($('.sec-bind-step2-verify-input').val()).length !== 0) {
                    //发送ajax，看看手机号和验证码是不有问题
                    //错误就反馈，正确弹小滑块提示
                    var url = '<?php echo U('common/ValidateCod/Msgcoderead') ?>';
                    var msgcode = $('.sec-bind-step2-verify-input').val();
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            msgcode: msgcode,
                            username: $('.sec-bind-step2-phone-input').val(),
                            status: 1
                        },
                        success: function (data) {
                            if (data.code == 0) {
                                wtSlideBlock('修改成功,请重新登录');
                                window.location.href = '<?php echo U('user/login/login') ?>';
                            } else {
                                wtSlideBlock(data.msg, true);
                            }
                        }
                    });
                } else {
                    $('.sec-bind-step2-verify').addClass('base-input-box-fb');
                }
            } else {
                $('.sec-bind-step2-phone').addClass('base-input-box-fb');
                $('.sec-bind-step2-phone > p').html('请输入正确的手机号或邮箱');
            }
        });
        //页面刷新，读取cookie，继续倒计时。
        if (getCookie('actime') != 0) {
            step2VerifyBtn = new RhaCountDown('.sec-bind-step1-btn', 'base-btn-forbi');
            step2VerifyBtn.begin(Number(getCookie('actime')));
        }
        ;
    </script>
</body>