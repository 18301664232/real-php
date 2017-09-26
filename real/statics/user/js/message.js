//我要不要去学习css的简写
(function(){
    //消息条展开的逻辑
    // $('.mg_body').on('click','.mg_base_close',function(){
    //     if($(this).parents('.mg_base').hasClass('mg_base_show')){
    //         $(this).parents('.mg_base').removeClass('mg_base_show');
    //     } else {
    //         $(this).parents('.mg_base').addClass('mg_base_show');
    //     }

    //     if(!$(this).parents('.mg_base').hasClass('mg_base_readed')){
    //         $(this).parents('.mg_base').addClass('mg_base_readed');
    //     }

    //     $(this).parents('.mg_base').siblings().removeClass('mg_base_show');
    // })


    //全部删除弹框出现
    $('.mg_del').on('click',function(){
        $('#alert').modal({backdrop:'static',keyboard:false});
        var rhMarginTop = ($(window).height() >= $('.alertHeight').height()) ? ($(window).height() - $('.alertHeight').height())/2 : 0;
        $('.alertWidth').css('marginTop',rhMarginTop + 'px');
    });

    //确定按钮
    $('.mg_del_ysa').on('click',function(){
        $('.mg_base').remove();
        $('.mg_tip_num').text($('.mg_base').length);
        $('#alert').modal('hide');
    });

    //下拉加载
    var loading = false;
    $(window).scroll(function(){
        console.log('xxxxx');
        if(loading==true) return false;
        if($(document).height() - $(window).height()-$(window).scrollTop() <=1){
            $('#mg_laod_box').show();
            loading = true;
            //ajax
            setTimeout(function(){
                $('#mg_laod_box').hide();
                loading = false;
            },1000);
        }
    });
})();