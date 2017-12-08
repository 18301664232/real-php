
<script src='<?php echo STATICSADMIN ?>javascript/ajaxfileupload.js'></script>
<div class="container-fluid">
    <section>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="javascript:void(0)">背景音效编辑</a>
            </li>
            <li role="presentation">
                <a href="javascript:void(0)">icon位置编辑</a>
            </li>
        </ul>
        <div class="content-box">
            <div class="active content music clearfix">
                <div class="clearfix">
                    <div class="add-btn prev-btn">
                        <button id="musicadd" class="btn btn-info" >添加音效</button>
                    </div>
                </div>
                <div class="table-box">
                    <table id="system_music" class="active table table-hover">
                        <tr>
                            <th>排序</th>
                            <th>音效名称</th>
                            <th>音效大小</th>
                            <th>操作</th>
                        </tr>

                                <!-- 系统音乐内容开始 -->

                                  <!-- 系统音乐内容结束 -->
                    </table>
                </div>
            </div>
            <div class="content icon clearfix">
                <div class="clearfix">
                    <div class="add-btn prev-btn">
                        <button id="iconadd" class="btn btn-info" ">添加位置</button>
                    </div>
                </div>
                <div class="table-box">
                    <table id="icon_location" class="table table-hover">
                        <tr>
                            <th>排序</th>
                            <th>权重</th>
                            <th>位置名称</th>
                            <th>操作</th>
                        </tr>
                       <!--  音乐图标内容开始  -->
<!--                        <tr>-->
<!--                            <td>1</td>-->
<!--                            <td>1.1</td>-->
<!--                            <td>滑屏</td>-->
<!--                            <td>-->
<!--                                <button  class="btn btn-success iconedit" >修改</button>-->
<!--                                <button class="btn btn-danger del-btn">删除</button>-->
<!--                            </td>-->
<!--                        </tr>-->
                        <!--  音乐图标结束 -->
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div role='dialog' class='modal fade' id="yinxiao">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">音效</h4>
            </div>
            <div class="modal-body text-center">
                <form id="musform" class="form-horizontal" enctype="multipart/form-data">
                    <div class="form-group margin-b mus-origin-box">
                        <label for="" class="control-label col-sm-2">音效源</label>
                        <div class="col-sm-10">
                            <input id="m-origin" type="file" name="music" class="form-control mus-origin" placeholder="音效源文件">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">音效名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control mus-name" placeholder="音效名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">KEY值</label>
                        <div class="col-sm-10">
                            <input type="text" name="key" class="form-control mus-key" placeholder="KEY值">
                        </div>
                    </div>
                    <div class="form-group margin-b mus-id-box hidden">
                        <label for="" class="control-label col-sm-2">id值</label>
                        <div class="col-sm-10">
                            <input type="text" name="id" class="form-control mus-id" placeholder="id值">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button id="suc-ok" class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- icon位置弹框 -->
