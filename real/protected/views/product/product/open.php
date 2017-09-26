
<!-- 公开项目弹框 -->
<div class="modal" id="L_phone_yz_box4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" pid="">
    <div class="modal-dialog rhPublicModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel4">公开项目</h4>
            </div>
            <div class="modal-body" id="L_phone_yz_bottombox4">
                <div class="Lwtl_nameline"></div>
                <div class="Lwtl_telline">是否确认公开至项目广场？</div>
                <ul class="Lwtl_list_1">
                    <li>
                        <span   class="Lwtl_btns Lwtl_btns_long lpwtPublicAlertBtn"  >确认 </span>
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

//项目公开的逻辑
        $('.wtProItemBox').on('click', '.wtProItemHoverControlPublic', function () {
            if ($(this).hasClass('wtProItemHoverControlPublicState')) {
                var url = '<?php echo U('product/product/open') ?>';
                var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
                product_id = p_id.substr(-10);
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        product_id: product_id

                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.code == '0') {
                            $('#' + product_id).find('.wtProItemHoverControlPublic').removeClass('wtProItemHoverControlPublicState');

                            wtSlideBlock('未公开成功');
                        } else {
                            wtSlideBlock('未公开失败', true);
                        }
                    }
                });
            } else {
                $('#L_phone_yz_box4').modal({backdrop: 'static', keyboard: false});
                var rhMarginTop = ($(window).height() >= 268) ? ($(window).height() - 268) / 2 : 0;
                $('.rhPublicModalDialog').css('marginTop', rhMarginTop + 'px');
                var value = $(this).parent().parent().prev().find('p').html();
                var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
                p_id = p_id.substr(-10);
                $('#L_phone_yz_box4').attr('pid', p_id);
                $('#L_phone_yz_box4 .Lwtl_nameline').html(value);

            }
        })


//公开AJAX
        $('.lpwtPublicAlertBtn').on('click', function () {
            var url = '<?php echo U('product/product/open') ?>';
            var product_id = $('#L_phone_yz_box4').attr('pid');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id

                },
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        wtSlideBlock('公开成功');
                        $('#L_phone_yz_box4').modal('hide');
                        //这里的是确定公开之后才会执行的
                        $('#' + product_id).find('.wtProItemHoverControlPublic').addClass('wtProItemHoverControlPublicState');

                    } else {
                        wtSlideBlock('公开失败', true);
                        $('#L_phone_yz_box4').modal('hide');
                    }
                }
            });


        });

    })

</script>