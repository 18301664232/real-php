//相关正则表达式
var logonPassWordReg = /^(?!(?:\d+|[a-zA-Z]+)$)[\da-zA-Z]{6,}$/;
//var logonPassWordReg = /^(\d|[A-z]){6,16}$/;
var logonEmailReg =  /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/;
var logonPhoneReg = /^1[3|4|5|7|8][0-9]{9}$/;

//验证密码的逻辑
function ValidatePasswordFormat(){
	if($('.logonUserPassWord > input').val() === ''){
		$('.logonUserPassWord > p').html('请输入密码');
		$('.logonUserPassWord').addClass('logonResponse');
	} else {
		if(!$('.logonUserPassWord > input').val().match(logonPassWordReg)){
			$('.logonUserPassWord > p').html('输入密码，6-16位数字、字母组合');
			$('.logonUserPassWord').addClass('logonResponse');
		}
	}
}

//封装的ajax
function xhr(o){
	var data = {
		url: "http://192.168.30.10/kuaih5/moneplus/index.php?",
		dataType: "json",
		type: "POST",
		crossDomain: true,
		xhrFields: {
			withCredentials: true
		},
		data: {
			antiCache: new Date().getTime()
		}
	};
	data.url += o.url;
	data.data = o.data;
	data.success = o.success;
	data.error = o.error;
	$.ajax(data);
};

//计时器相关逻辑
var count1;
var timer1;
var defaultCount1 = 60;//全局的默认时间
var checkdoor = true;
function regCountDown(btn,time){
	if(checkdoor){
		checkdoor = false;
		$(btn).attr('disabled','disabled');
		count1 = time || defaultCount1;
		$(btn).html(count1 + '秒');
		timer1 = setInterval(function(){
			count1--;
			$(btn).html(count1 + '秒');
			if(count1 === 0){
				checkdoor = true;
				$(btn).attr('disabled',null);
				clearInterval(timer1);
				$(btn).html('发送验证码');
				count1 = time || defaultCount1;
			}
		},1000);
	}
}

//input蓝色样式
$('.logonBaseSec > input').focus(function(){
	$(this).addClass('logonInputTip');
});
$('.logonBaseSec > input').blur(function(){
	$(this).removeClass('logonInputTip');
});

//手机号码+86的样式逻辑。同样在上传手机号码的时候，拼接字符串+86
$('.logonUserName > input').on('input',function(){
	if($(this).val().match(logonPhoneReg)){
		$('.logonUserName').append('<span>+86</span>');
		$('.logonUserName > input').css('text-indent','52px');
	} else {
		$('.logonUserName > span').remove();
		$('.logonUserName > input').css('text-indent','18px');
	}
})