$(function() {
    // /*左侧导航栏显示隐藏功能*/
    $('.subNav').each(function() {
            if ($(this).siblings('ul').length > 0) {
                $(this).click(function() {
                    /*显示*/
                    if ($(this).find("span:first-child").attr('class') == "title-icon glyphicon glyphicon-chevron-down") {
                        $(this).find("span:first-child").removeClass("glyphicon-chevron-down");
                        $(this).find("span:first-child").addClass("glyphicon-chevron-up");
                        $(this).removeClass("sublist-down");
                        $(this).addClass("sublist-up");
                    }
                    /*隐藏*/
                    else {
                        $(this).find("span:first-child").removeClass("glyphicon-chevron-up");
                        $(this).find("span:first-child").addClass("glyphicon-chevron-down");
                        $(this).removeClass("sublist-up");
                        $(this).addClass("sublist-down");
                    }
                    // 修改数字控制速度， slideUp(500)控制卷起速度
                    $(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(300);
                    $(this).parents('.subNavBox').find('li').click(function() {
                        $('.subNavBox').find('li').removeClass('active');
                        $(this).addClass('active');
                    });

                });
            }
        })
        // 三级菜单切换效果
    if ($('.nav-tabs').length > 0) {
        $('.nav-tabs').children().each(function() {
            $(this).click(function() {
                //选项卡选中效果
                var index = $(this).index();
                $('.nav-tabs').children().removeClass('active');
                $(this).addClass('active');
                //显示对应的内容
                $('.content-box').children().each(function() {
                    $(this).removeClass('active');
                });
                $('.content-box').children().eq(index).addClass('active');
            })
        });
    }
    delTip($('.del-btn'), 'haha', 'hehe');
});
