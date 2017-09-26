$(function () {
    //计算进度条颜色长度
    $('.flow-item-left').find('.progress').each(function () {
        var surplus = Number($(this).next('.flow-num-box').find('.flow-num').text());
        var total = Number($(this).text());
        var progressWidth = surplus / total;
        $(this).width(progressWidth * 558);
        if (progressWidth > 0.9) {
            console.log(progressWidth)
            $(this).parent().find('.flow-num-box').css({
                position: 'absolute',
                top: 0,
                right: -$(this).parent().find('.flow-num-box').width() + 'px'
            })
        }
    });

    //已启用，已过期，已用完
    $('.flow-item-list li').each(function () {
        if ($(this).hasClass('flow-on')) {
            $(this).find('.flow-status').text('已启用');
        } else if ($(this).hasClass('flow-expire')) {
            $(this).find('.flow-status').text('已过期');
        } else {
            $(this).find('.flow-status').text('已用完');
        }
    })



    //流量总览里面的流量开关

    //初始化多选
    if ($('.flow-on').length > 0) {
        //$('#flowFlag').prop('checked','checked');
        isChecked($('#flowFlag'));
        //点击切换
        $('#flowFlag').change(function () {
            isChecked($(this))
        });
    } else {
        //$('#flowFlag').prop('checked',false);
        $('#flowFlag').prop('disabled', 'disabled');
    }



    function isChecked(obj) {
        var isTrue = obj.prop('checked');
        if (isTrue) {
            $('.modify').addClass('active');
            $('.modify').click(function () {
                modify($(this));
            })
        } else {
            $('.modify').removeClass('active');
            $('.modify').unbind();
        }
    }


    /**
     * [modify description]  [修改按钮执行逻辑]
     * @param  {[type]} obj [修改按钮]
     * @return {[type]}     [description]
     */
    function modify(obj, surplus) {
        //保存阈值初始数据
        var oldValue = $('.tip-num b').text();
        $('.saveOrCancel').addClass('active');
        $('#flowFlag').attr('disabled', 'disabled');
        obj.css('display', 'none');
        $('.tip-num b').text('');
        $('#tipNum').prop('type', 'text').val(oldValue);
        //保存输入流量
        //先解除之前绑定的事件，以免多次触发
//    $('.saveOrCancel a').unbind();

        //取消输入流量
        $('.saveOrCancel .cancel-btn').click(function () {
            saveOrCancelBtn($(this), 'cancel', oldValue);
        })
    }




    /**
     * [saveOrCancelBtn 点击取消和保存按钮的执行逻辑]
     * @param  {[type]} obj      [按钮]
     * @param  {[type]} type     [save  cancel]
     * @param  {[type]} oldValue [点击修改的时候存储的阈值]
     * @return {[type]}          [description]
     */
    function saveOrCancelBtn(obj, type, oldValue) {
        oldValue = oldValue || '';
        if (type === 'save') {
            var flowValue = $('.tip-num').find('input').val();
            //设置流量预警验证纯数字
            var flowReg = /^([1-9])([0-9]?)([0-9]?)$/;
            if (!flowReg.test(flowValue)) {
                $('.tip-word').addClass('active').text('只能输入1-3位整数且不能为0');
                return;
            } else {
                if ($('.tip-word').hasClass('active')) {
                    $('.tip-word').removeClass('active');
                }
                $('#tipNum').prop('type', 'hidden');
                $('.tip-num b').text(flowValue);
            }
        } else {
            if ($('.tip-word').hasClass('active')) {
                $('.tip-word').removeClass('active');
            }
            $('.tip-num').find('input').prop('type', 'hidden').val(oldValue);
            $('.tip-num b').text(oldValue);
        }
        $('#flowFlag').removeAttr('disabled');
        cancelBtnStyle(obj);
    }


    /**
     * [cancelBtnStyle 取消时候初始化样式]
     * @param  {[type]} obj [按钮]
     * @return {[type]}     [description]
     */
    function cancelBtnStyle(obj) {
        obj.parent().removeClass('active');
        $('.modify').css('display', 'block');
    }
})