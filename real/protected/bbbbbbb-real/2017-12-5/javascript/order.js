$(function () {
    //查询选项卡切换
    commonTab($('.query-box'));



    $('#upload').change(function (e) {
        var file = e.target.files[0];
        var extName = file.name.split('.')[1];
        console.log(extName);
        if ($('.edit-right .img-area img').length > 2 || (extName !== 'png' && extName !== 'jpg')) {
            return;
        }
        var fileReader = new FileReader();
        fileReader.readAsDataURL(file);
        fileReader.onload = function () {
            $('.edit-right .img-area').append('<div class="img-group"><img src="' + this.result + '" alt="" /><a href="javascript:void(0)" class="delete-img">删除</a></div>');
            $('.delete-img').on('click', function (e) {
                e.stopPropagation();
                $(this).parent().remove();
            })
        }
    })




});

//返回上级切换
function goBack() {
    $('.go-back').unbind();
    $('.go-back').click(function (e) {
        $('.user-query,.detail-box').removeClass('active');
    })
}