<div role='dialog' class='modal fade' id="weizhi">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">位置</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">位置名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control icon-name" placeholder="位置名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">配置权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control icon-grade" placeholder="配置权重">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">KEY值</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control icon-key" placeholder="KEY值">
                        </div>
                    </div>
                    <div class="form-group margin-b fade ">
                        <label for="" class="control-label col-sm-2">id值</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control icon-id" placeholder="id值">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button id="icon-ok" class='btn btn-danger btn-sm btn-click ' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var mus_status = true;

        //音乐添加按钮配置
        $('#musicadd').on('click', function (event) {
            mus_status = true;
            $('.mus-origin-box').show();
            $('.mus-name').val('');
            $('.mus-key').val('');
            $('.mus-origin').val('');
            $('.mus-id').val('');
            $('.mus-id-box').hide();
            $("#yinxiao").modal({show:true});

        });

        //音乐修改按钮配置
        $('#system_music').delegate('.musedit', 'click', function() {
            mus_status = false;
            $('.mus-origin-box').hide();
            $('.mus-origin').val('');
            $("#yinxiao").modal({show:true});
            //获取到当前DOM里面的值
            var tr=$(this).parent().parent();
            var tr_arr=$(this).parent().parent().children();
            $('.mus-name').val($(tr_arr[1]).html());
            $('.mus-key').val($(tr_arr[0]).html());
            $('.mus-id').val($(tr).attr('mucid'));

        });

        //系统音乐增加和删除
        $('#suc-ok').on('click', function () {
            if (mus_status) {
                var musform = new FormData(document.getElementById("musform"));
    //             var req = new XMLHttpRequest();
    //             req.open("post", "${pageContext.request.contextPath}/public/testupload", false);
    //             req.send(form);
                $.ajax({
                    url:"<?php echo U('admin/music/systemadd')?>",
                    type:"post",
                    data:musform,
                    processData:false,
                    contentType:false,
                    success:function(data){
                        var obj = JSON.parse(data);
                        datainit();
                        alert("添加成功！！"+obj.msg);
                    },
                    error:function(e){
                        alert("代码提交错误！！");
                    }
                });
            } else {
                console.log('正在更新');
                //更新系统音乐
                var name = $('.mus-name').val();
                var key= $('.mus-key').val();
                var upmusid= $('.mus-id').val();
                console.log(upmusid);
                $.post(
                    "<?php echo U('admin/music/systemupdate')?>",
                    {
                        id: upmusid,
                        name: name,
                        key:key

                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            datainit();
                            alert('更新成功');
                        }else{
                            alert('更新失败');
                        }
                    }
                );

            }

        });



        //定义当前添加或者修改状态
        var ionic_status = true;
        $('#iconadd').on('click', function (event) {
            ionic_status = true;
            $('.icon-name').val('');
            $('.icon-grade').val('');
            $('.icon-key').val('');
            $('.icon-id').val('');
            $("#weizhi").modal({show:true});

        });
        $('#icon_location').delegate('.iconedit', 'click', function() {
            ionic_status = false;
            $("#weizhi").modal({show:true});
            //获取到当前DOM里面的值
            var tr=$(this).parent().parent();
            var tr_arr=$(this).parent().parent().children();
            $('.icon-name').val($(tr_arr[2]).html());
            $('.icon-grade').val($(tr_arr[1]).html());
            $('.icon-key').val($(tr_arr[0]).html());
            $('.icon-id').val($(tr).attr('iconid'));


        });

        //音乐图标位置的删除
        $('#icon_location').delegate('.del-btn', 'click', function() {
            var nowdom=$(this);
            var iconid=$(this).parent().parent().attr('iconid');
            if(iconid){
                $.get("<?php echo U('admin/music/locationdel')?>",
                    {
                        id:iconid
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){

                            nowdom.parent().parent().remove();
                            alert('删除成功');
                        }else{
                            alert('删除失败');
                        }

                    });
            }
        });

        //图标位置的更新或者添加
        $('#icon-ok').on('click', function () {
            if (ionic_status) {
                //添加图标位置
                var name = $('.icon-name').val();
                var grade = $('.icon-grade').val();
                var key = $('.icon-key').val();
                $.post(
                    "<?php echo U('admin/music/locationdd')?>",
                    {
                        name: name,
                        grade: grade,
                        jskey: key
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            alert('添加成功');
                            datainit();
                        } else {
                            alert('添加失败' + '' + obj.msg);
                        }
                    }
                );

            } else {
                //更新图标位置
                var name = $('.icon-name').val();
                var grade = $('.icon-grade').val();
                var key = $('.icon-key').val();
                var iconnowid = $('.icon-id').val();
                $.post(
                    "<?php echo U('admin/music/locationupdate')?>",
                    {
                        id : iconnowid,
                        name : name,
                        grade : grade,
                        jskey : key
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            datainit();
                            alert('更新成功');
                        }else{
                            alert('更新失败');
                        }
                    }
                );

            }

        });

        //执行一次//
        datainit();
        function datainit() {
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
                            // system += '<li><ul  mucid = ' + data.result.data.system[key].id + ' ><li class="long1">&nbsp;</li><li class="long2">' + data.result.data.system[key].name + '</li><li class="long3">' + data.result.data.system[key].music_size + '</li><li class="long4" jskey=' + data.result.data.system[key].url + '><span class="xiugai">修改</span><span  class="del">删除</span></li></ul></li>';
                            system += '<tr mucid = ' + data.result.data.system[key].id + '>'+
                                '<td>'+data.result.data.system[key].id+'</td>'+
                                '<td>'+data.result.data.system[key].name+'</td>'+
                                '<td>'+data.result.data.system[key].music_size+'</td>'+
                                '<td>'+
                                '<button class="btn btn-success edit-btn musedit" >'+'修改'+'</button>'+
                                ' <button class="btn btn-danger del-btn">'+'删除'+'</button>'+
                                '</td>'+
                                '</tr>'
                        }
                        for (var key in data.result.data.location) {
                            //  location += '<li><ul iconid = ' + data.result.data.location[key].id + '><li class="long1">&nbsp;</li><li class="long2">' + data.result.data.location[key].grade + '</li><li class="long3">' + data.result.data.location[key].name + '</li><li class="long4" jskey=' + data.result.data.location[key].jskey + '><span class="xiugai">修改</span><span  class="del">删除</span></li></ul></li>'
                            location += '<tr iconid = ' +data.result.data.location[key].id + '>'+
                                '<td>'+data.result.data.location[key].id+'</td>'+
                                '<td>'+data.result.data.location[key].grade+'</td>'+
                                '<td>'+data.result.data.location[key].name+'</td>'+
                                '<td>'+
                                '<button class="btn btn-success edit-btn iconedit">修改</button>'+
                                ' <button class="btn btn-danger del-btn">删除</button>'+
                                '</td>'+
                                '</tr>'
                        }
                        $('#system_music tr:gt(0)').remove();
                        $('#icon_location tr:gt(0)').remove();
                        $('#system_music').append(system);
                        $('#icon_location').append(location);
                        checkAuth();
                    }
                }
            });
        }

        //删除系统音乐列表项
        $('#system_music').delegate('.del-btn', 'click', function() {
            var nowdom=$(this);
            var mucid=$(this).parent().parent().attr('mucid');
            if(mucid){
                $.get("<?php echo U('admin/music/systemdel')?>",
                    {
                        id:mucid
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            nowdom.parent().parent().remove();
                            alert('删除成功');
                        }else{
                            alert('删除失败'+''+obj.msg);
                        }
                    });
               }
        });

        //执行权限--以下是在没有权限的情况下操作
        function checkAuth() {
            if(<?php echo $this->checkAuth('admin/switchover/add') ?>){

                $('.add-btn button').attr('disabled','disabled');
                $('#iconadd').attr('disabled','disabled');

            }
            if(<?php  echo $this->checkAuth('admin/switchover/edit') ?>){
                $('.table-box tr button').attr('disabled','disabled');
            }
            if(<?php  echo $this->checkAuth('admin/switchover/list') ?>){
                $('.nav-tabs li').unbind();
            }
        };


        //增加系统音乐列表项

