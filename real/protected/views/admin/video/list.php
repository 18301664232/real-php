<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/check_management.css">
<script src='<?php echo STATICSADMIN ?>javascript/check_management.js'></script>

<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">
                <div class="input-group col-sm-4">
                    <input id="search-key" type="text" class="form-control" placeholder="PID,项目名">
                    <span class="input-group-btn">
	    				    	<button id="search-btn" class="btn btn-default" type="button">搜索</button>
	    				    </span>
                </div>
            </div>
        </div>
        <div class="query-box">
            <div class="row">
                <div class="clearfix">
                    <em>项目类别：</em>
                    <ul class="clearfix">
                        <li class="active">全部</li>
                        <li>自有项目</li>
                        <li>公开项目</li>
                    </ul>
                </div>
                <div class="clearfix">
                    <em>审查状态：</em>
                    <ul class="clearfix">
                        <li data-status="1" class="active">待审核</li>
                        <li data-status="2">已审核</li>
                    </ul>
                </div>
                <div class="clearfix">
                    <em>项目类型：</em>
                    <ul class="clearfix">
                        <li data-video="0" class="active">全部</li>
                        <li data-video="2">视频项目</li>
                        <li data-video="1">非视频项目</li>
                    </ul>
                </div>

                <div class="current-num">
                    当前条件共有数据：<span class="current-nownum" style="color:#ff6700">0</span>条
                </div>
            </div>
        </div>
        <div class="table-box">
            <table class="table table-bordered">
                <tr>
                    <th>序号</th>
                    <th>项目名称</th>
                    <th>帐号</th>
                    <th>PID</th>
                    <th>项目类型</th>
                    <th>项目类别</th>
                    <th>项目操作</th>
                </tr>
                <!--   ///////////////////////       -->
                <!--                <tr>-->
                <!--                    <td>1</td>-->
                <!--                    <td>草榴社区</td>-->
                <!--                    <td>13666666666@qq.com</td>-->
                <!--                    <td>视频项目</td>-->
                <!--                    <td>DDSDSDS</td>-->
                <!--                    <td>自有项目</td>-->
                <!--                    <td>-->
                <!--                        <button class="btn btn-info btn-look" data-toggle="modal" data-target="#check_tip">查看</button>-->
                <!--                        <button class="btn btn-success btn-bak">备份</button>-->
                <!--                        <button class="btn btn-default btn-die" data-toggle="modal" data-target="#shield_form">屏蔽</button>-->
                <!--                        <button class="btn btn-danger relieve">通过</button>-->
                <!--                    </td>-->
                <!--                </tr>-->

                <!--   ///////////////////////       -->
            </table>
        </div>
        <div class="page-box ">
            <nav class="clearfix" aria-label="Page navigation">
                <div class="row">

                    <ul class="pagination ">
                        <li class="pagein">
                            <a href="javascript:void(0)" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!--                        ///从次插入进去-->

                        <li pageattr="" class="pageend">
                            <a href="javascript:void(0)" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

    </section>
</div>
</div>
<!-- 屏蔽弹框 -->
<div role='dialog' class='modal fade' id="shield_form">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">屏蔽项目</h4>
            </div>
            <div class="modal-body text-center">
                <form action="">
                    <h1 class="hidden">3</h1>
                    <h3 class="hidden">2</h3>
                    <h2 class="hidden">1</h2>
                    <h5 style="padding-bottom:15px">确定要屏蔽此项目么？（PID：<span>sadfasdf</span>）</h5>
                    <div class="input-group" style="margin-bottom:20px">
                        <span class="input-group-addon" id="basic-addon3">所属账号</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon3"
                               value="asdfa@163.com">
                    </div>
                    <div class="input-group" style="margin-bottom:40px">
                        <span class="input-group-addon" id="basic-addon3">屏蔽次数</span>
                        <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon3"
                               value="3">
                    </div>
                    <div class="input-group" style="margin-bottom:20px">
                        <span class="input-group" id="">选择屏蔽原因（选择后，该用户将受到告知消息）</span>
                    </div>
                    <div class="input-group">
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox1" value=" 内容含有敏感信息"> 内容含有敏感信息
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox2" value="项目无实质性内容"> 项目无实质性内容
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="侵犯他人知识产权"> 侵犯他人知识产权
                        </label>
                        <label class="checkbox-inline">
                            <input type="checkbox" id="inlineCheckbox3" value="其他"> 其他
                        </label>
                    </div>
                    <div class="form-group" style="margin-top:20px">
                        <textarea class="form-control" rows="5" style="resize:none" placeholder="请输入详细内容"></textarea>
                    </div>
                    <div class="button-group">
                        <button type="button" data-dismiss='modal' class="btn btn-primary btn-block">确认</button>
                        <button type="button" data-dismiss='modal' class="btn btn-default btn-block">取消</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 查看弹框 -->
