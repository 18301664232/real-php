/**
 * Created by syl on 2017/11/8.
 * 必须提供参数page，selfparams[]
 */

function ajaxPages(page,data) {
    //遍历出一共多少个按钮
    var btnstr = '';
    function addstr(page,i){
        if(i==page){
            btnstr+= '<li class="active isup"><a class="isa" href="javascript:void(0)">'+i+'</a></li>';
        }else{
            btnstr+= '<li class="isup"><a class="isa" href="javascript:void(0)">'+i+'</a></li>';
        }
    }

    if(data.result.pages<=7){
        for(var i=1;i<=data.result.pages;i++){
            addstr(page,i)
        }
    }else{
        if(page<=3){
            for(var i=1;i<=7;i++){
                addstr(page,i)
            }
        }else if(page>data.result.pages-3){
            for(var i=data.result.pages-6;i<=data.result.pages;i++){
                addstr(page,i)
            }
        }else {
            yop=parseInt(page)-3;
            end=parseInt(page)+3;
            for(var i=yop;i<=end;i++){
                addstr(page,i)
            }
        }
    }
    $('.isup').remove();
    $('.pagein').after(btnstr);


}

function bindPagesEvent(datainit,self_status) {

    //给按钮绑定事件
    $('.pagination').delegate('.isa', 'click', function() {
        $(this).parent().siblings('li').removeClass('active');
        datainit($(this).html(),self_status);
    });
    $('.pagein').click(function(){
        datainit(1,self_status);
    });
    $('.pageend').click(function(){
        datainit($(this).attr('pageattr'),self_status);
    });


}











