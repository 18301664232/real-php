$(function() {
	//查询选项卡切换
	commonTab($('.query-box'));
	//解封和封停弹框
	delTip($('.on'),'解封账号','确定解封此用户么？');
	delTip($('.off'),'封停账号','确认封停此用户么？');


	//@syl后台逻辑
	//定义初始按钮状态
	var self_status={
		time_type:'total',
		user_type:'total',
        user_status:'',
        search_key:''
	};



    //导出数据
    $('.excel-ok').click(function(){

        window.location.href = window_request_url.admin_user_list+'&page=1&time_type='+self_status.time_type+'&user_type='+self_status.user_type+'& user_status_type='+self_status.user_status+'&search_key='+self_status.search_key+'&need_excel=true';

        datainit(1,self_status,'','','true');

    });

	//初始化获得数据
    datainit(1,self_status);
    function datainit(page,self_status,start_time,end_time,excel_ok) {
        excel_ok = excel_ok || '';
        $('.total span').html(0);
        if(!page)page=1;
        //初始化数据
        $.ajax({
            type: "POST",
            url: window_request_url.admin_user_list,
            dataType: "json",
            data:{
                page:page,
                time_type: self_status.time_type,
                user_type:self_status.user_type,
                user_status_type:self_status.user_status,
                search_key:self_status.search_key,
				start_time:start_time,
                end_time:end_time,
                need_excel:excel_ok,
            },
            success: function (data) {
                if (data.code == '0') {
                    var column_str = '';
                    $('.table-bordered tr:gt(0)').remove();
                    for (var key in data.result.data) {
                        column_str += '<tr data-reason=' + data.result.data[key]['reason'] +' data-selfid=' + data.result.data[key]['id'] + ' data-selfuid=' + data.result.data[key]['user_id'] + '>' +
                            '<td>' + (parseInt(key) + 1) + '</td>' ;
								if(data.result.data[key]['tel'] == null){
                                    column_str +=    '<td>' + (data.result.data[key]['email'])  + '</td>' ;
								}else {
                                    column_str +=   '<td>' + (data.result.data[key]['tel'])  + '</td>' ;
								}
                        column_str +=        '<td>' + data.result.data[key]['total_product'] + '</td>' +
                            '<td>' + getLocalTime(data.result.data[key]['addtime']) + '</td>' +
                            '<td>' + getLocalTime(data.result.data[key]['last_time']) + '</td>' +
                            '<td>' + data.result.data[key]['total_money'] + '</td>' +
                            '<td>' + data.result.data[key]['status'] + '</td>' +
                            '<td>' +
                            '<button class="btn btn-info btn-detail" >查看</button>' ;
                        if (data.result.data[key]['status'] == '已屏蔽') {
                            column_str += ' <button  class="btn btn-default btn-life" >解除</button>'
                        } else {
                            column_str += ' <button  class="btn btn-danger btn-off">封停</button>'
                        }
                        column_str += '</td>'
                        column_str += '</tr>'
                    }
                $('.table-bordered').append(column_str);
                $('.total span').html(data.result.c_count);
                $('.pageend').attr('pageattr', data.result.pages);
                //执行分页
                ajaxPages(page,data);
                }else {
                    $('.isup').remove();
                    $('.table-bordered tr:gt(0)').remove();
                }
            }})}
    		bindPagesEvent(datainit,self_status);


//提交按钮切换状态逻辑
	$('.clearfix-time li').click(function(){
		switch ($(this).index()){
			case 0:
                self_status.time_type = 'total';
				break;
            case 1:
                self_status.time_type = 1;
                break;
            case 2:
                self_status.time_type = 2;
                break;
            case 3:
                self_status.time_type = 7;
                break;
            case 4:
                self_status.time_type = 15;
                break;
            case 5:
                self_status.time_type = 30;
                break;

		}
        datainit(1,self_status);

	});
    $('.clearfix-user li').click(function(){
        switch ($(this).index()){
            case 0:
                self_status.user_type = 'total';
                break;
            case 1:
                self_status.user_type = 'register';
                break;
            case 2:
                self_status.user_type = 'login';
                break;
            case 3:
                self_status.user_type = 'issuance';
                break;
            case 4:
                self_status.user_type = 'pay';
                break;

        }
        datainit(1,self_status);

    });
    $('.clearfix-ststus li').click(function(){
        switch ($(this).index()) {
            case 0:
                self_status.user_status = '';
                break;
            case 1:
                self_status.user_status = 1;
                break;
            case 2:
                self_status.user_status = 2;
                break;
        }
        datainit(1,self_status);

    });

    //点击搜索按钮
	$('.search-key').click(function(){
        $('.query-box li').removeClass('active');
        $('.query-box li').eq(0).addClass('active');
        $('.query-box li').eq(6).addClass('active');
        $('.query-box li').eq(11).addClass('active');
        self_status.time_type = 'total';
        self_status.user_type = 'total';
        self_status.user_status = '';
        self_status.search_key = $('.search-key-input').val();
        datainit(1,self_status);


	});
    //自定义时间搜索按钮
    $('.date-search-btn').click(function(){
        $('.query-box li').removeClass('active');
        $('.query-box li').eq(0).addClass('active');
        $('.query-box li').eq(6).addClass('active');
        $('.query-box li').eq(11).addClass('active');
        self_status.time_type = 'self';
        self_status.user_type = 'total';
        self_status.user_status = '';
        self_status.search_key = '';
  		var start_time = $('.datePicker input').eq(0).val();
  		var end_time = $('.datePicker input').eq(1).val();
        datainit(1,self_status,start_time,end_time);

    });



    //详情点击
    // $('.btn-detail').on('click',function(){
    //     detail();
    // });

    //进入详情页
    $('.table-box').delegate('.btn-detail', 'click', function() {
        $('.detail-table table tr:gt(0)').remove();
    	var user_id =$(this).parent().parent().attr('data-selfuid');
        $.ajax({
            type: "POST",
            url: window_request_url.admin_user_detail,
            dataType: "json",
            data:{
            	user_id:user_id
            },
            success: function (data) {
                 if(data.code ==0){

					$('.project-info-box em').eq(0).text(data.result.data.user_product_pay);
					$('.project-info-box em').eq(1).text(data.result.data.user_product_notpay);
					$('.project-info-box em').eq(2).text(data.result.data.user_product_notonline);
					$('.user-info .user-name').text(data.result.data.user_base_data[0].nickname);
					$('.user-info .user-address span').eq(0).text(data.result.data.user_base_data[0].province);
					$('.user-info .user-address span').eq(0).text(data.result.data.user_base_data[0].city);
                     var column_str_detalil = '';
					//消费情况
                     for (var key in data.result.data.user_order_info) {
                         column_str_detalil += '<tr>' +
                             '<td>' + (parseInt(key) + 1) + '</td>' +
                             '<td>' +  data.result.data.user_order_info[key]['order_no'] + '</td>' +
                             '<td>' +  data.result.data.user_order_info[key]['detail'] + '</td>' +
                             '<td>' +  getLocalTime(data.result.data.user_order_info[key]['addtime']) + '</td>' +
                             '<td class="money">' +  data.result.data.user_order_info[key]['money'] + '</td>' ;
                         column_str_detalil += '</tr>'
                     }
                     if(column_str_detalil==''){
                         $('.order-record').removeClass('hidden');
                     }
                   $('.detail-table-box .table').append(column_str_detalil);

				 }
               }
		   });


        detail();
    });

    //封杀用户
    $('.table-box').delegate('.btn-off', 'click', function() {
        $('#flow_del_true').modal({show:true});
        $('#flow_del_true .modal-title').text('屏蔽用户');
        $('.flow-modal-name').html('确定要封停'+$(this).parent().parent().children().eq(1).text()+'?');
        var user_id =$(this).parent().parent().attr('data-selfuid');
        $('#flow_true_btn').attr('data-userid',user_id);
        $('#flow_true_btn').attr('data-type','kill');
       $('.self-reason').val('');

    });

    //解封用户
    $('.table-box').delegate('.btn-life', 'click', function() {
        $('#flow_del_true').modal({show:true});
        $('#flow_del_true .modal-title').text('解封用户');
        $('.flow-modal-name').html('确定要解封'+$(this).parent().parent().children().eq(1).text()+'?');
        var user_id =$(this).parent().parent().attr('data-selfuid');
        $('#flow_true_btn').attr('data-userid',user_id);
        $('#flow_true_btn').attr('data-type','life');
        $('.self-reason').val($(this).parent().parent().attr('data-reason'));

    });

    //执行解封或者封杀
	$('#flow_del_true .btn-danger').click(function () {

		if($('#flow_true_btn').attr('data-type')=='kill'){
            var request_url = window_request_url.admin_user_kill;
		}else {
            var request_url = window_request_url.admin_user_life;
		}
		var user_id =  $('#flow_true_btn').attr('data-userid');
        var reason = $('.self-reason').val();

        $.ajax({
            type: "POST",
            url: request_url,
            dataType: "json",
            data:{
                user_id:user_id,
                reason:reason
            },
            success: function (data) {
                if(data.code ==0){
                    //解封成功

                    saveTip('操作成功');
                    datainit(1,self_status);
                }else {
                    saveTip('操作失败');
                }
            }
        });
    })





//点击详情切换
    function detail(){
        $('.user-query,.detail-box').addClass('active');
        goBack();
    }
//返回上级切换
    function goBack(){
        $('.go-back').unbind();
        $('.go-back').click(function(e){
            $('.user-query,.detail-box').removeClass('active');
        })
    }







});
