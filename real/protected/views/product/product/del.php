<!-- 删除项目弹框 -->
<div class="modal" id="L_phone_yz_box3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" pid="">
    <div class="modal-dialog rhDeleteModalDialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel3">删除项目</h4>
            </div>
            <div class="modal-body" id="L_phone_yz_bottombox3">
                <div class="Lwtl_nameline"> </div>
                <div class="Lwtl_telline">是否确认删除？删除后不可恢复。</div>
                <ul class="Lwtl_list_1">
                    <li>
                        <span   class="Lwtl_btns Lwtl_btns_long lpwtDeleteAlertBtn"  >确认 </span>
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

//项目删除的逻辑
        $('.wtProItemBox').on('click', '.wtProItemHoverControlDelete', function () {
            var value = $(this).parent().parent().prev().find('p').html();
            var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);
            $('#L_phone_yz_box3').attr('pid', p_id);
            $('#L_phone_yz_box3 .Lwtl_nameline').html(value);
            $('#L_phone_yz_box3').modal({backdrop: 'static', keyboard: false});
            var rhMarginTop = ($(window).height() >= 268) ? ($(window).height() - 268) / 2 : 0;
            $('.rhDeleteModalDialog').css('marginTop', rhMarginTop + 'px');
        })
        $('.lpwtDeleteAlertBtn').on('click', function () {
            var url = '<?php echo U('product/product/del') ?>';
            var product_id = $('#L_phone_yz_box3').attr('pid');
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        $('#L_phone_yz_box3').modal('hide');
                        wtSlideBlock('删除成功');
                        //总数字减1
                        var total = $('.wtProMenuListAll a').find('span').eq(1).html();
                        total = total.substr(1);
                        total = total.substr(0, total.length - 1);
                        total--;
                        $('.wtProMenuListAll a').find("span").eq(1).html('(' + total + ')');
                        var online = $('.wtProMenuListOffline a').find('span').eq(1).html();
                        online = online.substr(1);
                        online = online.substr(0, online.length - 1);
                        online--;
                        $('.wtProMenuListOffline a').find('span').eq(1).html('(' + online + ')');

                        $('#' + product_id).remove();

                    } else {
                        wtSlideBlock('删除失败', true);
                    }

                }
            });
        });

    })

</script>