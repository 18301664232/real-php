<!-- 上线设置弹框 -->
<div class="modal" id="L_phone_yz_box6" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" pid="">

    <div class="modal-dialog rhOnlineSetModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel6">上线设置</h4>
            </div>
            <ul id="myTab" class="nav nav-tabs">
                <li class="active">
                    <a href="#L_tab1" data-toggle="tab">项目设置</a>
                </li>
                <li>
                    <a href="#L_tab2" data-toggle="tab">渠道设置</a>
                </li>
                <li>
                    <a href="#L_tab3" data-toggle="tab">微信分享</a>
                </li>
            </ul>
            <div class="modal-body" id="L_phone_yz_bottombox6">
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade in active" id="L_tab1">
                        <ul class="Lwtl_list_2">
                            <li>
                                <div class="Lwtl_li_l">项目名称：</div>
                                <div class="Lwtl_li_r">
                                    <input type="text" class="form-control Lwtl_xm_name"  placeholder="请输入名称"  id="max_textlength2"onKeyUp="gbcount($('#max_textlength2'), 26, $('#max_textlengnum2'));">
                                    <span class="   Lwtl_input-group-addon" id="max_textlengnum2">0/26</span>
                                    <div class="Lwtl_red"> </div>
                                </div>
                            </li>
                            <li>
                                <div class="Lwtl_li_l">项目简介：</div>
                                <div class="Lwtl_li_r">
                                    <textarea   placeholder="请输入作品介绍" cols="36" rows="3" id="textarea2"   onKeyUp="gbcount($('#textarea2'), 36);"></textarea>
                                </div>
                            </li>
                            <li>
                                <div class="Lwtl_li_l"> </div>
                                <div class="Lwtl_li_r">
                                    <span  class="Lwtl_btns Lwtl_btns_long lpOnlineItemSetSave">保存</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="L_tab2">
                        <ul id="L_tab2_nav">
                            <li class="Lwtl_w191">渠道名称</li>
                            <li class="Lwtl_w417">渠道URL</li>
                            <li class="Lwtl_w44">&nbsp;</li>
                            <li class="Lwtl_w123">二维码</li>
                        </ul>
                        <div id="L_list_url">
                            <ul class="Lwtl_tab2_list_li">

                            </ul>
                        </div>
                        <div id="L_list_url_btnbox">
                            <ul>
                                <li><span   class="Lwtl_btns Lwtl_btns_long Lwtl_addbtn"  id="L_save_qudao" >添加渠道</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="L_tab3">
                        <from>
                            <ul class="Lwtl_list_4" id="warp">
                                <li>
                                    <div class="Lwtl_li_l">分享标题：</div>
                                    <div class="Lwtl_li_r">
                                        <input type="text" class="form-control Lwtl_xm_name" name="wechat_title"  placeholder="请输入微信分享标题"  id="max_textlength3" onKeyUp="gbcount1($('#max_textlength3'), 26, $('#max_textlengnum3'));">
                                        <span class="   Lwtl_input-group-addon" id="max_textlengnum3">0/26</span>
                                        <div class="Lwtl_red"> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Lwtl_li_l">分享内容：</div>
                                    <div class="Lwtl_li_r">
                                        <textarea   placeholder="微信转发给好友内容" cols="36" rows="3" id="textarea3" name="wechat_content"  onKeyUp="gbcount2($('#textarea3'), 36, $('.Lwtl_fd p'));" ></textarea>
                                        <div class="Lwtl_red"> </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="Lwtl_li_l">分享图片：</div>
                                    <div class="Lwtl_li_r">
                                        <input type="file" id="L_up_img_WU_FILE_0" files=""  />
                                        <div>
                                            <div id="L_wxfx_head"><img id="L_imgShow_WU_FILE_0" width="100" height="100"  class="Lwtl_icon_fx"  /></div>
                                            <span id="L_fx_pic">分享图片</span><span id="L_fx_picsm">（ 120 ＊ 120尺寸）</span>
                                        </div>
                                        <div class="Lwtl_red"> </div>
                                        <span  class="Lwtl_btns Lwtl_btns_long lpOnlineShareSetSave" >保存</span>
                                    </div>
                                </li>
                            </ul>
                        </from>
                        <ul class="Lwtl_list_5">
                            <li>
                                <div class="Lwtl_fd_q">
                                    <div class="lwtl_pphead" id="L_pphead1"><img src="<?php echo STATICS ?>images/pp_head.jpg"> </div>
                                    <h1>RealApp</h1>
                                    <div id="L_fd_text">
                                        <img src="<?php echo STATICS ?>images/L_icon1.jpg" class="Lwtl_icon_fx" id="Licon2">
                                        <p></p>
                                    </div>
                                    <div id="L_fd_textsl"> <div class="Lwtl_time">一小时前</div> <img src="<?php echo STATICS ?>images/sl.jpg" id="L_sl"> </div>
                                </div>
                            </li>
                            <li>
                                <div class="Lwtl_fd">
                                    <div class="lwtl_pphead" id="L_pphead2"><img src="<?php echo STATICS ?>images/pp_head.jpg"> </div>
                                    <h1></h1>
                                    <img src="<?php echo STATICS ?>images/L_icon1.jpg" class="Lwtl_icon_fx" id="Licon3">
                                    <p></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
            </div>-->
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>



