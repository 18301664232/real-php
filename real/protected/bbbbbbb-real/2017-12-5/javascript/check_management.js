$(function(){
	//选择区域部分点击切换效果
	commonTab($('.query-box'));

	//点击备份的弹框
	// $('.btn-bak').each(function(){
	// 	simpleTip($(this), '备份成功');
	// });

	//点击通过按钮的处理
	// $('.relieve').each(function(){
	// 	simpleTip($(this), '审核通过');
	// });
	
	//点击屏蔽按钮的处理
	$('.table-box tr').each(function(){
		$(this).find('.shield').click(function(){

		})
	})
});

/**
 * [simpleTip description]
 * @param  {[type]} obj     [按钮]
 * @param  {[type]} content [弹框内容]
 * @return {[type]}         [none]
 */
function simpleTip(obj, content){
	obj.click(function(){
		saveTip(content)
	})
}