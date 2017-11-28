<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/order.css">
<script src="<?php echo STATICSADMIN ?>javascript/order.js"></script>


<div class="container-fluid">
    <section class="user-query">
        <div class="search-box">
            <div class="row">
                <div class="input-group col-sm-4">
                    <input type="text" class="form-control" placeholder="输入工单标题，工单号" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">搜索</button>
                    </span>
                </div>
            </div>
        </div>
        <div class="query-box">
            <div class="row">
                <div class="clearfix">
                    <em>工单类别：</em>
                    <ul class="clearfix" id="type">
                        <li <?php echo isset($_GET['type']) && $_GET['type'] == '会员账号' ? "class='active'" : '' ?> >会员账号</li>
                        <li <?php echo isset($_GET['type']) && $_GET['type'] == '财务问题' ? "class='active'" : '' ?>>财务问题</li>
                        <li <?php echo isset($_GET['type']) && $_GET['type'] == '使用问题' ? "class='active'" : '' ?>>使用问题</li>
                        <li <?php echo isset($_GET['type']) && $_GET['type'] == '其他问题' ? "class='active'" : '' ?>>其他问题</li>
                    </ul>
                </div>
                <div class="clearfix">
                    <em>处理状态：</em>
                    <ul class="clearfix" id="status">
                        <li <?php echo isset($_GET['status']) && $_GET['status'] == '1' ? "class='active'" : '' ?> sid="1">待处理</li>
                        <li <?php echo isset($_GET['status']) && $_GET['status'] == '2' ? "class='active'" : '' ?> sid="2">已答复</li>
                        <li <?php echo isset($_GET['status']) && $_GET['status'] == '3' ? "class='active'" : '' ?> sid="3" >已关闭</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="table-box">
            <table class="table table-bordered">
                <tr>
                    <th>序号</th>
                    <th>工单编号</th>
                    <th>账号</th>
                    <th>问题标题</th>
                    <th>提交时间</th>
                    <th>已回复次数</th>
                    <th>操作</th>
                </tr>
                <?php if (!empty($data)): ?>
                    <?php foreach ($data as $k => $v): ?>
                        <tr>
                            <td><?php echo ($k+1) ?></td>
                            <td><?php echo $v['order_no'] ?></td>
                            <td><?php echo $v['_id'] ?></td>
                            <td><?php echo $v['title'] ?></td>
                            <td><?php echo date('Y-m-d', $v['addtime']) ?></td>
                            <td><?php echo $v['total'] ?></td>
                            <td>
                                <?php if ($v['status'] == 3): ?>
                                    <button class="btn btn-info btn-detail">查看</button>
                                <?php else: ?>
                                    <button class="btn btn-info btn-detail">回复</button>
                                <?php endif; ?>
                                <button class="btn btn-danger off">删除</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
        <div class="page-box">
            <nav class="clearfix" aria-label="Page navigation">
                <div class="row">
                    <p class="total col-sm-4">当前条件共有数据：<span style="color:#0099FF"><?php echo $count; ?></span>条</p>
                    <ul class="pagination col-sm-6">
                        <?php $this->widget('application.widgets.pages.ListPagesDWidget', array('pages' => $pages, 'params' => array('keyword' => $keyword))) ?>
                    </ul>
                </div>
            </nav>
        </div>
    </section>

    <section class="detail-box">
        <div class="go-back">
            <p>返回上级</p>
        </div>
        <div class="order-area" id="">
            <h4 class="clearfix"><span class="order-title">工单标题：</span><span class="order-word"></span></h4>
            <button href="javascript:void(0)" class="btn btn-danger off order-delete">删除工单</button>
            <div class="question-box">
                <div class="question-list">


                </div>
            </div>
            <div class="edit-area clearfix" >
                <h4>编辑内容</h4>
                <div class="edit-box">
                    <div class="edit-left">
                        <img src="<?php echo STATICSADMIN ?>img/11.png" alt="">
                        <p>客服回复</p>
                    </div>
                    <div class="edit-right">
                        <textarea class="textarea" ></textarea>
                        <div class="upload-box">
                            <label for="upload">上传图片<span class="glyphicon glyphicon-plus" aria-hidden="true"></span></label>
                            <input type="file" id="upload">
                            <p style="display:inline-block; margin-left:20px; color:#337ab7">格式为jpg, png</p>
                            <div class="img-area clearfix">

                            </div>
                        </div>
                        <button  class="send-res">发送回复</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="mask"></div>
<div class = "pop-tip">
    <img src="" alt="">
    <i class="close-img"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></i>
</div>

