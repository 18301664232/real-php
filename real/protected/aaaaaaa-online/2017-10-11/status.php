<!-- 各种状态的修改 -->
<!-- 项目下线的弹窗 -->
<div class="modal" id="L_phone_yz_box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"  pid="">
    <div class="modal-dialog rhOfflineModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">项目下线</h4>
            </div>
            <div class="modal-body" id="L_phone_yz_bottombox">
                <div class="Lwtl_nameline"> </div>
                <div class="Lwtl_telline">绑定账号  <span><?php $username = empty(Yii::app()->session['user']['tel']) ? Yii::app()->session['user']['email'] : Yii::app()->session['user']['tel'];
echo $username; ?></span></div>
                <ul class="Lwtl_list_1">
                    <li>
                        <input type="text" class="Lwtl_text lpOfflineInput1" placeholder="输入验证码" id="L_yzm_yz">
                        <button   class="lpBaseBtnStyle lpOffLineAlertVBtn"  id="L_yzmfs_btn" >发送验证码</button>
                        <div class="Lwtl_red lpOfflineInput1Res"> </div>
                    </li>

                    <li class="lpImgVBox">
                        <input type="text" class="Lwtl_text lpOfflineInput2" placeholder="输入图片验证码">
                        <button class="lpImgVBtnStyle">
                            <img class="lpImgVImg" src=""/>
                        </button>
                        <div class="Lwtl_red lpOfflineInput2Res"> </div>
                    </li>
                    <li>
                        <button  class="lpBaseBtnStyle lpOffLineAlertCertainBtn">确认下线</button>
                    </li>
                </ul>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<!-- 上线更新弹框 -->
<div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="alert-online-load" class="modal in">
    <div class="modal-dialog alert-online-load-width">
        <div class="modal-content alert-online-load-height">
            <button data-dismiss="modal" class="alert-online-close"></button>
            <div class="alert-online-img"></div>
            <p class="alert-online-text1"></p>
            <p class="alert-online-text2"></p>
        </div>
    </div>
</div>