//        $('.tit_up span').click(function () {
//            $(this).parent().parent().hide();
//            $('.filer').hide();
//        });
//        click_1();
//        function click_1() {//添加 修改 删除音乐列表
//            $('.weUploadMusic').on('change', function (e) {
//                var form = document.querySelector('.weUploadForm');
//                var musicData = new FormData(form);
//                $.ajax({
//                    url: '<?php //echo U('admin/music/systemadd')?>//',
//                    type: 'POST',
//                    processData: false,
//                    contentType: false,
//                    cache: false,
//                    data: musicData,
//                    success: function (result) {
////                        var obj = JSON.parse(result);
//                        console.log(result);
////                        if(obj.code == 0){
////                            alert('添加成功');
////                        }else{
////                            alert('添加失败'+''+obj.msg);
////                        }
//                    },
//                    error: function (error) {
//                        console.log(error);
//                    }
//                })
//            });}
//
////            $('.del').click(function () {//删除整行
////                delmulist($(this))
////            });
////            function delmulist(the) {
////                the.parent().parent().parent().remove();
////            }
//        ////修改系统音乐不全面
////        $('#system_music').delegate('.edit-btn', 'click', function() {
////
////            $('.filer').show();
////            $('#mu_add1').show();
////            var a= $('#mu_add1 .name').val($(this).parent().parent().find('.long2').html());
////            $('#mu_add1 .key').val();
////
////            console.log(1111);
////
////        });
////        $('#mu_add1 .btn1').click(function () {
////            $(this).parent().hide();
////            $('.filer').hide()
////        });
////            $('#mu_add1 .btn2').click(function () {
////                the.parent().parent().find('.long2').html($('#mu_add1 .name').val());
////                $(this).parent().hide();
////                $('.filer').hide()
////            });
////            $('.del').click(function () {
////                $(this).parent().parent().parent().remove()
////            })
////        }
//
//
////            $('#icon_add1 .btn2').click(function () {
////                //the.parent().parent().find('.long2').html( $('#mu_add1 .name').val())
////
////                console.log(111);
////                if ($('#icon_add1 .quanzhong').val().length < 0 || $('#icon_add1 .quanzhong').val() == null || $('#icon_add1 .quanzhong').val() == undefined || $('#icon_add1 .quanzhong').val() == '') {
////                    alert('请输入正确权重值')
////                } else
////                if ($('#icon_add1 .name').val().length < 0 || $('#icon_add1 .name').val() == null || $('#icon_add1 .name').val() == undefined || $('#icon_add1 .name').val() == '') {
////                    alert('请输入名称')
////                } else {
////                    //如果参数输入正确提交post请求
////                    $.post(
////                        "<?php ////echo U('admin/music/locationdd')?>////",
////                        {
////                            name:$('#icon_add1 .name').val(),
////                            grade:$('#icon_add1 .quanzhong').val(),
////                            jskey:$('#icon_add1 .key').val()
////                        },
////                        function(data){
////                            var obj = JSON.parse(data);
////                            if(obj.code == 0){
////                                alert('添加成功');
////                            }else{
////                                alert('添加失败'+''+obj.msg);
////                            }
////                        }
////                    );
//
//                    var thum = '<li><ul><li class="long1">&nbsp;</li><li class="long2">' + $('#icon_add1 .quanzhong').val() + '</li><li class="long3">' + $('#icon_add1 .name').val() + '</li><li class="long4"><span class="xiugai">修改</span><span class="del">删除</span></li></ul></li>'
//                    $('#mianlist2>ul').append(thum);
//
//
//                    $(this).parent().hide();
//                    $('.filer').hide();
//
//
//                }
//            });

