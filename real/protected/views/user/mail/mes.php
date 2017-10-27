<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/message.css">


    <div class='mg_box'>
        <ul class='mg_nav clearfix'>
            <li class='mg_nav_btn1'>
                <a class='mg_nav_btn1_a'>消息中心</a>
            </li>
        </ul>
        <div class='mg_body'>
            <div class='mg_ope clearfix'>
                <p class='mg_tip'>您有<span class='mg_tip_num'>0</span>条未读消息</p>
                <button class='mg_del'>全部删除</button>
            </div>
<!--           邮件插入去 -->

        </div>
    </div>



    <!-- 全部删除弹出框 -->
    <div class="modal fade rhModel" id="alert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog alertWidth">
            <div class="modal-content alertHeight">
                <p class="alertHead clearfix">
                    <span class="alertHeadText">全部删除</span>
                    <button class="alertHeadClose" data-dismiss="modal"></button>
                </p>
                <div class="rhDataConAlertBody">
                    <p class="mg_alert_tip">是否删除所有消息？</p>
                    <button class="alertButton mg_del_ysa">确认</button>
                </div>
            </div>
        </div>
    </div>

    <div id="mg_laod_box"><img src="<?php echo STATICS ?>images/mg_loading.gif" /></div>
<script type="text/javascript" src="<?php echo STATICS ?>js/message.js"></script>

<script>
    $(function(){
        //初始化数据
        datainit();
        function datainit(){
            $.get(
                "<?php echo U('user/mail/list') ?>",
                {
                },
                function(data){
                   var obj = JSON.parse(data);
                    if(obj.code == 0){
                        var mail_str = '';
                        var mail_see=0;
                        for (var key in obj.result.MailInfo) {
                            if(obj.result.MailInfo[key].status==1){
                               mail_see++;
                            }
                              mail_str+="<div data-type="+obj.result.MailInfo[key].type+" sta="+obj.result.MailInfo[key].status+" mail-id="+obj.result.MailInfo[key].id+" class='mg_base clearfix'>"+
                            "<div class='mg_base_con'>"+
                                "<p class='mg_base_type'>"+obj.result.MailInfo[key].type+"<span class='mg_base_time'>"+obj.result.MailInfo[key].sendtime+"</span></p>"+
                                "<p class='mg_base_title'>"+obj.result.MailInfo[key].title+"</p>"+
                                "<div class='mg_base_text'>"+obj.result.MailInfo[key].contents+"</div>"+
                            '</div>'+
                            "<button class='mg_base_close'>"+
                                "<div class='mg_base_close_tri'></div>"+
                                "</button>"+
                                "<button class='mg_base_del'>"+
                                "<div class='mg_base_del_base mg_base_del_right'></div>"+
                                "<div class='mg_base_del_base mg_base_del_left'></div>"+
                                "</button>"+
                                "</div>";

                        }
                        $('.mg_tip_num').html(mail_see);
                        $('.mg_body').append(mail_str);

                        //遍历阅读状态
                        for (var key in $('.mg_base')) {
                           if($('.mg_base').eq(key).attr('sta')==2){
                               $('.mg_base').eq(key).addClass('mg_base_readed');
                           }
                            if($('.mg_base').eq(key).attr('data-type')=='系统公告'){
                                $('.mg_base').eq(key).addClass('mg_sys');
                            }else if($('.mg_base').eq(key).attr('data-type')=='消息提醒'){

                                $('.mg_base').eq(key).addClass('mg_not');
                            }

                        }

                    }else{

                    }
                }
            );
        }

        //删除全部邮件
        $('.mg_del_ysa').click(function(){
            $.post(
                "<?php echo U('user/mail/DelAll')?>",
                {
                },
                function(data){
                    var obj = JSON.parse(data);
                    if(obj.code == 0){
                    }else{
                        alert('删除失败');
                    }
                }
            )

        });

        //邮件更新
        $('.mg_body').on('click','.mg_base',function(e){

            e.stopPropagation();
            /////////////修改邮件阅读状态
            var now_mail_div=$(this);
            var mail_id=$(this).attr('mail-id');
            if(now_mail_div.attr('sta')==1) {
                $.post(
                    "<?php echo U('user/mail/StatusRevise')?>",
                    {
                        id: mail_id
                    },
                    function (data) {
                        var obj = JSON.parse(data);
                        if (obj.code == 0) {
                            if (now_mail_div.attr('sta') == 1) {
                                $('.mg_tip_num').html($('.mg_tip_num').html() - 1);
                            }

                        } else {

                        }
                    }
                );
            }
            if($(this).hasClass('mg_base_show')){
                $(this).removeClass('mg_base_show');
            } else {
                $(this).addClass('mg_base_show');
            }

            if(!$(this).hasClass('mg_base_readed')){
                $(this).addClass('mg_base_readed');
            }
            $(this).siblings().removeClass('mg_base_show');
        });
    //邮件的删除
        $('.mg_body').on('click','.mg_base_del',function(e){
            var now_mail_div=$(this).parent();
            var mail_id=$(this).parent().attr('mail-id');
            $.post(
                "<?php echo U('user/mail/UserMailDel')?>",
                {
                    id:mail_id
                },
                function(data){
                    var obj = JSON.parse(data);
                    if(obj.code == 0){
                        if(now_mail_div.attr('sta')==1) {
                            $('.mg_tip_num').html($('.mg_tip_num').html() - 1);
                        }
                        now_mail_div.remove();
                    }else{
                        alert('删除失败');
                    }
                }

            );
            e.stopPropagation();
        })


    })



</script>