<!-- 项目批量下线 -->
<div class="modal" id="L_phone_yz_box2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog rhOfflineModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel2">批量下线</h4>
            </div>
            <div class="modal-body" id="L_phone_yz_bottombox2">
                <div class="Lwtl_nameline"> 批量下线<span class="wtManyOfflineItemNum">0</span>个项目</div>
                <div class="Lwtl_telline">绑定账号  <span><?php echo Yii::app()->session['user']['tel'] ?></span></div>
                <ul class="Lwtl_list_1">
                    <li>
                        <input type="text" class="Lwtl_text lpManyOfflineInput1" placeholder="输入手机验证码">
                        <button  class="lpBaseBtnStyle lpManyOffLineAlertVBtn"  >发送验证码</button>
                        <div class="Lwtl_red lpManyOfflineInput1Res"></div>
                    </li>
                    <li class="lpImgVBox">
                        <input type="text" class="Lwtl_text lpManyOfflineInput2" placeholder="输入图片验证码">
                        <button class="lpImgVBtnStyle">
                            <img class="lpImgVImg" src=""/>
                        </button>
                        <div class="Lwtl_red lpManyOfflineInput2Res"> </div>
                    </li>
                    <li>
                        <button class="lpBaseBtnStyle lpManyOffLineAlertCertainBtn">确认下线</button>
                    </li>
                </ul>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<script>
    $(function () {
//复制项目ID
        var clipBoard = new Clipboard('#copybtn');
        clipBoard.on('success', function (e) {
            wtSlideBlock('复制成功');
        })
        clipBoard.on('error', function (e) {
            wtSlideBlock('复制成功', true);
        })


//上线按钮改变项目状态
        $('.wtProItemBox').on('click', '.wtProItemHoverUpload', function () {
            alertShow();
            var url = '<?php echo U('product/product/sendmsg') ?>';
            var p_id = $(this).parent().parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);

            socket = io.connect('http://123.56.177.30:3080');
            socket.emit('join', {
                key: p_id
            });
            socket.on('message', function (msg) {
                var result = msg.msg;
                var code = 1;
                if (result) {
                    var code = result.code || 1;
                }
                if (code == 0) {
                    if ($('.wtProMenuListItemChoosed').hasClass('wtProMenuListAll wtProMenuListItemChoosed')) {
                        $('#' + p_id).removeClass('wtProItemTagStateOff').addClass('wtProItemTagStateOn');
                    } else {
                        $('#' + p_id).remove();
                    }
                    var total = $('.wtProMenuListOnline a').find('span').eq(1).html();
                    total = total.substr(1);
                    total = total.substr(0, total.length - 1);
                    total++;
                    $('.wtProMenuListOnline a').find("span").eq(1).html('(' + total + ')');
                    var online = $('.wtProMenuListOffline a').find('span').eq(1).html();
                    online = online.substr(1);
                    online = online.substr(0, online.length - 1);
                    online--;
                    $('.wtProMenuListOffline a').find('span').eq(1).html('(' + online + ')');
                    wtSlideBlock('上线成功');
                    alertSuccess();
                    socket.disconnect();
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: p_id,
                    type: 'online',
                },
                dataType: "json",
                success: function (data) {
                }
            });

        });


//更新按钮改变项目状态
        $('.wtProItemBox').on('click', '.wtProItemHoverUpdate', function () {
            alertShow('update');
            var url = '<?php echo U('product/product/sendmsg') ?>';
            var p_id = $(this).parent().parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);

            socket = io.connect('http://123.56.177.30:3080');
            socket.emit('join', {
                key: p_id
            });
            socket.on('message', function (msg) {
                var result = msg.msg;
                var code = 1;
                if (result) {
                    var code = result.code || 1;
                }
                console.log(msg);
                if (code == 0) {
                    if ($('.wtProMenuListItemChoosed').hasClass('wtProMenuListAll wtProMenuListItemChoosed')) {
                        $('#' + p_id).removeClass('wtProItemTagStateUpdate').addClass('wtProItemTagStateOn');
                    } else {
                        $('#' + p_id).remove();
                    }
                    var total = $('.wtProMenuListOnline a').find('span').eq(1).html();
                    total = total.substr(1);
                    total = total.substr(0, total.length - 1);
                    total++;
                    $('.wtProMenuListOnline a').find("span").eq(1).html('(' + total + ')');
                    var online = $('.wtProMenuListUpdate a').find('span').eq(1).html();
                    online = online.substr(1);
                    online = online.substr(0, online.length - 1);
                    online--;
                    $('.wtProMenuListUpdate a').find('span').eq(1).html('(' + online + ')');
                    alertSuccess('update');
                    wtSlideBlock('更新成功');
                    socket.disconnect();
                }
            });

            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: p_id,
                    type: 'online',
                },
                dataType: "json",
                success: function (data) {


                }
            });

        });


        //验证码的按钮逻辑
        $('.lpOffLineAlertVBtn,.lpManyOffLineAlertVBtn').on('click', function () {
            //初始化
            $('.lpOfflineInput1Res').html('');
            //判断手机是否正确
            logonUserNameStr = $('#L_phone_yz_box .Lwtl_telline span').html();
            var status = 3;
            url = '<?php echo U('common/ValidateCod/msgcode') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    username: logonUserNameStr,
                    status: status
                },
                success: function (data) {
                    if (data.code == 100001) {
                        $('.lpOfflineInput1Res').html('');
                        //倒计时
                        var OfflineCountdown = new RhaCountDown(this);
                        OfflineCountdown.begin();
                        if ($(this).hasClass('lpBaseBtnStyleState2')) {
                            $(this).removeClass('lpBaseBtnStyleState2');
                        } else {
                            $(this).addClass('lpBaseBtnStyleState2');
                        }
                        wtSlideBlock('发送成功');
                    } else {
                        $('.lpOfflineInput1Res').html(data.msg);
                    }
                }
            });
        });


