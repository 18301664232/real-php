<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/auth.css">
<script src="<?php echo STATICSADMIN ?>javascript/role.js"></script>
<script src="<?php echo STATICSCOMMON ?>ajaxPages.js"></script>
<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">

                <div class="input-group col-sm-4">
                    <input type="text" class="form-control search-key-input" placeholder="角色名">
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
                    <button class="btn btn-success add-ok">添加角色</button>
                </div>


            </div>

        </div>
        <div class="table1 table-box">
            <table class="table table-bordered">
                <tr>
                    <th>序号</th>
                    <th>角色名称</th>
                    <th>创建日期</th>
                    <th>栏目权限</th>
                    <th>操作</th>

                </tr>
                <tr>
                    <td>1</td>
                    <td>12342425435@qq.com</td>
                    <td>43</td>
                    <td>2015-08-07</td>


                    <td>
                        <button class="btn btn-info btn-detail">详情</button>
                        <button class="btn btn-danger btn-del">删除</button>
                    </td>
                </tr>

            </table>
        </div>
        <!--	    		<div class="page-box">-->
        <!--	    			<nav class="clearfix" aria-label="Page navigation">-->
        <!--	    				<div class="row">-->
        <!--                            <p class="total col-sm-5" style="visibility: hidden" ></p>-->
        <!---->
        <!--		    			  	<ul class="pagination col-sm-6">-->
        <!--		    			    	<li class="pagein">-->
        <!--		    			      		<a href="javascript:void(0)" aria-label="Previous">-->
        <!--		    			        	<span aria-hidden="true">&laquo;</span>-->
        <!--		    			      		</a>-->
        <!--		    			    	</li>-->
        <!--		    			    	<li class="active"><a href="javascript:void(0)">1</a></li>-->
        <!--		    			   		<li><a href="javascript:void(0)">2</a></li>-->
        <!--		    			    	<li><a href="javascript:void(0)">3</a></li>-->
        <!--		    			    	<li><a href="javascript:void(0)">4</a></li>-->
        <!--		    			    	<li><a href="javascript:void(0)">5</a></li>-->
        <!--		    			    	<li class="pageend">-->
        <!--		    			      		<a href="javascript:void(0)" aria-label="Next">-->
        <!--		    			        	<span aria-hidden="true">&raquo;</span>-->
        <!--		    			      		</a>-->
        <!--		    			    	</li>-->
        <!--		    			  	</ul>-->
        <!--	    				</div>-->
        <!--	    			</nav>-->
        <!--	    		</div>-->
    </section>

</div>


<div role='dialog' class='modal fade' id="leimu">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">添加角色</h4>
            </div>
            <div class="modal-body text-center" style="max-height:600px;overflow:hidden;overflow-y:scroll;">
                <form action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label">角色名称</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail4" placeholder="角色名称" value=""
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr class="row">
                                <th class="col-md-2">标题</th>
                                <th class="col-md-10">选项</th>
                            </tr>
                            <?php foreach ($data as $k => $v): ?>
                                <tr class="row">
                                    <td class="col-md-2"><?php echo $k; ?></td>

                                    <td class="col-md-10" style="text-align:left">
                                        <?php foreach ($v as $key => $vel): ?>
                                            <label class="checkbox-inline" style="line-height:1.6;padding-top:0">
                                                <input type="checkbox" name="role_permissions" class="inlineCheckbox3" value="<?php echo $vel['id']; ?>"><?php echo $vel['permissions_name']; ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>


                        </table>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div role='dialog' class='modal fade' id="role_add">
    <div class="modal-dialog">
        <div class='modal-content'>
            <div class='modal-header'>
                <button class='close' data-dismiss='modal'>
                    <span>&times;</span>
                </button>
                <h4 class="modal-title text-center">编辑角色</h4>
            </div>
            <div class="modal-body text-center" style="max-height:600px;overflow:hidden;overflow-y:scroll;">
                <form action="" class="form-horizontal">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-2 control-label"></label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" rid="" id="inputEmail3" placeholder="" value=""
                                   readonly="readonly">
                        </div>
                    </div>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <tr class="row">
                                <th class="col-md-2">标题</th>
                                <th class="col-md-10">选项</th>
                            </tr>
                            <?php foreach ($data as $k => $v): ?>
                                <tr class="row">
                                    <td class="col-md-2"><?php echo $k; ?></td>

                                    <td class="col-md-10" style="text-align:left">
                                        <?php foreach ($v as $key => $vel): ?>
                                            <label class="checkbox-inline" style="line-height:1.6;padding-top:0">
                                                <input type="checkbox" class="inlineCheckbox4"
                                                       value="<?php echo $vel['id']; ?>"><?php echo $vel['permissions_name']; ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </td>

                                </tr>
                            <?php endforeach; ?>

                        </table>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>


