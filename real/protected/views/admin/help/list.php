<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/help_edit.css">
<script src="<?php echo STATICSADMIN ?>javascript/help_edit.js"></script>

<div class="right-product ">
    <div class="container-fluid">
        <section class="help-box">
            <ul class="nav nav-tabs">
                <li role="presentation" class="active">
                    <a href="javascript:void(0)">
                        <?php if($this->checkAuth('admin/index/list')){ echo '有权限';} ?> 类目管理
                        <?php  dump(Yii::app()->session['admin'])  ?> 类目管理
                    </a>
                </li>
                <li role="presentation">
                    <a href="javascript:void(0)" class="file_list">文档管理</a>
                </li>
            </ul>
            <div class="content-box">
                <div class="active content clearfix">
                    <div class="yiji active">
                        <div class="clearfix">
                            <div class="input-group col-sm-4 search-box">
                                <input type="text" class="form-control one_input" placeholder="输入一级类目名称">
                                <span class="input-group-btn">
                                    <button class="btn btn-default one_ss" type="button">搜索</button>
                                </span>
                            </div>
                            <div class="add-btn prev-btn">
                                <button class="btn btn-info" data-toggle="modal" data-target="#leimu1">添加</button>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="active table table-hover one_list">


                                <th>序号</th>
                                <th>权重</th>
                                <th>一级类目名</th>
                                <th>二级类目数</th>
                                <th>三级文档总数</th>
                                <th>操作</th>

                                <?php foreach ($data as $k => $v): ?>
                                    <tr>
                                        <td><?php echo $v['id'] ?></td>
                                        <td><?php echo $v['grade'] ?></td>
                                        <td><?php echo $v['title'] ?></td>
                                        <td><?php echo $v['child'] ?></td>
                                        <td><?php echo $v['childs'] ?></td>
                                        <td>
                                            <button class="btn btn-info look">查看</button>
                                            <button class="btn btn-success one_xg" data-toggle="modal"
                                                    data-target="#leimu1x">修改
                                            </button>
                                            <button class="btn btn-danger one_del">删除</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                    <div class="erji">
                        <div class="clearfix">
                            <div class="input-group col-sm-4 search-box">
                                <input type="text" class="form-control two_input" placeholder="输入二级类目名称">
                                <span class="input-group-btn">
                                    <button class="btn btn-default two_ss" type="button">搜索</button>
                                </span>
                            </div>
                            <div class="add-btn prev-btn">
                                <button class="btn btn-info" data-toggle="modal" data-target="#leimu2">添加</button>
                                <button class="btn btn-success return-btn">返回</button>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="active table table-hover two_list">
                                <tr>
                                    <th>序号</th>
                                    <th>权重</th>
                                    <th>二级类目名</th>
                                    <th>三级文档总数</th>
                                    <th>操作</th>
                                </tr>

                            </table>
                        </div>
                    </div>
                </div>
                <div class="content clearfix">
                    <div class="clearfix">
                        <div class="input-group col-sm-4 search-box">
                            <input type="text" class="form-control three_input" placeholder="请输入文档名">
                            <span class="input-group-btn">
                                <button class="btn btn-default three_ss" type="button">搜索</button>
                            </span>
                        </div>
                        <div class="add-btn prev-btn">
                            <button class="btn btn-info btn-ueditor">添加</button>
                        </div>
                    </div>
                    <div class="table-box">
                        <table class="table table-hover three_list">
                            <tr>
                                <th>序号</th>
                                <th>权重</th>
                                <th>文档名称</th>
                                <th>
                                    <select name="twoname" class="twoname">
                                        <option value="">全部</option>

                                    </select>
                                </th>
                                <th>操作</th>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
        </section>
        <section class="ueditor-box">
            <div class="go-back">
                <p>返回上级</p>
            </div>
            <div class="form-group">
                <label for="exampleInput">标题：</label>
                <input type="email" class="form-control ueditor-title" placeholder="请输入标题">
            </div>
            <div class="form-group">
                <label for="exampleInput">权重：</label>
                <input type="email" class="form-control ueditor-grade" style="width: 1000px;" placeholder="请输入权重">
            </div>
            <script id="editor" type="text/plain" style="height:500px;"></script>
            <script type="text/javascript">

                //实例化编辑器
                //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                var ue = UE.getEditor('editor');

            </script>
            <div class="ueditor-right-box clearfix">
                <div class="ueditor-right">
                    <div class="select-category">
                        <h4>选择发布类目</h4>
                        <form class="form-horizontal">
                        </form>
                        <button type="button" class="btn btn-success threeadd">发布</button>
                    </div>
                </div>

            </div>
    </div>
    </section>
