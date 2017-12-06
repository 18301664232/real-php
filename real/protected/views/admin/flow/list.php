<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/flow_edit.css">
<script src="<?php echo STATICSADMIN ?>javascript/flow_edit.js"></script>

<div class="container-fluid">
    <section>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active">
                <a href="javascript:void(0)">流量包编辑</a>
            </li>
        </ul>
        <div class="content-box">
            <div class="active content fangshi clearfix">
                <div class="clearfix">
                    <div class="add-btn prev-btn">
                        <button id="btn-add" class="btn btn-info" >新增流量包</button>
                    </div>
                </div>
                <div class="table-box">
                    <table id="flow-box" class="active table table-hover">
                        <tr>
                            <th>排序</th>
                            <th>权重</th>
                            <th>流量包名称</th>
                            <th>包类别</th>
                            <th>单价</th>
                            <th>
                                <select name="" style="background:transparent;border:none;outline: none;appearance:none;-moz-appearance: none;-webkit-appearance: none;-ms-appearance:none">
                                    <option value="">总购买次数</option>
                                    <option value="">昨日</option>
                                    <option value="">近7日</option>
                                    <option value="">近半月</option>
                                    <option value="">近一月</option>
                                </select>
                            </th>
                            <th>总购买金额</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1.1</td>
                            <td>1T流量包</td>
                            <td>年度包</td>
                            <td>¥600.00</td>
                            <td>100</td>
                            <td>60000</td>
                            <td>
                                <button class="btn btn-success" ">修改</button>
                                <button class="btn btn-danger del-btn">删除</button>
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
        </div>
    </section>
</div>


<!-- 确认删除弹出框 -->
<div class="modal fade" id="flow_del_true" tabindex="-1" role="dialog" >
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">删除流量包</h4>
            </div>
            <div class="modal-body">
                <p class="text-center flow-modal-name"></p>
            </div>
            <div class="modal-footer" style="border: none">

                <div class="text-center">
                    <button type="button" class="btn btn-success" data-dismiss="modal">取消</button>
                    <button data-flowid id="flow_true_btn" type="button" class="btn btn-danger" data-dismiss='modal'>确定</button>
                </div>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- 按钮弹框 -->