<script>
    $(function () {
//项目设置
        $('.wtProItemBox').on('click', '.wtProItemHoverControlSetting', function () {
            var url = '<?php echo U('product/product/setting') ?>';
            var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
            product_id = p_id.substr(-10);
            $('#L_phone_yz_box6').attr('pid', product_id);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        $('#L_phone_yz_box6').modal({backdrop: 'static', keyboard: false});
                        var rhMarginTop = ($(window).height() >= 384) ? ($(window).height() - 384) / 2 : 0;
                        $('.rhOnlineSetModalDialog').css('marginTop', rhMarginTop + 'px');
                        $('#max_textlength2').val(data.result.title);
                        $('#max_textlengnum2').html('0/26');
                        $('#max_textlengnum2').html(data.result.title.length + '/26');
                        $('#textarea2').val(data.result.description);
                        $('#max_textlength3').val(data.result.wechat_title);
                        $('#L_fd_text').find('p').html(data.result.wechat_title);
                        $('.Lwtl_list_5 .Lwtl_fd').find('h1').html(data.result.wechat_title);
                        $('#textarea3').val(data.result.wechat_content);
                        $('.Lwtl_list_5 .Lwtl_fd').find('p').html(data.result.wechat_content);
                        $('#L_imgShow_WU_FILE_0').attr('src', '<?php echo STATICS . '/images/46x46.png' ?>');
                        $('#Licon2').attr('src', '<?php echo STATICS . '/images/36x36.png' ?>');
                        $('#Licon3').attr('src', '<?php echo STATICS . '/images/58x58.png' ?>');
                        if (data.result.wechat_img != null) {
                            if (data.result.wechat_img != '') {
                                $('#L_imgShow_WU_FILE_0').attr('src', '<?php echo UPLOAD ?>' + data.result.wechat_img);
                                $('#Licon2').attr('src', '<?php echo UPLOAD ?>' + data.result.wechat_img);
                                $('#Licon3').attr('src', '<?php echo UPLOAD ?>' + data.result.wechat_img);
                            }
                        }
                        var channel = '';
                        for (var key in data.result.link) {
                            channel += '<li>'
                                    + '           <ul class="Lwtl_tab2_list_ul">'
                                    + '               <li class="Lwtl_w191">'
                                    + '                   <span class="Lwtl_span_tit Lwtl_span_tit_f">';
                            if (key != 0) {
                                channel += '<input type="text"  value="' + data.result.link[key].name + '">';
                            } else {
                                channel += '<input type="text"  disabled="disabled" value="' + data.result.link[key].name + '">';
                            }
                            channel += '</span>'
                                    + ' </li>'
                                    + '<li class="Lwtl_w417"><em>' + data.result.link[key].url + '</em></li>'
                                    + '<li class="Lwtl_w123">'
                                    + '<span class="Lwtl_span_er">'
                                    + '<img src="<?php echo STATICS ?>images/er_t.png"> '
                                    + '</span>'
                                    + '</li>'
                                    + '<li class="Lwtl_w27">';
                            if (key != 0) {
                                channel += ''
                                        + '<div class="Lwtl_del_true Lwtl_TF">确定</div>'
                                        + '<div class="Lwtl_del_false Lwtl_TF">取消</div>'
                                        + '<div class="Lwtl_save">保存</div>'
                                        + '<div class="Lwtl_del">删除</div>';
                            }
                            channel += '</li></ul></li>';
                        }
                        $('.Lwtl_tab2_list_li').html(channel);
                        addClick();
                        init();

                        $('#max_textlengnum3').html('0/26');
                        $('#max_textlengnum3').html(data.result.wechat_title.length + '/26');

                    } else {
                        wtSlideBlock('设置打开失败', true);
                    }
                }
            });

        });

