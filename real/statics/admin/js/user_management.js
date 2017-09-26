$(function() {
	//查询选项卡切换
	commonTab($('.query-box'));

	//解封和封停弹框
	delTip($('.on'),'解封账号','确定解封此用户么？');
	delTip($('.off'),'封停账号','确认封停此用户么？');

	//详情点击
	$('.btn-detail').on('click',function(){
		detail();
	})
});
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