//更换图片验证码
        function RefreshlogonVerImgSec(nub) {
            var ImgUrl = '<?php echo U('common/ValidateCod/user') ?>' + '&=' + Math.random();
            if (nub == 'one') {
                $('#L_phone_yz_box .lpImgVImg').attr('src', ImgUrl);
            }
            if (nub = 'many') {
                $('#L_phone_yz_box2 .lpImgVImg').attr('src', ImgUrl);
            }

        }
        $('#L_phone_yz_box .lpImgVBtnStyle').on('click', function () {
            RefreshlogonVerImgSec('one');
        });
        $('#L_phone_yz_box2 .lpImgVBtnStyle').on('click', function () {
            RefreshlogonVerImgSec('many');
        });


//项目下线的逻辑
        $('.wtProItemBox').on('click', '.wtProItemHoverDownload', function () {
            $('.lpOfflineInput1').val('');
            var value = $(this).parent().parent().prev().find('p').html();
            var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);
            $('#L_phone_yz_box').attr('pid', p_id);
            $('#L_phone_yz_box .Lwtl_nameline').html(value);
            $('#L_phone_yz_box').modal({backdrop: 'static', keyboard: false});
            var rhMarginTop = ($(window).height() >= 317) ? ($(window).height() - 317) / 2 : 0;
            $('.rhOfflineModalDialog').css('marginTop', rhMarginTop + 'px');
            $('.lpImgVBox').css('display', 'none');
        });


        //确认下线按钮的逻辑
        var itemOfflineNum = 0;
        $('.lpOffLineAlertCertainBtn').on('click', function () {
            var product_id = $('#L_phone_yz_box').attr('pid');
            var msg_code = $('#L_yzm_yz').val();
            itemOfflineNum++;
            if (itemOfflineNum <= 2) {
                if ($('.lpOfflineInput1').val() == "") {
                    $('.lpOfflineInput1Res').html('手机验证码输入有误');
                } else {
                    var url = '<?php echo U('product/product/editonline') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            product_id: product_id,
                            online: 'notonline',
                            msg_code: msg_code
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.code == '0') {

                                if ($('#' + product_id).hasClass('wtProItemTagStateUpdate')) {
                                    var online = $('.wtProMenuListUpdate a').find('span').eq(1).html();
                                    online = online.substr(1);
                                    online = online.substr(0, online.length - 1);
                                    online--;
                                    $('.wtProMenuListUpdate a').find('span').eq(1).html('(' + online + ')');
                                }
                                if ($('#' + product_id).hasClass('wtProItemTagStateOn')) {
                                    var online = $('.wtProMenuListOnline a').find('span').eq(1).html();
                                    online = online.substr(1);
                                    online = online.substr(0, online.length - 1);
                                    online--;
                                    $('.wtProMenuListOnline a').find('span').eq(1).html('(' + online + ')');
                                }
                                var total = $('.wtProMenuListOffline a').find('span').eq(1).html();
                                total = total.substr(1);
                                total = total.substr(0, total.length - 1);
                                total++;
                                $('.wtProMenuListOffline a').find("span").eq(1).html('(' + total + ')');

                                $('#L_phone_yz_box').modal('hide');
                                if ($('.wtProMenuListItemChoosed').hasClass('wtProMenuListAll wtProMenuListItemChoosed')) {
                                    $('#' + product_id).removeClass('wtProItemTagStateOn').removeClass('wtProItemTagStateUpdate').addClass('wtProItemTagStateOff');
                                } else {
                                    $('#' + product_id).remove();
                                }

                                wtSlideBlock('下线成功');
                            } else {
                                if (data.code == '100003') {
                                    $('.lpOfflineInput1Res').html('手机验证码输入有误');
                                } else if (data.code == '100004') {
                                    $('.lpOfflineInput2Res').html('图片验证码输入有误');
                                }
                                wtSlideBlock('下线失败', true);
                            }

                        }
                    });

                }
            } else {
                if (($('.lpOfflineInput1').val() == "") || ($('.lpOfflineInput2').val() == "")) {
                    if ($('.lpOfflineInput1').val() == "") {
                        $('.lpOfflineInput1Res').html('手机验证码输入有误');
                    }
                    if ($('.lpOfflineInput2').val() == "") {
                        $('.lpOfflineInput2Res').html('图片验证码输入有误');
                    }

                } else {
                    var val_code = $('.lpOfflineInput2').val();
                    var url = '<?php echo U('product/product/editonline') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            product_id: product_id,
                            online: 'notonline',
                            msg_code: msg_code,
                            val_code: val_code
                        },
                        async: false,
                        dataType: "json",
                        success: function (data) {
                            if (data.code == '0') {
                                if ($('#' + product_id).hasClass('wtProItemTagStateUpdate')) {
                                    var online = $('.wtProMenuListUpdate a').find('span').eq(1).html();
                                    online = online.substr(1);
                                    online = online.substr(0, online.length - 1);
                                    online--;
                                    $('.wtProMenuListUpdate a').find('span').eq(1).html('(' + online + ')');
                                }
                                if ($('#' + product_id).hasClass('wtProItemTagStateOn')) {
                                    var online = $('.wtProMenuListOnline a').find('span').eq(1).html();
                                    online = online.substr(1);
                                    online = online.substr(0, online.length - 1);
                                    online--;
                                    $('.wtProMenuListOnline a').find('span').eq(1).html('(' + online + ')');
                                }
                                var total = $('.wtProMenuListOffline a').find('span').eq(1).html();
                                total = total.substr(1);
                                total = total.substr(0, total.length - 1);
                                total++;
                                $('.wtProMenuListOffline a').find("span").eq(1).html('(' + total + ')');

                                $('#L_phone_yz_box').modal('hide');
                                if ($('.wtProMenuListItemChoosed').hasClass('wtProMenuListAll wtProMenuListItemChoosed')) {
                                    $('#' + product_id).removeClass('wtProItemTagStateOn').removeClass('wtProItemTagStateUpdate').addClass('wtProItemTagStateOff');
                                } else {
                                    $('#' + product_id).remove();
                                }

                                wtSlideBlock('下线成功');
                            } else {
                                if (data.code == '100003') {
                                    $('.lpOfflineInput1Res').html('手机验证码输入有误');
                                } else if (data.code == '100004') {
                                    $('.lpOfflineInput2Res').html('图片验证码输入有误');
                                }
                                wtSlideBlock('下线失败', true);
                            }

                        }
                    });
                }
                $('#L_phone_yz_box .lpImgVBox').css('display', 'block');
                var ImgUrl = '<?php echo U('common/ValidateCod/user') ?>' + '&=' + Math.random();
                $('#L_phone_yz_box .lpImgVImg').attr('src', ImgUrl);
            }
        });


