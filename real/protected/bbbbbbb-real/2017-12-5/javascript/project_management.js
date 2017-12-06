$(function(){
	//选择区域部分点击切换效果
	commonTab($('.query-box'));


	//项目状态的下拉框hack处理
	$('.select-val').html($('.project-status select').find('option:selected').text());
	$('.project-status select').change(function(){
		$('.select-val').html($(this).find('option:selected').text());
	})


	//点击屏蔽或解除按钮
	delTip($('.shield'),'屏蔽项目','确定屏蔽当前项目？');
	delTip($('.relieve'),'解除项目','确定解除当前项目？');
});