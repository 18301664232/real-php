<!-- 去除logo弹框 -->
<div class="modal" id="wt_delete_logo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">去除logo</h4>
            </div>
            <div class="modal-body" id="wt_delete_logo_bottom_box">
                <div class="Lwtl_nameline" >请流购买量包</div>
                <div class="Lwtl_telline">购买后可为所有项目开启本服务。</div>
                <ul class="Lwtl_list_1">
                    <li>
                        <span   class="Lwtl_btns Lwtl_btns_long lp_wt_flow_buy" onclick = "window.location.href = '<?php echo U('finance/pay/select') ?>'" >购买 </span>
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

        //去除logo按钮的逻辑
        $('.wtProItemBox').on('click', '.wtProDeleteLogoBtn', function () {
            var t = $(this);
            var url = '<?php echo U('product/product/dellogo') ?>';
            var p_id = $(this).parent().parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: p_id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == 0) {
                        if (t.hasClass('wtProDeleteLogoBtnClick')) {
                            t.removeClass('wtProDeleteLogoBtnClick');
                        } else {
                            t.addClass('wtProDeleteLogoBtnClick');
                        }
                    }
                    if (data.code == '100001') {
                        $('#wt_delete_logo').modal({backdrop: 'static', keyboard: false});
                        var rhMarginTop = ($(window).height() >= 270) ? ($(window).height() - 270) / 2 : 0;
                        $('#wt_delete_logo .modal-dialog').css('marginTop', rhMarginTop + 'px');
                    }
                }
            });
        });


    })

</script>