//项目批量下线
        $('.wtProMenuListOnlineBtnList > .wtProBtnListCertain > button').on('click', function () {
            $('#L_phone_yz_box2').modal({backdrop: 'static', keyboard: false});
            var rhMarginTop = ($(window).height() >= 349) ? ($(window).height() - 349) / 2 : 0;
            $('.rhOfflineModalDialog').css('marginTop', rhMarginTop + 'px');
            $('.lpImgVBox').css('display', 'none');
            $('.wtManyOfflineItemNum').html(wtToOfflineSelectedNum);
        });

        //批量下线确认
        var itemOfflineNum2 = 0;
        $('#L_phone_yz_box2 .lpManyOffLineAlertCertainBtn').on('click', function () {
            var id_array = new Array();
            var i = 0;
            $('.wtProItemChooseYes').each(function () {
                var p_id = $(this).parent().attr('id');
                p_id = p_id.substr(-10);
                id_array[i] = p_id;
                i++;
            });
            var msg_code = $('.lpManyOfflineInput1').val();
            itemOfflineNum2++;
            if (itemOfflineNum2 <= 2) {
                if ($('.lpManyOfflineInput1').val() == "") {
                    $('.lpManyOfflineInput1Res').html('手机验证码输入有误');
                } else {
                    var url = '<?php echo U('product/product/editonline') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            product_id: id_array,
                            online: 'notonline',
                            msg_code: msg_code
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.code == '0') {
                                if ($('.wtProMenuListOnline').hasClass('wtProMenuListItemChoosed')) {
                                    var leng = $('.wtProItemChooseYes').length;
                                    var add = $('.wtProMenuListOffline a').find('span').eq(1).html();
                                    add = add.substr(1);
                                    add = add.substr(0, add.length - 1);
                                    add = Number(add) + Number(leng);
                                    $('.wtProMenuListOffline a').find("span").eq(1).html('(' + add + ')');
                                    var dec = $('.wtProMenuListOnline a').find('span').eq(1).html();
                                    dec = dec.substr(1);
                                    dec = dec.substr(0, dec.length - 1);
                                    dec -= leng;
                                    $('.wtProMenuListOnline a').find('span').eq(1).html('(' + dec + ')');

                                }
                                $(id_array).each(function () {
                                    $('#' + this).remove();
                                });
                                removeYes();
                                $('#L_phone_yz_box2').modal('hide');
                                wtSlideBlock('下线成功');
                            } else {
                                if (data.code == '100003') {
                                    $('.lpManyOfflineInput1Res').html('手机验证码输入有误');
                                } else if (data.code == '100004') {
                                    $('.lpManyOfflineInput2Res').html('图片验证码输入有误');
                                }
                                wtSlideBlock('下线失败', true);
                            }

                        }
                    });

                }
            } else {
                if (($('.lpManyOfflineInput1').val() == "") || ($('.lpManyOfflineInput2').val() == "")) {
                    if ($('.lpManyOfflineInput1').val() == "") {
                        $('.lpManyOfflineInput1Res').html('手机验证码输入有误');
                    }
                    if ($('.lpManyOfflineInput2').val() == "") {
                        $('.lpManyOfflineInput2Res').html('图片验证码输入有误');
                    }

                } else {
                    var val_code = $('.lpManyOfflineInput2').val();
                    var url = '<?php echo U('product/product/editonline') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: {
                            product_id: id_array,
                            online: 'notonline',
                            msg_code: msg_code,
                            val_code: val_code
                        },
                        async: false,
                        dataType: "json",
                        success: function (data) {
                            if (data.code == '0') {
                                if ($('.wtProMenuListOnline').hasClass('wtProMenuListItemChoosed')) {
                                    var leng = $('.wtProItemChooseYes').length;
                                    var add = $('.wtProMenuListOffline a').find('span').eq(1).html();
                                    add = add.substr(1);
                                    add = add.substr(0, add.length - 1);
                                    add = Number(add) + Number(leng);
                                    $('.wtProMenuListOffline a').find("span").eq(1).html('(' + add + ')');
                                    var dec = $('.wtProMenuListOnline a').find('span').eq(1).html();
                                    dec = dec.substr(1);
                                    dec = dec.substr(0, dec.length - 1);
                                    dec -= leng;
                                    $('.wtProMenuListOnline a').find('span').eq(1).html('(' + dec + ')');

                                }
                                $(id_array).each(function () {
                                    $('#' + this).remove();
                                });
                                removeYes();
                                $('#L_phone_yz_box2').modal('hide');
                                wtSlideBlock('下线成功');
                            } else {
                                if (data.code == '100003') {
                                    $('.lpManyOfflineInput1Res').html('手机验证码输入有误');
                                } else if (data.code == '100004') {
                                    $('.lpManyOfflineInput2Res').html('图片验证码输入有误');
                                }
                                wtSlideBlock('下线失败', true);
                            }

                        }
                    });
                }
                $('#L_phone_yz_box2 .lpImgVBox').css('display', 'block');
                var ImgUrl = '<?php echo U('common/ValidateCod/user') ?>' + '&=' + Math.random();
                $('#L_phone_yz_box2 .lpImgVImg').attr('src', ImgUrl);
            }
        });