//            // 修改按钮加事件
//            $('#mianlist2 ul').delegate('.xiugai', 'click', function() {
//                ionic_status = false;
//                the2 = $(this);
//                $('.filer').show();
//                $('#icon_add2').show();
//                $('#icon_add2 .quanzhong').val(the2.parent().parent().find('.long2').html());
//                $('#icon_add2 .name').val(the2.parent().parent().find('.long3').html());
//                $('#icon_add2 .key').val();
//                $('#icon_add2 .nowid').val(the2.parent().parent().attr('iconid'));
//            });
//
//
//
//            $('#icon_add2 .btn1').click(function () {
//                $(this).parent().hide();
//                $('.filer').hide()
//            });
//
//            //音乐图标位置的更新
//            $('#icon_add2 .btn2').click(function () {
//
//                $.post(
//                    "<?php //echo U('admin/music/locationupdate')?>//",
//                    {
//                        id:$('#icon_add2 .nowid').val(),
//                        name:$('#icon_add2 .name').val(),
//                        grade:$('#icon_add2 .quanzhong').val(),
//                        jskey:$('#icon_add2 .key').val()
//                    },
//                    function(data){
//                        var obj = JSON.parse(data);
//                        if(obj.code == 0){
//                            alert('更新成功');
//                        }else{
//                            alert('更新失败');
//                        }
//                    }
//                );
//                the2.parent().parent().find('.long3').html($('#icon_add2 .name').val());
//                the2.parent().parent().find('.long2').html($('#icon_add2 .quanzhong').val());
//                $(this).parent().hide();
//                $('.filer').hide()
//            });


//
//        function icon() {//ICON列表 修改  删除
//            var the;
//            $('#mianlist2 .xiugai').each(function (i, div) {
//                $(this).click(function () {
//                    var s = i;
//                    the = $(this);
//                    $('.filer').show();
//                    $('#icon_add2').show();
//                    $('#icon_add2 .quanzhong').val(the.parent().parent().find('.long2').html());
//                    $('#icon_add2 .name').val(the.parent().parent().find('.long3').html());
//                    $('#icon_add2 .key').val()
//
//
//                })
//            });
//            $('#icon_add2 .btn1').click(function () {
//                $(this).parent().hide();
//                $('.filer').hide()
//            });
//            $('#icon_add2 .btn2').click(function () {
//                the.parent().parent().find('.long3').html($('#icon_add2 .name').val());
//                the.parent().parent().find('.long2').html($('#icon_add2 .quanzhong').val());
//                $(this).parent().hide();
//                $('.filer').hide()
//            });
//            $('.del').click(function () {
//                $(this).parent().parent().parent().remove()
//            })
//
//        }
    });
</script>
