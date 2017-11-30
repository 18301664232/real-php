  <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/auth.css">
  <script src="<?php echo STATICSCOMMON ?>ajaxPages.js"></script>
	    <div class="container-fluid">
	    	<section class="user-query">
	    		<div class="search-box">
	    			<div class="row">

	    				<div class="input-group col-sm-4">
	    				    <input  type="text" class="form-control search-key-input" placeholder="角色名">
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
	    		<div class="table-box">
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
	    		<div class="page-box">
	    			<nav class="clearfix" aria-label="Page navigation">
	    				<div class="row">
                            <p class="total col-sm-5" style="visibility: hidden" ></p>

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

