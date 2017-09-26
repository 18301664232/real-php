$(function(){
	//第一次出现的逻辑
	
	function FirstShow(dom,height,cb){
		this.showDoor = true;
		this.dom = dom;
		this.height = height;
		this.cb = cb;
	}

	FirstShow.prototype.init = function(){
		var that = this;
		function ifShow(){
                    if(that.dom.length>0){
                        if(($(window).height()-(that.dom.offset().top - $(window).scrollTop())) > that.height){
				if(that.showDoor){
					that.showDoor = false;
					that.cb();
				};
			};
                    }
		}
		ifShow();
		$('.wrapper').scroll(ifShow);
	};

	//头部样式的逻辑
	// var delayTimer1
	// $('.headList > li > a,.headList > li > button').on('mouseenter',function(e){
	// 	clearTimeout(delayTimer1);
	// 	delayTimer1 = setTimeout(function(){
	// 		if((e.target.tagName).toLowerCase() === 'button'){
	// 			$(this).css({
	// 				'color':'#fff',
	// 				'background-color':'#2eafeb'
	// 			});
	// 		} else {
	// 			$(this).css('color','#2eafeb');
	// 		}
	// 	}.bind(this),300);
	// });
	// $('.headList > li > a,.headList > li > button').on('mouseleave',function(e){
	// 	clearTimeout(delayTimer1);
	// 	if((e.target.tagName).toLowerCase() === 'button'){
	// 		$(this).css({
	// 			'color':'#2eafeb',
	// 			'background-color':'#fff'
	// 		});
	// 	} else {
	// 		$(this).css('color','#858b99');
	// 	}
	// });

	//第二屏的逻辑
	var s2Options = {
	    bigDuration : 200,
	    initDuration : 100,
	    textDuration:300,
	    imgBig : {
	        width : 163,
	        height : 163,
	        left : 28,
	        top : 0,
	        opacity : 1
	    },
	    imgInit : {
	        width : 143,
	        height : 143,
	        left : 38,
	        top : 10,
	        opacity : 1
	    },
	    textInit:{
	    	opacity:1
	    }
	};

	function screemAnimation2(dom){
		dom.children().each(function(index){
			setTimeout(function(){

				$(this).find('img').stop().animate(s2Options.imgBig,s2Options.bigDuration,'',function(){
					$(this).stop().animate(s2Options.imgInit,s2Options.initDuration);
				});

				$(this).find('img').on('mouseenter',function(){
					$(this).stop().animate(s2Options.imgBig,s2Options.bigDuration);
				});

				$(this).find('img').on('mouseleave',function(){
					$(this).stop().animate(s2Options.imgInit,s2Options.initDuration);
				});


				$(this).find('p').stop().animate(s2Options.textInit,s2Options.textDuration);

			}.bind(this),150*index);
		});
	}

	var screem2 = new FirstShow($('.index-s2'),400,function(){
		screemAnimation2($('.index-s2-box'));
	});
	screem2.init();

	//第三屏的逻辑
	function screemAnimation3(){
		$('.index-s3-leftimg').animate({
			'right':-46,
			'opacity':1
		},1000,'',function(){
			$('.index-s3-leftalert,.index-s3-leftalert-shadow').fadeIn(500);
		});

		$('.index-s3-right').fadeIn(1500);
	}
	
	var screem3 = new FirstShow($('.index-s3'),250,function(){
		screemAnimation3();
	});
	screem3.init();

	//第四屏的逻辑
	function screemAnimation4(){
		$('.index-s4-rightimg').animate({
			'left':-168,
			'opacity':1
		},1000,'',function(){
			$('.index-s4-rightiphone').fadeIn(500);
		});

		$('.index-s4-left').fadeIn(1500);
	}

	var screem4 = new FirstShow($('.index-s4'),220,function(){
		screemAnimation4();
	});
	screem4.init();

	//第五屏的逻辑
	function screemAnimation5(){
		$('.index-s5-leftimg').animate({
			'right':-48,
			'opacity':1
		},1000);

		$('.index-s5-right').fadeIn(1000);
	}

	var screem5 = new FirstShow($('.index-s5'),220,function(){
		screemAnimation5();
	});
	screem5.init();

	//第六屏的逻辑
	$('.index-s6-showbase').on('mouseenter',function(){
		$(this).find('.index-s6-showmask').stop().fadeIn(300);
	});
	$('.index-s6-showbase').on('mouseleave',function(){
		$(this).find('.index-s6-showmask').stop().fadeOut(300);
	});

	$('.wrapper').scrollbar();
});