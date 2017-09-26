<div class="mu_add" id="icon_add2" >
    <div class="tit_up">修改<span>X</span></div>
    <ul>
        <li>
            <ul><li>位置:</li><li><input type="text" class="name"></li></ul>
        </li>
        <li>
            <ul><li>权重:</li><li><input type="text" class="quanzhong"></li></ul>
        </li>
        <li>
            <ul><li>KEY值:</li><li><input type="text" class="key"></li></ul>
        </li>
    </ul>
    <div class="btn1 btns">取消</div>
    <div class="btn2 btns">确定</div>
</div>
<div class="mu_add" id="icon_add1" >
    <div class="tit_up">添加<span>X</span></div>
    <ul>
        <li>
            <ul><li>位置:</li><li><input type="text" class="name"></li></ul>
        </li>
        <li>
            <ul><li>权重:</li><li><input type="text" class="quanzhong"></li></ul>
        </li>
        <li>
            <ul><li>KEY值:</li><li><input type="text" class="key"></li></ul>
        </li>
    </ul>
    <div class="btn1 btns">取消</div>
    <div class="btn2 btns">确定</div>
</div>
<div class="mu_add" id="mu_add1">
    <div class="tit_up">修改<span>X</span></div>
    <ul>
        <li>
            <ul><li>音效名称:</li><li><input type="text" class="name"></li></ul>
        </li>
        <li>
            <ul><li>KEY值:</li><li><input type="text" class="key"></li></ul>
        </li>
    </ul>
    <div class="btn1 btns">取消</div>
    <div class="btn2 btns">确定</div>
</div>

