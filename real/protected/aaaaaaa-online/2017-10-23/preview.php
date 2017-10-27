
<!-- 预览项目弹出框 -->
<div class="modal" id="preview-alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog alert2-dialog">
        <div class="modal-content alert2-content clearfix">
            <div class="alert2-qr">
                <p class="alert2-qr-text alert2-qr-text-official">正式地址</p>
                <img class="alert2-qr-img alert2-qr-img-official" src=""/>
                <p class="alert2-qr-text alert2-qr-text-test">测试地址</p>
                <img class="alert2-qr-img alert2-qr-img-test" src=""/>
            </div>
            <div class="alert2-view">
                <p class="alert2-view-title">
                    <span class="alert2-view-text"></span>
                </p>
                <div class="alert2-view-frame-box"></div>
                <p class="alert2-view-frame-page"></p>
                <button type="type" class="alert2-close" data-dismiss="modal"></button>
                <div class="alert2-btn-group">
                    <button type="button" class="alert2-btn-up"></button>
                    <button type="button" class="alert2-btn-down"></button>
                </div>
            </div>
            <div class='alert2-loading-box clearfix'>
                <div class='alert2-loading'></div>
                <div class='alert2-loading-text'>正在加载...</div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var previewIframe = '<iframe scrolling="no" class="alert2-view-iframe" src="$htmlpreview"></iframe>';
        var previewUrlFinal = '<?php echo U('product/product/Sendmsg') ?>';

//这里是弹框触发按钮（预览）//这里修改过
        document.domain = "realplus.cc";
        var preIframe;
        $('.wtProItemBox').on('click', '.wtProItemHoverView', function () {
            var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
            product_id = p_id.substr(-10);
            $('#preview-alert').modal({backdrop: 'static', keyboard: false});
            $('.alert2-loading-box').show();
            var rhMarginTop = ($(window).height() > $('.alert2-content').height()) ? ($(window).height() - $('.alert2-content').height()) / 2 : 0;
            $('.alert2-dialog').css('marginTop', rhMarginTop + 'px');

            socket = io.connect('http://123.56.177.30:3080');
            socket.emit('join', {
                key: product_id
            });
            socket.on('message', function (msg) {
                var result = msg.msg;
                var code = 1;
                if (result) {
                    var code = result.code || 1;
                }
                if (code == 0) {
                    var data = msg.msg.data;
                    renderAlert(data);
                    socket.disconnect();
                }
            });

            $.ajax({
                url: previewUrlFinal,
                type: 'POST',
                data: {
                    product_id: product_id,
                },
                success: function (result) {

                },
            })
        })

        $('.alert2-close').on('click', function () {
            $('.alert2-view-frame-box').empty();
            $('.alert2-qr-img').attr('src', '');
            $('#preview-alert').removeClass('alert2-online').removeClass('alert2-update').removeClass('alert2-offline');
        })

        function renderAlert(data) {
            $('.alert2-view-text').html(data.title);
            switch (data.status) {
                case 'online':
                    $('#preview-alert').addClass('alert2-online');
                    getOssImg(data.onlineimg+'&ossimg=ok','online');
                    break;
                case 'update':
                    $('#preview-alert').addClass('alert2-update');
                     getOssImg(data.onlineimg+'&ossimg=ok','update_one');
                     getOssImg(data.notonlineimg+'&ossimg=ok','update_two');
                    break;
                default:
                    $('#preview-alert').addClass('alert2-offline');
                    getOssImg(data.notonlineimg+'&ossimg=ok','other');
            }
            var previewHtmlUrl;
            if (data.status === 'online') {
                previewHtmlUrl = data.online;
            } else {
                previewHtmlUrl = data.notonline;
            }
            var previewIframeFinal = previewIframe.replace('$htmlpreview', previewHtmlUrl);
            $('.alert2-view-frame-box').append(previewIframeFinal);
            $('.alert2-view-frame-box').find('.alert2-view-iframe').on('load', function () {
                preIframe = document.querySelector('.alert2-view-iframe');
                $('.alert2-loading-box').hide();
            });
        }

        //请求获取oss图片地址
        function getOssImg($url,$type){
            $.ajax({
                type: "POST",
                url:$url,
                dataType: "json",
                data:{
                },
                success: function (data) {
                    switch ($type) {
                        case 'online':
                            $('.alert2-qr-img-official').attr('src',data);
                        break;
                        case 'update_one':
                            $('.alert2-qr-img-official').attr('src',data);
                        break;
                        case 'update_two':
                            $('.alert2-qr-img-test').attr('src',data);
                            break;
                        case 'other':
                            $('.alert2-qr-img-test').attr('src',data);
                        break;

                     }}
                })

        }

        window.updatePageNum = function (current, total) {
            $('.alert2-view-frame-page').html(current + '/' + total);
        }

        window.previewInit = function (current, total) {
            $('.alert2-view-frame-page').html(current + '/' + total);
            $('.alert2-btn-up').on('click', function () {
                preIframe.contentWindow.mcjs.DOMInterface.prevView();
            });

            $('.alert2-btn-down').on('click', function () {
                preIframe.contentWindow.mcjs.DOMInterface.nextView();
            });
        }


    })

</script>