<div role='dialog'uptype="1" class='modal fade' id="type_button">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">流量包</h4>
            </div>
            <div class="modal-body text-center">
                <form id="musform"  method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">价格</label>
                        <div class="col-sm-10">
                            <input type="text" name="money" class="form-control" placeholder="价格">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">权重</label>
                        <div class="col-sm-10">
                            <input type="text" name="grade" class="form-control" placeholder="权重">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">类型选择</label>
                        <div class="col-sm-10" style="padding-top:7px;text-align:left">
                            <input  class='ra' checked type="radio" value="365" name="btype" style="margin-right:5px">年包（自购买之日起12月内）
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label  for="" class="control-label col-sm-2">上传图片</label>
                        <div class="col-sm-10 upload-box" style="padding-top:7px;text-align:left">
                            <img src="" alt="" style="width:100px;height:100px;background:#000">
                            <div class="file_area">
                                <input class="upload-file"value="" type="file" name="imgfile">
                                <p id="upimg">上传图片</p>
                            </div>
                        </div>

                    </div>
                    <div class="form-group margin-b hidden">
                        <label for="" class="control-label col-sm-2">id</label>
                        <div class="col-sm-10">
                            <input type="text" name="fid" class="form-control" placeholder="id">
                        </div>
                    </div>
                    <div class="form-group margin-b hidden">
                        <label for="" class="control-label col-sm-2">图片链接</label>
                        <div class="col-sm-10">
                            <input type="text" name="furl" class="form-control" placeholder="图片链接">
                        </div>
                    </div>


                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>发布</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(function(){

        //初始化数据
        datainit();
        function datainit(){
            $.get(
                "<?php echo U('admin/flow/ajax')?>",
                {
                },
                function(data){
                    var obj = JSON.parse(data);
                    if(obj.code == 0){
                        var flow_str = '';
                        for (var key in obj.result.data) {
                            flow_str += '<tr flowid = ' + obj.result.data[key].id + '>'+
                                '<td flowsrc = ' + obj.result.data[key].img_url + '>'+obj.result.data[key].id +'</td>'+
                                '<td>'+obj.result.data[key].grade+'</td>'+
                                '<td>'+obj.result.data[key].name+'</td>'+
                                '<td>'+obj.result.data[key].type+'</td>'+
                                '<td>'+'¥'+obj.result.data[key].money+'</td>'+
                                '<td>'+obj.result.data[key].total+'</td>'+
                                '<td>'+'¥'+obj.result.data[key].total_money+'</td>'+
                                '<td>'+
                                '<button class="btn btn-success edit-btn" >'+'修改'+'</button>'+
                                ' <button class="btn btn-danger del-btn">'+'删除'+'</button>'+
                                '</td>'+
                                '</tr>'
                        }
                        $('.table-box tr:gt(0)').remove();
                        $('#flow-box').append(flow_str);
                        checkAuth();
                    }else{
                        alert('读取失败');
                    }
                }
            );
        }
        //添加包
        $('#btn-add').click(function(){

            $("#type_button input[type='text']").val('');
            $("#type_button").modal({show:true});
            $('#type_button').attr('uptype','1');

        });

        //点击提交按钮
        $('#type_button .btn-danger').click(function () {
            if($('#type_button').attr('uptype')==1){
                //添加
                var up_url ="<?php echo U('admin/flow/FlowTypeadd')?>";
            }else{
                //更新
                var up_url ="<?php echo U('admin/flow/FlowTypeupdate')?>";
                var del_img_url= $("#type_button input[name='furl']").val();

            }
            var musform = new FormData(document.getElementById("musform"));
                musform.append('del_img_url',del_img_url);
            $.ajax({
                url:up_url,
                type:"post",
                data:musform,
                processData:false,
                contentType:false,
                success:function(data){
                    var obj=eval('(' + data + ')');
                    if(obj.code == 0) {
                        datainit();
                    }
                },
                error:function(e){
                    alert("代码提交错误！！");
                }
            });

        });

        //点击修改按钮
        $('.table-box').delegate('.btn-success', 'click', function() {

          var arr = $(this).parent().parent().find('td');
          var now_tr = $(this).parent().parent();

          $.each(arr,function(key,val){
                switch (key){
                    case 2:
                        $('#type_button input').eq(0).val($(val).text());
                        break;
                    case 4:
                        $('#type_button input').eq(1).val($(val).text().replace(/[^0-9]/ig,""));
                        break;
                    case 1:
                        $('#type_button input').eq(2).val($(val).text());
                        break;
                    case 3:
                        $('#type_button input').eq(3).attr('checked','true');
                        break;
                    case 0:
                        $('#type_button input').eq(6).val($(val).attr('flowsrc'));
                        $('.upload-box img').attr('src',$(val).attr('flowsrc')+'.jpg');
                        break;
                    case 5:
                        $('#type_button input').eq(5).val($(now_tr).attr('flowid'));
                        break;

                }
            });

            $("#type_button").modal({show:true});
            $('#type_button').attr('uptype','2');

        });


        //点击删除按钮
        $('.table-box').delegate('.btn-danger', 'click', function() {

            $('#flow_del_true').modal({show:true});
            var flow_id =   $(this).parent().parent().attr('flowid');
            $('#flow_true_btn').attr('data-flowid',flow_id);
            $('.flow-modal-name').html('确定要删除'+$(this).parent().parent().children().eq(2).text()+'?');

        });

        $('#flow_true_btn').click(function(){

            $.post(
                "<?php echo U('admin/flow/FlowTypeDel')?>",
                {
                    id: $(this).data('flowid')
                },
                function(data){
                    var obj = JSON.parse(data);
                    if(obj.code == 0){
                        datainit();

                    }else{
                        alert('删除失败');
                    }
                }
            )

        })


        //执行权限--以下是在没有权限的情况下操作
        function checkAuth() {
            if(<?php echo $this->checkAuth($this->id.'/add') ?>){

                $('#btn-add').attr('disabled','disabled');

            }
            if(<?php echo $this->checkAuth($this->id.'/edit') ?>){
                $('.table-box tr button').attr('disabled','disabled');
            }
        };


    });





</script>