//确定逻辑按钮
        $('.wtProBtnListCertain > button').on('click', function () {
            //获取ID
            var id_array = new Array();
            var i = 0;
            $('.wtProItemChooseYes').each(function () {
                var p_id = $(this).parent().find('.wtProItemHoverTitle').html();
                p_id = p_id.substr(-10);
                id_array[i] = p_id;
                i++;
            });

            //改变显示数字
            //未上线
            if ($('.wtProMenuListOffline').hasClass('wtProMenuListItemChoosed')) {
                var leng = $('.wtProItemChooseYes').length;
                var add = $('.wtProMenuListOnline a').find('span').eq(1).html();
                add = add.substr(1);
                add = add.substr(0, add.length - 1);
                add = Number(add) + Number(leng);
                $('.wtProMenuListOnline a').find("span").eq(1).html('(' + add + ')');
                var dec = $('.wtProMenuListOffline a').find('span').eq(1).html();
                dec = dec.substr(1);
                dec = dec.substr(0, dec.length - 1);
                dec -= leng;
                $('.wtProMenuListOffline a').find('span').eq(1).html('(' + dec + ')');
                var url = '<?php echo U('product/product/editonline') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        product_id: id_array,
                        online: 'online',
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code == '0') {
                            $(id_array).each(function () {
                                $('#' + this).remove();
                            });
                            removeYes();
                            wtSlideBlock('上线成功');
                        } else {
                            wtSlideBlock('批量修改失败', true);
                        }
                    }
                });

            }
            //更新
            if ($('.wtProMenuListUpdate').hasClass('wtProMenuListItemChoosed')) {
                var leng = $('.wtProItemChooseYes').length;
                var add = $('.wtProMenuListOnline a').find('span').eq(1).html();
                add = add.substr(1);
                add = add.substr(0, add.length - 1);
                add = Number(add) + Number(leng);
                $('.wtProMenuListOnline a').find("span").eq(1).html('(' + add + ')');
                var dec = $('.wtProMenuListUpdate a').find('span').eq(1).html();
                dec = dec.substr(1);
                dec = dec.substr(0, dec.length - 1);
                dec -= leng;
                $('.wtProMenuListUpdate a').find('span').eq(1).html('(' + dec + ')');
                var url = '<?php echo U('product/product/editonline') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        product_id: id_array,
                        online: 'online',
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code == '0') {
                            $(id_array).each(function () {
                                $('#' + this).remove();
                            });
                            removeYes();
                            wtSlideBlock('上线成功');
                        } else {
                            wtSlideBlock('批量修改失败', true);
                        }
                    }
                });

            }

        });


        function removeYes() {
            $('.wtProItemChoose').removeClass('wtProItemChooseYes');
            $('.wtProItemChoose').css('display', 'none');
            $('.wtProBtnList > li').removeClass('wtProBtnChoosed');
            noAll = true;
            $('.wtProBtnListAllChooseDot').css('display', 'none');
            $('.wtProBtnListAllChoose > button').hide();
            $('.wtProBtnListCertain > button').hide();
            $('.wtProBtnListCertain').addClass('wtProBtnListCertainDisabled');
            $('.wtProBtnListCertain > button').prop('disabled', 'disabled');
        }

    })

</script>