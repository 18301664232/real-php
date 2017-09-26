<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/account-center.css">

<body>
    <div class="title-sec">
        <div class="title-box clearfix">
            <p class="title-text">账户中心</p>
            <ul class="title-list">
                <li ><a href="<?php echo U('user/user/info') ?>">账户资料</a></li>
                <li ><a href="<?php echo U('user/user/safety') ?>">账户安全</a></li>
                <li  class="title-current"><a href="<?php echo U('user/user/workorder') ?>">工单管理</a></li>
            </ul>
        </div>
    </div>
    <div class="ord-sec">
        <ul class="nav nav-tabs ord-head">
            <li class="active"><a href="#my-order" data-toggle="tab">我的工单</a></li>
            <li><a href="#new-order" data-toggle="tab">新建工单</a></li>
        </ul>
        <div class="tab-content ord-body">
            <div id="my-order" class="tab-pane active ord-my-order">
                <div class="ord-search-box clearfix">
                    <p class="ord-search-key">关键字:</p>
                    <input type="text" class="ord-search-key-input">
                    <p class="ord-search-time">时间:</p>
                    <div id="ord-search-box-inner" class="ord-search-box-inner clearfix">
                        <input id="ord-search-start" type="text" class="ord-search-start">-
                        <input id="ord-search-finish" type="text" class="ord-search-finish">
                    </div>
                    <button class="ord-search-btn">查询</button>
                </div>
                <div class="ord-table-box">
                    <table class="table ord-table">
                        <thead>
                            <tr>
                                <th>工单编号</th>
                                <th>提问问题</th>
                                <th>类型</th>                       
                                <th>账号</th>
                                <th>时间</th>
                                <th>
                                    <div class="dropdown">
                                        <button id="order-state" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">全部状态<span class="caret"></span></button>
                                        <ul aria-labelledby="order-state" class="dropdown-menu ord-table-list">
                                            <li class="ord-table-list-all">全部状态</li>
                                            <li class="ord-table-list-wait">待受理</li>
                                            <li class="ord-table-list-reply">已答复</li>
                                            <li class="ord-table-list-close">已关闭</li>
                                        </ul>
                                    </div>
                                </th>
                                <th>操作</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data)): ?>
                                <?php foreach ($data as $k => $v): ?>
                                    <?php if ($v['status'] == 1): ?><tr class="ord-table-wait-res">
                                    <?php elseif ($v['status'] == 2): ?><tr class="ord-table-resed">
                                    <?php elseif ($v['status'] == 3): ?><tr class="ord-table-closed">
                                    <?php endif; ?>
                                        <td><?php echo $v['order_no']; ?></td>
                                        <td><?php echo $v['title']; ?></td>
                                        <td><?php echo $v['type']; ?></td>
                                        <td><?php echo $v['_id']; ?></td>
                                        <td><?php echo date('Y-m-d', $v['addtime']) ?></td>
                                        <?php if ($v['status'] == 1): ?><td class="status">待受理</td>
                                        <?php elseif ($v['status'] == 2): ?><td class="status">已答复</td>
                                        <?php elseif ($v['status'] == 3): ?><td class="status">已关闭</td>
                                        <?php endif; ?>
                                        <td>
                                            <button class="btn btn-default ord-table-view-det"></button>
                                            <button class="btn btn-default ord-table-delete"></button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div class="det-sec">
                    <div class="det-head clearfix">
                        <p class="det-head-text">工单详情</p>
                        <button class="det-head-return">返回列表</button>
                    </div>
                    <div class="det-state-box det-state-pro-wait">
                        <div class="det-state-title">您的工单编号：<span class="det-state-title-num"></span>&nbsp;<span class="det-state-title-text">待受理</span></div>
                        <div class="det-state-pro-back">
                            <div class="det-state-pro-front"></div>
                        </div>
                        <div class="det-state-pro-text clearfix">
                            <p>待受理</p>
                            <p>已答复</p>
                            <p>已关闭</p>
                        </div>
                        <div class="det-des-box">
                            <div class="det-des1 clearfix">
                                <p class="det-des1-title">提问问题：<span></span></p>
                                <button class="det-des1-ope"></button>
                            </div>
                            <div class="det-des2 clearfix">
                                <p class="det-dest2-name">提交账号：<span></span></p>
                                <p class="det-dest2-time">提交时间：<span></span></p>
                                <p class="det-dest2-type">工单类型：<span></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="det-com-box">
                        <div class="det-com-head">沟通记录</div>
                        <div class="det-com-body clearfix">
                            <div class="det-com-left"><img src="<?php echo STATICS ?>images/det-ava.png" class="det-com-ava"></div>
                            <div class="det-com-right">
                                <p class="det-com-name"></p>
                                <p class="det-com-time"></p>
                                <p class="det-com-text"></p>
                                <div class="det-com-img clearfix">
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="det-res-box">
                        <p class="det-res-text">发表回复</p>
                        <textarea  class="det-res-input"></textarea>
                        <div class="det-res-upload clearfix">
                            <button class="det-res-upload-btn">上传附件</button>
                            <input type="file" class="det-res-file">
                            <p class="det-res-upload-text">单个上传文件大小不超过3M、个数不超过3个、格式为jpg、png</p>
                        </div>
                        <div class="det-res-show clearfix">
                            <div class="det-res-show-unit"><img class="det-res-show-img">
                                <button class="det-res-show-del">删除</button>
                            </div>
                            <div class="det-res-show-unit"><img class="det-res-show-img">
                                <button class="det-res-show-del">删除</button>
                            </div>
                            <div class="det-res-show-unit"><img class="det-res-show-img">
                                <button class="det-res-show-del">删除</button>
                            </div>
                        </div>
                        <button class="base-btn det-res-submit">提交</button>
                    </div>
                </div>
            </div>
            <div id="new-order" class="tab-pane ord-new-order">
                <div class="new-type">
                    <div class="new-type-text">工单类型</div>
                    <div class="new-type-box clearfix">
                        <div class="new-acc new-type-selected clearfix">
                            <div class="new-type-left"><img src="<?php echo STATICS ?>images/new-acc.png" class="new-type-img"></div>
                            <div class="new-type-right">
                                <p class="new-type-title">会员账号</p>
                                <p class="new-type-descripe">关于会员帐号的相关问题</p>
                            </div>
                        </div>
                        <div class="new-fin clearfix">
                            <div class="new-type-left"><img src="<?php echo STATICS ?>images/new-fin.png" class="new-type-img"></div>
                            <div class="new-type-right">
                                <p class="new-type-title">财务问题</p>
                                <p class="new-type-descripe">关于财务的相关问题</p>
                            </div>
                        </div>
                        <div class="new-tec clearfix">
                            <div class="new-type-left"><img src="<?php echo STATICS ?>images/new-tec.png" class="new-type-img"></div>
                            <div class="new-type-right">
                                <p class="new-type-title">使用问题</p>
                                <p class="new-type-descripe">关于产品使用的相关问题</p>
                            </div>
                        </div>
                        <div class="new-oth clearfix">
                            <div class="new-type-left"><img src="<?php echo STATICS ?>images/new-oth.png" class="new-type-img"></div>
                            <div class="new-type-right">
                                <p class="new-type-title">其他问题</p>
                                <p class="new-type-descripe">其他类产品问题</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="new-input">
                    <p class="new-input-text">信息输入</p>
                    <div class="new-input-box">
                        <p class="new-title">问题标题&nbsp;<span>*</span></p>
                        <div class="new-textarea-title clearfix">
                            <textarea placeholder="输入汉字、字母及数字不超过60个字符" maxlength="60" class="new-title-input"></textarea>
                            <p class="new-textarea-title-fb">请输入问题描述</p>
                        </div>
                        <p class="new-des">详细信息&nbsp;<span>*</span></p>
                        <div class="new-textarea-des clearfix">
                            <textarea  class="new-des-input"></textarea>
                            <p class="new-textarea-des-fb">请输入问题描述</p>
                        </div>
                        <p class="new-mes">接收短信提醒&nbsp;<span>*</span></p>
                        <div class="new-mes-btn-gr clearfix">
                            <button class="new-mes-never new-mes-selected" replace="1">从不接收</button>
                            <button class="new-mes-daytime" replace="2">每日&nbsp;9:00-18:00</button>
                            <button class="new-mes-any" replace="3">任何时间</button>
                        </div>
                        <div class="new-upload clearfix">
                            <input type="file" class="new-upload-file">
                            <button class="new-upload-btn">上传附件</button>
                            <p class="new-upload-text">单个上传文件大小不超过3M、个数不超过3个、格式为jpg、png</p>
                        </div>
                        <div class="new-res-show clearfix">
                            <div class="new-res-show-unit"><img class="new-res-show-img">
                                <button class="new-res-show-del">删除</button>
                            </div>
                            <div class="new-res-show-unit"><img class="new-res-show-img">
                                <button class="new-res-show-del">删除</button>
                            </div>
                            <div class="new-res-show-unit"><img class="new-res-show-img">
                                <button class="new-res-show-del">删除</button>
                            </div>
                        </div>
                        <button class="new-input-submit base-btn">提交</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="order-alert-del" class="modal">
        <div class="modal-dialog order-alert-del-width">
            <div class="modal-content order-alert-del-height">
                <p class="alert-head clearfix"><span class="alert-head-text">删除工单</span>
                    <button data-dismiss="modal" class="alert-head-close"></button>
                </p>
                <div class="alert-body">
                    <p class="order-alert-text">确认删除此工单？</p>
                    <button class="order-alert-btn">确认</button>
                </div>
            </div>
        </div>
    </div>
    <div tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="order-alert-img" class="modal">
        <div class="modal-dialog order-alert-img-width">
            <div class="modal-content order-alert-img-height">
                <p class="order-alert-img-top">
                    <button data-dismiss="modal" class="order-alert-img-close"></button>
                </p><img class="order-alert-img-big">
            </div>
        </div>
    </div>
    <div class="wtSlideBlock"></div>

    <script type="text/javascript">
        $(function () {

            //工单管理的我的工单的逻辑
            //列表为空，禁止使用搜索框，筛选框的逻辑
            function forbinInput() {
                var tableItemNum = $('.ord-table > tbody > tr').length;
                if (tableItemNum === 0) {
                    $('.ord-search-key-input,.ord-search-start,.ord-search-finish').prop('disabled', 'disabled');
                } else {
                    $('.ord-search-key-input,.ord-search-start,.ord-search-finish').prop('disabled', null);
                }
            }
            // forbinInput();
            //表格状态切换下拉列表的逻辑
            $('.ord-table-list li').on('click', function () {//this是哪一个，this,
                if ($(this).hasClass('ord-table-list-all')) {
                    $('.ord-table > tbody > tr').show();
                }
                if ($(this).hasClass('ord-table-list-wait')) {
                    $('.ord-table > tbody > tr').hide();
                    $('.ord-table-wait-res').show();
                }
                if ($(this).hasClass('ord-table-list-reply')) {
                    $('.ord-table > tbody > tr').hide();
                    $('.ord-table-resed').show();
                }
                if ($(this).hasClass('ord-table-list-close')) {
                    $('.ord-table > tbody > tr').hide();
                    $('.ord-table-closed').show();
                }
            })
            //工单筛选的逻辑
            $('#ord-search-box-inner').dateRangePicker({
                separator: ' - ',
                autoClose: true,
                getValue: function ()
                {
                    if ($('#ord-search-start').val() && $('#ord-search-finish').val())
                        return $('#ord-search-start').val() + ' - ' + $('#ord-search-finish').val();
                    else
                        return '';
                },
                setValue: function (s, s1, s2)
                {
                    $('#ord-search-start').val(s1);
                    $('#ord-search-finish').val(s2);
                }
            }).bind('datepicker-closed', function () {
                console.log($('#ord-search-start').val() + ' to ' + $('#ord-search-finish').val());
            });
            //已经关闭的表格项可以删除的逻辑,删除的时候加上判断是否表格项为空，然后禁止搜索和筛选
            //这个的话。需要哪个弹出框，弹出框最后好了
            var did = '';
            var needRemoveDom = null;
            $('.ord-table').on('click', '.ord-table-delete', function () {
                did = $(this).parent().parent().find('td').eq(0).html();
                needRemoveDom = $(this).parents('tr');
                var conHeight = $(window).height();
                var alertHeight = $('.order-alert-del-height').outerHeight();
                var diffHeight = conHeight - alertHeight;
                var alertMarginTop = diffHeight > 0 ? ((diffHeight / 2) | 0) + 'px' : '0px';
                $('#order-alert-del').css('margin-top', alertMarginTop);
                $('#order-alert-del').modal({
                    backdrop: 'static',
                    show: true
                });
            });
            $('.order-alert-btn').on('click', function () {

                url = '<?php echo U('user/user/delorder') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        id: did,
                    },
                    success: function (data) {
                        if (data.code == '0') {
                            $('#order-alert-del').modal('hide');
                            needRemoveDom.remove();
                            needRemoveDom = null;

                        } else {
                            alert('删除失败');
                        }
                    }
                });

            });
            //查看工单详情
            $('.ord-table').on('click', '.ord-table-view-det', function () {
                var id = $(this).parent().parent().find('td').eq(0).html();
                url = '<?php echo U('user/user/workorderinfo') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        id: id,
                    },
                    success: function (data) {
                        if (data.code == '0') {
                            //初始化
                            $('.det-com-body:gt(0)').remove();
                            $('.det-state-title-num').html(data.result.order_no);
                            if (data.result.status == 1)
                                orderState.orderWait();
                            if (data.result.status == 2)
                                orderState.orderReply();
                            if (data.result.status == 3)
                                orderState.orderClose();
                            $('.det-des1-title span').html(data.result.title);
                            var name = '<?php if (isset(Yii::app()->session['user']['tel'])) {
                                echo Yii::app()->session['user']['tel'];
                            } else {
                                echo Yii::app()->session['user']['email'];
                            } ?>';
                            $('.det-dest2-name span').html(name);
                            $('.det-dest2-time span').html(getLocalTime(data.result.addtime));
                            $('.det-dest2-type span').html(data.result.type);
<?php if (!empty(Yii::app()->session['user']['headimg'])): ?>
                                var headimg = '<?php echo Yii::app()->session['user']['headimg'] ?>';
                                $('.det-com-head').next('.det-com-body').find('.det-com-left img').attr('src', headimg);
<?php endif; ?>
                            $('.det-com-head').next('.det-com-body').find('.det-com-name').html(name);
                            $('.det-com-head').next('.det-com-body').find('.det-com-time').html(getLocalTime(data.result.addtime));
                            $('.det-com-head').next('.det-com-body').find('.det-com-text').html(data.result.content);
                            var link_list = ''
                            if (data.result.link != '') {
                                for (var key in data.result.link) {
                                    link_list += '<img src="<?php echo REAL . '/uploads/workorder/' ?>' + data.result.link[key] + '">';
                                }
                            }
                            $('.det-com-head').next('.det-com-body').find('.det-com-img').html(link_list);
                            //回复内容
                            if (data.result.children != '') {
                                var str = '';
                                for (var key in data.result.children) {
                                    if (data.result.children[key].reply_type == 'user') { //用户
                                        str += '<div class="det-com-body clearfix">';
<?php if (!empty(Yii::app()->session['user']['headimg'])): ?>
                                            var headimg = '<?php echo Yii::app()->session['user']['headimg'] ?>';
                                            str += '<div class="det-com-left"><img src="' + headimg + '" class="det-com-ava"></div><div class="det-com-right">';
<?php else: ?>
                                            str += '<div class="det-com-left"><img src="<?php echo STATICS ?>images/det-ava.png" class="det-com-ava"></div><div class="det-com-right">';
<?php endif; ?>
                                        str += ' <p class="det-com-name">' + name + '</p>';
                                        str += '<p class="det-com-time">' + getLocalTime(data.result.children[key].addtime) + '</p>';
                                        str += '<p class="det-com-text">' + data.result.children[key].content + '</p><div class="det-com-img clearfix">';
                                        if (data.result.children[key].link != '') {
                                            for (var k in data.result.children[key].link) {
                                                str += '<img src="<?php echo REAL . '/uploads/workorder/' ?>' + data.result.children[key].link[k] + '">';
                                            }

                                        }
                                        str += '</div></div></div>';
                                    } else { //回复人员
                                        str += '<div class="det-com-body  det-com-res clearfix">';
                                        str += '<div class="det-com-left"><img src="<?php echo STATICS ?>images/det-official.png" class="det-com-ava"></div><div class="det-com-right">';
                                        str += ' <p class="det-com-name">' + data.result.children[key].reply_type + '</p>';
                                        str += '<p class="det-com-time">' + getLocalTime(data.result.children[key].addtime) + '</p>';
                                        str += '<p class="det-com-text">' + data.result.children[key].content + '</p><div class="det-com-img clearfix">';
                                        if (data.result.children[key].link != '') {
                                            for (var k in data.result.children[key].link) {
                                                str += '<img src="<?php echo REAL . '/uploads/workorder/' ?>' + data.result.children[key].link[k] + '">';
                                            }

                                        }
                                        str += '</div></div></div>';
                                    }
                                }
                            }
                            $('.det-com-box').append(str);
                            cancleRes();
                            $('.ord-search-box').hide();
                            $('.ord-table-box').hide();
                            $('.det-sec').show();
                        } else {
                            alert('提交失败');
                        }
                    }
                });

            });

            function getLocalTime(nS) {
                return new Date(parseInt(nS) * 1000).toLocaleString().replace(/年|月/g, "-").replace(/日/g, " ");
            }

            var orderState = {
                orderWait: function () {
                    $('.det-state-box').prop('class', 'det-state-box');
                    $('.det-state-box').addClass('det-state-pro-wait');
                    $('.det-state-title-text').text('待受理');
                    $('.det-des1-ope').hide().off();
                },
                orderReply: function () {
                    $('.det-state-box').prop('class', 'det-state-box');
                    $('.det-state-box').addClass('det-state-pro-resed');
                    $('.det-state-title-text').text('已答复');
                    $('.det-des1-ope').show().text('关闭工单').off().on('click', function () {
                        var id = $('.det-state-title-num').html();
                        url = '<?php echo U('user/user/closeorder') ?>';
                        $.ajax({
                            type: "POST",
                            url: url,
                            dataType: "json",
                            data: {
                                id: id,
                            },
                            success: function (data) {
                                if (data.code == '0') {
                                    orderState.orderClose();
                                    cancleRes();
                                    var tableRow = getTableRow(id);
                                    tableRow.attr('class', 'ord-table-closed');
                                    tableRow.find('.status').html('已关闭');
                                    alert('关闭成功');

                                } else {
                                    alert('关闭失败');
                                }
                            }
                        });
                    });
                },
                orderClose: function () {
                    $('.det-state-box').prop('class', 'det-state-box');
                    $('.det-state-box').addClass('det-state-pro-closed');
                    $('.det-state-title-text').text('已关闭');
//            $('.det-des1-ope').show().text('删除工单').off().on('click',function(){
//                 
//            });
                }
            }
            //orderState.orderReply();

            $('.doc-head-btn').on('click', function () {
                $('.doc-file').val('');
                $('.doc-file').one('change', function (e) {
                    var file = e.target.files[0];
                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    $(fileReader).on('load', function () {
                        $('.doc-img').attr('src', fileReader.result);
                    });

                    //此处有ajax上传
                });
                $('.doc-file').click();
            });
            //上传图片
            var resImgArr = [];
            $('.det-res-upload-btn').on('click', function () {
                if (resImgArr.length < 3) {
                    $('.det-res-file').val('');
                    $('.det-res-file').one('change', function (e) {
                        var file = e.target.files[0];
                        var fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        $(fileReader).on('load', function () {
                            resImgArr.push(fileReader.result);
                            //$('.det-res-show-unit:nth-child(1) > img').attr('src',fileReader.result);
                            for (var i = 0; i < resImgArr.length; i++) {
                                $('.det-res-show-unit:nth-child(' + (i + 1) + ')').addClass('det-res-show-unit-see').find('.det-res-show-img').attr('src', resImgArr[i]);
                            }
                        });
                    });
                    $('.det-res-file').click();
                }
            });
            //删除上传的图片
            $('.det-res-show-del').on('click', function () {
                var uniteSe = $(this).parents('.det-res-show-unit').prevAll('.det-res-show-unit-see').length;//显示的dom的次序
                resImgArr.splice(uniteSe, 1);
                $(this).parents('.det-res-show-unit').removeClass('det-res-show-unit-see');
            });
            //图片点击放大
            $('.det-com-box').on('click', '.det-com-img > img', function () {
                $('.order-alert-img-big').attr('src', $(this).attr('src'));
                $('body').css('overflow', 'hidden');
                $('#order-alert-img').modal({
                    backdrop: 'static',
                    show: true
                });
                var imgHeight = parseInt($('.order-alert-img-big').css('height').replace('px', ''));
                var conHeight = $(window).height() - $('.order-alert-img-top').outerHeight();
                var diffHeight = conHeight - imgHeight;
                var imgMarginTop = diffHeight > 0 ? (((diffHeight / 2) | 0) - 3) + 'px' : '0px';
                $('.order-alert-img-big').css('margin-top', imgMarginTop);
                $('.order-alert-img-big').css('display', 'block');
            });
            $('.order-alert-img-close').on('click', function () {
                $('body').css('overflow', 'visible');
            });
            //提交按钮的逻辑
            $('.det-res-submit').on('click', function () {
                var content = $('.det-res-input').val();
                var order_no = $('.det-state-title-num').html();
                //图片上传
                var img = new Array();
                $('.det-res-show-unit-see').each(function (i) {
                    img[i] = $(this).find('img').attr('src');
                });
                url = '<?php echo U('user/user/replyorder') ?>';
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
                        if (data.code == '0') {
                            $('.det-res-input').val('');
                            $('.det-res-show-unit-see').each(function (i) {
                                $(this).find('.det-res-show-del').click();
                            });
                            var name = '<?php if (isset(Yii::app()->session['user']['tel'])) {
    echo Yii::app()->session['user']['tel'];
} else {
    echo Yii::app()->session['user']['email'];
} ?>';
                            var str = '';
                            str += '<div class="det-com-body clearfix">';
<?php if (!empty(Yii::app()->session['user']['headimg'])): ?>
                                var headimg = '<?php echo Yii::app()->session['user']['headimg'] ?>';
                                str += '<div class="det-com-left"><img src="' + headimg + '" class="det-com-ava"></div><div class="det-com-right">';
<?php else: ?>
                                str += '<div class="det-com-left"><img src="<?php echo STATICS ?>images/det-ava.png" class="det-com-ava"></div><div class="det-com-right">';
<?php endif; ?>
                            str += ' <p class="det-com-name">' + name + '</p>';
                            str += '<p class="det-com-time">' + getLocalTime(data.result.addtime) + '</p>';
                            str += '<p class="det-com-text">' + data.result.content + '</p><div class="det-com-img clearfix">';
                            if (data.result.link != '') {
                                for (var k in data.result.link) {
                                    str += '<img src="<?php echo REAL . '/uploads/workorder/' ?>' + data.result.link[k] + '">';
                                }

                            }
                            str += '</div></div></div>';
                            $('.det-com-box').append(str);

                            alert('提交成功');

                        } else {
                            alert('提交失败');
                        }
                    }
                });
            });

            //返回列表
            $('.det-head-return').on('click', function () {
                $('.ord-search-box').show();
                $('.ord-table-box').show();
                $('.det-sec').hide();
            });

            //我的工单之新建工单的逻辑
            //选择工单类型的逻辑
            $('.new-type-box > div').on('click', function () {
                $('.new-type-box > div').removeClass('new-type-selected');
                $(this).addClass('new-type-selected');
            });
            //提交按钮的逻辑
            $('.new-input-submit').on('click', function () {
                var titleBlank = $('.new-title-input').val().length == 0;
                var desBlank = $('.new-des-input').val().length == 0;
                if (titleBlank) {
                    $('.new-textarea-title').addClass('new-textarea-fb-box');
                }
                if (desBlank) {
                    $('.new-textarea-des').addClass('new-textarea-fb-box');
                }
                if (!titleBlank && !desBlank) {
                    //可以提交
                    var title = $('.new-title-input').val();
                    var content = $('.new-des-input').val();
                    var key = $('.new-type-selected').find('.new-type-title').html();
                    var remind = $('.new-mes-selected').attr('replace');
                    //图片上传
                    var img = new Array();
                    $('.new-res-show-unit-see').each(function (i) {
                        img[i] = $(this).find('img').attr('src');
                    });

                    url = '<?php echo U('user/user/addworkorder') ?>';
                    $.ajax({
                        type: "POST",
                        url: url,
                        dataType: "json",
                        data: {
                            title: title,
                            content: content,
                            type: key,
                            remind: remind,
                            img: img
                        },
                        success: function (data) {
                            if (data.code == '0') {
                                alert('提交成功');
                                window.location.href = '<?php echo REAL . U('user/user/workorder') ?>';
                            } else {
                                alert(data.msg);
                            }
                        }
                    });
                }
            });

            $('.new-title-input,.new-des-input').on('focus', function () {
                $(this).parent('div').removeClass('new-textarea-fb-box');
            });

            //短信接收时间选择d
            $('.new-mes-btn-gr > button').on('click', function () {
                $('.new-mes-btn-gr > button').removeClass('new-mes-selected');
                $(this).addClass('new-mes-selected');
            });

            //上传图片的逻辑
            var newImgArr = [];
            $('.new-upload-btn').on('click', function () {
                if (newImgArr.length < 3) {
                    $('.new-upload-file').val('');
                    $('.new-upload-file').one('change', function (e) {
                        var file = e.target.files[0];
                        var fileReader = new FileReader();
                        fileReader.readAsDataURL(file);
                        $(fileReader).on('load', function () {
                            newImgArr.push(fileReader.result);
                            //$('.det-res-show-unit:nth-child(1) > img').attr('src',fileReader.result);
                            for (var i = 0; i < newImgArr.length; i++) {
                                $('.new-res-show-unit:nth-child(' + (i + 1) + ')').addClass('new-res-show-unit-see').find('.new-res-show-img').attr('src', newImgArr[i]);
                            }
                        });
                    });
                    $('.new-upload-file').click();
                }
            });
            //删除上传的图片
            $('.new-res-show-del').on('click', function () {
                var uniteSe = $(this).parents('.new-res-show-unit').prevAll('.new-res-show-unit-see').length;//显示的dom的次序
                newImgArr.splice(uniteSe, 1);
                $(this).parents('.new-res-show-unit').removeClass('new-res-show-unit-see');
            });


            //查询按钮
            $('.ord-search-btn').on('click', function () {
                var keyword = $('.ord-search-key-input').val();
                var start = $('#ord-search-start').val();
                var end = $('#ord-search-finish').val();
                var url = '<?php echo REAL . U('user/user/workorder') ?>' + '&keyword=' + keyword + '&start=' + start + '&end=' + end;

                window.location.href = url;
            })


            function cancleRes() {
                if ($('.det-state-box').hasClass('det-state-pro-closed')) {
                    $('.det-res-box').hide();
                } else {
                    $('.det-res-box').show();
                }
            }

            function getTableRow(number) {
                var num = String(number);
                for (var i = 0; i < $('.ord-table tbody tr').length; i++) {
                    if ($('.ord-table tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(1)').text() == num) {
                        return $('.ord-table tbody tr:nth-child(' + (i + 1) + ')');
                    }
                    ;
                }
                ;
            }

        })


    </script>
</body>