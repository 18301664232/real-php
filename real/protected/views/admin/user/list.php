  <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/user_management.css">
      <script src="<?php echo STATICSADMIN ?>js/user_management.js"></script>
	    <div class="container-fluid">
	    	<section class="user-query">
	    		<div class="search-box">
	    			<div class="row">
	    				<div class="input-group col-sm-4">
	    				    <input type="text" class="form-control" placeholder="搜索用户">
	    				    <span class="input-group-btn">
	    				    	<button class="btn btn-default" type="button">搜索</button>
	    				    </span>
	    				</div>
	    			</div>
	    		</div>
	    		<div class="query-box">
	    			<div class="row">
	    				<div class="clearfix">
	    					<em>产品版本：</em>
	    					<ul class="clearfix">
	    						<li class="active">全部</li>
	    						<li>企业版</li>
	    						<li>个人版</li>
	    					</ul>
	    				</div>
	    				<div class="clearfix">
	    					<em>用户类别：</em>
	    					<ul class="clearfix">
	    						<li>封停用户</li>
	    						<li>封停用户</li>
	    						<li class="active">封停用户</li>
	    						<li>封停用户</li>
	    						<li>封停用户</li>
	    					</ul>
	    				</div>
	    				<div class="clearfix">
	    					<em>时间选择：</em>
	    					<ul class="clearfix">
	    						<li>今日</li>
	    						<li>昨日</li>
	    						<li class="active">近7日</li>
	    						<li>近15日</li>
	    						<li>近30日</li>
	    					</ul>
	    					<div class="datePicker">						
    							<input class="Wdate" type="text" onfocus="WdatePicker()">
    							<span>至</span>
    							<input class="Wdate" type="text" onfocus="WdatePicker()">
	    					</div>
	    				</div>
	    			</div>
	    			<div class="text-left btn-area">
	    				<button class="btn btn-primary btn-query">查询</button>
	    				<button class="btn btn-success btn-export">导出数据</button>
	    			</div>
	    		</div>
	    		<div class="table-box">
	    			<table class="table table-bordered">
	    				<tr>
	    					<th>序号</th>
	    					<th>产品版本</th>
	    					<th>账号</th>
	    					<th>线上项目</th>
	    					<th>注册时间</th>
	    					<th>最后登录</th>
	    					<th>账号操作</th>
	    				</tr>
	    				<tr>
	    					<td>1</td>
	    					<td>企业版</td>
	    					<td>12342425435@qq.com</td>
	    					<td>35</td>
	    					<td>2015-08-07</td>
	    					<td>2015-08-07</td>
	    					<td>
	    						<button class="btn btn-info btn-detail">详情</button>
	    						<button class="btn btn-danger off">封停</button>
	    					</td>
	    				</tr>
	    				<tr>
	    					<td>1</td>
	    					<td>企业版</td>
	    					<td>12342425435@qq.com</td>
	    					<td>35</td>
	    					<td>2015-08-07</td>
	    					<td>2015-08-07</td>
	    					<td>
	    						<button class="btn btn-info btn-detail">详情</button>
	    						<button class="btn btn-danger on">解封</button>
	    					</td>
	    				</tr>
	    			</table>
	    		</div>
	    		<div class="page-box">
	    			<nav class="clearfix" aria-label="Page navigation">
	    				<div class="row">
							<p class="total col-sm-4">当前条件共有数据：<span style="color:#0099FF">331400</span>条</p>
		    			  	<ul class="pagination col-sm-6">
		    			    	<li>
		    			      		<a href="javascript:void(0)" aria-label="Previous">
		    			        	<span aria-hidden="true">&laquo;</span>
		    			      		</a>
		    			    	</li>
		    			    	<li class="active"><a href="javascript:void(0)">1</a></li>
		    			   		<li><a href="javascript:void(0)">2</a></li>
		    			    	<li><a href="javascript:void(0)">3</a></li>
		    			    	<li><a href="javascript:void(0)">4</a></li>
		    			    	<li><a href="javascript:void(0)">5</a></li>
		    			    	<li>
		    			      		<a href="javascript:void(0)" aria-label="Next">
		    			        	<span aria-hidden="true">&raquo;</span>
		    			      		</a>
		    			    	</li>
		    			  	</ul>
	    				</div>
	    			</nav>
	    		</div>
	    	</section>
			<section class="detail-box">
				<div class="go-back">
					<p>返回上级</p>
				</div>
				<div class="detail-top clearfix">
					<div class="row">
						<div class="col-sm-4 basic-info">
							<h2 class="title">基本信息</h2>
							<div class="user-info-box clearfix">
								<div class="head-img">
									<img src="" alt="">
								</div>
								<div class="user-info">
									<p class="user-name">弗朗西斯</p>
									<p class="user-address"><span>上海</span><span>普陀区</span></p>
								</div>
							</div>
						</div>
						<div class="col-sm-7 project-profile">
							<div class="project-info">
								<h2 class="title">项目概况</h2>
								<div class="project-info-box">
									<div>
										<p>线上项目</p>
										<em>23</em>
									</div>
									<div>
										<p>公开项目</p>
										<em>23</em>
									</div>
									<div>
										<p>线下项目</p>
										<em>23</em>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="detail-table-box">
					<h2 class="title">消费情况</h2>
					<div class="detail-table row">
						<div class="col-sm-11 detail-table">
							<table class="table">
								<tr>
									<th>序号</th>
									<th>订单编号</th>
									<th>流量包名称</th>
									<th>购买日期</th>
									<th>金额</th>
								</tr>
								<tr>
									<td>1</td>
									<td>123123123123</td>
									<td>10T季度包</td>
									<td>2017-08-07</td>
									<td class="money">10</td>
								</tr>
							</table>
						</div>
					</div>
				</div>
			</section>	    	
	    </div>
