$(function() {

	//////////////////////////////////////////////
	//@syl
    var   message_type = '';
    var   message_status = '2';
    var   search_title = '';
    var   btn_type = 'send';
    var   mes_type = 1;
    var   save_btn = 'add';
    var   edit_selfid =0;
    var   is_send_id=false;
     //执行一次//
    datainit(1,message_type,message_status,search_title);
    function datainit(page ,message_type,message_status,search_title) {

        //初始化数据
        $.ajax({
            type: "POST",
            url: window_request_url.admin_mail_list,
            dataType: "json",
            data:{
                page:page,
                message_type: message_type,
                message_status:message_status,
				like :search_title,
            },
            success: function (data) {
                $('.table-bordered tr:gt(0)').remove();
                console.log(data);
                if (data.code == '0') {
                    var column_str = '';
                    for (var key in data.result.data.mail) {
                            column_str += '<tr data-selfid=' + data.result.data.mail[key]['id'] +  '>' +
                                '<td>' + (parseInt(key) + 1) + '</td>' +

                                '<td>' + (data.result.data.mail[key]['type'] == 1? '系统公告':'消息提醒') + '</td>' +
                                '<td>' + data.result.data.mail[key]['title'] + '</td>' ;
                            if (data.result.data.mail[key]['status'] == '2') {
                                column_str += '<td>' + getLocalTime(data.result.data.mail[key]['sendtime']) + '</td>'
                            }else{
                                column_str += '<td>' + getLocalTime(data.result.data.mail[key]['addtime'])+ '</td>'

                            }
                            column_str += '<td>全体用户</td>' + '<td>';
                            if (data.result.data.mail[key]['status'] == '2') {
                                column_str += '<button class="btn btn-info btn-detail">查看</button>' +
                                    ' <button class="btn btn-danger delete">删除</button>'
                            }else {
                                column_str += '<button class="btn btn-info btn-edit">编辑</button>' +
                                    ' <button class="btn btn-danger delete">删除</button>'
                            }

                            column_str += '</td>';
                            column_str += '</tr>'

                    }

                    $('.table-bordered').append(column_str);
                    //$('.current-nownum').html(data.result.c_count);
                  //  $('.pageend').attr('pageattr', data.result.pages);

                }}
            }
            )
        }

        //搜索按钮逻辑
        $('.search-btn').click(function(){
            //search_title = $('.search-input').val();
            datainit(1,message_type,message_status,$('.search-input').val());

        });

        //草稿箱列表逻辑
        $('.need-edit').click(function(){
            message_status = '1';
            datainit(1,message_type,message_status,search_title);
        });
      //已发送列表逻辑
        $('.sended').click(function(){
            message_status = '2';
            datainit(1,message_type,message_status,search_title);
        });
      //查看按钮逻辑
    $('.table-box .table-bordered').delegate('.btn-detail', 'click', function() {
        var pid=$(this).parent().parent().attr('data-selfid');
        if(pid){
            $.ajax({
                    type: "POST",
                    url: window_request_url.admin_mail_list,
                    dataType: "json",
                    data:{
                        mailid:pid
                    },
                    success: function (data) {
                        if (data.code == '0') {
                            console.log(data.result.data.mail.contents);
                            detail();
                            UE.getEditor('editor').setContent(data.result.data.mail.contents);
                            $('.ueditor-right').hide();
                        }
                    }
                   })
        }
        });

    //编辑按钮逻辑
    $('.table-box .table-bordered').delegate('.btn-edit', 'click', function() {
        is_send_id=true;
        btn_type = 'save';
        save_btn ='update';
        var pid=$(this).parent().parent().attr('data-selfid');
        edit_selfid =pid;
        if(pid){
            $.ajax({
                type: "POST",
                url: window_request_url.admin_mail_list,
                dataType: "json",
                data:{
                    mailid:pid
                },
                success: function (data) {
                    if (data.code == '0') {
                        $('.ueditor-title').val(data.result.data.mail.title);
                        detail();
                        UE.getEditor('editor').setContent(data.result.data.mail.contents);
                        $('.ueditor-right').show();
                    }
                }
            })
        }
    });

    //删除按钮逻辑
    $('.table-box .table-bordered').delegate('.delete', 'click', function() {
        var pid=$(this).parent().parent().attr('data-selfid');
        if(pid){
            $.ajax({
                type: "POST",
                url: window_request_url.admin_mail_delete,
                dataType: "json",
                data:{
                    id:pid
                },
                success: function (data) {
                    if (data.code == '0') {
                        datainit(1,message_type,message_status,search_title);
                    }
                }
            })
        }
    });

    //保存为草稿ueditor-right
    $('.ueditor-right .btn-default').click(function(){
        var pid=edit_selfid;
        btn_type = 'save';
        var mes_contents =  ue.getContent();
        var mes_title = $('.ueditor-title').val();
        if(save_btn =='add'){
            var now_url = window_request_url.admin_mail_add;
        }else {
            var now_url = window_request_url.admin_mail_update;
        }
        $.ajax({
            type: "POST",
            url: now_url,
            dataType: "json",
            data:{
                id:pid,
                btn_type:btn_type,
                title:mes_title,
                type:mes_type,
                content:mes_contents,

            },
            success: function (data) {
                if (data.code == '0') {

                    window.location.reload();
                }
            }
        })

    })

    //保存并发布逻辑
    $('.ueditor-right .btn-success').click(function(){
        if(is_send_id){
            $.ajax({
                type: "POST",
                url: window_request_url.admin_mail_draft,
                dataType: "json",
                data:{
                  id:edit_selfid,
                },
                success: function (data) {
                    if (data.code == '0') {

                        window.location.reload();
                    }
                }
            })
        }else {
            btn_type = 'send';
            var mes_contents =  ue.getContent();
            var mes_title = $('.ueditor-title').val();
            $.ajax({
                type: "POST",
                url: window_request_url.admin_mail_add,
                dataType: "json",
                data:{
                    btn_type:btn_type,
                    title:mes_title,
                    type:mes_type,
                    content:mes_contents,

                },
                success: function (data) {
                    if (data.code == '0') {

                        window.location.reload();
                    }
                }
            })
        }
    })


                    //////////////////////////////////////////////
	//选项卡切换
	commonTab($('.query-box'));

	//删除
	delTip($('.delete'),'删除消息','确定删除此条消息么？');


	//点保存按钮的时候 弹一下 保存成功tip
	//saveTip('保存成功');

	//编辑查看添加按钮点击
	$( '.add-message').on('click',function(){
        is_send_id=false;
        $('.ueditor-right').show();
		detail();
	});


//编辑查看弹框
    function detail(){
        $('.user-query,.detail-box').addClass('active');
        goBack();

    }
//返回上级切换
    function goBack(){
        $('.go-back').unbind();
        delTip($('.go-back'), '退出编辑', '确认退出编辑？未保存的修改将丢失。', function(){
            //刷新页面
            //刷新代码;
            $('.user-query,.detail-box').removeClass('active');
        });
    }



});





