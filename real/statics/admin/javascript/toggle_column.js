$(function() {
    //上一页，下一页,效果时长切换
    $('.xiaoguo .nav-pills').children('li').on('click', function(e) {
            e.stopPropagation();
            var index = $(this).index();
            $(this).addClass('active');
            $(this).siblings('li').removeClass('active');
            $('.xiaoguo-box>div').eq(index).css('display', 'block');
            $('.xiaoguo-box>div').eq(index).siblings('div').css('display', 'none');
        })
    //判断效果时长有没有初始值，1为没有，2为有
    var type = $('.xiaoguo-times').attr('type');
    //获取初始化数据
    var xiaoguoArr = (function(){
        var arr = [];
        for (var i = $('.xiaoguo-times').find('input').length - 1; i >= 0; i--) {
            arr.push($('.xiaoguo-times').find('input').eq(i).val());
        }
        return arr;
    })();
    console.log(xiaoguoArr);

    //效果时长按钮点击时判断初始化有没有数据
    $('.times-btn').on('click', function() {
        //每次点击的时候，初始化数据
        for (var i = xiaoguoArr.length - 1; i >= 0; i--) {
            $('.xiaoguo-times').find('input').eq(i).val(xiaoguoArr[i]);
        }
        //执行编辑保存
        saveOrEdit(type, $('.xiaoguo-times'));
    })
})


/**
 * [saveOrEdit description]
 * @param  type [1代表有数据，2代表没有数据]
 * @param  obj  [效果时长容器：$('.xiaoguo-times')]
 */
function saveOrEdit(type, obj) {
    var saveBtn = obj.find('.btn-save');
    var editBtn = obj.find('.btn-edit');
    if (type === 1) {
        saveBtn.show();
        editBtn.hide();

        //保存成功函数
        saveSuccess(saveBtn, editBtn, obj);

    } else {
        saveBtn.hide();
        editBtn.show();
        obj.find('input').attr('disabled', 'disabled');
        editBtn.on('click', function(e) {
            saveBtn.show();
            $(this).hide();
            obj.find('input').removeAttr('disabled');
            obj.find('input').eq(0).focus();

            //保存成功函数
            saveSuccess(saveBtn, editBtn, obj);

            //阻止浏览器默认行为
            e.preventDefault();
        })
    }
}
/**
 * [saveSuccess description]
 * @param  {[type]} saveBtn [保存按钮]
 * @param  {[type]} editBtn [编辑按钮]
 * @param  {[type]} obj     [$('.xiaoguo-times')]
 */
function saveSuccess(saveBtn, editBtn, obj) {
    saveBtn.unbind();
    saveBtn.on('click', function() {
        if(isNull(obj)){
            //ajax code here
            saveTip('保存成功！')
            saveBtn.hide();
            editBtn.show();
            obj.find('input').attr('disabled', 'disabled');
        }
        return false;
    })
}
/**
 * [isNull 判断时长输入框是否为空]
 * @param  {[type]}  obj [$('.xiaoguo-times')]
 */
function isNull(obj){
    for (var i = obj.find('input').length - 1; i >= 0; i--) {
        if(obj.find('input').eq(i).val()!==''){
            return true;
        }else{
            return false;
        }
    }
}