//二维码图片下载
        function addClick() {
            $('.Lwtl_w123').each(function () {
                $(this).on('click', function (e) {
                    e.stopPropagation();
                    var name = $(this).parents('.Lwtl_tab2_list_ul').find('input').val();
                    var url = '<?php echo U('product/preview/Createimg') ?>' + '&id=' + $(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_w417 em').html().substr(-10);
                    var link = url + '&name=' + name;
                    window.location.href = link;
                })
            });
        }


//点击追加
        $('#L_save_qudao').click(function () {
            //如果只有默认的渠道，则可以继续添加
            if ($('.Lwtl_tab2_list_li').children().length <= 1) {
                addChannel();
            } else {
                //判断当前添加渠道是否保存，如果保存则可以点击，否则按钮置灰
                if (isSave) {
                    addChannel();
                } else {
                    return false;
                }
            }
        });


//判断当前添加渠道是否保存的标志
        var isSave = true;
        function addChannel() {
            //列表字符串
            var channel = '<li>'
                    + '           <ul class="Lwtl_tab2_list_ul">'
                    + '               <li class="Lwtl_w191">'
                    + '                   <span class="Lwtl_span_tit Lwtl_span_tit_f">'
                    + '                       <input type="text" value="">'
                    + '                   </span>'
                    + '               </li>'
                    + '               <li class="Lwtl_w417"><em></em></li>'
                    + '               </li><li class="Lwtl_w123">'
                    + '                   <span class="Lwtl_span_er">'
                    + '<img src="<?php echo STATICS ?>images/er_t.png"> '
                    + '                   </span>'
                    + '               </li>'
                    + '               <li class="Lwtl_w27">'
                    + '                   <div class="Lwtl_del_true Lwtl_TF">确定</div>'
                    + '                   <div class="Lwtl_del_false Lwtl_TF">取消</div>'
                    + '                   <div class="Lwtl_save">保存</div>'
                    + '                   <div class="Lwtl_del">删除</div>'
                    + '               </li>'
                    + '           </ul>'
                    + '       </li>';
            //追加列表
            $('.Lwtl_tab2_list_li').append(channel);

            //追加完列表之后，保存标志变为false，在点击保存的时候再设置为true;
            isSave = false;
            //设置添加渠道按钮不可点击的样式
            $('.Lwtl_addbtn').addClass('disabled');

            //当前渠道获得焦点
            $('.Lwtl_tab2_list_ul').find('input').last().focus();
            //当前渠道获得焦点并且可以修改
            $('.Lwtl_tab2_list_ul').find('input').last().on('focus', function () {
                $(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_del').hide();
                $(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_save').show();
                $(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_save').unbind();
                $(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_save').on('click', function () {
                    if ($(this).parents('.Lwtl_tab2_list_ul').find('.Lwtl_w417 em').html() != '') {
                        initSaveBtn($(this));
                    } else {
                        saveBtn($(this));
                    }
                    $(this).unbind();
                })
            })

            //点击保存按钮
            $('.Lwtl_tab2_list_ul').last().find('.Lwtl_save').on('click', function () {
                if ($('.Lwtl_tab2_list_ul').last().find('.Lwtl_w417 em').html() == '') {
                    saveBtn($(this));
                }
                $(this).unbind();
            })

            //点击删除按钮
            delBtn();
        }


// 渠道添加保存
        function saveBtn(obj) {
            var t = obj;
            //判断是否为空
            if (!(obj.parents('.Lwtl_tab2_list_ul').find('input').val())) {
                //失败小滑块
                wtSlideBlock('保存失败', true);
                return false;
            }
            var url = '<?php echo U('product/product/addditch') ?>';
            var product_id = $('#L_phone_yz_box6').attr('pid');
            var name = obj.parents('.Lwtl_tab2_list_ul').find('input').val();
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    name: name,
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == 0) {
                        //保存成功，isSave变为TRUE,可以继续添加渠道
                        isSave = true;
                        //设置添加渠道按钮可以点击
                        $('.Lwtl_addbtn').removeClass('disabled');

                        t.hide()
                        t.next().show();
                        //添加链接
                        var content = '<?php echo REAL . U('product/index/index') ?>' + '&id=' + data.result.uid;

                        t.parent().parent().find('.Lwtl_w417 em').html(content);
                        addClick();
                        //成功小滑块
                        wtSlideBlock('保存成功');
                    } else {
                        wtSlideBlock('保存失败', true);
                    }

                }
            });
        }