<script>
    $(function () {
        $('#type li ,#status li').on('click', function () {
            var keyword = $('.form-control').val();
            var type = $('#type').find('.active').html();
            var status = $('#status').find('.active').attr('sid');
            url = '<?php echo REAL . U('admin/order/list') ?>';
            url += '&keyword=' + keyword + '&type=' + type + '&status=' + status;
            window.location.href = url;
        })

        $('.btn-default').on('click', function () {
            var keyword = $('.form-control').val();

            url = '<?php echo REAL . U('admin/order/list') ?>';
            url += '&keyword=' + keyword;
            window.location.href = url;
        })


        $('.btn-detail').on('click', function () {
            var order_on = $(this).parent().parent().find('td').eq(1).html();
            var _id = $(this).parent().parent().find('td').eq(2).html();
            var url = '<?php echo U('admin/order/Workorderinfo') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    order_no: order_on,
                    _id: _id
                },
                success: function (data) {
                    $('.order-word').html(data.result.title);
                    var nr = '';
                    nr += " <div class='question clearfix'><div class='head-img'><img src='" + data.result.headimg + "' alt=''></div><div class='content-box'>";
                    nr += "<p class='username'>" + data.result.name + "</p><p class='comment-time'>" + getLocalTime(data.result.addtime) + "</p>";
                    nr += "<p class='content'>" + data.result.content + "</p>";
                    if (typeof (data.result.link) != 'undefined') {
                        nr += "<div class='img-area'>";
                        for (var key in data.result.link) {
                            if (data.result.link[key] != null) {
                                nr += "<img src='" + '<?php echo REAL . '/uploads/workorder/' ?>' + data.result.link[key] + "' alt=''>";
                            }

                        }
                    }
                    nr += "</div>";
                    nr += "</div></div>";
                    //是否有回复
                    if (typeof (data.result.children) != 'undefined') {
                        for (var key in data.result.children) {
                            if (data.result.children[key].reply_type == 'realapp') {
                                nr += " <div class='response clearfix'><div class='head-img'><img src='<?php echo STATICSADMIN ?>img/11.png' alt=''></div><div class='content-box'>";
                                nr += "<p class='username'>客服回复</p><p class='comment-time'>" + getLocalTime(data.result.children[key].addtime) + "</p>";
                                nr += "<p class='content'>" + data.result.children[key].content + "</p>";
                                if (typeof (data.result.children[key].link) != 'undefined') {
                                    nr += "<div class='img-area'>";
                                    for (var ckey in data.result.children[key].link) {
                                        if (data.result.children[key].link[ckey] != null) {
                                            nr += "<img src='" + '<?php echo REAL . '/uploads/workorder/' ?>' + data.result.children[key].link[ckey] + "' alt=''>";
                                        }
                                    }
                                }
                                nr += "</div>";
                                nr += "</div></div>";

                            } else {
                                nr += " <div class='response clearfix'><div class='head-img'><img src='" + data.result.headimg + "' alt=''></div><div class='content-box'>";
                                nr += "<p class='username'>" + data.result.name + "</p><p class='comment-time'>" + getLocalTime(data.result.children[key].addtime) + "</p>";
                                nr += "<p class='content'>" + data.result.children[key].content + "</p>";
                                if (typeof (data.result.children[key].link) != 'undefined') {
                                    nr += "<div class='img-area'>";
                                    for (var ckey in data.result.children[key].link) {
                                        if (data.result.children[key].link[ckey] != null) {
                                            nr += "<img src='" + '<?php echo REAL . '/uploads/workorder/' ?>' + data.result.children[key].link[ckey] + "' alt=''>";
                                        }
                                    }
                                }
                                nr += "</div>";
                                nr += "</div></div>";
                            }
                        }
                    }
                    $('.question-list').html(nr);
                    $('.user-query,.detail-box').addClass('active');
                    $('.order-area').attr('id', order_on);
                    if (data.result.status == '3') {
                        $('.edit-area').hide()
                    } else {
                        $('.edit-area').show()
                    }
                    imgopen();
                    goBack();
                }
            });

        })

        //回复
        $('.send-res').on('click', function () {
            var order_no = $('.order-area').attr('id');
            var content = $('.textarea').val();
            var img = new Array();
            $('.edit-area .img-area .img-group').each(function (i) {
                img[i] = $(this).find('img').attr('src');
            });

            var url = '<?php echo U('admin/order/Replyorder') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    order_no: order_no,
                    content: content,
                    img: img
                },
                success: function (data) {
                    if (data.code == 0) {
                        alert('回复成功');
                        window.location.reload();
                    }
                }
            })
        })
        var order_no = '';
        //删除
        $('.order-delete').on('click', function () {
            order_no = $('.order-area').attr('id');
        })

        //删除
        $('.table-bordered .btn-danger').on('click', function () {
            order_no = $(this).parent().parent().find('td').eq(1).html();
        })
        delTip($('.off'), '删除工单', '确认删除此工单么？', ajax);
        function ajax() {

            var url = '<?php echo U('admin/order/Delorder') ?>';
            $.ajax({
                type: "POST",
                url: url,
                dataType: "json",
                data: {
                    order_no: order_no
                },
                success: function (data) {
                    if (data.code == 0) {
                        alert('删除成功');
                        window.location.reload();
                    }
                }
            })
        }

        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
        }

        function imgopen() {

            //点击放大图片
            $('.question-list .img-area img').each(function () {
                $(this).click(function () {
                    $('.pop-tip, .mask').css('display', 'block');
                    $('.right-product').css('position', 'fixed');
                    $('.pop-tip img').attr('src', $(this).attr('src'));
                    $('.close-img').on('click', function () {
                        $('.pop-tip, .mask').css('display', 'none');
                        $('.right-product').css('position', 'absolute');
                    })
                })
            })

        }



    })

</script>