//用到的一些变量

var wtToOfflineSelectedNum,wtToOnlineSelectedNum,wtToUpdateSelectedNum;//已选择的各种项目的数目


$('.rhHead').hover(function(){
	$('.rhHead > a').css('border','3px solid #ffffff');
	$('.rhHeadInfo').css('display','block');
},function(){
	$('.rhHead > a').css('border','3px solid #395999');
	$('.rhHeadInfo').css('display','none');
});

//2.正确与错误，两种反馈小滑块。改造了一个函数
var wtSlideBlockDoor = true;
	function wtSlideBlock(text,backgroundImgDoor){
		if(wtSlideBlockDoor){
							if(backgroundImgDoor){
					$('.wtSlideBlock').addClass('wtSlideBlockFalse');
				} else {
					$('.wtSlideBlock').removeClass('wtSlideBlockFalse');
				}
			$('.wtSlideBlock').html(text);
			$('.wtSlideBlock').css('left',((($(window).width() - $('.wtSlideBlock').width())/2)|0)+'px');
			wtSlideBlockDoor = false;
			$('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState1');
			setTimeout(function(){
				$('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState2');
				wtSlideBlockDoor = true;
			},1300);
		}
	}
	
//成功时的反馈小滑块
//wtSlideBlock('删除成功');
//失败时的反馈小滑块
//wtSlideBlock('删除成功',true);

//回到顶部的js
//需要显示的话，$('.rhToTop').show()。
$('.rhToTop').on('click',function(){
	$('body,html').scrollTop(0);
	//$(this).hide();
});

//一级菜单切换逻辑
$('.wtMyItem,.wtMyCollection,.wtMyPublic').on('click',function(){
	$(this).siblings('a').removeClass('wtMyItemChoosed');
	$(this).addClass('wtMyItemChoosed');
	$('.wtPro').css('display','none');
	if($(this).hasClass('wtMyItem')){
		$('.wtProPannal').css('display','block');
		
		$('.wtProItem').show();
	}
	if($(this).hasClass('wtMyCollection')){
		$('.wtColPannal').css('display','block');
	}
	if($(this).hasClass('wtMyPublic')){
		$('.wtPubPannal').css('display','block');
	}
})



//统计项目及确定按钮是否可以点击的函数
function certainBtnCanClick(selectedNum,dom){ 
	if(selectedNum > 0){
		dom.find('.wtProBtnListCertain').removeClass('wtProBtnListCertainDisabled');
		dom.find('.wtProBtnListCertain > button').prop('disabled',null);
	} else {
		dom.find('.wtProBtnListCertain').addClass('wtProBtnListCertainDisabled');
		dom.find('.wtProBtnListCertain > button').prop('disabled','disabled');
	}
}

//按钮交互的逻辑
$('.wtProBtnListAllOff > button,.wtProBtnListAllOn > button,.wtProBtnListAllUpdate > button').on('click',function(){

	if($(this).parent().hasClass('wtProBtnListAllOff')){
		if($(this).parent().hasClass('wtProBtnChoosed')){
			$(this).parent().removeClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').hide();
			$('.wtProBtnListCertain > button').hide();
			$('.wtProItemTagStateOn > .wtProItemChoose').css('display','none');
			noAll = true;
		} else {
			$(this).parent().addClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').show();
			$('.wtProBtnListCertain > button').show();
	 		$('.wtProItemTagStateOn > .wtProItemChoose').css('display','block');
	 		noAll = false;
		}
	}

	if($(this).parent().hasClass('wtProBtnListAllOn')){
		if($(this).parent().hasClass('wtProBtnChoosed')){
			$(this).parent().removeClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').hide();
			$('.wtProBtnListCertain > button').hide();
			$('.wtProItemTagStateOff > .wtProItemChoose').css('display','none');
			noAll = true;
		} else {
			$(this).parent().addClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').show();
			$('.wtProBtnListCertain > button').show();
	 		$('.wtProItemTagStateOff > .wtProItemChoose').css('display','block');
	 		noAll = false;
		}
	}

	if($(this).parent().hasClass('wtProBtnListAllUpdate')){
		if($(this).parent().hasClass('wtProBtnChoosed')){
			$(this).parent().removeClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').hide();
			$('.wtProBtnListCertain > button').hide();
			$('.wtProItemTagStateUpdate > .wtProItemChoose').css('display','none');
			noAll = true;
		} else {
			$(this).parent().addClass('wtProBtnChoosed');
			$('.wtProBtnListAllChoose > button').show();
			$('.wtProBtnListCertain > button').show();
	 		$('.wtProItemTagStateUpdate > .wtProItemChoose').css('display','block');
	 		noAll = false;
		}
	}

})