<div class="right-product my-index right-full">
    <ul id="myTab" class="nav nav-tabs">
        <li class="active">
            <a href="#home" data-toggle="tab">
                背景音效编辑
            </a>
        </li>
        <li><a href="#ios" data-toggle="tab">图标位置</a></li>

    </ul>
    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade in active" id="home">
            <div class="tit_">官方音效列表</div>
            <div class="true" id="true3x">
                添加<form class="weUploadForm" enctype="multipart/form-data">
                    <input class="weUploadMusic" name="music" type="file"/>
                </form>
            </div>
            <div class="divs ">
                <ul class="listtit">
                    <li class="long1">
                        &nbsp;
                    </li>
                    <li class="long2">
                        音效名称
                    </li>
                    <li class="long3">
                        大小
                    </li>
                    <li class="long4">
                        操作
                    </li>
                </ul>
            </div>
            <div class="divs mianlist" id="mianlist1">
                <ul>
                    <!--<li>
                        <ul>
                            <li class="long1">1</li>
                            <li class="long2">巴拉巴拉</li>
                            <li class="long3">2.22M</li>
                            <li class="long4"><span class="xiugai">修改</span><span class="del">删除</span></li>
                        </ul>
                    </li>-->

                </ul>
            </div>

        </div>
        <div class="tab-pane fade" id="ios">
            <div class="tit_">图标位置</div>
            <div class="true" id="true3">
                添加
            </div>
            <div class="divs">
                <ul class="listtit">
                    <li class="long1">
                        &nbsp;
                    </li>
                    <li class="long2">
                        权重
                    </li>
                    <li class="long3">
                        位置
                    </li>
                    <li class="long4">
                        操作
                    </li>
                </ul>
            </div>
            <div class="divs mianlist" id="mianlist2" >
                <ul>
                    <!--<li>
                        <ul>
                            <li class="long1">1</li>
                            <li class="long2">巴拉巴拉</li>
                            <li class="long3">左上角</li>
                            <li class="long4"><span class="xiugai">修改</span><span class="del">删除</span></li>
                        </ul>
                    </li>-->
                </ul>
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        //初始化数据
        $.ajax({
            type: "GET",
            url: "<?php echo U('admin/music/ajax') ?>",
            dataType: "json",
            success: function (data) {
                if (data.code == '0') {
                    var system = '';
                    var location = '';

                    for (var key in data.result.data.system) {
                        system += '<li><ul mid = ' + data.result.data.system[key].id + ' ><li class="long1">&nbsp;</li><li class="long2">' + data.result.data.system[key].name + '</li><li class="long3">' + data.result.data.system[key].music_size + '</li><li class="long4" jskey=' + data.result.data.system[key].jskey + '><span class="xiugai">修改</span><span  class="del">删除</span></li></ul></li>';
                    }
                    for (var key in data.result.data.location) {
                        location += '<li><ul mid = ' + data.result.data.location[key].id + '><li class="long1">&nbsp;</li><li class="long2">' + data.result.data.location[key].grade + '</li><li class="long3">' + data.result.data.location[key].name + '</li><li class="long4" jskey=' + data.result.data.location[key].jskey + '><span class="xiugai">修改</span><span  class="del">删除</span></li></ul></li>'
                    }

                    $('#mianlist1 ul').append(system);
                    $('#mianlist2 ul').append(location);


                }
            }
        });

        $('.tit_up span').click(function () {
            $(this).parent().parent().hide();
            $('.filer').hide();
        })
        click_1()
        function click_1() {//添加 修改 删除音乐列表
            $('.weUploadMusic').on('change', function (e) {
                var form = document.querySelector('.weUploadForm');
                var musicData = new FormData(form);
                $.ajax({
                    url: endUploadUrl,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    cache: false,
                    data: musicData,
                    success: function (result) {
                        console.log(result);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                })
            });

            $('.del').click(function () {//删除整行
                delmulist($(this))
            })
            function delmulist(the) {
                the.parent().parent().parent().remove();
            }
            var the
            $('#mianlist1 .xiugai').each(function (i, div) {
                $(this).click(function () {
                    var s = i
                    the = $(this)
                    $('.filer').show()
                    $('#mu_add1').show()
                    $('#mu_add1 .name').val(the.parent().parent().find('.long2').html());
                    $('#mu_add1 .key').val()


                })
            })
            $('#mu_add1 .btn1').click(function () {
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('#mu_add1 .btn2').click(function () {
                the.parent().parent().find('.long2').html($('#mu_add1 .name').val())
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('.del').click(function () {
                $(this).parent().parent().parent().remove()
            })
        }
        ADDicon()
        function ADDicon() { //ICON  添加
            var the
            var the2
            $('#true3').click(function () {
                $('#icon_add1 input').val('');
                $('#icon_add1').show();
                $('.filer').show()
            })
            $('#icon_add1 .btn1').click(function () {
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('#icon_add1 .btn2').click(function () {
                //the.parent().parent().find('.long2').html( $('#mu_add1 .name').val())

                if ($('#icon_add1 .quanzhong').val().length < 0 || $('#icon_add1 .quanzhong').val() == null || $('#icon_add1 .quanzhong').val() == undefined || $('#icon_add1 .quanzhong').val() == '') {
                    alert('请输入正确权重值')
                } else
                if ($('#icon_add1 .name').val().length < 0 || $('#icon_add1 .name').val() == null || $('#icon_add1 .name').val() == undefined || $('#icon_add1 .name').val() == '') {
                    alert('请输入名称')
                } else {
                    var thum = '<li><ul><li class="long1">&nbsp;</li><li class="long2">' + $('#icon_add1 .quanzhong').val() + '</li><li class="long3">' + $('#icon_add1 .name').val() + '</li><li class="long4"><span class="xiugai">修改</span><span class="del">删除</span></li></ul></li>'
                    $('#mianlist2>ul').append(thum)
                    $(this).parent().hide();
                    $('.filer').hide()
                    $('#mianlist2 .xiugai').each(function (i, div) {
                        $(this).click(function () {
                            var s = i
                            the2 = $(this)
                            $('.filer').show()
                            $('#icon_add2').show()
                            $('#icon_add2 .quanzhong').val(the2.parent().parent().find('.long2').html());
                            $('#icon_add2 .name').val(the2.parent().parent().find('.long3').html());
                            $('#icon_add2 .key').val()
                        })
                    })
                    $('.del').click(function () {
                        $(this).parent().parent().parent().remove()
                    })

                }
            })
            $('#icon_add2 .btn1').click(function () {
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('#icon_add2 .btn2').click(function () {
                the2.parent().parent().find('.long3').html($('#icon_add2 .name').val())
                the2.parent().parent().find('.long2').html($('#icon_add2 .quanzhong').val())
                $(this).parent().hide();
                $('.filer').hide()
            })

        }

        function icon() {//ICON列表 修改  删除
            var the
            $('#mianlist2 .xiugai').each(function (i, div) {
                $(this).click(function () {
                    var s = i
                    the = $(this)
                    $('.filer').show()
                    $('#icon_add2').show()
                    $('#icon_add2 .quanzhong').val(the.parent().parent().find('.long2').html());
                    $('#icon_add2 .name').val(the.parent().parent().find('.long3').html());
                    $('#icon_add2 .key').val()


                })
            })
            $('#icon_add2 .btn1').click(function () {
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('#icon_add2 .btn2').click(function () {
                the.parent().parent().find('.long3').html($('#icon_add2 .name').val())
                the.parent().parent().find('.long2').html($('#icon_add2 .quanzhong').val())
                $(this).parent().hide();
                $('.filer').hide()
            })
            $('.del').click(function () {
                $(this).parent().parent().parent().remove()
            })

        }
    });
</script>