//初始化保存
        function initSaveBtn(obj) {
            //判断是否为空
            if (!(obj.parents('.Lwtl_tab2_list_ul').find('input').val())) {
                //失败小滑块
                wtSlideBlock('保存失败', true);
                return false;
            }
            var url = '<?php echo U('product/product/addditch') ?>';
            var product_id = $('#L_phone_yz_box6').attr('pid');
            var name = obj.parents('.Lwtl_tab2_list_ul').find('input').val();
            var uid = obj.parents('.Lwtl_tab2_list_ul').find('.Lwtl_w417 em').html().substr(-10)
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    name: name,
                    uid: uid,
                },
                dataType: "json",
                success: function (data) {
                    //保存成功，isSave变为TRUE,可以继续添加渠道
                    isSave = true;
                    //设置添加渠道按钮可以点击
                    $('.Lwtl_addbtn').removeClass('disabled');
                    obj.hide()
                    obj.next().show();
                    addClick();
                    //成功小滑块
                    wtSlideBlock('保存成功');
                }
            });

        }
        /*
         * delBtn
         * */
        function delBtn() {
            $('.Lwtl_tab2_list_li').find('.Lwtl_del').last().click(function () {
                $(this).parent().find('.Lwtl_TF').show();
                //确定删除
                isDel($(this));
                //取消删除
                notDel($(this));
            })
        }

//删除里的确定和取消
        function isDel(obj) {
            obj.siblings('.Lwtl_del_true').unbind();
            obj.siblings('.Lwtl_del_true').click(function () {
                var t = $(this);
                var url = '<?php echo U('product/product/delditch') ?>';
                var product_id = $('#L_phone_yz_box6').attr('pid');
                var uid = t.parents('.Lwtl_tab2_list_ul').find('.Lwtl_w417 em').html().substr(-10);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        product_id: product_id,
                        uid: uid,
                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code == 0) {
                            t.parents('.Lwtl_tab2_list_ul').parent().remove();
                            wtSlideBlock('删除成功');
                        } else {
                            wtSlideBlock('删除失败', true);
                        }
                    }
                })
                $(this).unbind();
            })
        }


//直接删除初始化
        function init() {
            isSave = true;
            //设置添加渠道按钮可以点击
            $('.Lwtl_addbtn').removeClass('disabled');
            if ($('.Lwtl_tab2_list_li').children('li').length > 0) {
                $('.Lwtl_tab2_list_li').children('li').each(function () {
                    $(this).find('.Lwtl_del').show();
                    $(this).find('.Lwtl_del').click(function () {
                        $(this).parent().find('.Lwtl_TF').show();
                        //确定删除
                        isDel($(this));
                        //取消删除
                        notDel($(this));
                    });
                    $(this).find('.Lwtl_save').hide();
                    //修改以后可以保存
                    var that = $(this);
                    $(this).find('input').focus(function () {
                        that.find('.Lwtl_del').hide();
                        that.find('.Lwtl_save').unbind();
                        that.find('.Lwtl_save').show().click(function () {
                            initSaveBtn($(this));
                            $(this).unbind();
                        });
                    });
                });
                addClick();
            }
        }

        init();

//项目信息保存
        $('.lpOnlineItemSetSave').on('click', function () {
            var url = '<?php echo U('product/product/setting') ?>';
            var title = $('#max_textlength2').val();
            var description = $('#textarea2').val();
            var product_id = $('#L_phone_yz_box6').attr('pid');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    title: title,
                    description: description
                },
                dataType: "json",
                success: function (data) {
                    wtSlideBlock('保存成功');
                    $('#' + product_id + ' .wtProItemTiTle p').html(title);
                }
            });

        });

//分享保存
        $('.lpOnlineShareSetSave').on('click', function () {
            var url = '<?php echo U('product/product/setting') ?>';
            var wechat_title = $('#max_textlength3').val();
            var wechat_content = $('#textarea3').val();
            var wechat_img = $('#L_up_img_WU_FILE_0').attr('files');

            var product_id = $('#L_phone_yz_box6').attr('pid');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    wechat_title: wechat_title,
                    wechat_content: wechat_content,
                    wechat_img: wechat_img
                },
                dataType: "json",
                success: function (data) {
                    wtSlideBlock('保存成功');
                }
            });
        });


  })

</script>