<div role='dialog' class='modal fade' id="check_tip">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">项目审核</h4>
            </div>
            <div class="modal-body text-center">
                <div class="btn-group" role="group" style="padding-bottom:15px">
                    <p class="btn btn-default" style="width:190px">创建日期<span class="create-time">0</span></p>
                    <p class="btn btn-default" style="width:190px">最近更新<span class="recent-update">0</span></p>
                    <p class="btn btn-default" style="width:190px">累计更新<span class="total-update">0</span>次</p>
                </div>
                <div class="form-horizontal">
                    <div class="form-group" style="padding-top:15px">
                        <label for="inputEmail3" class="col-sm-2 control-label">投放渠道</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="inputEmail3" placeholder="投放渠道">
                        </div>
                    </div>
                    <div class="form-group" style="padding-top:15px">
                        <label for="inputPassword3" class="col-sm-2 control-label">电脑查看</label>
                        <div class="col-sm-10">
                            <div><a target="_blank" class="look-link"
                                    style="display:block;text-align:left;color: #00a0e9" href="">未找到链接</a></div>
                        </div>
                    </div>
                    <div class="form-group" style="padding-top:15px">
                        <label for="" class="col-sm-2 control-label">扫码查看</label>
                        <div class="col-sm-10">
                            <img class="look-img" src="" alt="" style="width:120px;height:120px;display:block">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    $(function () {
        var verify_status = '1';
        var is_has_video = '';
        var search_key = '';
        //执行一次//
        datainit(1, verify_status, is_has_video, search_key);
        function datainit(page=null, verify_status, is_has_video, search_key) {

            if (!page) page = 1;
            //初始化数据
            $.ajax({
                type: "POST",
                url: "<?php echo U('admin/video/ajax') ?>",
                dataType: "json",
                data: {
                    page: page,
                    verify_status: verify_status,
                    is_has_video: is_has_video,
                    search_key: search_key
                },
                success: function (data) {
                    if (data.code == '0') {
                        var column_str = '';
                        $('.table-bordered tr:gt(0)').remove();
                        for (var key in data.result.data) {

                            if (verify_status == 2) {

                                column_str += '<tr data-selfid=' + data.result.data[key]['id'] + ' data-selfpid=' + data.result.data[key]['product_id'] + '>' +
                                    '<td>' + (parseInt(key) + 1) + '</td>' +
                                    '<td>' + data.result.data[key]['title'] + '</td>' +
                                    '<td>' + data.result.data[key]['tel'] + '</td>' +
                                    '<td>' + data.result.data[key]['product_id'] + '</td>' +
                                    '<td>视频项目</td>' +
                                    '<td>自有项目</td>' +
                                    '<td>' +
                                    '<button class="btn btn-info btn-look" data-toggle="modal" data-target="#check_tip">查看</button>' +
                                    ' <button class="btn btn-success btn-bak">备份</button>'
                                if (data.result.data[key]['status'] == '已屏蔽') {
                                    column_str += ' <button  data-tel=' + data.result.data[key]['tel'] + ' class="btn btn-danger btn-life" >解除</button>'
                                } else {
                                    column_str += ' <button  data-tel=' + data.result.data[key]['tel'] + ' class="btn btn-default btn-die" data-toggle="modal" data-target="#shield_form">屏蔽</button>'
                                }
                                column_str += '</td>'
                                column_str += '</tr>'


                            } else {

                                column_str += '<tr data-selfid=' + data.result.data[key]['id'] + ' data-selfpid=' + data.result.data[key]['product_id'] + '>' +
                                    '<td>' + (Number(key) + 1) + '</td>' +
                                    '<td>' + data.result.data[key]['title'] + '</td>' +
                                    '<td>' + data.result.data[key]['tel'] + '</td>' +
                                    '<td>' + data.result.data[key]['product_id'] + '</td>' +
                                    '<td>视频项目</td>' +
                                    '<td>自有项目</td>' +
                                    '<td>' +
                                    '<button class="btn btn-info btn-look" data-toggle="modal" data-target="#check_tip">查看</button>' +
                                    ' <button class="btn btn-success btn-bak">备份</button>' +
                                    ' <button  data-tel=' + data.result.data[key]['tel'] + ' class="btn btn-default btn-die" data-toggle="modal" data-target="#shield_form">屏蔽</button>' +
                                    ' <button class="btn btn-danger relieve">通过</button>' +
                                    '</td>' +
                                    '</tr>'

                            }

                        }

                        $('.table-bordered').append(column_str);
                        $('.current-nownum').html(data.result.c_count);
                        $('.pageend').attr('pageattr', data.result.pages);

                        console.log(data.result.pages);

                        //遍历出一共多少个按钮
                        var btnstr = '';

                        function addstr(page, i) {
                            if (i == page) {
                                btnstr += '<li class="active isup"><a class="isa" href="javascript:void(0)">' + i + '</a></li>';
                            } else {
                                btnstr += '<li class="isup"><a class="isa" href="javascript:void(0)">' + i + '</a></li>';
                            }
                        }

                        if (data.result.pages <= 7) {

                            for (var i = 1; i <= data.result.pages; i++) {
                                addstr(page, i)
                            }
                        } else {

                            if (page <= 3) {
                                for (var i = 1; i <= 7; i++) {
                                    addstr(page, i)
                                }
                            } else if (page > data.result.pages - 3) {
                                for (var i = data.result.pages - 6; i <= data.result.pages; i++) {
                                    addstr(page, i)
                                }

                            } else {
                                yop = parseInt(page) - 3;
                                end = parseInt(page) + 3;
                                for (var i = yop; i <= end; i++) {
                                    addstr(page, i)
                                }
                            }

                        }
                        $('.isup').remove();
                        $('.pagein').after(btnstr);

                    } else {
                        $('.isup').remove();
                        $('.table-bordered tr:gt(0)').remove();

                    }
                }
            });
        }

        //给按钮绑定事件
        $('.pagination').delegate('.isa', 'click', function () {

            $(this).parent().siblings('li').removeClass('active');
            datainit($(this).html(), verify_status, is_has_video, search_key);
        });
        $('.pagein').click(function () {
            datainit(1, verify_status, is_has_video, search_key);
        });
        $('.pageend').click(function () {
            datainit($(this).attr('pageattr'), verify_status, is_has_video, search_key);
        });

        //提交按钮绑定事件
        $('.query-box .row li').click(function () {
            $('.query-box .row li.active').each(function (index, element) {
                if ($(element).attr('data-status')) {
                    verify_status = $(element).attr('data-status');
                }
                if ($(element).attr('data-video')) {
                    is_has_video = $(element).attr('data-video');
                }
                search_key = $('#search-key').val();

            });
            datainit(1, verify_status, is_has_video, search_key);
        });
        //搜索按钮绑定事件
        $('#search-btn').click(function () {
            search_key = $('#search-key').val();
            datainit(1, verify_status, is_has_video, search_key);
        });

        //展示项目详情
        $('.table-box .table-bordered').delegate('.btn-look', 'click', function () {
            var pid = $(this).parent().parent().attr('data-selfpid');
            if (pid) {
                $.get("<?php echo U('admin/video/ProDetial')?>",
                    {
                        product_id: pid
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            $('#check_tip').find('.create-time').html(obj.result.data.addtime);
                            $('#check_tip').find('.recent-update').html(obj.result.data.uptime);
                            $('#check_tip').find('.total-update').html(obj.result.up_count);
                            $('#check_tip').find('.look-link').html(obj.result.data.show_url);
                            $('#check_tip').find('.look-link').attr('href', obj.result.data.show_url);
                            $('#check_tip').find('.look-img').attr('src', "<?php echo REAL . U('product/preview/Createimg') . '&id=' ?>" + obj.result.data.uid);

                        } else {
                            // alert('项目详情读取失败');
                        }
                    });
            }
        });

        //项目备份
        $('.table-box .table-bordered').delegate('.btn-bak', 'click', function () {
            var pid = $(this).parent().parent().attr('data-selfpid');
            var id = $(this).parent().parent().attr('data-selfid');
            if (pid) {
                $.get("<?php echo U('admin/video/ProCopy')?>",
                    {
                        product_id: pid,
                        verify_id: id

                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            saveTip('备份成功');


                        } else {
                            // saveTip('项目详情读取失败');
                        }
                    });
            }
        });

        var p_ajax_name = '';
        //屏蔽项目
        $('.table-box .table-bordered').delegate('.btn-die', 'click', function () {
            var pid = $(this).parent().parent().attr('data-selfpid');
            var id = $(this).parent().parent().attr('data-selfid');
            var user_tel = $(this).attr('data-tel');
            p_ajax_name = $(this).parent().parent().children().eq(1).text();
            if (pid) {
                $.get("<?php echo U('admin/video/ProDetial')?>",
                    {
                        product_id: pid,
                        verify_id: id
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            $('#shield_form input').eq(1).val(obj.result.die_count);
                            $('#shield_form input').eq(0).val(user_tel);
                            $('#shield_form h2').html(user_tel);
                            $('#shield_form h3').html(pid);
                            $('#shield_form h1').html(id);


                        } else {
                            // saveTip('项目详情读取失败');
                        }
                    });
            }
        });

        //执行屏蔽

        $('#shield_form').find('.btn-primary').click(function () {

            var pid = $('#shield_form h3').html();
            var id = $('#shield_form h1').html();
            var user_tel = $('#shield_form h2').html();
            var reason = encodeURI($('#shield_form input:checked').val() + '@' + $('#shield_form textarea').val());
            var p_name = p_ajax_name;

            //初始化数据
            $.ajax({
                type: "POST",
                url: "<?php echo U('admin/video/ForceOut') ?>",
                dataType: "json",
                data: {
                    product_id: pid,
                    id: id,
                    type: 'p_no',
                    reason: reason,
                    user_tel: user_tel,
                    product_name: p_name
                },
                success: function (data) {
                    if (data.code == 0) {
                        saveTip('屏蔽成功');
                        datainit(1, verify_status, is_has_video, search_key);
                    } else {
                        saveTip('屏蔽失败');
                    }
                }
            })

        })

        //执行解除

        $('.table-box .table-bordered').delegate('.btn-life', 'click', function () {

            var pid = $(this).parent().parent().attr('data-selfpid');
            var id = $(this).parent().parent().attr('data-selfid');
            var user_tel = $(this).attr('data-tel');

            //初始化数据
            $.ajax({
                type: "POST",
                url: "<?php echo U('admin/video/ForceOut') ?>",
                dataType: "json",
                data: {
                    product_id: pid,
                    id: id,
                    type: 'p_ok',
                    user_tel: user_tel,

                },
                success: function (data) {
                    if (data.code == 0) {
                        saveTip('解除成功');
                        datainit(1, verify_status, is_has_video, search_key);
                    } else {
                        saveTip('解除失败');
                    }
                }
            })

        })

        //执行通过

        $('.table-box .table-bordered').delegate('.relieve', 'click', function () {

            var pid = $(this).parent().parent().attr('data-selfpid');
            var id = $(this).parent().parent().attr('data-selfid');
            // var user_tel = $(this).attr('data-tel');
            //初始化数据
            $.ajax({
                type: "POST",
                url: "<?php echo U('admin/video/ForceOut') ?>",
                dataType: "json",
                data: {
                    product_id: pid,
                    id: id,
                    type: 'p_ok',
                    //user_tel: user_tel
                },
                success: function (data) {
                    if (data.code == 0) {
                        datainit(1, verify_status, is_has_video, search_key);
                        saveTip('通过成功');

                    } else {
                        saveTip('通过失败');
                    }
                }
            })

        })


    });


    //    $.post(
    //        "<?php //echo U('admin/video/ProDetial')?>//",
    //        {
    //
    //        },
    //        function(data){
    //            var obj = JSON.parse(data);
    //            console.log(obj.result.data.url);
    //            $('img').attr('src','http://localhost/yii9/real/?r=admin/video/Linkimg&url='+'http://www.baidu.com');
    ////            if(obj.code == 0){
    ////
    ////                alert('更新成功');
    ////            }else{
    ////                alert('更新失败');
    ////            }
    //        }
    //    );


</script>