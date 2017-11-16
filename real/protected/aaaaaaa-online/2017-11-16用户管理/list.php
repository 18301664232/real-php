 <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/project_management.css">
   <script src="<?php echo STATICSADMIN ?>js/project_management.js"></script>
<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">
                <div class="input-group col-sm-4">
                    <input type="text" class="form-control" placeholder="PID,项目名" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : '' ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜索</button>
                    </span>
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

                    <th>项目名称</th>
                    <th>PID</th>

                    <th>账号</th>

                    <th>pv</th>
                    <th>uv</th>
                    <th>使用流量</th>
<!--	    					<th>项目操作</th>-->
                </tr>

                <?php if (!empty($data)) {
                    foreach ($data as $k => $v): ?>
                        <tr>

                            <td><?php echo $v['title'] ?></td>
                            <td><?php echo $v['product_id'] ?></td>
                            <td><?php echo $v['user_id'] ?></td>
                            <td><?php echo $v['pv'] + $v['nv'] + $v['uv'] ?></td>
                            <td><?php echo $v['nv'] + $v['uv'] ?></td>
                            <td><?php echo $v['water'] != null ? number_format(($v['water'] / 1024 / 1024), 2, '.', '') . 'MB' : 0 ?></td>

        <!--	    					<td>
                <button class="btn btn-info btn-detail" data-toggle="modal" data-target="#project">详情</button>
                <button class="btn btn-success btn-pass">通过</button>
                <button class="btn btn-danger relieve">解除</button>
        </td>-->
                        </tr>
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

    $('.btn-default').on('click', function () {
        var keyword = $('.form-control').val();
        window.location.href = '<?php echo U('admin/product/list') ?>&keyword=' + keyword;

    });

</script>