/**
 * Created by syl on 2017/11/30.
 */

$(function () {

    $('.table-box').delegate('.btn-del', 'click', function () {
        var account_id = $(this).parent().parent().attr('admin_id');
        $.ajax({
            type: "POST",
            url: window_request_url.admin_auth_delete,
            dataType: "json",
            data: {
                account_id: account_id
            },
            success: function (data) {
                if (data.code == 0) {
                    datainit(1, self_status);
                    saveTip('删除成功');
                } else {
                    saveTip('删除失败');
                }
            }
        });

    });

    $('.clear_input').click(function () {
        $('#musform input').val('');
    });
    //点击保存按钮
    $('.btn-click').click(function () {
        var cname = $('#musform input').eq(0).val();
        var pass = $('#musform input').eq(1).val();
        var department = $('#musform input').eq(2).val();
        var name = $('#musform input').eq(3).val();
        var role = $('#dropdownMenu1 span').eq(0).attr('role_id');
        $.ajax({
            url: window_request_url.admin_auth_creat,
            type: "post",
            data: {
                account: cname,
                password: pass,
                department: department,
                name: name,
                role_id: role,

            },
            // processData:false,
            // contentType:false,
            success: function (data) {
                var obj = eval('(' + data + ')');
                if (obj.code == 0) {
                    $('#musform input').val('');
                    datainit(1, self_status);
                    saveTip('创建成功');
                } else if (obj.code == '100444') {
                    saveTip('请完成添加');
                } else {
                    saveTip('创建失败');
                }
            },
            error: function (e) {
                alert("代码提交错误！！");
            }
        });
    });
    //显示模块
    $(".add-ok").click(function () {
        $("#type_button").modal({show: true});
    });
    //下拉框赋值
    $('.dropdown-menu').delegate('li', 'click', function () {
        $('#dropdownMenu1 span').eq(0).html($(this).text());
        $('#dropdownMenu1 span').eq(0).attr('role_id', $(this).attr('role_id'));
    });
    //点击搜索按钮
    $('.search-key').click(function () {
        self_status.search_key = $('.search-key-input').val();
        datainit(1, self_status);
    });

    //定义初始按钮状态
    var self_status = {
        search_key: ''
    };

    //初始化获得数据
    datainit(1, self_status);
    function datainit(page, self_status) {
        $('.total span').html(0);
        if (!page) page = 1;
        //初始化数据
        $.ajax({
            type: "POST",
            url: window_request_url.admin_auth_list,
            dataType: "json",
            data: {
                page: page,
                search_key: self_status.search_key,
            },
            success: function (data) {
                if (data.code == '0') {
                    var column_str = '';
                    $('.table-bordered tr:gt(0)').remove();
                    for (var key in data.result.data) {
                        column_str += '<tr admin_id=' + data.result.data[key]['id'] + '><td>' + (parseInt(key) + 1) + '</td>' +
                            '<td>' + data.result.data[key]['username'] + '</td>' +
                            '<td>' + data.result.data[key]['role_name'] + '</td>' +
                            '<td>' + data.result.data[key]['department'] + '</td>' +
                            '<td>' + data.result.data[key]['name'] + '</td>' +
                            '<td>' + getLocalTime(data.result.data[key]['addtime']) + '</td>' +
                            '<td>' +
                            '<button class="btn btn-info btn-del" >删除</button>';
                        column_str += '</td>'
                        column_str += '</tr>'
                    }
                    $('.table-bordered').append(column_str);
                    checkAuth();
                    $('.total span').html(data.result.c_count);
                    $('.pageend').attr('pageattr', data.result.pages);
                    //执行分页
                    ajaxPages(page, data);
                } else {
                    $('.isup').remove();
                    $('.table-bordered tr:gt(0)').remove();
                }
            }
        })
    }
    bindPagesEvent(datainit, self_status);
});

