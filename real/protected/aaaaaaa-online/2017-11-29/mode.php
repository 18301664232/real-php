<div class="wrapper scrollbar-macosx">
	<!-- 头部 -->

	<div class='bm-pane1'>
		<div class='bm-pane1-inner clearfix'>
			<div class='bm-pane1-left'></div>
			<div class='bm-pane1-right'>
				<p class='bm-pane1-p1'>简单高效的计费模式</p>
				<p class='bm-pane1-p2'>摒弃分版本包月收费模式</p>
				<p class='bm-pane1-p3'>免费流量人人尽享，付费流量可随时开启/关闭</p>
                                <?php if(isset(Yii::app()->session['user'])):?>
				<a class='bm-pane1-btn' href='<?php echo U('finance/pay/select')?>'>立刻购买</a>
                                <?php else:?>
                                <a class='bm-pane1-btn' href='<?php echo U('user/login/login',array('token'=>'pay'))?>'>立刻购买</a>
                                <?php endif;?>
			</div>
		</div>
	</div>
	<div class='bm-pane2'>
		<div class='bm-pane2-inner'>
			<p class='bm-pane2-p'>流量对比</p>
			<div class='bn-pane2-show'></div>
		</div>
	</div>
	<!-- 底部 -->