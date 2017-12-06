
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
                        <button class="btn btn-info" data-toggle="modal" data-target="#shoushi">添加手势</button>
                    </div>
                </div>
                <div class="table-box">
                    <table class="table table-hover">
                        <tr>
                            <th>顺序</th>
                            <th>权重</th>
                            <th>手势名称</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1.1</td>
                            <td>滑屏</td>
                            <td>
                                <button class="btn btn-success" data-toggle="modal" data-target="#shoushi">修改</button> 
                                <button class="btn btn-danger del-btn">删除</button>
                            </td>
                        </tr>
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
                                <button class="btn btn-info" data-toggle="modal" data-target="#xiaoguo">添加效果</button>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="table table-hover">
                                <tr>
                                    <th>顺序</th>
                                    <th>权重</th>
                                    <th>效果名称</th>
                                    <th>操作</th>
                                </tr>
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
                    <div class="next-list" style="display:none">
                        <div class="clearfix">
                            <div class="add-btn next-btn">
                                <button class="btn btn-info" data-toggle="modal" data-target="#xiaoguo">添加效果</button>
                            </div>
                        </div>
                        <div class="table-box">
                            <table class="table table-hover">
                                <tr>
                                    <th>顺序</th>
                                    <th>权重</th>
                                    <th>效果名称</th>
                                    <th>操作</th>
                                </tr>
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
                        <form action="" class="form-horizontal">
                            <div class="form-group margin-b">
                                <label for="" class="control-label col-sm-4">最小值</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="最小值" value=''>
                                </div>
                            </div>
                            <div class="form-group margin-b">
                                <label for="" class="control-label col-sm-4">最大值</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="最大值" value=''>
                                </div>
                            </div>
                            <div class="form-group margin-b">
                                <label for="" class="control-label col-sm-4">缺省值</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="缺省值" value=''>
                                </div>
                            </div>
                            <div class="form-group margin-b">
                                <label for="" class="control-label col-sm-4">步长</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" placeholder="步长"  value=''>
                                </div>
                            </div>
                            <div class="text-center margin-b">
                                <button class="btn btn-primary btn-save">保存</button>
                                <button class="btn btn-primary btn-edit">编辑</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="content fangxiang clearfix">
                <div class="clearfix">
                    <div class="add-btn prev-btn">
                        <button class="btn btn-info" data-toggle="modal" data-target="#fangxiang">添加方向</button>
                    </div>
                </div>
                <div class="table-box">
                    <table class="table table-hover">
                        <tr>
                            <th>顺序</th>
                            <th>权重</th>
                            <th>方向名称</th>
                            <th>操作</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>1.1</td>
                            <td>滑屏</td>
                            <td>
                                <button class="btn btn-success" data-toggle="modal" data-target="#fangxiang">修改</button>
                                <button class="btn btn-danger del-btn">删除</button>
                            </td>
                        </tr>
                    </table>
                </div>  
            </div>
        </div>
    </section>
</div>
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
                            <input type="text" class="form-control" placeholder="手势名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">配置权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="配置权重">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">KEY值</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="KEY值">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
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
                            <input type="text" class="form-control" placeholder="效果名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">配置权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="配置权重">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">KEY值</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="KEY值">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">方向配置</label>
                        <div class="col-sm-10">
                            <select class="form-control">
                                <option value="">无</option>
                                <option value="">全部选择</option>
                                <option value="">从上到下</option>
                                <option value="">从左到右</option>
                                <option value="">从前到后</option>
                            </select>
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
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
                            <input type="text" class="form-control" placeholder="方向名称">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">配置权重</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="配置权重">
                        </div>
                    </div>
                    <div class="form-group margin-b">
                        <label for="" class="control-label col-sm-2">KEY值</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" placeholder="KEY值">
                        </div>
                    </div>
                    <button class='btn btn-primary btn-sm' data-dismiss='modal'>取消</button>
                    <button class='btn btn-danger btn-sm btn-click' data-dismiss='modal'>确认</button>
                </form>
            </div>
        </div>
    </div>
</div>


