  <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/user_management.css">
      <script src="<?php echo STATICSADMIN ?>javascript/user_management.js"></script>
  <script src="<?php echo STATICSADMIN ?>javascript/My97DatePicker/WdatePicker.js"></script>
  <script src="<?php echo STATICSCOMMON ?>ajaxPages.js"></script>
	    <div class="container-fluid">
	    	<section class="user-query">
	    		<div class="search-box">
	    			<div class="row">
	    				<div class="input-group col-sm-4">
	    				    <input  type="text" class="form-control search-key-input" placeholder="搜索用户">
	    				    <span class="input-group-btn">
	    				    	<button class="btn btn-default search-key" type="button">搜索</button>
	    				    </span>
	    				</div>
	    			</div>
	    		</div>
	    		<div class="query-box">
	    			<div class="row">
                        <div class="clearfix">
                            <em>时间选择：</em>
                            <ul class="clearfix clearfix-time">
                                <li class="active">全部</li>
                                <li >今日</li>
                                <li>昨日</li>
                                <li >近7日</li>
                                <li>近15日</li>
                                <li>近30日</li>
                            </ul>
                            <div class="datePicker">
                                <input class="Wdate" type="text" onfocus="WdatePicker()">
                                <span>至</span>
                                <input class="Wdate" type="text" onfocus="WdatePicker()">
                            </div>
                            <button class="btn btn-sm btn-warning date-search-btn" style="margin-left: 10px">搜索</button>
                        </div>

                        <div class="clearfix">
                            <em>用户类别：</em>
                            <ul class="clearfix clearfix-user" >
                                <li class="active">全部</li>
                                <li>注册用户</li>
                                <li >登录用户</li>
                                <li>发布用户</li>
                                <li>消费用户</li>
                            </ul>
                        </div>
	    				<div class="clearfix">
	    					<em>账户状态：</em>
	    					<ul class="clearfix clearfix-ststus">
	    						<li class="active">全部</li>
	    						<li>正常</li>
	    						<li>封停</li>
	    					</ul>
	    				</div>


	    			</div>
	    			<div class="text-right btn-area ">
                        <p class="total" style="line-height:30px;">当前条件共有数据：<span style="color:#0099FF"></span>条</p>
<!--	    				<button class="btn btn-primary btn-query">查询</button>-->
	    				<button <?php if( $this->checkAuth($this->id.'/data')){echo 'disabled';} ?>  class="btn btn-success excel-ok">导出数据</button>
	    			</div>
	    		</div>
	    		<div class="table-box">
	    			<table class="table table-bordered">
	    				<tr>
	    					<th>序号</th>
	    					<th>账号</th>
	    					<th>线上项目</th>
	    					<th>注册时间</th>
	    					<th>最后登录</th>
	    					<th>消费金额</th>
                            <th>账户状态</th>
                            <th>账号操作</th>
	    				</tr>
	    				<tr>
	    					<td>1</td>
	    					<td>12342425435@qq.com</td>
	    					<td>43</td>
	    					<td>2015-08-07</td>
	    					<td>35</td>
	    					<td>封停</td>
	    					<td>2015-08-07</td>
	    					<td>
	    						<button class="btn btn-info btn-detail">查看</button>
	    						<button class="btn btn-danger off">封停</button>
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
									<p class="user-name"></p>
									<p class="user-address"><span></span><span></span></p>
								</div>
							</div>
						</div>
						<div class="col-sm-7 project-profile">
							<div class="project-info">
								<h2 class="title">
                                    <div>项目概况</div>
                                    <div>详情查看>></div>
                                    <div style="display:none"></div>
                                </h2>

								<div class="project-info-box">
									<div>
										<p>付费项目</p>
										<em>23</em>
									</div>
									<div>
										<p>免费项目</p>
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
                            <div class="order-record hidden" style="color:#0095cd;text-align: center">无购买记录</div>
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
                  <textarea  placeholder="请输入原因.." class="form-control self-reason" rows="6" style="margin-top: 10px"></textarea>
              </div>
              <div class="modal-footer" style="border: none">

                  <div class="text-center">
                      <button type="button" class="btn btn-success" data-dismiss="modal">取消</button>
                      <button data-userid data-type id="flow_true_btn" type="button" class="btn btn-danger" data-dismiss='modal'>确定</button>
                  </div>

              </div>
          </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <script>
      //执行权限--以下是在没有权限的情况下操作
      function checkAuth() {
          if(<?php echo $this->checkAuth($this->id.'/list') ?>){
              $('.query-box .row li').unbind();
              $('.search-key').attr('disabled','disabled');
              $('.date-search-btn').attr('disabled','disabled');

          }
          if(<?php echo $this->checkAuth($this->id.'/edit') ?>){
              $('.table-box tr button').attr('disabled','disabled');
          }
      };


  </script>
