/**
 * Created by syl on 2017/12/1.
 */

$(function () {
    //删除
    $('.table-box').delegate('.btn-del', 'click', function () {
        var account_id = $(this).parent().parent().attr('admin_id');
        $.ajax({
            type: "POST",
            url: window_request_url.admin_role_delete,
            dataType: "json",
            data: {
                role_id: account_id
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


    //点击保存按钮
    $('#leimu .btn-click').click(function () {

        var name = $('#leimu #inputEmail4').val();
        var piss_arr = [];
        $("#leimu table input:checked").each(function () {
            piss_arr.push($(this).val());
        });
        var musform = new FormData(document.getElementById("leimu"));
        musform.append('role_name', name);
        musform.append('role_permissions', JSON.stringify(piss_arr));
        $.ajax({
            url: window_request_url.admin_role_create,
            type: "post",
            data: musform,
            processData: false,
            contentType: false,
            success: function (data) {
                var obj = eval('(' + data + ')');
                if (obj.code == 0) {
                    datainit(1, self_status);
                    saveTip('创建成功');
                }
            },
            error: function (e) {
                alert("代码提交错误！！");
            }
        });

    });


    //点击编辑保存按钮
    $('#role_add .btn-click').click(function () {
        var name = $('#role_add #inputEmail3').val();
        var role_id = $('#role_add #inputEmail3').attr('rid');
        var piss_arr = [];
        $("#role_add  table input:checked").each(function () {
            piss_arr.push($(this).val());
        });
        var musform = new FormData(document.getElementById("leimu"));
        musform.append('role_name', name);
        musform.append('role_permissions', JSON.stringify(piss_arr));
        musform.append('role_id', role_id);
        $.ajax({
            url: window_request_url.admin_role_update,
            type: "post",
            data: musform,
            processData: false,
            contentType: false,
            success: function (data) {
                var obj = eval('(' + data + ')');
                if (obj.code == 0) {
                    datainit(1, self_status);
                    saveTip('修改成功');
                }
            },
            error: function (e) {
                alert("代码提交错误！！");
            }
        });

    });
    //显示模块
    $(".add-ok").click(function () {
        $("#leimu").modal({show: true});
        // $('#musform input').val('');
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
            url: window_request_url.admin_role_list,
            dataType: "json",
            data: {
                page: page,
                search_key: self_status.search_key,

            },
            success: function (data) {
                if (data.code == '0') {
                    var column_str = '';
                    var numkey = 0;
                    $('.table1 .table-bordered tr:gt(0)').remove();
                    for (var key in data.result.data) {
                        numkey++;
                        column_str += '<tr admin_id=' + data.result.data[key]['id'] + '><td>' + (parseInt(numkey)) + '</td>' +
                            '<td>' + data.result.data[key]['name'] + '</td>' +
                            '<td>' + getLocalTime(data.result.data[key]['addtime']) + '</td>' +
                            '<td>' + data.result.data[key]['permissions_main'].splice(0, 4) + '...' + '</td>' +
                            '<td>' +
                            '<button class="btn btn-info btndetail" > 详情</button>' +
                            ' <button class="btn btn-danger btn-del" >删除</button>';
                        column_str += '</td>'
                        column_str += '</tr>'
                    }
                    $('.table1 .table-bordered').append(column_str);
                    $('.total span').html(data.result.c_count);
                    //$('.pageend').attr('pageattr', data.result.pages);
                    //$('.pageend').attr('pageattr', data.result.pages);
                    // //执行分页
                    // ajaxPages(page,data);
                } else {
                    $('.isup').remove();
                    $('.table1 .table-bordered tr:gt(0)').remove();
                }
            }
        })
    }

    //  bindPagesEvent(datainit,self_status);
    //点击详情按钮
    $('.table-box').delegate('.btndetail', 'click', function () {
        var role_id = $(this).parent().parent().attr('admin_id');
        $.ajax({
            type: "POST",
            url: window_request_url.admin_role_list,
            dataType: "json",
            data: {
                role_id: role_id
            },
            success: function (data) {
                if (data.code == 0) {
                    $("#role_add").modal({show: true});
                    var main_key = '';
                    for (var key in data.result.data) {
                        main_key = data.result.data[key]['permissions_sign'];
                        $("#role_add #inputEmail3").val(key);
                        $("#role_add #inputEmail3").attr('rid', data.result.data[key]['id']);
                    }
                    for (var key in main_key) {
                        //获得权限的id遍历选中权限
                        for (var i = 0; i < $('#role_add table input').length; i++) {
                            if ($('#role_add table input').eq(i).val() == key) {
                                $('#role_add table input').eq(i).attr('checked', 'checked');
                            }
                        }
                    }

                } else {

                }
            }
        });
    });


});

