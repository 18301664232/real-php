<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/auth.css">
<script src="<?php echo STATICSADMIN ?>javascript/auth.js"></script>
<script src="<?php echo STATICSCOMMON ?>ajaxPages.js"></script>
<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">

                <div class="input-group col-sm-4">
                    <input type="text" class="form-control search-key-input" placeholder="帐号、姓名">
                    <span class="input-group-btn">
	    				    	<button class="btn btn-default search-key" type="button">搜索</button>
	    				    </span>
                </div>
            </div>
        </div>
        <div class="query-box">

            <div class="row">
                <div></div>
                <div class="text-right btn-area">
                    <p class="total" style="line-height:30px;">当前条件共有数据：<span style="color:#0099FF"></span>条</p>
                    <button class="btn btn-success add-ok">添加帐号</button>
                </div>


            </div>

        </div>
        <div class="table-box">
            <table class="table table-bordered">
                <tr>
                    <th>序号</th>
                    <th>账号名称</th>
                    <th>部门</th>
                    <th>姓名</th>
                    <th>创建日期</th>
                    <th>操作</th>

                </tr>
                <tr>
                    <td>1</td>
                    <td>12342425435@qq.com</td>
                    <td>43</td>
                    <td>2015-08-07</td>
                    <td>35</td>

                    <td>
                        <button class="btn btn-danger btn-del">删除</button>
                    </td>
                </tr>

            </table>
        </div>
        <div class="page-box">
            <nav class="clearfix" aria-label="Page navigation">
                <div class="row">
                    <p class="total col-sm-5" style="visibility: hidden"></p>

                    <ul class="pagination col-sm-6">
                        <li class="pagein">
                            <a href="javascript:void(0)" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!--		    			    	<li class="active"><a href="javascript:void(0)">1</a></li>-->
                        <!--		    			   		<li><a href="javascript:void(0)">2</a></li>-->
                        <!--		    			    	<li><a href="javascript:void(0)">3</a></li>-->
                        <!--		    			    	<li><a href="javascript:void(0)">4</a></li>-->
                        <!--		    			    	<li><a href="javascript:void(0)">5</a></li>-->
                        <li class="pageend">
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


<div role='dialog' uptype="1" class='modal fade in' id="type_button">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">添加帐号</h4>
            </div>
            <div class="modal-body text-center">
                <form id="musform" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">登录帐号</label>
                        <div class="col-sm-10">
                            <input type="text" name="cname" class="form-control" placeholder="登录帐号">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">初始密码</label>
                        <div class="col-sm-10">
                            <input type="text" name="pass" class="form-control" placeholder="初始密码">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">所属部门</label>
                        <div class="col-sm-10">
                            <input type="text" name="develpoment" class="form-control" placeholder="所属部门">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">员工姓名</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" class="form-control" placeholder="员工姓名">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">选择角色</label>
                        <div class="col-sm-2">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <span role_id="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php foreach ($data as $k=>$v):?>
                                    <li role_id="<?php echo $v['id'] ;?>" ><a href="#"><?php echo $v['role_name'] ;?></a></li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        </div>
                    </div>


                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>保存</button>
                </form>
            </div>
        </div>
    </div>
</div>


