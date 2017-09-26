/**
 * [commonTab 公用选项卡]
 * @param  {[type]} obj [父元素 $('.parents')]
 * @return {[type]}     [description]
 */
function commonTab(obj) {
    $('.query-box').find('li').on('click', function() {
        var _this = $(this);
        $(this).siblings().each(function() {
            if ($(this).hasClass('active')) {
                $(this).removeClass('active')
                _this.addClass('active');
            } else {
                _this.addClass('active');
            }
        });
    });
}

/**
 * 统一删除弹框
 * obj.删除按钮
 * title:弹出框的标题
 * content:弹出框的内容
 * func:点击确认删除的执行逻辑
 */
function delTip(obj, title, content, func) {
    obj.click(function() {
        var delStr = '<div role="dialog" class="modal fade" id="delete_tip">' + '<div class="modal-dialog">' + '<div class="modal-content">' + '<div class="modal-header">' + '<button class="close" data-dismiss="modal">' + '<span>&times;</span>' + '</button>' + '<h4 class="modal-title">' + title + '</h4>' + '</div>' + '<div class="modal-body text-center">' + '<p style="margin:20px 0">' + content + '</p>' + '<button class="btn btn-primary btn-sm btn-cancel" data-dismiss="modal" style="margin-right:10px;">取消</button>' + '<button class="btn btn-danger btn-sm btn-sure" data-dismiss="modal">确认</button>' + '</div>' + '</div>' + '</div>' + '</div>';
        //插入弹框字符串
        if ($('#delete_tip').length <= 0) {
            $('body').append(delStr);
        } else {
            $('#delete_tip').remove();
            $('body').append(delStr);
        }
        //弹出删除层
        $('#delete_tip').modal();
        //点击确认删除的执行函数
        $('.btn-sure').unbind();
        $('.btn-sure').on('click', function() {
            if (func !== undefined) {
                func();
            }else{
                return;
            }
        });
    })
}
/**
 * [saveTip 点击保存按钮弹框]
 * @param  content ['保存成功'或者'保存失败']
 * @param  obj [保存按钮]
 */
function saveTip(content) {
    var saveStr = '<div class="modal fade" role="dialog" id="save_tip">' + '<div class="modal-dialog" role="document">' + '<div class="modal-content">' + '<div class="modal-header">' + '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' + '</div>' + '<div class="modal-body">' + '<p class="text-center save-success-word">' + content + '</p>' + '</div>' + '</div>' + '</div>' + '</div>';
    if ($('#save_tip').length <= 0) {
        $('body').append(saveStr);
    }
    $('#save_tip').modal();

    return false;
}

//分页点击切换效果
(function() {
    $(function() {
        if ($('.page-box').length > 0) {
            $('.page-box').find('li').on('click', function() {
                var _this = $(this);
                $(this).siblings().each(function() {
                    if ($(this).hasClass('active')) {
                        $(this).removeClass('active');
                        _this.addClass('active');
                    }
                })
            })
        }
    })
})()
//iframe自适应
// function autoHeight() {
//     var ifr = document.getElementById('iframeBox');
//     ifr.height = (ifr.contentDocument && ifr.contentDocument.body.offsetHeight)+50
//             || (ifr.contentWindow.document.body.scrollHeight)+50;
// }
