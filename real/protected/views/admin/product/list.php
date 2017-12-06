 <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/project_management.css">
   <script src="<?php echo STATICSADMIN ?>js/project_management.js"></script>
<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">
                <div class="input-group col-sm-4">
                    <input type="text" class="form-control" placeholder="PID.用户帐号" value="<?php echo isset($_REQUEST['keyword']) ? $_REQUEST['keyword'] : '' ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜索</button>
                    </span>
                </div>

            </div>
        </div>

        <div class="query-box">
            <div class="row">
                <div class="clearfix">
                    <em>用户类别：</em>
                    <ul class="clearfix">
                        <li class="<?php if((!empty($_REQUEST['status'])?$_REQUEST['status']:'total') =='total'){echo 'active'; } ?>" >全部</li>
                        <li  class="<?php if((!empty($_REQUEST['status'])?$_REQUEST['status']:'total') =='online'){echo 'active'; } ?>">已上线</li>
                        <li class="<?php if((!empty($_REQUEST['status'])?$_REQUEST['status']:'total') =='notonline'){echo 'active'; } ?>">未上线</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--	    		<div class="query-box">
                                        <div class="row">
                                                <div class="clearfix">
                                                        <em>项目版本：</em>
                                                        <ul class="clearfix">
                                                                <li class="active">全部</li>
                                                                <li>企业版</li>
                                                                <li>个人版</li>
                                                        </ul>
                                                </div>
                                                <div class="clearfix">
                                                        <em>审查状态：</em>
                                                        <ul class="clearfix">
                                                                <li class="active">未审查</li>
                                                                <li>已审查</li>
                                                        </ul>
                                                </div>
                                                <div class="current-num">
                                                        当前条件共有数据：<span style="color:#ff6700">31400</span>条
                                                </div>
                                        </div>
                                </div>-->
        <div class="table-box">
            <table class="table table-bordered">
                <tr>
                    <th>序号</th>
                    <th>项目名称</th>
                    <th>PID</th>
                    <th>用户账号</th>
                    <th>项目状态</th>
                    <th>pv</th>
                    <th>uv</th>
                    <th>使用流量</th>
	    					<th>项目操作</th>
                </tr>

                <?php if (!empty($data)) {
                    $num = 1;
                    foreach ($data as $k => $v): ?>
                        <tr>
                            <td><?php echo ($num) ?></td>
                            <td><?php echo $v['title'] ?></td>
                            <td><?php echo $v['product_id'] ?></td>
                            <td><?php echo !empty($v['tel'] )?$v['tel']:$v['email'] ?></td>
                            <td><?php echo $v['online'] ?></td>
                            <td><?php echo $v['pv'] + $v['nv'] + $v['uv'] ?></td>
                            <td><?php echo $v['nv'] + $v['uv'] ?></td>
                            <td><?php echo $v['water'] != null ? number_format(($v['water'] / 1024 / 1024), 2, '.', '') . 'MB' : 0 ?></td>
                            <td><a target="_blank" href="<?php echo $v['looklink'] ?>"><button  <?php if( $this->checkAuth($this->id.'/edit')){echo 'disabled';} ?> class="btn btn-success btn-sm btn-looklink">查看</button></a></td>

        <!--	    					<td>
                <button class="btn btn-info btn-detail" data-toggle="modal" data-target="#project">详情</button>
                <button class="btn btn-success btn-pass">通过</button>
                <button class="btn btn-danger relieve">解除</button>
        </td>-->
                        </tr>
                        <?php $num++; ?>
    <?php endforeach;
} ?>
            </table>
        </div>


        <div class="page-box">
            <nav class="clearfix" aria-label="Page navigation">
                <div class="row">
                    <p class="total col-sm-4">当前条件共有数据：<span style="color:#0099FF"><?php echo $count ?></span>条</p>
                    <ul class="pagination col-sm-6">
<?php $this->widget('application.widgets.pages.ListPagesDWidget', array('pages' => $pages, 'params' => array('keyword' => $keyword))) ?>
                    </ul>
                </div>
            </nav>
        </div>
    </section>   	
</div>
<!-- 详情弹框 -->
<div role='dialog' class='modal fade' id="project">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">项目详情</h4>
            </div>
            <div class="modal-body text-center">
                <form action="" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">项目序号</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="项目序号" value="1" readonly/>
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">项目体积</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="项目体积" value="370M" readonly/>
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">备份日期</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="备份日期" value="2017-01-01" readonly/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var search_btn_status = 'total';
    $('.query-box ul li').click(function () {
        switch ($(this).index()){
            case 0:
                search_btn_status = 'total';
                search_key_start();
            break;
            case 1:
                search_btn_status = 'online';
                search_key_start();
                break;
            case 2:
                search_btn_status = 'notonline';
                search_key_start();
                break;
        }

    })

    $('.btn-default').on('click', function () {
        search_key_start();
    });

    function search_key_start() {
        var keyword = $('.form-control').val() || 2;
        if(keyword == 2){
            window.location.href = '<?php echo U('admin/product/list') ?>&keyword=_'+'&status=' + search_btn_status;
        }else {
            window.location.href = '<?php echo U('admin/product/list') ?>&keyword=' + keyword+'&status=' + search_btn_status;
        }
    }

    if($('.form-control').val()=="_"){
        $('.form-control').val('');
    }

//    //点击修改按钮
//    $('.table-box').delegate('.btn-looklink', 'click', function() {
//        $.ajax({
//            url:window_request_url.admin_product_getlink,
//            type:"post",
//            data:{
//               product_id: $(this).parent().siblings().eq(2).text()
//            },
//            success:function(data){
//                var obj=eval('(' + data + ')');
//                if(obj.code == 0) {
//                    var tempwindow=window.open();
//                    tempwindow.location.href=window_request_url.product_index_index+'&url_type=pc'+'&id='+obj.result.data.uid;
//                    //window.open(window_request_url.product_index_index+'&url_type=pc'+'&id='+obj.result.data.uid);
//                }
//            },
//            error:function(e){
//                alert("代码提交错误！！");
//            }
//        });
//    })

    //函数触发链接
//
//    function LookLinkUrl(self) {
//        $.ajax({
//            url:window_request_url.admin_product_getlink,
//            async: false,
//            type:"post",
//            data:{
//                product_id: self.parent().siblings().eq(2).text()
//            },
//            success:function(data){
//                var obj=eval('(' + data + ')');
//                if(obj.code == 0) {
//                    //var tempwindow=window.open();
//                  //  tempwindow.location.href=window_request_url.product_index_index+'&url_type=pc'+'&id='+obj.result.data.uid;
//                    //window.open(window_request_url.product_index_index+'&url_type=pc'+'&id='+obj.result.data.uid);
//                    return obj.result.data.uid;
//                }
//            },
//            error:function(e){
//                alert("代码提交错误！！");
//            }
//        });
//    }

    //执行权限--以下是在没有权限的情况下操作
    if(<?php echo $this->checkAuth($this->id.'/list') ?>){
        $('.query-box .row .clearfix li').unbind();
        $('.input-group-btn button').attr('disabled','disabled');


   }


</script>