
<script>
    $(function () {
        var online = '';
        var keyword = '';
//二级菜单切换逻辑
        $('.wtProMenuListAll,.wtProMenuListOnline,.wtProMenuListOffline,.wtProMenuListUpdate,.wtProSeachBtn').on('click', function () {
            if (!$(this).hasClass('wtProSeachBtn')) {
                $('.wtProBtn').show();
                $('.wtProMenuList > li').removeClass('wtProMenuListItemChoosed');
                $(this).addClass('wtProMenuListItemChoosed');
                $('.wtProBtnList > li > button').hide();
                $('.wtProBtnList > li').removeClass('wtProBtnChoosed');
                $('.wtProItem').show();//假切换项目显示
                $('.wtProItemChoose').removeClass('wtProItemChooseYes');
                $('.wtProItemChoose').hide();
                $('.wtProBtnListAllChooseDot').hide();
                $('.wtProBtnList').hide();
                noAll = true;
            } else {
                keyword = $('.wtProSearch').val();
                $('.wtProItemBox').children().remove();//
            }
            if ($(this).hasClass('wtProMenuListAll')) {
                $('.wtProItemBox').children().remove();//
                online = '';
                keyword = '';
            }
            if ($(this).hasClass('wtProMenuListOnline')) {
                $('.wtProMenuListOnlineBtnList').show();
                $('.wtProBtnListAllOff > button').show();
                $('.wtProItemBox').children().remove();//
                online = 'online';
                keyword = '';
            }
            if ($(this).hasClass('wtProMenuListOffline')) {
                $('.wtProMenuListOfflineBtnList').show();
                $('.wtProBtnListAllOn > button').show();
                $('.wtProItemBox').children().remove();//
                online = 'notonlineall';
                keyword = '';
            }
            if ($(this).hasClass('wtProMenuListUpdate')) {
                $('.wtProBtnListAllUpdate > button').show();
                $('.wtProMenuListUpdateBtnList').show();
                $('.wtProItemBox').children().remove();//
                online = 'update';
                keyword = '';
            }
            var page = 1;
            var url = '<?php echo U('product/product/ajax') ?>';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    page: page,
                    online: online,
                    keyword: keyword
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == '0' && data.result != '') {
                        var content = '';
                        var i = 0;
                        for (var key in data.result.data) {
                            content += '<div id="' + data.result.data[key].product_id + '"';
                            if (data.result.data[key].online == 'empty') {
                                content += 'class="wtProItem wtProItemTagStateInit">';
                            }
                            if (data.result.data[key].online == 'online') {
                                content += 'class="wtProItem wtProItemTagStateOn">';
                            }
                            if (data.result.data[key].online == 'notonline') {
                                content += 'class="wtProItem wtProItemTagStateOff">';
                            }
                            if (data.result.data[key].online == 'update') {
                                content += 'class="wtProItem wtProItemTagStateUpdate">';
                            }

                            if (data.result.data[key].cover == null) {
                                content += '<img class="wtProItemImg" class="img-responsive" src="<?php echo STATICS ?>images/wtProImg.png"/>';
                            } else {
                                content += '<img class="wtProItemImg" class="img-responsive" src="' + data.result.data[key].cover + '"/>';
                            }
                            content += '<div class="wtProItemTiTle"><p>' + data.result.data[key].title + '</p></div><div class="wtProItemHover"><p class="wtProItemHoverTitle">ID:&nbsp;' + data.result.data[key].product_id + '</p><p class="wtProItemHoverFlow">\n\
项目大小:' + data.result.data[key].p_size + 'MB</p><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOn"><button class="btn btn-default wtProItemHoverDownload ">下线\n\
</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView">预览</button>\n\
<button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOff">\n\
<button class="btn btn-default wtProItemHoverUpload">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新\n\
</button><button class="btn btn-default wtProItemHoverView">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
<button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionUpdate">\n\
<button class="btn btn-default wtProItemHoverDownload">下线</button><button class="btn btn-default wtProItemHoverUpdate">更新</button><button class="btn btn-default wtProItemHoverView"\n\
>预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection \n\
wtProItemHoverBtnSectionInit"><button class="btn btn-default wtProItemHoverUpload disabledBtn" disabled="disabled">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn"\n\
disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView disabledBtn" disabled="disabled">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
<button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><p class="wtProItemHoverLastEditor">';
                            if (data.result.data[key].updatetime != '') {
                                content += "最后编辑：" + data.result.data[key].updatetime;
                            }
                            content += '</p><div class="wtProItemHoverControl clearfix"><a class="wtProItemHoverControlSetting" href="javascript:;"></a>';
                            if (data.result.data[key].pay == 'no') {
                                content += '<div class="wtProDeleteLogo clearfix"><button class="wtProDeleteLogoBtn"><div></div></button><p class="wtProDeleteLogoText">去除logo</p></div>';
                            } else {
                                content += '<div class="wtProDeleteLogo clearfix"><button class="wtProDeleteLogoBtn wtProDeleteLogoBtnClick"><div></div></button><p class="wtProDeleteLogoText">去除logo</p></div>';
                            }
                            if (data.result.data[key].online != 'empty') {
                                if (data.result.data[key].is_open == 'yes') {
                                    content += '<a class="wtProItemHoverControlPublic wtProItemHoverControlPublicState" href="javascript:;"></a>';
                                } else {
                                    content += '<a class="wtProItemHoverControlPublic " href="javascript:;"></a>';
                                }
                            }
                            content += '<a class="wtProItemHoverControlDelete" href="javascript:;"></a>\n\
   </div></div><div class="wtProItemChoose"><a href="javascript:;"><div></div></a></div><p class="wtProItemState wtProItemStateOn">已上线</p><p class="wtProItemState wtProItemStateOff">未上线</p>\n\
   <p class="wtProItemState wtProItemStateOffZero">未上线</p><p class="wtProItemState wtProItemStateUpdate">待更新</p></div>';
                            i++;
                        }
                        $('.wtProItemBox').append(content);

                    }
                    reloadlist();

                }
            });
        });
