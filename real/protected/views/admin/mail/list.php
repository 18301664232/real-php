<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/message_management.css">
<script src="<?php echo STATICSADMIN ?>javascript/message_management.js"></script>
<script src="<?php echo STATICSADMIN ?>javascript/My97DatePicker/WdatePicker.js"></script>

<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">
                <div class="input-group col-sm-4" style="float:left">
                    <input type="text" class="form-control search-input" placeholder="输入消息名称">
                    <span class="input-group-btn">
	    				    	<button class="btn btn-default search-btn" type="button">搜索</button>
	    				    </span>
                </div>
                <div class="input-group col-sm-7" style="float:left">
                    <button class="btn default-btn btn-info add-message" style="float:right">添加消息</button>
                </div>
            </div>
        </div>
        <div class="query-box">
            <div class="row">
                <div class="clearfix">
                    <em>消息类别：</em>
                    <ul class="clearfix">
                        <li>全部消息</li>
                        <li class="active">系统公告</li>
                        <li>消息提醒</li>
                    </ul>
                </div>
                <div class="clearfix message-status">
                    <em>消息状态：</em>
                    <ul class="clearfix">
                        <li class="active sended">已推送</li>
                        <li class="need-edit">草稿箱</li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="table-box">
            <table class="table table-bordered edit active">
                <tr>
                    <th>序号</th>
                    <th>消息类别</th>
                    <th>标题</th>
                    <th>推送时间</th>
                    <th>推送用户</th>
                    <th>操作</th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>系统消息</td>
                    <td class="message-title">啊老三肯德基疯狂拉升了的咖啡金卡圣诞快乐发克鲁塞德拉卡拉上岛咖啡考虑了卡萨</td>
                    <td>2017-1-10 8:30:32</td>
                    <td>全体用户</td>
                    <td>
                        <button class="btn btn-info btn-detail">查看</button>
                        <button class="btn btn-danger delete">删除</button>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>系统消息</td>
                    <td class="message-title">啊老三肯德基疯狂拉升了的咖啡金卡圣诞快乐发克鲁塞德拉卡拉上岛咖啡考虑了卡萨</td>
                    <td>2017-1-10 8:30:32</td>
                    <td>全体用户</td>
                    <td>
                        <button class="btn btn-info btn-detail">查看</button>
                        <button class="btn btn-danger delete">删除</button>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <section class="detail-box">
        <div class="go-back">
            <p>返回上级</p>
        </div>
        <div class="query-box child-query-box">
            <div class="row">
                <div class="clearfix">
                    <em>消息类别：</em>
                    <ul class="clearfix">
                        <li class="active">系统公告</li>
                        <!--                        <li>消息提醒</li>-->
                    </ul>
                </div>
                <div class="clearfix">
                    <em>时间筛选：</em>
                    <ul class="clearfix">
                        <li class="active">全部</li>
                        <!--                        <li>近7日</li>-->
                        <!--                        <li>近15日</li>-->
                        <!--                        <li>近30日</li>-->
                        <!--                        <li></li>-->
                    </ul>
                    <!--                    <div class="datePicker">-->
                    <!--                        <input class="Wdate" type="text" onfocus="WdatePicker()">-->
                    <!--                        <span>至</span>-->
                    <!--                        <input class="Wdate" type="text" onfocus="WdatePicker()">-->
                    <!--                    </div>-->
                </div>
                <div class="clearfix">
                    <em>用户类别：</em>
                    <ul class="clearfix">
                        <li class="active">全部</li>
                        <!--                        <li>新用户（3日内）</li>-->
                        <!--                        <li>老用户</li>-->
                    </ul>
                </div>
                <div class="clearfix">
                    <em>登陆情况：</em>
                    <ul class="clearfix">
                        <li class="active">全部</li>
                        <!--                        <li>有登陆</li>-->
                        <!--                        <li>未登录</li>-->
                    </ul>
                </div>
                <div class="clearfix">
                    <em>消费情况：</em>
                    <ul class="clearfix">
                        <li class="active">全部</li>
                        <!--                        <li>未消费</li>-->
                        <!--                        <li>已消费</li>-->
                    </ul>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="exampleInput">标题：</label>
            <input type="email" class="form-control ueditor-title" placeholder="请输入标题">
        </div>
        <div class="ueditor_a">
            <script id="editor" type="text/plain" style="width:100%;height:500px;float:left"></script>
            <script type="text/javascript">

                //实例化编辑器
                //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                var ue = UE.getEditor('editor');

            </script>
            <div class="ueditor-right">
                <div class="publish-area">
                    <button type="button" class="btn btn-default">存为草稿</button>
                    <button type="button" class="btn btn-success">保存发布</button>
                </div>
            </div>
            <script type="text/javascript">
                document.addEventListener('readystatechange', function () {
                    if (document.readyState === 'complete') {
                        document.getElementById('edui1').style.width = "100%";
                    }
                }, false)

            </script>
        </div>
    </section>
</div>
</div>