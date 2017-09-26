<!-- 创建项目弹出框 -->
<div class="modal" id="L_phone_yz_box5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

    <div class="modal-dialog rhCreateItemModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel5">创建项目</h4>
            </div>
            <div class="modal-body" id="L_phone_yz_bottombox5">
                <ul class="Lwtl_list_2">
                    <li style="display:none">
                        <div class="Lwtl_li_l">项目ID：&nbsp;</div>
                        <div class="Lwtl_li_r">
                            <span class="Lwtl_text_copy"   id="copythis"  ></span>
                            <span class="Lwtl_btns Lwtl_btns_r"   data-clipboard-target="#copythis" id="copybtn" >复制</span>
                            <div class="Lwtl_red"> </div>
                        </div>
                    </li>
                    <li>
                        <div class="Lwtl_li_l">项目名称：</div>
                        <div class="Lwtl_li_r">
                            <input type="text" class="form-control Lwtl_xm_name"  placeholder="请输入名称" maxlength="26" id="max_textlength1"  onKeyUp="gbcount($('#max_textlength1'), 26, $('#max_textlengnum1'));">
                            <span class="   Lwtl_input-group-addon" id="max_textlengnum1">0/26</span>
                            <div class="Lwtl_red"> </div>
                        </div>
                    </li>
                    <li>
                        <div class="Lwtl_li_l">项目简介：</div>
                        <div class="Lwtl_li_r">
                            <textarea placeholder="请输入作品介绍"   rows="3" id="textarea1" onKeyUp="gbcount($('#textarea1'), 36);"></textarea>
                        </div>
                    </li>
                    <li>
                        <div class="Lwtl_li_l"> </div>
                        <div class="Lwtl_li_r">
                            <span class="Lwtl_btns Lwtl_btns_long LPCreateItemServe" >创建</span>
                        </div>
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

//显示创建弹窗
        $('.wtCreatePro').on('click', function () {
            var url = '<?php echo U('product/product/creat') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        $('#copythis').html(data.result.product_id);
                        $('#L_phone_yz_box5').modal({backdrop: 'static', keyboard: false});
                        var rhMarginTop = ($(window).height() >= 391) ? ($(window).height() - 391) / 2 : 0;
                        $('.rhCreateItemModalDialog').css('marginTop', rhMarginTop + 'px');
                    }

                }
            });
        });
        //添加项目
        $('.LPCreateItemServe').on('click', function () {
            var url = '<?php echo U('product/product/creat') ?>';
            var product_id = $('#copythis').html();
            var title = $('#max_textlength1').val();
            var description = $('#textarea1').val();
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    title: title,
                    description: description,
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        $('#L_phone_yz_box5').modal('hide');
                        var wtNewItemTemplate = '<div id=' + data.result.product_id + ' class="wtProItem wtProItemTagStateInit"><img class="wtProItemImg" class="img-responsive" src="<?php echo STATICS ?>images/wtProImg.png"/>\n\
               <div class="wtProItemTiTle"><p>' + data.result.title + '</p></div><div class="wtProItemHover"><p class="wtProItemHoverTitle">ID:&nbsp;' + data.result.product_id + '</p><p class="wtProItemHoverFlow">\n\
流量价格&nbsp;0元/G</p><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOn"><button class="btn btn-default wtProItemHoverDownload ">下线\n\
</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView">预览</button>\n\
<button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOff">\n\
<button class="btn btn-default wtProItemHoverUpload">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新\n\
</button><button class="btn btn-default wtProItemHoverView">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
<button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionUpdate">\n\
<button class="btn btn-default wtProItemHoverDownload">下线</button><button class="btn btn-default wtProItemHoverUpdate">更新</button><button class="btn btn-default wtProItemHoverView"\n\
>预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection \n\
wtProItemHoverBtnSectionInit"><button class="btn btn-default wtProItemHoverUpload disabledBtn" disabled="disabled">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn"\n\
disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView disabledBtn" disabled="disabled">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
<button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><p class="wtProItemHoverLastEditor"></p><div class="wtProItemHoverControl \n\
clearfix"><div class="wtProDeleteLogo clearfix"><button class="wtProDeleteLogoBtn"><div></div></button><p class="wtProDeleteLogoText">去除logo</p></div><a class="wtProItemHoverControlSetting" href="javascript:;"></a><a class="wtProItemHoverControlDelete" href="javascript:;"></a>\n\
</div></div><div class="wtProItemChoose"><a href="javascript:;"><div></div></a></div><p class="wtProItemState wtProItemStateOn">已上线</p><p class="wtProItemState wtProItemStateOff">未上线</p>\n\
<p class="wtProItemState wtProItemStateOffZero">未上线</p><p class="wtProItemState wtProItemStateUpdate">待更新</p></div>';
                        if ($('.wtProMenuListItemChoosed').hasClass('wtProMenuListOffline wtProMenuListItemChoosed') || $('.wtProMenuListItemChoosed').hasClass('wtProMenuListAll wtProMenuListItemChoosed')) {
                            $('.wtProItemBox').prepend(wtNewItemTemplate);
                        }

                        //数字加1
                        var total = $('.wtProMenuListAll a').find('span').eq(1).html();
                        total = total.substr(1);
                        total = total.substr(0, total.length - 1);
                        total++;
                        $('.wtProMenuListAll a').find("span").eq(1).html('(' + total + ')');

                        var notonline = $('.wtProMenuListOffline a').find('span').eq(1).html();
                        notonline = notonline.substr(1);
                        notonline = notonline.substr(0, notonline.length - 1);
                        notonline++;
                        $('.wtProMenuListOffline').find('span').eq(1).html('(' + notonline + ')');
                        wtSlideBlock('创建成功');
                    } else {
                        $('#L_phone_yz_box5').modal('hide');
                        wtSlideBlock('创建失败', true);
                    }

                }
            });

        });

    })

</script>