//
////下拉加载的js
        function reloadlist() {
            var page = 2;
            var loadHtml = '<div class="loadTotleBox"><div class="loadBox"><div class="loadBase"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div><p class="loadText">更多作品加载中</p></div>';
            var pullDownDoor = true;
            $(window).scroll(function () {
                if (($('body').height() - $(window).scrollTop() - $(window).height()) < 100) {
                    if (pullDownDoor) {
                        pullDownDoor = false;
                        $('body').append(loadHtml);
                        var url = '<?php echo U('product/product/ajax') ?>';
                        $.ajax({
                            type: "POST",
                            url: url,
                            data: {
                                page: page,
                                online: online,
                                keyword: keyword
                            },
                            dataType: "json",
                            success: function (data) {
                                var content = '';
                                var i = 0;
                                if (data.code == '0' && data.result != '') {
                                    for (var key in data.result.data) {
                                        content += '<div id="' + data.result.data[key].product_id + '"';
                                        if (data.result.data[key].online == 'empty') {
                                            content += 'class="wtProItem wtProItemTagStateInit">';
                                        }
                                        if (data.result.data[key].online == 'online') {
                                            content += 'class="wtProItem wtProItemTagStateOn">';
                                        }
                                        if (data.result.data[key].online == 'notonline') {
                                            content += 'class="wtProItem wtProItemTagStateOff">';
                                        }
                                        if (data.result.data[key].online == 'update') {
                                            content += 'class="wtProItem wtProItemTagStateUpdate">';
                                        }
                                        if (data.result.data[key].cover == null) {
                                            content += '<img class="wtProItemImg" class="img-responsive" src="<?php echo STATICS ?>images/wtProImg.png"/>';
                                        } else {
                                            content += '<img class="wtProItemImg" class="img-responsive" src="' + data.result.data[key].cover + '"/>';
                                        }
                                        content += '<div class="wtProItemTiTle"><p>' + data.result.data[key].title + '</p></div><div class="wtProItemHover"><p class="wtProItemHoverTitle">ID:&nbsp;' + data.result.data[key].product_id + '</p><p class="wtProItemHoverFlow">\n\
   项目大小:' + data.result.data[key].p_size + 'MB</p><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOn"><button class="btn btn-default wtProItemHoverDownload ">下线\n\
   </button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView">预览</button>\n\
   <button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOff">\n\
   <button class="btn btn-default wtProItemHoverUpload">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新\n\
   </button><button class="btn btn-default wtProItemHoverView">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
   <button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionUpdate">\n\
   <button class="btn btn-default wtProItemHoverDownload">下线</button><button class="btn btn-default wtProItemHoverUpdate">更新</button><button class="btn btn-default wtProItemHoverView"\n\
   >预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button><button class="btn btn-default wtProItemHoverData">数据</button></div><div class="wtProItemHoverBtnSection \n\
   wtProItemHoverBtnSectionInit"><button class="btn btn-default wtProItemHoverUpload disabledBtn" disabled="disabled">上线</button><button class="btn btn-default wtProItemHoverUpdate disabledBtn"\n\
    disabled="disabled">更新</button><button class="btn btn-default wtProItemHoverView disabledBtn" disabled="disabled">预览</button><button class="btn btn-default wtProItemHoverEditor">编辑</button>\n\
   <button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button></div><p class="wtProItemHoverLastEditor">';
                                        if (data.result.data[key].updatetime != '') {
                                            content += "最后编辑：" + data.result.data[key].updatetime;
                                        }
                                        content += '</p><div class="wtProItemHoverControl clearfix"><a class="wtProItemHoverControlSetting" href="javascript:;"></a>';
                                        if (data.result.data[key].pay == 'no') {
                                            content += '<div class="wtProDeleteLogo clearfix"><button class="wtProDeleteLogoBtn"><div></div></button><p class="wtProDeleteLogoText">去除logo</p></div>';
                                        } else {
                                            content += '<div class="wtProDeleteLogo clearfix"><button class="wtProDeleteLogoBtn wtProDeleteLogoBtnClick"><div></div></button><p class="wtProDeleteLogoText">去除logo</p></div>';
                                        }
                                        if (data.result.data[key].online != 'empty') {
                                            if (data.result.data[key].is_open == 'yes') {
                                                content += '<a class="wtProItemHoverControlPublic wtProItemHoverControlPublicState" href="javascript:;"></a>';
                                            } else {
                                                content += '<a class="wtProItemHoverControlPublic " href="javascript:;"></a>';
                                            }
                                        }
                                        content += '<a class="wtProItemHoverControlDelete" href="javascript:;"></a>\n\
   </div></div><div class="wtProItemChoose"><a href="javascript:;"><div></div></a></div><p class="wtProItemState wtProItemStateOn">已上线</p><p class="wtProItemState wtProItemStateOff">未上线</p>\n\
   <p class="wtProItemState wtProItemStateOffZero">未上线</p><p class="wtProItemState wtProItemStateUpdate">待更新</p></div>';
                                        i++;
                                    }
                                    $('.wtProItemBox').append(content);
                                    page++;
                                    $('.loadTotleBox').remove();
                                    pullDownDoor = true;
                                }
                                if (i < 20) {
                                    $('.loadTotleBox').remove();
                                    pullDownDoor = false;
                                }

                            }
                        });

                    }
                    ;
                }
                ;
            });

        }
        reloadlist();
    })

</script>