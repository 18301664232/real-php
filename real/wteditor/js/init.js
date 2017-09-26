(function(){

	function canvasSupport() {
    	return !!document.createElement('canvas').getContext;
	}

	var lt10 = function(){
		var isIE = function(ver){
		    var b = document.createElement('b')
		    b.innerHTML = '<!--[if IE ' + ver + ']><i></i><![endif]-->'
		    return b.getElementsByTagName('i').length === 1
		}
		var isIE10 = (navigator.appVersion.indexOf("MSIE 10") !== -1);
		return (isIE(5) || isIE(6) || isIE(7) || isIE(8) || isIE(9) || isIE10)
	}

	if(lt10() || !canvasSupport()){
		location.href='http://test.realplus.cc/wteditor/prompt.html';
	}

	var tokenInit = (function(locHref){
		var token;
		if((locHref.split('?')[1].indexOf('#'))===-1){
			token = locHref.split('?')[1];
		} else {
			token = locHref.split('?')[1].substring(0,locHref.split('?')[1].indexOf('#'));
		}
		return token;
	})(location.href)

	var xhrInit = new XMLHttpRequest();
	xhrInit.open('POST','http://test.realplus.cc/?r=product/resources/index',true);
	xhrInit.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xhrInit.send(tokenInit);
	xhrInit.onreadystatechange = function(){
		if(xhrInit.readyState == 4 && xhrInit.status == 200){
			var result  = JSON.parse(xhrInit.responseText);
			if(result.code == 100008){
    			location.href='http://test.realplus.cc/?r=user/login/login';
			}
		}
	}
})()