//全选按钮的逻辑

$('.wtProBtnListAllChoose > button').on('click',function(){
	if($('.wtProBtnListAllChoose').hasClass('wtProBtnChoosed')){
		$('.wtProBtnListAllChoose').removeClass('wtProBtnChoosed');
		$('.wtProItemChoose').removeClass('wtProItemChooseYes');
		$('.wtProBtnListAllChooseDot').css('display','none');
	} else {
		$('.wtProBtnListAllChoose').addClass('wtProBtnChoosed');
		$('.wtProItem:not(".wtProItemTagStateInit") > .wtProItemChoose').addClass('wtProItemChooseYes');
		$('.wtProBtnListAllChooseDot').css('display','block');
	}

//批量下线时的逻辑
	if($(this).parentsUntil('.wtProBtn','.wtProBtnList').hasClass('wtProMenuListOnlineBtnList')){
		wtToOfflineSelectedNum = $('.wtProItemTagStateOn > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToOfflineSelectedNum,$(this).parentsUntil('.wtProBtn','.wtProBtnList'));
	}
	//批量上线时的逻辑
	if($(this).parentsUntil('.wtProBtn','.wtProBtnList').hasClass('wtProMenuListOfflineBtnList')){
		wtToOnlineSelectedNum = $('.wtProItemTagStateOff > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToOnlineSelectedNum,$(this).parentsUntil('.wtProBtn','.wtProBtnList'));
	}
	//批量更新时的逻辑
	if($(this).parentsUntil('.wtProBtn','.wtProBtnList').hasClass('wtProMenuListUpdateBtnList')){
		wtToUpdateSelectedNum = $('.wtProItemTagStateUpdate > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToUpdateSelectedNum,$(this).parentsUntil('.wtProBtn','.wtProBtnList'));
	}

})




// 选择项目相关的js
$('.wtProItemBox').on('click','.wtProItemChoose',function(){
	if($(this).hasClass('wtProItemChooseYes')){
		$(this).removeClass('wtProItemChooseYes');
	} else {
		$(this).addClass('wtProItemChooseYes');
	}
	//批量下线时的逻辑
	if($(this).parent().hasClass('wtProItemTagStateOn')){
		wtToOfflineSelectedNum = $('.wtProItemTagStateOn > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToOfflineSelectedNum,$('.wtProMenuListOnlineBtnList'));
	}
	//批量上线时的逻辑
	if($(this).parent().hasClass('wtProItemTagStateOff')){
		wtToOnlineSelectedNum = $('.wtProItemTagStateOff > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToOnlineSelectedNum,$('.wtProMenuListOfflineBtnList'));
	}
	//批量更新时的逻辑
	if($(this).parent().hasClass('wtProItemTagStateUpdate')){
		wtToUpdateSelectedNum = $('.wtProItemTagStateUpdate > .wtProItemChooseYes').length;
		certainBtnCanClick(wtToUpdateSelectedNum,$('.wtProMenuListUpdateBtnList'));
	}

})

//遮盖层的js
var noAll = true;

$('.wtProItemBox').on('mouseenter','.wtProItem',function(){
	if(noAll){
		$(this).find('.wtProItemHover').css('display','block');
	}
})
$('.wtProItemBox').on('mouseleave','.wtProItem',function(){
	if(noAll){
		$(this).find('.wtProItemHover').css('display','none');
	}
})




//我的收藏面板的js
//项目蒙版的js
$('.wtColPannalBoxItem').on('mouseenter',function(){
	$(this).find('.wtColItemMask').show();
});

$('.wtColPannalBoxItem').on('mouseleave',function(){
	$(this).find('.wtColItemMask').hide();
});
//收藏按钮样式的js
$('.wtColItemMaskBtnCol').on('click',function(){
	if($(this).hasClass('wtColItemMaskBtnColDoor')){
		$(this).removeClass('wtColItemMaskBtnColDoor');
		wtSlideBlock('收藏成功');
	} else {
		$(this).addClass('wtColItemMaskBtnColDoor');
		wtSlideBlock('取消收藏');
	}
})

//我的发布面板的js
$('.wtPubPannalBoxItem').on('mouseenter',function(){
	$(this).find('.wtPubItemMask').show();
});

$('.wtPubPannalBoxItem').on('mouseleave',function(){
	$(this).find('.wtPubItemMask').hide();
});
//发布按钮样式的js
$('.wtPubItemMaskBtnCol').on('click',function(){
	if($(this).hasClass('wtPubItemMaskBtnColDoor')){
		$(this).removeClass('wtPubItemMaskBtnColDoor');
		wtSlideBlock('公开成功');
	} else {
		$(this).addClass('wtPubItemMaskBtnColDoor');
		wtSlideBlock('取消公开');
	}
});


// 我的收藏以及我的发布查看弹框的逻辑

$('.wtColItemMaskBtnLook').on('click',function(){
  $('#rhaLookUpAlert').modal({});
  var rhMarginTop = ($(window).height() - $('.rhViewModalContent').height()) ? ($(window).height() - $('.rhViewModalContent').height())/2 : 0;
  $('.rhViewModalDialog').css('marginTop',rhMarginTop + 'px');
});

$('.wtPubItemMaskBtnLook').on('click',function(){
  $('#rhaLookUpAlert').modal({});
  var rhMarginTop = ($(window).height() - $('.rhViewModalContent').height()) ? ($(window).height() - $('.rhViewModalContent').height())/2 : 0;
  $('.rhViewModalDialog').css('marginTop',rhMarginTop + 'px');
});



// 数据弹出框的js
// wtSlideBlock('保存成功');文档说明是将导出的excel表格保存之后。

	//数据时间选择按钮的逻辑
$('.rhDataConTabContentChannel > .rhDataConTabTimePannal > button').on('click',function(){
  $('.rhDataConTabContentChannel > .rhDataConTabTimePannal > button').removeClass('rhDataConTabTimeChoosed');
  $(this).addClass('rhDataConTabTimeChoosed');
})

$('.rhDataConTabContentPage > .rhDataConTabTimePannal > button').on('click',function(){
  $('.rhDataConTabContentPage > .rhDataConTabTimePannal > button').removeClass('rhDataConTabTimeChoosed');
  $(this).addClass('rhDataConTabTimeChoosed');
})

$('.rhDataConTabContentButton > .rhDataConTabTimePannal > button').on('click',function(){
  $('.rhDataConTabContentButton > .rhDataConTabTimePannal > button').removeClass('rhDataConTabTimeChoosed');
  $(this).addClass('rhDataConTabTimeChoosed');
})
$('.rhDataConTabContentInter > .rhDataConTabTimePannal > button').on('click',function(){
  $('.rhDataConTabContentInter > .rhDataConTabTimePannal > button').removeClass('rhDataConTabTimeChoosed');
  $(this).addClass('rhDataConTabTimeChoosed');
})



// 输入框获取与失去焦点的逻辑
$('.rhDataConTabTimeFrom').focus(function(){
	$(this).addClass('wtInputBorderResStyle');
});
$('.rhDataConTabTimeTo').focus(function(){
	$(this).addClass('wtInputBorderResStyle');
});
$('.rhDataConTabTimeFrom').blur(function(){
	$(this).removeClass('wtInputBorderResStyle');
});
$('.rhDataConTabTimeTo').blur(function(){
	$(this).removeClass('wtInputBorderResStyle');
});



//计时器相关逻辑
function RhaCountDown(btn){
	this.defaultCount = 60;
	this.checkDoor = true;
	this.btn = btn;
}
RhaCountDown.prototype.begin = function(time){
	if(this.checkDoor){
		this.checkDoor = false;
		this.count = time || this.defaultCount;
		$(this.btn).attr('disabled','disabled');
		$(this.btn).html(this.count + '秒');
		this.timer = setInterval(function(){
			--this.count;
			$(this.btn).html(this.count + '秒');
			if(this.count === 0){
				this.checkdoor = true;
				$(this.btn).attr('disabled',null);
				clearInterval(this.timer);
				$(this.btn).html('发送验证码');
				this.count = time = this.defaultCount;
			}
		}.bind(this),1000);
	}
}

//判断字符长度
    function strlen(str) {
        var len = 0;
        var strCode=0;
        var wordCode=0;
        for (var i = 0; i < str.length; i++) {
            var c = str.charCodeAt(i);
            //单字节加1
            //判断单行多行行高
            if ((c >= 0x0001 && c <= 0x007e) || (0xff60 <= c && c <= 0xff9f)) {
                len++;
                strCode++;
            }
            else {
                len++;
                wordCode++;
            }
            if ((wordCode*2 + strCode)> 26) {
                $('#L_fd_text p').css('line-height', '22px');
            }
            else {
                $('#L_fd_text p').css('line-height', '44px');
            }
        }

        return len;
    }
    function gbcount1(message, total, used) {
        var strlength = strlen(message.val());
        var max;
        var len = 0;
        max = total;
        if (strlength > max) {
            message.val(message.val().substring(0, max));
            if (used) {
                used.html(message.val().length + '/' + total)
            }
      
            alert("不能超过" + total + "个字!");
        }
        else {
            if (used) {
                used.html(message.val().length + '/' + total)
            }
            // remain.value = max - used.value;
        }
        $('#L_fd_text p').html(message.val())
        $('.Lwtl_fd h1').html(message.val())
    }
    function gbcount2(message,total,used)
    {
        var max;
        max = total;
        if (message.val().length > max) {
            message.val(message.val().substring(0,max)) ;

   
            alert("不能超过"+total+"个字!");
        }
        $('.Lwtl_fd p').html(message.val())
    }

/**
 * Created by lixiaoyong on 2017/3/14.
 */
/*
* 添加渠道
* */



//删除里的确定和取消

function notDel(obj){
    obj.siblings('.Lwtl_del_false').click(function(){
        $(this).parent().find('.Lwtl_TF').hide();
    })
}









// 创建项目的js逻辑
function gbcount(message,total,used)
    {
        var max;
        max = total;
        if (message.val().length > max) {
            message.val(message.val().substring(0,max)) ;
            if(used){
                used.html(message.val().length+'/'+total)
            }
            alert("不能超过"+total+"个字!");
        }
        else {
            if(used){
                used.html(message.val().length+'/'+total)
            }
            // remain.value = max - used.value;
        }
    }

$('.wtCreatePro').on('click',function(){
	 $('.Lwtl_xm_name').val('')
	$('#L_phone_yz_box5').modal({backdrop:'static',keyboard:false});
	var rhMarginTop = ($(window).height() >= 391) ? ($(window).height() - 391)/2 : 0;
  	$('.rhCreateItemModalDialog').css('marginTop',rhMarginTop + 'px');
});




  //验证码的按钮逻辑
$('.lpOffLineAlertVBtn').on('click',function(){
	var OfflineCountdown = new RhaCountDown(this);
	OfflineCountdown.begin();
	if($(this).hasClass('lpBaseBtnStyleState2')){
		$(this).removeClass('lpBaseBtnStyleState2');
	} else {
		$(this).addClass('lpBaseBtnStyleState2');
	}
});
 

// 输入框获取与失去焦点的逻辑
$('.lpOfflineInput1').focus(function(){
	$('.lpOfflineInput1Res').html('');
	$(this).addClass('wtInputBorderResStyle');
});
$('.lpOfflineInput2').focus(function(){
	$('.lpOfflineInput2Res').html('');
	$(this).addClass('wtInputBorderResStyle');
});
$('.lpOfflineInput1').blur(function(){
	$(this).removeClass('wtInputBorderResStyle');
});
$('.lpOfflineInput2').blur(function(){
	$(this).removeClass('wtInputBorderResStyle');
});


  //验证码的按钮逻辑
$('.lpManyOffLineAlertVBtn').on('click',function(){
	var OfflineCountdown = new RhaCountDown(this);
	OfflineCountdown.begin();
	if($(this).hasClass('lpBaseBtnStyleState2')){
		$(this).removeClass('lpBaseBtnStyleState2');
	} else {
		$(this).addClass('lpBaseBtnStyleState2');
	}
});
 

// 输入框获取与失去焦点的逻辑
$('.lpManyOfflineInput1').focus(function(){
	$('.lpManyOfflineInput1Res').html('');
	$(this).addClass('wtInputBorderResStyle');
});
$('.lpManyOfflineInput2').focus(function(){
	$('.lpManyOfflineInput2Res').html('');
	$(this).addClass('wtInputBorderResStyle');
});
$('.lpManyOfflineInput1').blur(function(){
	$('.lpManyOfflineInput1Res').html('');
	$(this).removeClass('wtInputBorderResStyle');
});
$('.lpManyOfflineInput2').blur(function(){
	$('.lpManyOfflineInput2Res').html('');
	$(this).removeClass('wtInputBorderResStyle');
});

//控制上线更新弹出框显示隐藏的函数
function alertShow(which){
	if(which === 'update'){
		$('.alert-online-text1').text('项目正在更新...');
		$('.alert-online-text2').text('更新文件生效时间大约为30分钟');
	} else {
		$('.alert-online-text1').text('上线准备中...');
		$('.alert-online-text2').text('正在配置合成效果，请稍后');
	}
        $('.alert-online-close').css('visibility','hidden');
	$('.alert-online-img').addClass('alert-online-img-animation');
	$('.alert-online-text1').css('margin-top','36px');
	$('#alert-online-load').modal({backdrop:'static',keyboard:false});
	var alertMarginTop = ($(window).height() > $('.alert-online-load-height').height()) ? ($(window).height() - $('.alert-online-load-height').height())/2 : 0;
	$('.alert-online-load-width').css('marginTop',alertMarginTop + 'px');
}

function alertHide(){
	$('#alert-online-load').modal('hide');
}

function alertSuccess(which){
        $('.alert-online-close').css('visibility','visible');
	$('.alert-online-img').removeClass('alert-online-img-animation');
	$('.alert-online-text1').css('margin-top','26px');
	if(which === 'update'){
		$('.alert-online-text1').text('项目更新成功');
		$('.alert-online-text2').text('更新文件生效时间大约为30分钟');
	} else {
		$('.alert-online-text1').text('上线成功');
		$('.alert-online-text2').text('效果配置完成');
	}
}
// 引导层js
var guideCenter = {
	init:function(){
		$('.wt-guide').addClass('wt-guide-show');
		$('html').css('height','100%');
		$('body').css('height','100%');
		$('body').css('overflow','hidden');
		guideCenter.step1();
		guideCenter.bindEvent();
	},
	step1:function(){
		guideCenter.zero();
		$('.wt-guide-right-top-left').removeClass('wt-guide-bc1').addClass('wt-guide-bc2');
		$('.guide-step1-box').show();
		$('.guide-step1-box-border').show();
		$('.guide-step1').show();
		$('.guide-step1-tri').show();
	},
	step2:function(){
		guideCenter.zero();
		$('.wt-guide-left-top-right').removeClass('wt-guide-bc1').addClass('wt-guide-bc2');
		$('.guide-step2-box').show();
		$('.guide-step2-box-border').show();
		$('.guide-step2').show();
		$('.guide-step2-tri').show();
	},
	step3:function(){
		guideCenter.zero();
		$('.wt-guide-left-top-right').removeClass('wt-guide-bc1').addClass('wt-guide-bc2');
		$('.guide-step3-box').show();
		$('.guide-step3-box-border').show();
		$('.guide-step3').show();
		$('.guide-step3-tri').show();
	},
	zero:function(){
		$('.guide-step-box').hide();
		$('.guide-step-box-border').hide();
		$('.wt-guide-left-top-right').removeClass('wt-guide-bc2').addClass('wt-guide-bc1');
		$('.wt-guide-right-top-left').removeClass('wt-guide-bc2').addClass('wt-guide-bc1');
		$('.guide-step').hide();
		$('.guide-step-tri').hide();
	},
	complete:function(){
		$('.wt-guide').removeClass('wt-guide-show');
		$('html').css('height','auto');
		$('body').css('height','auto');
		$('body').css('overflow','auto');
	},
	bindEvent:function(){
		$('.guide-step1-btn').on('click',function(){
			guideCenter.step2();
		});
		$('.guide-step2-btn-up').on('click',function(){
			guideCenter.step1();
		});
		$('.guide-step2-btn-down').on('click',function(){
			guideCenter.step3();
		});
		$('.guide-step3-btn-rea').on('click',function(){
			guideCenter.step1();
		});
		$('.guide-step3-btn-com').on('click',function(){
			guideCenter.complete();
		});
	}
}


function getCookie(c_name){ 
       var cookie = document.cookie; 
       if (cookie.length>0){ 
               c_start = cookie.indexOf(encodeURIComponent(c_name) + "="); 
               if (c_start!=-1){ 
                       c_start = c_start + c_name.length+1; 
                       c_end = cookie.indexOf(";",c_start); 
                       if (c_end==-1) c_end = cookie.length; 
                       return decodeURIComponent(cookie.substring(c_start,c_end)) 
           } 
         } 
       return "" 
} 
function setCookie(c_name,value,expiredays){ 
        var exdate = new Date() 
        exdate.setDate(exdate.getDate()+expiredays); 
        document.cookie = encodeURIComponent(c_name)+ "=" + encodeURIComponent(value)+ 
                ((expiredays==null) ? "" : ";expires="+exdate.toGMTString()); 
}