</div>
</div>
<!-- 弹框 -->
<div role='dialog' class='modal fade' id="leimu1">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">添加一级类目</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">类目名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control title" placeholder="类目名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grade" placeholder="权重">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click leimu1' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 弹框 -->
<div role='dialog' class='modal fade' id="leimu1x" str=''>
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">修改一级类目</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">类目名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control title" placeholder="类目名称" value="">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grade" placeholder="权重" value="">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click leimu1x' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 弹框 -->
<div role='dialog' class='modal fade' id="leimu2">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">添加二级类目</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">类目名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control title" placeholder="类目名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grade" placeholder="权重">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click leimu2' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- 弹框 -->
<div role='dialog' class='modal fade' id="leimu2x" str=''>
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">修改二级类目</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">类目名称</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control title" placeholder="类目名称" value="">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control grade" placeholder="权重" value="">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click leimu2x' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function () {
        var obj
        //添加一级类目
        $('.leimu1').on('click', function () {
            var title = $('#leimu1 .title').val();
            var grade = $('#leimu1 .grade').val();
            var types = 1;
            var data = addajax(title, grade, types);
            if (data.code == 0) {
                window.location.reload();
                // var nr = "<tr><td>" + data.result.id + "</td><td>" + data.result.grade + "</td><td>" + data.result.title + "</td><td>0</td><td>0</td><td><button class='btn btn-info look'>查看</button> <button class='btn btn-success one_xg' data-toggle='modal' data-target='#leimu1x'>修改</button> <button class='btn btn-danger del-btn'>删除</button></td></tr>";
                // $('.one_list tbody').append(nr);
            } else {
                alert('添加失败');
            }
        })
        function one_open() {
            //修改一级类目弹窗
            $('.one_xg').on('click', function () {
                var id = $(this).parent().parent().find('td').eq(0).html();
                var grade = $(this).parent().parent().find('td').eq(1).html();
                var title = $(this).parent().parent().find('td').eq(2).html();
                $('#leimu1x ').attr('str', id);
                $('#leimu1x .title').val(title);
                $('#leimu1x .grade').val(grade);
            })
        }

        one_open();

        //修改一级类目
        $('.leimu1x').on('click', function () {
            var id = $('#leimu1x').attr('str');
            var title = $('#leimu1x .title').val();
            var grade = $('#leimu1x .grade').val();
            var data = updateajax(id, title, grade);
            if (data.code == 0) {
                window.location.reload();
                // var nr = "<tr><td>" + data.result.id + "</td><td>" + data.result.grade + "</td><td>" + data.result.title + "</td><td>0</td><td>0</td><td><button class='btn btn-info look'>查看</button> <button class='btn btn-success one_xg' data-toggle='modal' data-target='#leimu1x'>修改</button> <button class='btn btn-danger del-btn'>删除</button></td></tr>";
                // $('.one_list tbody').append(nr);
            } else {
                alert('修改失败');
            }
        })

        //一级搜索
        $('.one_ss').on('click', function () {
            var keyword = $('.one_input').val();
            var data = ajax(keyword, 1);
            if (data.code == 0) {
                var nr;
                for (var key in data.result) {
                    nr += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].child + "</td><td>" + data.result[key].childs + "</td><td><button class='btn btn-info look'>查看</button> <button class='btn btn-success one_xg' data-toggle='modal' data-target='#leimu1x'>修改</button> <button class='btn btn-danger del-btn'>删除</button></td></tr>";
                }
                $('.one_list tr:not(tr:first)').remove();
                $('.one_list tbody').append(nr);
                one_open();
                look()
            }
        })
        //一级类目查看切换到二级
        function look() {
            $('.look').each(function () {
                $(this).click(function () {
                    var id = $(this).parent().parent().find('td').eq(0).html();
                    var data = ajax('', 2, id);
                    if (data.code == 0) {
                        var nr;
                        for (var key in data.result) {
                            nr += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].child + "</td><td> <button class='btn btn-success two_xg' data-toggle='modal' data-target='#leimu2x'>修改</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                        }
                        $('.two_list tr:not(tr:first)').remove();
                        $('.two_list tbody').append(nr);
                        $('.two_list tbody').attr('str', id);
                        $('.yiji').removeClass('active');
                        $('.erji').addClass('active');
                        two_open();
                        delclass();
                    }
                    //返回
                    $('.return-btn').click(function () {

                        $(this).unbind();
                        $('.erji').removeClass('active');
                        $('.yiji').addClass('active');
                    });
                })
            })
        }

        look()


        //添加二级类目
        $('.leimu2').on('click', function () {
            var title = $('#leimu2 .title').val();
            var grade = $('#leimu2 .grade').val();
            var types = 2;
            var pid = $('.two_list tbody').attr('str');
            var data = addajax(title, grade, types, pid);
            if (data.code == 0) {

                var nr = "<tr><td>" + data.result.id + "</td><td>" + data.result.grade + "</td><td>" + data.result.title + "</td><td>0</td><td> <button class='btn btn-success two_xg' data-toggle='modal' data-target='#leimu2x'>修改</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                $('.two_list tbody').append(nr);
                two_open();
                delclass();
            } else {
                alert('添加失败');
            }
        })
        //修改二级类目弹窗
        function two_open() {
            $('.two_xg').on('click', function () {
                var id = $(this).parent().parent().find('td').eq(0).html();
                var grade = $(this).parent().parent().find('td').eq(1).html();
                var title = $(this).parent().parent().find('td').eq(2).html();
                obj = $(this).parent().parent();
                $('#leimu2x ').attr('str', id);
                $('#leimu2x .title').val(title);
                $('#leimu2x .grade').val(grade);
            })
        }

        //修改二级类目
        $('.leimu2x').on('click', function () {
            var id = $('#leimu2x').attr('str');
            var title = $('#leimu2x .title').val();
            var grade = $('#leimu2x .grade').val();
            var data = updateajax(id, title, grade);
            if (data.code == 0) {
                obj.find('td').eq(1).html(grade);
                obj.find('td').eq(2).html(title);
                alert('修改成功');

            } else {
                alert('修改失败');
            }
        })
        //二级搜索
        $('.two_ss').on('click', function () {
            var keyword = $('.two_input').val();
            var pid = $('.two_list tbody').attr('str');
            var data = ajax(keyword, 2, pid);
            if (data.code == 0) {
                var nr;
                for (var key in data.result) {
                    nr += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].child + "</td><td> <button class='btn btn-success two_xg' data-toggle='modal' data-target='#leimu2x'>修改</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                }
                $('.two_list tr:not(tr:first)').remove();
                $('.two_list tbody').append(nr);
                two_open();
            }
        })

        //三级类目
        $('.file_list').on('click', function () {
            //查找二级类目列表
            var data = ajax('', 2);
            var nr = "<option value=''>全部</option>";
            var nr2 = '';
            if (data.code == 0) {
                for (var key in data.result) {
                    nr += "<option value=" + data.result[key].id + ">" + data.result[key].title + "</option>";
                    nr2 += " <div class='radio'><label><input type='radio' name='category'  value=" + data.result[key].id + ">" + data.result[key].title + " </label></div>";
                }
                $('.twoname').html(nr);
                $('.select-category .form-horizontal').html(nr2);
                option_list();
            }
            //查找三级类目列表
            var data = ajax('', 3);
            if (data.code == 0) {
                var nr3 = '';
                for (var key in data.result) {
                    nr3 += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].p_name + "</td><td> <button class='btn btn-success btn-ueditor'>详情</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                }
                $('.three_list tr:not(tr:first)').remove();
                $('.three_list tbody').append(nr3);
                delclass();
            }

        })

        //添加和修改三级类目
        $('.threeadd').on('click', function () {
            var title = $('.ueditor-title').val();
            var grade = $('.ueditor-grade').val();
            var types = 3;
            var content = ue.getContent();
            var pid = $('input:radio:checked').val();
            // console.log(pid);
            if (typeof (pid) == 'undefined') {
                alert('请选择类目');
                return false;
            }
            if ($('.help-box').hasClass('update')) {
                var id = $('.help-box, .ueditor-box').attr('str');
                var data = updateajax(id, title, grade, types, pid, content);

            } else {
                var data = addajax(title, grade, types, pid, content);
            }

            if (data.code == 0) {
                $('.ueditor-title').val('');
                $('.ueditor-grade').val('');
                UE.getEditor('editor').setContent('', false);
                alert('发布成功');
            } else {
                alert('发布失败');
            }
        })

        //三级搜索
        $('.three_ss').on('click', function () {
            var keyword = $('.three_input').val();
            var data = ajax(keyword, 3);
            if (data.code == 0) {
                var nr3 = '';
                for (var key in data.result) {
                    nr3 += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].p_name + "</td><td> <button class='btn btn-success btn-ueditor'>详情</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                }
                $('.three_list tr:not(tr:first)').remove();
                $('.three_list tbody').append(nr3);
                delclass();
            }
        })
        //下拉筛选
        function option_list() {
            $('.twoname').on('change', function () {
                var keyword = $('.three_input').val();
                var pid = $('.twoname option:selected').attr('value');
                var data = ajax(keyword, 3, pid);
                if (data.code == 0) {
                    var nr3 = '';
                    for (var key in data.result) {
                        nr3 += "<tr><td>" + data.result[key].id + "</td><td>" + data.result[key].grade + "</td><td>" + data.result[key].title + "</td><td>" + data.result[key].p_name + "</td><td> <button class='btn btn-success btn-ueditor'>详情</button> <button class='btn btn-danger del-btn one_del'>删除</button></td></tr>";
                    }
                    $('.three_list tr:not(tr:first)').remove();
                    $('.three_list tbody').append(nr3);

                }

            })
        }


        //三级类详情
        $('.content').on('click', '.btn-ueditor', function () {
            var id = $(this).parent().parent().find('td').eq(0).html();
            if (typeof(id) === "string") {
                var url = '<?php echo U('admin/help/info') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    async: false,
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        if (data.code == 0) {
                            $('.ueditor-title').val(data.result.title);
                            $('.ueditor-grade').val(data.result.grade);
                            ue.setContent(data.result.content);
                            $("input[value='" + data.result.pid + "'").attr('checked', 'true');
                            $('.help-box, .ueditor-box').addClass('update');
                            $('.help-box, .ueditor-box').attr('str', id);
                            $('.help-box, .ueditor-box').addClass('active');
                            $('.go-back').click(function () {
                                $(this).unbind();
                                $('.help-box, .ueditor-box').removeClass('active');
                            })
                        }

                    }
                });

            } else {
                $('.ueditor-title').val('');
                $('.ueditor-grade').val('');
                ue.setContent('');
                $('.help-box, .ueditor-box').removeClass('update');
                $('.help-box, .ueditor-box').addClass('active');
                $('.go-back').click(function () {
                    $(this).unbind();
                    $('.help-box, .ueditor-box').removeClass('active');
                })
            }
        })


        //删除弹框
        var id = 0;

        function delclass() {
            $('.one_del').on('click', function () {
                id = $(this).parent().parent().find('td').eq(0).html();
                obj = $(this).parent().parent();
            })
            delTip($('.one_del'), '删除类目', '确认删除此类目么？', del);
            function del() {
                var url = '<?php echo U('admin/help/del') ?>';
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
                            alert('删除成功');
                            obj.remove();
                        } else {
                            alert(data.msg);
                        }
                    }
                })
            }
        }

        delclass();

        function ajax(keyword, types, pid = '') {
            var rs = '';
            var url = '<?php echo U('admin/help/ajax') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                async: false,
                data: {
                    keyword: keyword,
                    type: types,
                    pid: pid
                },
                success: function (data) {
                    rs = data;
                }
            })
            return rs;
        }

        function updateajax(id, title, grade, types = '', pid = '', content = '') {
            var rs = '';
            var url = '<?php echo U('admin/help/update') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                async: false,
                data: {
                    id: id,
                    title: title,
                    grade: grade,
                    type: types,
                    pid: pid,
                    content: content

                },
                success: function (data) {
                    rs = data;
                }
            });
            return rs;
        }

        function addajax(title, grade, types, pid = '', content = '') {
            var rs = '';
            var url = '<?php echo U('admin/help/add') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                async: false,
                data: {
                    title: title,
                    grade: grade,
                    type: types,
                    pid: pid,
                    content: content

                },
                success: function (data) {
                    rs = data;
                }
            });
            return rs;
        }


    })
</script>