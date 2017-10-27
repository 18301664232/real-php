<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/help.css">
<!-- 搜索区域 -->
<div class='hp_se_sec'>
    <div class='hp_se_box clearfix'>
        <input type='text' class='hp_se_input' placeholder='输入关键字' />
        <button class='hp_se_btn'></button>
    </div>
</div>
<!-- 三级菜单 -->
<div class='hp_me_sec clearfix' >
    <div class='hp_me_left'>
        <?php foreach ($data as $k => $v): ?>
            <div class='hp_me_one'>
                <button class='hp_me_one_btn'><?php echo $v['title'] ?></button>
                <ul class='hp_me_two_list'>
                    <?php if (isset($v['child'])): ?>
                        <?php foreach ($v['child'] as $kk => $vv): ?>
                            <li class='hp_me_two'>
                                <a class='hp_me_two_a' href='javascript:;' str = <?php echo $vv['id'] ?>><?php echo $vv['title'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endforeach; ?>
    </div>
    <div class='hp_me_right' >
        <div class='hp_me_nav clearfix' style="color: #8e9cb7;">  
        </div>
        <!-- 第三级标题 -->
        <div class='hp_me_three'>
            <ul class='hp_me_three_list'>


            </ul>
            <!-- 展示内容 -->
            <div class='hp_me_content'>
                <p class='hp_me_title'></p>
                <p class='hp_me_body'></p>
            </div>
        </div>

    </div>
</div>

<!-- 搜索结果 -->
<div class='hp_se_re' style="display: none">
    <p class='hp_se_tip'>搜索“<span class='hp_se_key'></span>”相关的结果，共<span class='hp_se_num'>0</span>条
        <button class='hp_se_return'>返回</button>
    </p>
    <div class='hp_se_re_body'>
        <div class='hp_se_re_item'>
    
        </div>

    </div>
</div>

<script>
// 二级菜单显示或隐藏
    $('.hp_me_one_btn').on('click', function () {

        if ($(this).hasClass('hp_me_one_btn_click')) {
            $(this).removeClass('hp_me_one_btn_click');
        } else {
            $(this).addClass('hp_me_one_btn_click');
        }
        $(this).next().toggle();

        $(this).parents('.hp_me_one').siblings().find('.hp_me_one_btn').removeClass('hp_me_one_btn_click');
        $(this).parents('.hp_me_one').siblings().find('.hp_me_two_list').hide();
    });

    $('.hp_me_sec').on('click', '.hp_me_two_a', function () {
        var obj = $(this);
        var id = $(this).attr('str');
        var url = '<?php echo U('site/index/helpajax') ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            async: false,
            data: {
                id: id
            },
            success: function (data) { 
                if (data.code == 0) {
                    var nr = '';
                    for (var key in data.result) {
                        nr += "<li class='hp_me_three_li'><a class='jp_me_three_a' href='javascript:;' str=" + data.result[key].id + ">" + data.result[key].title + "</a></li>";
                    }
                    $('.hp_me_three_list').html(nr);
                    $('.hp_me_three_list').show();
                    $('.hp_me_content').hide();
                    var tab = "<span class='hp_me_nav1'>" + obj.parent().parent().parent().find('.hp_me_one_btn').html() + "&gt;</span><span class='hp_me_nav1'>" + obj.html() + "&gt;</span>"
                    $('.hp_me_nav').html(tab);
                } else {
                    alert('查询失败');
                }
            }
        })
    })
    //详细
    $('.hp_me_three_list').on('click', 'a', function () {
        var id = $(this).attr('str');
        var url = '<?php echo U('site/index/helpajaxinfo') ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            async: false,
            data: {
                id: id
            },
            success: function (data) {
                if (data.code == 0) {
                    $('.hp_me_title').html(data.result[0].title);
                    $('.hp_me_body').html(data.result[0].content);
                    $('.hp_me_content').show();
                    $('.hp_me_three_list').hide();
                    $('.hp_me_nav').append("<span class='hp_me_nav1'>" + data.result[0].title + "</span>");
                } else {
                    alert('查询失败');
                }
            }
        })
    })
    //搜索
    $('.hp_se_btn').on('click', function () {
        var keyword = $('.hp_se_input').val();
        var url = '<?php echo U('site/index/helpselect') ?>';
        $.ajax({
            type: "POST",
            url: url,
            dataType: "json",
            async: false,
            data: {
                keyword: keyword
            },
            success: function (data) {
                if (data.code == 0) {
                    $('.hp_se_num').html(data.result.length);
                    var nr = '';
                    for (var key in data.result) {
                        nr += "<div class='hp_se_re_item'><p class='hp_se_re_title'><a style='cursor:pointer;'>" + data.result[key].title + "</a></p><div class='hp_se_re_content'>" + data.result[key].content.substring(0, 200) + "</div></div><p class='hp_se_re_nav'>" + data.result[key].tab + "</p></div>";
                    }
                    $('.hp_se_key').html(keyword);
                    $('.hp_se_re_body').html(nr);
                    $('.hp_me_sec').hide();
                    $('.hp_se_re').show();
                } else {
                    alert('查询失败');
                }
            }
        })
        $('.hp_se_return').on('click', function () {
            $('.hp_me_sec').show();
            $('.hp_se_re').hide();
        })
    })

    //搜索后详情
    $('.hp_se_re_body').on('click','.hp_se_re_title a', function () {
        $('.hp_me_nav').html($(this).parent().parent().find('.hp_se_re_nav').html()); 
        $('.hp_me_title').html($(this).parent().parent().find('.hp_se_re_title a').html());
        $('.hp_me_body').html($(this).parent().parent().find('.hp_se_re_content').html());
        $('.hp_me_sec').show();
        $('.hp_se_re').hide();
        $('.hp_me_content').show();
        $('.hp_me_three_list').hide();
        showMenu($(this).parent().parent().find('.hp_se_re_nav').html());
    })

     function showMenu(str){ 

        var pos = str.indexOf('&gt;');
        var name = str.slice(0,pos);
        var btn = null;
        for(var i = 0,len = $('.hp_me_one').length; i < len;i++){
            if($($('.hp_me_one')[i]).find('.hp_me_one_btn').text() == name){
                btn = $($('.hp_me_one')[i]).find('.hp_me_one_btn');
            }
        }

        btn.addClass('hp_me_one_btn_click');
        btn.next().show();

        btn.parents('.hp_me_one').siblings().find('.hp_me_one_btn').removeClass('hp_me_one_btn_click');
        btn.parents('.hp_me_one').siblings().find('.hp_me_two_list').hide();
    }

</script>