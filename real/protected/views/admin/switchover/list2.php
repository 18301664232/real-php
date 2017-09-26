
        <div class="container-fluid">
            <section>
                <ul class="nav nav-tabs">
                    <li role="presentation" class="active">
                        <a href="javascript:void(0)">手势</a>
                    </li>
                    <li role="presentation">
                        <a href="javascript:void(0)">效果</a>
                    </li>
                    <li role="presentation">
                        <a href="javascript:void(0)">方向</a>
                    </li>
                </ul>
                <div class="content-box">
                    <div class="active content shoushi clearfix">
                        <div class="clearfix">
                            <div class="add-btn prev-btn">
                                <button class="btn btn-info triggeradd" >添加手势</button>
                            </div>
                        </div>
                        <div class="table-box">
                            <table id="trigger-table" class="table table-hover">
                                <tr>
                                    <th>顺序</th>
                                    <th>权重</th>
                                    <th>手势名称</th>
                                    <th>操作</th>
                                </tr>
                        <!--              手势内容开始                 -->

                            </table>
                        </div>
                    </div>
                    <div class="content xiaoguo clearfix">
                        <ul class="nav nav-pills">
                          <li role="presentation" class="active"><a href="javascript:void(0)">上一页列表</a></li>
                          <li role="presentation"><a href="javascript:void(0)">下一页列表</a></li>
                          <li role="presentation" class="times-btn"><a href="javascript:void(0)">效果时长</a></li>
                        </ul>
                        <div class="xiaoguo-box">
                            <div class="prev-list">
                                <div class="clearfix">
                                    <div class="add-btn prev-btn">
                                        <button class="btn btn-info effectadd" >添加效果</button>
                                    </div>
                                </div>
                                <div class="table-box">
                                    <table id="effect-table-one"  class="table table-hover">
                                        <tr>
                                            <th>顺序</th>
                                            <th>权重</th>
                                            <th>效果名称</th>
                                            <th>操作</th>
                                        </tr>
                                        <!--              效果内容开始                 -->

                                    </table>
                                </div>
                            </div>
                            <div class="next-list" style="display:none">
                                <div class="clearfix">
                                    <div class="add-btn next-btn">
                                        <button etype="2" class="btn btn-info effectadd" >添加效果</button>
                                    </div>
                                </div>
                                <div class="table-box">
                                    <table  id='effect-table-two' class="table table-hover">
                                        <tr>
                                            <th>顺序</th>
                                            <th>权重</th>
                                            <th>效果名称</th>
                                            <th>操作</th>
                                        </tr>
                                        <!--              效果内容开始                 -->
                                        <tr>
                                            <td>1</td>
                                            <td>1.1</td>
                                            <td>滑屏</td>
                                            <td>
                                                <button class="btn btn-success" data-toggle="modal" data-target="#xiaoguo">修改</button>
                                                <button class="btn btn-danger del-btn">删除</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="xiaoguo-times" style="display:none" type=2> 
                                <div class="text-right">单位：秒</div>
                                <form action="" class="form-horizontal btn-save-parent">
                                    <div class="form-group margin-b">
                                        <label for="" class="control-label col-sm-4">最小值</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control timemin" placeholder="最小值" value=''>
                                        </div>
                                    </div>
                                    <div class="form-group margin-b">
                                        <label for="" class="control-label col-sm-4">最大值</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control timemax" placeholder="最大值" value=''>
                                        </div>
                                    </div>
                                    <div class="form-group margin-b">
                                        <label for="" class="control-label col-sm-4">缺省值</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control timeque" placeholder="缺省值" value=''>
                                        </div>
                                    </div>
                                    <div class="form-group margin-b">
                                        <label for="" class="control-label col-sm-4">步长</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control timelang" placeholder="步长"  value=''>
                                        </div>
                                    </div>
                                    <div class="text-center margin-b ">
                                        <button class="btn btn-primary btn-save btn-222">保存</button>
                                        <button class="btn btn-primary btn-edit">编辑</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content fangxiang clearfix">
                        <div class="clearfix">
                              <div class="add-btn prev-btn">
                                  <button class="btn btn-info diradd" >添加方向</button>
                              </div>
                          </div>
                          <div class="table-box">
                              <table id="dir-table" class="table table-hover ">
                                  <tr>
                                      <th>顺序</th>
                                      <th>权重</th>
                                      <th>方向名称</th>
                                      <th>操作</th>
                                  </tr>
                                  <!--              方向内容开始                 -->

                              </table>
                          </div>  
                    </div>
                </div>
            </section>
        </div>

    <!-- 手势弹框 -->
    <div role='dialog' class='modal fade' id="shoushi">
        <div class="modal-dialog">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button class='close' data-dismiss='modal'>
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title text-center">手势</h4>
                </div>
                <div class="modal-body text-center">
                    <form action="" class="form-horizontal">
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">手势名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control triggername" placeholder="手势名称">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">配置权重</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control triggergrade" placeholder="配置权重">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">KEY值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control triggerkey" placeholder="KEY值">
                            </div>
                        </div>
                        <div class="form-group margin-b triggerid-box">
                            <label for="" class="control-label col-sm-2">id值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control triggerid" placeholder="id值">
                            </div>
                        </div>
                        <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                        <button id="trigger-ok" class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 效果弹框 -->
    <div role='dialog' class='modal fade' id="xiaoguo">
        <div class="modal-dialog">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button class='close' data-dismiss='modal'>
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title text-center">效果</h4>
                </div>
                <div class="modal-body text-center">
                    <form action="" class="form-horizontal">
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">效果名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control effectname" placeholder="效果名称">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">配置权重</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control effectgrade" placeholder="配置权重">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">KEY值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control effectkey" placeholder="KEY值">
                            </div>
                        </div>
                        <div class="form-group margin-b effectid-box">
                            <label for="" class="control-label col-sm-2">id值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control effectid" placeholder="id值">
                            </div>
                        </div>
                        <div class="form-group margin-b effectid-box">
                            <label for="" class="control-label col-sm-2">type值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control effecttype" placeholder="etype">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">方向配置</label>
                            <div class="col-sm-10">
                                <select multiple class="form-control effectdir">
                                  <option value="0">无</option>
                                  <option value="666">全部选择</option>

                                </select>
                            </div>
                        </div>
                        <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                        <button id="effect-ok" class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- 方向弹框 -->
    <div role='dialog' class='modal fade' id="fangxiang">
        <div class="modal-dialog">
            <div class='modal-content'>
                <div class='modal-header'>
                    <button class='close' data-dismiss='modal'>
                        <span>&times;</span>
                    </button>
                    <h4 class="modal-title text-center">方向</h4>
                </div>
                <div class="modal-body text-center">
                    <form action="" class="form-horizontal">
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">方向名称</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control dirname" placeholder="方向名称">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">配置权重</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control dirgrade" placeholder="配置权重">
                            </div>
                        </div>
                        <div class="form-group margin-b">
                            <label for="" class="control-label col-sm-2">KEY值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control dirkey" placeholder="KEY值">
                            </div>
                        </div>
                        <div class="form-group margin-b dirid-box">
                            <label for="" class="control-label col-sm-2">id值</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control dirid" placeholder="id值">
                            </div>
                        </div>
                        <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                        <button id="dir-ok" class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>

    // @syl2017年8月23日
    $(function(){
        time_update_url=  "<?php echo U('admin/switchover/timeupdate')?>";
        $('.times-btn').click(function(){
            timesinit();
        });

        //读取时间戳配置信息
        function timesinit(){
                $.post(
                    "<?php echo U('admin/switchover/timeset')?>",
                    {
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            for (key in obj.result.data) {
                                $('.xiaoguo-times input').eq(key).val(obj.result.data[key]);
                            }
                        } else {
                            alert('读取失败' + '' + obj.msg);
                        }
                    }
                );
            }


        //执行一次//
        datainit();
        function datainit() {
            //初始化数据
            $.ajax({
                type: "GET",
                url: "<?php echo U('admin/switchover/ajax') ?>",
                dataType: "json",
                success: function (data) {
                    if (data.code == '0') {
                        var dir = '';
                        var effect_one = '';
                        var effect_two = '';
                        var trigger = '';
                        var effectdir_str='';

                        for (var key in data.result.data.trigger) {
                            i=parseInt(key)+1;
                            trigger+= '<tr>'+
                                    '<td>'+i+'</td>'+
                                    '<td>'+data.result.data.trigger[key]['grade']+'</td>'+
                                    '<td>'+data.result.data.trigger[key]['name']+'</td>'+
                                    '<td>'+
                                          '<button triggerid='+data.result.data.trigger[key]['id']+' class="btn btn-success triggeredit" >修改</button>'+
                                          ' <button class="btn btn-danger del-btn">删除</button>'+
                                    '</td>'+
                                 '</tr>'

                        }
                        for (var key in data.result.data.effect) {

                            if(parseInt(data.result.data.effect[key]['parentid']) == 2){

                                effect_two+= '<tr>'+
                                    '<td>'+key+'</td>'+
                                    '<td>'+data.result.data.effect[key]['grade']+'</td>'+
                                    '<td>'+data.result.data.effect[key]['name']+'</td>'+
                                    '<td>'+
                                    '<button effectid='+data.result.data.effect[key]['id']+'  class="btn btn-success effectedit" >修改</button>'+
                                    ' <button class="btn btn-danger del-btn">删除</button>'+
                                    '</td>'+
                                    '</tr>'

                            }else{

                                effect_one+= '<tr>'+
                                    '<td>'+key+'</td>'+
                                    '<td>'+data.result.data.effect[key]['grade']+'</td>'+
                                    '<td>'+data.result.data.effect[key]['name']+'</td>'+
                                    '<td>'+
                                    '<button effectid='+data.result.data.effect[key]['id']+'  class="btn btn-success effectedit" >修改</button>'+
                                    ' <button class="btn btn-danger del-btn">删除</button>'+
                                    '</td>'+
                                    '</tr>'


                            }


                        }
                        for (var key in data.result.data.dir) {
                            i=parseInt(key)+1;
                            dir+= '<tr>'+
                                '<td>'+i+'</td>'+
                                '<td>'+data.result.data.dir[key]['grade']+'</td>'+
                                '<td>'+data.result.data.dir[key]['name']+'</td>'+
                                '<td>'+
                                '<button dirid='+data.result.data.dir[key]['id']+'  class="btn btn-success diredit">修改</button>'+
                                ' <button class="btn btn-danger del-btn">删除</button>'+
                                '</td>'+
                                '</tr>'

                        }
                        for (var key in data.result.data.dir) {

                            effectdir_str+= '<option value="'+data.result.data.dir[key]['uid']+'">'+data.result.data.dir[key]['name']+'</option>';

                        }

                        $('#dir-table tr:gt(0)').remove();
                        $('#effect-table-one tr:gt(0)').remove();
                        $('#effect-table-two tr:gt(0)').remove();

                        $('#trigger-table tr:gt(0)').remove();
                        $('.effectdir option:gt(1)').remove();
                        $('#dir-table').append(dir);
                        $('.effectdir').append(effectdir_str);
                        $('#effect-table-one').append(effect_one);
                        $('#effect-table-two').append(effect_two);
                        $('#trigger-table').append(trigger);

                    }
                }
            });
        }

        var trigger_status = true;
        var effect_status = true;
        var dir_status = true;
        //手势添加按钮配置
        $('.triggeradd').on('click', function (event) {
            trigger_status = true;
            $('.triggerkey').val('');
            $('.triggergrade').val('');
            $('.triggername').val('');
            $('.triggerid').val('');
            $('.triggerid-box').hide();
            $("#shoushi").modal({show:true});
        });
        //效果添加按钮配置
        $('.effectadd').on('click', function (event) {
            effect_status = true;
            if($(this).attr('etype')==2){

                $('.effecttype').val(2);
            }else{
                $('.effecttype').val(1);
            }
            $('.effectkey').val('');
            $('.effectname').val('');
            $('.effectgrade').val('');
            $('.effectdir').val('无');
            $('.effectid-box').hide();
            $('.effectid').val('');
            $("#xiaoguo").modal({show:true});
        });
        //方向添加按钮配置
        $('.diradd').on('click', function (event) {
            dir_status = true;
            $('.dirkey').val('');
            $('.dirname').val('');
            $('.dirgrade').val('');
            $('.dirid-box').hide();
            $('.dirid').val('');
            $("#fangxiang").modal({show:true});
        });


        //手势修改按钮配置
        $('#trigger-table').delegate('.triggeredit', 'click', function() {
            trigger_status = false;
            $('.triggerid-box').hide();
            $('.mus-origin').val('');
            $("#shoushi").modal({show:true});
            //获取到当前DOM里面的值
            var tr_arr=$(this).parent().parent().children();
            $('.triggername').val($(tr_arr[2]).html());
            $('.triggerkey').val($(tr_arr[0]).html());
            $('.triggergrade').val($(tr_arr[1]).html());
            $('.triggerid').val($(this).attr('triggerid'));

        });
        //效果修改按钮配置
        $('#effect-table-one,#effect-table-two').delegate('.effectedit', 'click', function() {
            effect_status = false;
            $('.effectid-box').hide();
            $("#xiaoguo").modal({show:true});
            //获取到当前DOM里面的值
            var tr_arr=$(this).parent().parent().children();
            $('.effectname').val($(tr_arr[2]).html());
            $('.effectkey').val($(tr_arr[0]).html());
            $('.effectgrade').val($(tr_arr[1]).html());
            $('.effectid').val($(this).attr('effectid'));

        });
        //方向修改按钮配置
        $('#dir-table').delegate('.diredit', 'click', function() {
            dir_status = false;
            $('.dirid-box').hide();
            $("#fangxiang").modal({show:true});
            //获取到当前DOM里面的值
            var tr_arr=$(this).parent().parent().children();
            $('.dirname').val($(tr_arr[2]).html());
            $('.dirkey').val($(tr_arr[0]).html());
            $('.dirgrade').val($(tr_arr[1]).html());
            $('.dirid').val($(this).attr('dirid'));

        });

        //手势的添加和修改
        $('#trigger-ok').on('click', function () {
            if (trigger_status) {
                //添加
                var name = $('.triggername').val();
                var grade = $('.triggergrade').val();
                var key = $('.triggerkey').val();
                $.post(
                    "<?php echo U('admin/switchover/triggeradd')?>",
                    {
                        name: name,
                        grade: grade,
                        jskey: key
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            saveTip('添加成功！');
                            datainit();
                        } else {
                            alert('添加失败' + '' + obj.msg);
                        }
                    }
                );

            } else {
                //更新
                var name = $('.triggername').val();
                var grade = $('.triggergrade').val();
                var key = $('.triggerkey').val();
                var triggerid = $('.triggerid').val();
                $.post(
                    "<?php echo U('admin/switchover/triggerupdate')?>",
                    {
                        id : triggerid,
                        name : name,
                        grade : grade,
                        jskey : key
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            datainit();
                            saveTip('更新成功！')
                        }else{
                            saveTip('更新失败！')
                        }
                    }
                );

            }

        });

        //效果的添加和修改
        $('#effect-ok').on('click', function () {
            if (effect_status) {
                //添加
                var etype = $('.effecttype').val();
                var name = $('.effectname').val();
                var grade = $('.effectgrade').val();
                var key = $('.effectkey').val();
                var edir = $('.effectdir').val();

                $.post(
                    "<?php echo U('admin/switchover/effectadd')?>",
                    {
                        type:etype,
                        name: name,
                        grade: grade,
                        jskey: key,
                        dir:edir
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            saveTip('添加成功！');
                            datainit();
                        } else {
                            alert('添加失败' + '' + obj.msg);
                        }
                    }
                );

            } else {
                //更新
                var name = $('.effectname').val();
                var grade = $('.effectgrade').val();
                var key = $('.effectkey').val();
                var edir = $('.effectdir').val();
                var eid  = $('.effectid').val();
                $.post(
                    "<?php echo U('admin/switchover/effectupdate')?>",
                    {
                        id : eid,
                        name : name,
                        grade : grade,
                        jskey : key,
                        dir:edir
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            datainit();
                            saveTip('更新成功！')
                        }else{
                            alert('更新失败');
                        }
                    }
                );
            }
        });

        //方向的添加和修改
        $('#dir-ok').on('click', function () {
            if (dir_status) {
                //添加
                var name = $('.dirname').val();
                var grade = $('.dirgrade').val();
                var key = $('.dirkey').val();

                $.post(
                    "<?php echo U('admin/switchover/diradd')?>",
                    {
                        name: name,
                        grade: grade,
                        jskey: key,

                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            saveTip('添加成功！');
                            datainit();
                        } else {
                            alert('添加失败' + '' + obj.msg);
                        }
                    }
                );

            } else {
                //更新
                var name = $('.dirname').val();
                var grade = $('.dirgrade').val();
                var key = $('.dirkey').val();
                var did  = $('.dirid').val();
                $.post(
                    "<?php echo U('admin/switchover/dirupdate')?>",
                    {
                        id : did,
                        name : name,
                        grade : grade,
                        jskey : key,

                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            datainit();
                            saveTip('更新成功！')
                        }else{
                            alert('更新失败');
                        }
                    }
                );
            }
        });

        //手势的删除
        $('#trigger-table').delegate('.del-btn', 'click', function() {
            var nowdom=$(this);
            var iconid=$(this).siblings().attr('triggerid');
            if(iconid){
                $.post("<?php echo U('admin/switchover/triggerdel')?>",
                    {
                        id:iconid
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            nowdom.parent().parent().remove();
                            saveTip('删除成功！')
                        }else{
                            alert('删除失败');
                        }

                    });
            }
        });
        //效果的删除
        $('#effect-table-one,#effect-table-two').delegate('.del-btn', 'click', function() {
            var nowdom=$(this);
            var iconid=$(this).siblings().attr('effectid');
            if(iconid){
                $.post("<?php echo U('admin/switchover/effectdel')?>",
                    {
                        id:iconid
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            nowdom.parent().parent().remove();
                            saveTip('删除成功！')
                        }else{
                            alert('删除失败');
                        }

                    });
            }
        });
        //方向的删除
        $('#dir-table').delegate('.del-btn', 'click', function() {
            var nowdom=$(this);
            var iconid=$(this).siblings().attr('dirid');
            if(iconid){
                $.post("<?php echo U('admin/switchover/dirdel')?>",
                    {
                        id:iconid
                    },
                    function(data){
                        var obj = JSON.parse(data);
                        if(obj.code == 0){
                            nowdom.parent().parent().remove();
                            saveTip('删除成功');
                        }else{
                            alert('删除失败');
                        }

                    });
            }
        });



    });


</script>

