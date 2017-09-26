(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);throw new Error("Cannot find module '"+o+"'")}var f=n[o]={exports:{}};t[o][0].call(f.exports,function(e){var n=t[o][1][e];return s(n?n:e)},f,f.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.timeFormat = exports.cloudBtnEff = exports.addSource = undefined;

var _tool = require('./tool');

var _variable = require('./variable');

var _render = require('./render');

var _leftList = require('./left-list');

var _opeSwi = require('./ope-swi');

var _scrollbar = require('./scrollbar');

var leftExistArr = [];
var addBtnLoadDoor = true;
var continueLoadDoor = false;
var downLoadNum = 1;
var srcChooseArr = [];
var deleteFunArr = [];
var srcObj = {};
var srcUrl = 'http://test.realplus.cc/?r=product/resources/Getresources&';
var srcUrlFinal = (0, _tool.opeUrl)(srcUrl, location.href);
var srcDeleteUrl = 'http://test.realplus.cc/?r=product/resources/delresources&';
var deleteEndUrl = (0, _tool.opeUrl)(srcDeleteUrl, location.href);
function addSource() {
	openPane();
	downLoadControl(0, downLoadAjax);
	cloudBtn();
	chooseItem();
	chooseAll();
	closePane();
	refresh();
	deleteBtn();
	hoverPre();
	importSrc();
}

//开启导入素材页
function openPane() {
	$('.view-head-list-btn2-import').on('click', function () {
		cloudBtnEff(window.editor.cloudDoor);
		leftExistArr = [];
		for (var i = 0; i < $('.page-list-unit').length; i++) {
			var leftExistSrcName = $('.page-list-unit')[i].getAttribute('data-uid');
			leftExistArr.push(leftExistSrcName);
		}

		if (addBtnLoadDoor) {
			addBtnLoadDoor = false;
			ajaxHandleSrc();
		}

		$('.source').show();
		$('.source').animate({ top: '0' }, 100, function () {
			$('.source-head').css('position', 'fixed');
		});
		$('html,body').css('overflow', 'hidden');

		$('.source-all').removeClass('source-all-state-active');
		$('.source-import').removeClass('source-import-state-active');
		$('.source-import').html('导入素材');
		$('.source-import').prop('disabled', 'disabled');
		$('.source-item').removeClass('active');
	});
}

//导入素材按钮逻辑
function importSrc() {
	$('.source-import').on('click', function () {
		var haveOneNo = false;
		var haveOneYes = false;
		for (var i = 0; i < srcChooseArr.length; i++) {
			if (leftExistArr.indexOf(srcChooseArr[i]) === -1) {
				var needProSrc = srcObj[srcChooseArr[i]];
				RealEdit.List.addPage(needProSrc.initData);
				haveOneNo = true;
			} else {
				haveOneYes = true;
			}
		}

		$('.source-delete').removeClass('source-delete-state-active');
		srcChooseArr = [];
		$('.page-body-scroll-list').empty();
		var leftArr = RealEdit.List.getPages();
		(0, _render.renderLeft)(leftArr);

		if (window.editor.spacePageDoor) {
			window.editor.spacePageDoor = false;
			(0, _render.renderMiddle)(0);
			(0, _render.renderSwi)();
			RealEdit.Music.position = 'PfWzf6RdAJ';
			(0, _render.renderMusic)();
		}

		$('.cover-right').hide();

		$('.source').animate({ top: '100%' }, 100, function () {
			$('.source').hide();
			if (haveOneYes && haveOneNo) {
				(0, _tool.slideBlock)('导入成功');
				setTimeout(function () {
					(0, _tool.slideBlock)('重复素材未导入', false);
				}, 1650);
			} else if (haveOneNo) {
				(0, _tool.slideBlock)('导入成功');
			} else {
				(0, _tool.slideBlock)('重复素材未导入', false);
			}
		});
		$('.source-head').css('position', 'absolute');
		$('html,body').css('overflow', 'hidden');

		(0, _leftList.leftItemOrder)();
		(0, _scrollbar.newDomRefresh)();
		(0, _scrollbar.itemChange)();
		(0, _scrollbar.canScroll)();
		(0, _scrollbar.deleteItemBug)();
		(0, _scrollbar.rememberScrollBarPosition)();
		(0, _opeSwi.isForbidSwi)();
	});
}

//刷新按钮的逻辑
function refresh() {
	$('.source-refresh').on('click', function () {
		$(this).prop('disabled', 'disabled');
		$('.source-pane').empty();
		deleteFunArr = [];
		srcChooseArr = [];
		$('.source-all').removeClass('source-all-state-active');
		$('.source-import').removeClass('source-import-state-active');
		$('.source-import').html('导入素材');
		$('.source-import').prop('disabled', 'disabled');
		$('.source-item').removeClass('active');
		$('.source-delete').prop('disabled', 'disabled');
		$('.source-delete').removeClass('source-delete-state-active');
		downLoadNum = 1;
		ajaxHandleSrc();
		setTimeout(function () {
			$(this).prop('disabled', null);
		}.bind(this), 1000);
	});
}

//删除按钮的逻辑
function deleteBtn() {
	$('.source-delete').on('click', function () {
		$('.source-all').removeClass('source-all-state-active');
		$('.source-import').removeClass('source-import-state-active');
		$('.source-import').html('导入素材');
		$('.source-import').prop('disabled', 'disabled');
		$('.source-item').removeClass('active');
		$('.source-delete').prop('disabled', 'disabled');
		$('.source-delete').removeClass('source-delete-state-active');
		deleteFunArr = [];
		for (var i = 0; i < srcChooseArr.length; i++) {
			var imgPreview = srcObj[srcChooseArr[i]].imgPreview.replace('http://preview.realplus.cc/', '');
			imgPreview = imgPreview.substring(0, imgPreview.indexOf('?'));
			var htmlPreview = srcObj[srcChooseArr[i]].htmlPreview.replace('http://preview.realplus.cc/', '');
			htmlPreview = htmlPreview.substring(0, htmlPreview.indexOf('?'));
			var imgIcon = srcObj[srcChooseArr[i]].imgIcon.replace('http://preview.realplus.cc/', '');
			imgIcon = imgIcon.substring(0, imgIcon.indexOf('?'));
			var srcJson = srcObj[srcChooseArr[i]].json.replace('http://preview.realplus.cc/', '');

			deleteFunArr.push(imgPreview);
			deleteFunArr.push(htmlPreview);
			deleteFunArr.push(imgIcon);
			deleteFunArr.push(srcJson);

			$('.source-item[data-srcid=' + srcChooseArr[i] + ']').remove();
			$('.source-num').text('全部素材 (' + $('.source-item').length + ')');
		}

		$.ajax({
			url: deleteEndUrl,
			type: 'POST',
			data: {
				'param': deleteFunArr
			},
			success: function success(result) {
				console.log(result);
			},
			error: function error(_error) {
				console.log(_error);
			}
		});
	});
}

//关闭导入素材页
function closePane() {
	$('.source-cancel').on('click', function () {
		$('.source').animate({ top: '100%' }, 100, function () {
			$('.source').hide();
		});
		$('.source-head').css('position', 'absolute');
		$('html,body').css('overflow', 'hidden');
		$('.source-delete').removeClass('source-delete-state-active');
		srcChooseArr = [];
	});
}

//云端按钮
var cloudUrl = 'http://test.realplus.cc/?r=product/resources/cloud&';
var cloudUrlFinal = (0, _tool.opeUrl)(cloudUrl, location.href);
function cloudBtn() {
	$('.source-upload-bg').click(function () {
		var blockLeft = parseInt($('.source-upload-block').css('left'));
		var needDoor;
		if (blockLeft === 1) {
			needDoor = true;
		} else {
			needDoor = false;
		}
		cloudBtnEff(needDoor);

		if (window.editor.cloudDoor) {
			window.editor.cloudDoor = false;
		} else {
			window.editor.cloudDoor = true;
		}

		$.ajax({
			url: cloudUrlFinal,
			type: 'POST',
			success: function success(result) {
				console.log(result);
			},
			error: function error(_error2) {
				console.log(_error2);
			}
		});
	});
}

function cloudBtnEff(door) {
	if (door) {
		$('.source-upload-block').animate({ left: '23px' }, 100);
		$('.source-upload-bg').css({ background: '#4bc74e' });
	} else {
		$('.source-upload-block').animate({ left: '1px' }, 100);
		$('.source-upload-bg').css({ background: '#cacbcb' });
	}
}

//选择项目的逻辑
function chooseItem() {
	$('.source-pane').on('click', '.source-item', function () {
		var srcChooseId = $(this).attr('data-srcid');
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			srcChooseArr.splice(srcChooseArr.indexOf(srcChooseId), 1);
		} else {
			$(this).addClass('active');
			srcChooseArr.push(srcChooseId);
		}

		$('.source-import').html('导入素材(' + srcChooseArr.length + ')');
		if (srcChooseArr.length === 0) {
			$('.source-delete').prop('disabled', 'disabled');
			$('.source-delete').removeClass('source-delete-state-active');
			$('.source-import').removeClass('source-import-state-active');
			$('.source-import').prop('disabled', 'disabled');
		} else {
			$('.source-delete').prop('disabled', null);
			$('.source-delete').addClass('source-delete-state-active');
			$('.source-import').addClass('source-import-state-active');
			$('.source-import').prop('disabled', null);
		}

		if (srcChooseArr.length === $('.source-item').length) {
			$('.source-all').addClass('source-all-state-active');
		} else {
			$('.source-all').removeClass('source-all-state-active');
		}
	});
}

//全选按钮
function chooseAll() {
	$('.source-all').on('click', function () {
		srcChooseArr = [];
		if ($(this).hasClass('source-all-state-active')) {
			$(this).removeClass('source-all-state-active');
			$('.source-delete').prop('disabled', 'disabled');
			$('.source-delete').removeClass('source-delete-state-active');
			$('.source-import').removeClass('source-import-state-active');
			$('.source-import').prop('disabled', 'disabled');
			$('.source-item').removeClass('active');
		} else {
			$(this).addClass('source-all-state-active');
			$('.source-delete').prop('disabled', null);
			$('.source-delete').addClass('source-delete-state-active');
			$('.source-import').addClass('source-import-state-active');
			$('.source-import').prop('disabled', null);
			$('.source-item').addClass('active');
			$('.source-import').html('导入素材(' + srcChooseArr.length + ')');
			for (var i = 0; i < $('.source-item').length; i++) {
				var srcChooseId = $('.source-item')[i].getAttribute('data-srcid');
				srcChooseArr.push(srcChooseId);
			}
		}
		$('.source-import').html('导入素材(' + srcChooseArr.length + ')');
	});
}

//素材悬浮预览的逻辑

function hoverPre() {
	$('.source-pane').on('mouseenter', '.source-item-frame', function () {
		var htmlPreId = $(this).parent().attr('data-srcid');
		var htmlPreUrl = srcObj[htmlPreId].htmlPreview + _variable.htmlPreWidth;
		var srcPreItemFinal = _variable.srcPreItem.replace('$htmlpreview', htmlPreUrl);
		$(this).append(srcPreItemFinal);
		$(this).find('.source-item-frame-tag').on('load', function () {});
	});

	$('.source-pane').on('mouseleave', '.source-item-frame', function () {
		$(this).empty();
	});
};

//下拉加载
function downLoadControl(height, cb) {
	$('.source').scroll(function () {
		var wh = $(window).height();
		var dh = $('.source-body').outerHeight();
		var dlw = $('.source').scrollTop();
		var dlwl = dh - wh - dlw;
		var condition = height || 0;
		if (dlwl === condition) {
			cb();
		};
	});
}

function downLoadAjax() {
	downLoadNum++;
	if (continueLoadDoor) {
		ajaxHandleSrc('&page=' + downLoadNum);
	}
}

//接收与处理数据
function ajaxHandleSrc(page) {
	var page = page || '';
	var srcUrlFinal2 = srcUrlFinal + page;
	$.ajax({
		url: srcUrlFinal2,
		dataType: 'json',
		success: function success(result) {
			var resultArr = result.result;
			whenParse(resultArr, function () {
				parseJson(resultArr);
			});
		},
		error: function error(_error3) {
			console.log(_error3);
		}
	});
}

function whenParse(arr, cb) {
	if (arr !== '') {
		if (arr.length === 20) {
			continueLoadDoor = true;
		} else {
			continueLoadDoor = false;
		}
		cb();
	} else {
		continueLoadDoor = false;
	}
}
function parseJson(arr) {
	var srcArr = arr.reverse();
	$.ajaxSettings.async = false;
	for (var i = 0; i < srcArr.length; i++) {
		(function (e) {
			var srcItem = srcArr[e];
			var jsonUrl = _variable.jsonPre + srcItem.datas;
			$.getJSON(jsonUrl, function (data) {
				handleSrcObj(data, srcItem, jsonUrl);
				var endDate = timeFormat(srcItem.addtime);
				renderDom(data.jsData.id, endDate);
			});
		})(i);
	}
	$.ajaxSettings.async = true;
	$('.source-num').text('全部素材 (' + $('.source-item').length + ')');
}
function handleSrcObj(data, item, json) {
	srcObj[data.jsData.id] = {};
	srcObj[data.jsData.id].initData = data;
	srcObj[data.jsData.id].initData.jsData.videoPath = data.videoPath;
	srcObj[data.jsData.id].name = data.name;
	srcObj[data.jsData.id].imgPreview = _variable.jsonPre + data.img_preview + '?' + (0, _tool.timeStamp)();
	srcObj[data.jsData.id].imgIcon = _variable.jsonPre + data.img_icon + '?' + (0, _tool.timeStamp)();
	srcObj[data.jsData.id].htmlPreview = _variable.jsonPre + data.html_preview + '?' + (0, _tool.timeStamp)();
	srcObj[data.jsData.id].srcTime = item.addtime;
	srcObj[data.jsData.id].json = json;
}

function timeFormat(time) {
	var dateNow = new Date();
	var dateNowMill = dateNow.getTime() / 1000 | 0;
	var dateCheck = (dateNowMill - time) / (24 * 60 * 60) | 0;
	var dateImport = new Date(time * 1000);
	var endDate;
	if (dateCheck === 0 || dateCheck === 1) {
		var isToday = dateNow.getDate() === dateImport.getDate();
		if (isToday) {
			endDate = '今天';
		} else {
			endDate = '昨天';
		}
	} else {
		//endDate = dateImport.getFullYear() + '年' + (dateImport.getMonth()+1) + '月' + dateImport.getDate() + '日';
		endDate = dateImport.getMonth() + 1 + '月' + dateImport.getDate() + '日';
	}
	return endDate;
}
function renderDom(id, date) {
	var srcItemFinal = _variable.srcItem.replace(/\$srcname/g, srcObj[id].name).replace('$imgPreview', srcObj[id].imgPreview).replace('$srctime', date).replace(/\$srcid/g, id);
	$('.source-pane').append(srcItemFinal);
}
exports.addSource = addSource;
exports.cloudBtnEff = cloudBtnEff;
exports.timeFormat = timeFormat;
},{"./left-list":7,"./ope-swi":10,"./render":12,"./scrollbar":14,"./tool":15,"./variable":16}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
function blockInput(dom, time, timeMax, timeMin, timeGrade, cb) {
	if (time === undefined) {
		this.time = 0;
	} else {
		this.time = Number(time);
	}
	this.dom = dom;
	this.timeMax = Number(timeMax);
	this.timeMin = Number(timeMin);
	this.timeGrade = Number(timeGrade) * 10 | 0 || 1;
	this.cb = cb;
	this.changeTotle = 0;
	this.timeInputCheck = /(^\d+\.\d+|^\d+|^\-\d+\.\d+|^\-\d+)秒$/;
}

blockInput.prototype.init = function () {
	this.changeTotle = 0;
	this.currentBlockLeft = this.time;
	this.dom.find('.ope-base-time-block').css('left', (this.time * 10 - this.timeMin * 10) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 'px');
	this.dom.find('.ope-base-time-front').css('width', (this.time * 10 - this.timeMin * 10) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 7 + 'px');
	this.dom.find('.ope-base-time-input').val(this.time + '秒');

	this.dom.find('.ope-base-time-block').on('mousedown', function (e) {
		$('.ope-base-time-input').attr('disabled', 'disabled');
		this.currentBlockLeft = Number(this.dom.find('.ope-base-time-block').css('left').replace('px', ''));
		this.changeTotle = 0;
		this.twoPoint = e.pageX;
		$('body').addClass('user-select');
		this.dom.find('.ope-base-time-box').on('mousemove', this.changeStartMove.bind(this));
	}.bind(this));

	$(window).on('mouseup', function () {
		this.changeEndMove();
	}.bind(this));

	this.dom.find('.ope-base-time-input').on('focus', function () {
		var currentValue = this.dom.find('.ope-base-time-input').val();
		if (this.timeInputCheck.test(currentValue)) {
			this.currentRightValue = currentValue;
		}
	}.bind(this));

	this.dom.find('.ope-base-time-input').on('blur', function () {
		var currentValue = this.dom.find('.ope-base-time-input').val();
		if (this.timeInputCheck.test(currentValue)) {
			this.currentRightValue = currentValue;
			var inputValue = Math.round(Number(currentValue.replace('秒', '')) * 10);
			if (inputValue > this.timeMax * 10) {
				inputValue = this.timeMax * 10;
			}
			if (inputValue < this.timeMin * 10) {
				inputValue = this.timeMin * 10;
			}
			this.dom.find('.ope-base-time-block').css('left', (inputValue - this.timeMin) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 'px');
			this.dom.find('.ope-base-time-front').css('width', (inputValue - this.timeMin) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 7 + 'px');
			var inputValueFinal = (inputValue / this.timeGrade | 0) * this.timeGrade / 10;
			this.dom.find('.ope-base-time-input').val(inputValueFinal + '秒');
		} else {
			this.dom.find('.ope-base-time-input').val(this.currentRightValue);
		}
		this.cb();
	}.bind(this));

	this.dom.find('.ope-base-time-inc').on('click', function () {
		var inputValue = Number(this.dom.find('.ope-base-time-input').val().replace('秒', '')) * 10;
		inputValue = Math.round(inputValue);
		inputValue = (inputValue + this.timeGrade) / 10;
		if (inputValue < this.timeMin) {
			inputValue = this.timeMin;
		}
		if (inputValue > this.timeMax) {
			inputValue = this.timeMax;
		}
		this.dom.find('.ope-base-time-block').css('left', (inputValue - this.timeMin) / (this.timeMax - this.timeMin) * 130 + 'px');
		this.dom.find('.ope-base-time-front').css('width', (inputValue - this.timeMin) / (this.timeMax - this.timeMin) * 130 + 7 + 'px');
		this.dom.find('.ope-base-time-input').val(inputValue + '秒');
		this.cb();
	}.bind(this));

	this.dom.find('.ope-base-time-dec').on('click', function () {
		var inputValue = Number(this.dom.find('.ope-base-time-input').val().replace('秒', '')) * 10;
		inputValue = Math.round(inputValue);
		inputValue = (inputValue - this.timeGrade) / 10;
		if (inputValue < this.timeMin) {
			inputValue = this.timeMin;
		}
		if (inputValue > this.timeMax) {
			inputValue = this.timeMax;
		}
		this.dom.find('.ope-base-time-block').css('left', (inputValue - this.timeMin) / (this.timeMax - this.timeMin) * 130 + 'px');
		this.dom.find('.ope-base-time-front').css('width', (inputValue - this.timeMin) / (this.timeMax - this.timeMin) * 130 + 7 + 'px');
		this.dom.find('.ope-base-time-input').val(inputValue + '秒');
		this.cb();
	}.bind(this));
};
blockInput.prototype.changeStartMove = function (e) {
	this.onePoint = this.twoPoint;
	this.twoPoint = e.pageX;
	this.changeNumber = this.twoPoint - this.onePoint;
	this.changeTotle = this.changeTotle + this.changeNumber;
	var endLeft = this.currentBlockLeft + this.changeTotle;
	if (endLeft < 0) {
		endLeft = 0;
	}
	if (endLeft > 130) {
		endLeft = 130;
	}
	this.dom.find('.ope-base-time-block').css('left', endLeft + 'px');
	this.dom.find('.ope-base-time-front').css('width', endLeft + 7 + 'px');
	this.changeRatioEndValue = ((endLeft / 130 * (this.timeMax * 10 - this.timeMin * 10) | 0) / this.timeGrade | 0) * this.timeGrade / 10 + this.timeMin;
	if (this.changeRatioEndValue < this.timeMin) {
		this.changeRatioEndValue = this.timeMin;
	}
	this.dom.find('.ope-base-time-input').val(this.changeRatioEndValue + '秒');
	this.cb();
};
blockInput.prototype.changeEndMove = function (e) {
	$('body').removeClass('user-select');
	$('.ope-base-time-input').attr('disabled', null);
	this.dom.find('.ope-base-time-box').off();
};
blockInput.prototype.changeInit = function () {
	this.changeTotle = 0;
	this.currentBlockLeft = this.time;
	this.dom.find('.ope-base-time-block').css('left', (this.time * 10 - this.timeMin * 10) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 'px');
	this.dom.find('.ope-base-time-front').css('width', (this.time * 10 - this.timeMin * 10) / (this.timeMax * 10 - this.timeMin * 10) * 130 + 7 + 'px');
	this.dom.find('.ope-base-time-input').val(this.time + '秒');
};

exports.blockInput = blockInput;
},{}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.eleVideo = undefined;

var _opeEle = require('./ope-ele.js');

var eleVideo = {};

// eleVideo.slideDoor = false;  放到初始化函数里，解决初始化的问题。
//
// eleVideo.initPos = $('.v_slider').offset().left;
//
// eleVideo.dotArr = [];
//
// eleVideo.selectedDot = null;
//
// eleVideo.clickBlock = false;

eleVideo.run = function () {
    this.init();
    this.bindEvent();
};

eleVideo.init = function () {
    this.slideDoor = false;

    this.initPos = $('.v_slider').offset().left;

    this.dotArr = [];

    this.selectedDot = null;

    this.clickBlock = false;

    this.grooveWidth = $('.v_slider').width();
};

eleVideo.bindEvent = function () {
    var that = this;
    $('.v_block').on('mousedown', function () {
        //在滑块上按下鼠标时，可以执行滑动效果
        eleVideo.slideDoor = true;
        $('body').addClass('user-select');
        eleVideo.clickBlock = true;
        $('.v_tip_box').hide();
    });

    $(window).resize(function () {
        eleVideo.initPos = $('.v_slider').offset().left;
    });

    $(window).on('mouseup', function () {
        //松开鼠标按键，不执行滑动效果
        eleVideo.slideDoor = false;
        $('body').removeClass('user-select');
        eleVideo.clickBlock = false;
    });

    $('.v_slider').on('mousemove', function (e) {
        if (eleVideo.slideDoor) {
            var mousePos = e.clientX; //鼠标位置
            var blockPos = mousePos - 7; //滑块相对于视口位置
            var relPos = blockPos - eleVideo.initPos; //滑块相对于容器位置
            if (relPos > 228) {
                //相对于容器的位置需要过滤一下
                relPos = 228;
            }
            if (relPos < -7) {
                relPos = -7;
            }

            //eleVideo.setBlockPosition(relPos);
            //$('.v_block').css('left',relPos + 'px');//滑块相对于容器的位置
            //$('.v_front').css('width',relPos + 7 + 'px');//绿色长条条的宽度

            //联动其他区域
            var ratio = (mousePos - that.initPos) / that.grooveWidth;
            var sec = _opeEle.videoDuration * ratio | 0;
            eleVideo.setBlockPosition(relPos, sec);
            $('.ope-v-time-current').text((0, _opeEle.renderTime)(sec));
            (0, _opeEle.moveVideo)(sec);
        }
    });
    $('.v_slider').on('click', '.v_dot', function () {
        //获取选中的断点，滑块移动到选中的断点
        eleVideo.selectedDot = $(this);
        var pos = Number($(this).attr('data-pos'));
        var ratio = pos / that.grooveWidth;
        var sec = _opeEle.videoDuration * ratio | 0;
        eleVideo.setBlockPosition(pos - 7, sec);
    });

    $('.v_back,.v_front').on('click', function (e) {
        //点击轨道，让滑块移动到指定的点
        eleVideo.selectedDot = null;
        that.clickBlock = true;
        var mousePos = e.clientX;
        var blockPos = mousePos - 7;
        var relPos = blockPos - eleVideo.initPos;
        //eleVideo.setBlockPosition(relPos);
        var ratio = (mousePos - that.initPos) / that.grooveWidth;
        var sec = _opeEle.videoDuration * ratio | 0;
        eleVideo.setBlockPosition(relPos, sec);
        $('.ope-v-time-current').text((0, _opeEle.renderTime)(sec));
        (0, _opeEle.moveVideo)(sec);
    });

    $('.v_back,.v_front,.v_block').on('mousemove', function (e) {
        if (eleVideo.clickBlock) {
            //新学的
            return;
        }
        var mousePos = e.clientX;
        $('.v_tip_box').css('left', mousePos - 25 - eleVideo.initPos + 'px').show();
        var ratio = (mousePos - that.initPos) / that.grooveWidth;
        var sec = _opeEle.videoDuration * ratio | 0;
        $('.v_rect').text((0, _opeEle.renderTime)(sec));
    }).on('mouseleave', function () {
        $('.v_tip_box').hide();
    });
};

eleVideo.getMousePos = function () {
    return Number($('.v_block').css('left').replace('px', '')) + 7;
};

eleVideo.setBlockPosition = function (pos, sec) {
    //-7到228
    (0, _opeEle.renderLayer)(sec);
    $('.v_block').css('left', pos + 'px'); //滑块相对于容器的位置
    $('.v_front').css('width', pos + 7 + 'px'); //绿色长条条的宽度
};

eleVideo.addDot = function () {
    var have = false; //这个位置是否有短点的标志
    var mousePos = eleVideo.getMousePos();
    for (var i = 0; i < eleVideo.dotArr.length; i++) {
        if (eleVideo.dotArr[i] == mousePos) {
            have = true;
        }
    }
    if (!have) {
        //添加断点
        eleVideo.dotArr.push(mousePos);
        var node = $('<div class="v_dot" style="left:' + (mousePos - 4) + 'px" data-pos=' + mousePos + '></div>');
        $('.v_slider').append(node);
        // $('.v_slider').append('<div class="v_dot" style="left:' + (mousePos-4) + 'px" data-pos='+ mousePos+'></div>');
        eleVideo.selectedDot = node;
    }
};

eleVideo.addDotForRender = function (pos) {
    eleVideo.dotArr.push(pos);
    var node = $('<div class="v_dot" style="left:' + (pos - 4) + 'px" data-pos=' + pos + '></div>');
    $('.v_slider').append(node);
};

eleVideo.removeDot = function () {
    if (eleVideo.selectedDot) {
        eleVideo.selectedDot.remove();
        var pos = Number(eleVideo.selectedDot.attr('data-pos'));
        for (var i = 0, len = eleVideo.dotArr.length; i < len; i++) {
            if (eleVideo.dotArr[i] === pos) {
                eleVideo.dotArr.splice(i, 1);
            }
        }
    }
};

exports.eleVideo = eleVideo;

//-确定匹配指定值与对象数组是否匹配
//- 删除数组中指定项
//-添加到数组之前检查是否已经存在
//- 我在实践中，体会到了版本控制的需求。一个分支修改bug。另一个分支继续开发。
},{"./ope-ele.js":8}],4:[function(require,module,exports){
'use strict';

var _variable = require('./variable');

var _tool = require('./tool');

var _render = require('./render');

var _opeSwi = require('./ope-swi');

var _opeMusic = require('./ope-music');

var _opeEle = require('./ope-ele');

var _addSource = require('./add-source');

var _headBtn = require('./head-btn');

var _leftList = require('./left-list');

var _pageConfig = require('./page-config');

var _scrollbar = require('./scrollbar');

var _resize = require('./resize');

var _guide = require('./guide');

(0, _guide.guide)();
var thisToken = (0, _tool.getToken)(location.href);
var thisShortToken = (0, _tool.tokenToShort)(thisToken);
var initIndex = 0;
var initTotal = 2;
(0, _tool.canvasReady)();
RealEdit.init(undefined);
RealEdit.on(RealEdit.Event.LOAD_COMPLETE, onInitComplete);
RealEdit.load(thisShortToken);
mcjs.logic.ViewManager.on(mcjs.logic.ViewManager.VIEW_INIT, onInitComplete, undefined);
mcjs.RES.defaultPath = 'http://preview.realplus.cc/lib/res/config/default.json';
mcjs.Main.run(true);
function onInitComplete() {
    initIndex++;
    if (initIndex == initTotal) {
        initTotal = -9999;
        onLoadComplete();
    }
}

function onLoadComplete() {
    var leftArr = RealEdit.List.getPages();

    console.log(RealEdit.ProConfig.getProConfig());

    $('.view-head-list-id').html('项目ID: ' + RealEdit.PID);
    window.editor.cloudDoor = RealEdit.Cloud;
    if (leftArr.length !== 0) {
        (0, _render.render)(leftArr);
    } else {
        window.editor.spacePageDoor = true;
        (0, _render.canvansSize)();
        $('.cover-right').show();
        if (!window.editor.needGuide) {
            setTimeout(function () {
                $('.view-head-list-btn2-import').click();
            }, 1000);
        }
    }
    //先渲染，再操作
    (0, _pageConfig.configBtn)();
    (0, _addSource.addSource)();
    (0, _headBtn.headBtn)();
    (0, _leftList.leftOpe)();
    (0, _opeSwi.swiOpe)();
    (0, _opeMusic.musicOpe)();
    (0, _opeEle.eleOpe)();
    (0, _resize.resizeFun)();

    (0, _leftList.leftItemOrder)();
    (0, _scrollbar.newDomRefresh)();
    (0, _scrollbar.itemChange)();
    (0, _scrollbar.canScroll)();
    (0, _scrollbar.deleteItemBug)();
    (0, _scrollbar.rememberScrollBarPosition)();
    (0, _scrollbar.correctScrollBarPosition)();
    (0, _opeSwi.isForbidSwi)();
}
},{"./add-source":1,"./guide":5,"./head-btn":6,"./left-list":7,"./ope-ele":8,"./ope-music":9,"./ope-swi":10,"./page-config":11,"./render":12,"./resize":13,"./scrollbar":14,"./tool":15,"./variable":16}],5:[function(require,module,exports){
"use strict";

Object.defineProperty(exports, "__esModule", {
    value: true
});
function setCookie(name, value) {
    var Days = 10000;
    var exp = new Date();
    exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();
}

function getCookie(name) {
    var arr,
        reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)"); //正则匹配
    if (arr = document.cookie.match(reg)) {
        return unescape(arr[2]);
    } else {
        return null;
    }
}

function cookieGuide(name, cb) {
    if (!getCookie(name)) {
        setCookie(name, 1);
    } else {
        var getCookieNum = Number(getCookie(name));
        getCookieNum = getCookieNum + 1;
        setCookie(name, getCookieNum);
    }

    if (getCookie(name) == '1') {
        window.editor.needGuide = true;
        cb();
    }
}

function guide() {
    cookieGuide('userVisitNum', function () {
        guideCenter.init();
    });
    //guideCenter.init();
}

var guideCenter = {
    keyWidth: 0,
    init: function init() {
        $('.gui').addClass('gui-show');
        guideCenter.keyWidth = (($(window).height() - 36) * 0.82 * (640 / 1008) > 400 ? ($(window).height() - 36) * 0.82 * (640 / 1008) : 400) | 0;
        $('.gui-mid-top').css('min-width', guideCenter.keyWidth + 'px');
        guideCenter.step1();
        guideCenter.resize();
    },
    step1: function step1() {
        guideCenter.zero();
        $('.gui-lef-bot').addClass('gui-choose');
        $('.gui-step1').show();
        $('.gui-step1-tri').show();
    },
    step2: function step2() {
        //先设置隐藏dom的位置，再显示
        guideCenter.zero();
        if ($('.gui-mid-top').width() > guideCenter.keyWidth) {
            $('.gui-step2').css('left', ($(window).width() - $('.gui-step2').width()) / 2 + 'px');
            $('.gui-step2-tri').css('left', ($(window).width() - $('.gui-step2-tri').width()) / 2 + 'px');
        } else {
            $('.gui-step2').css('left', 210 + 'px');
            $('.gui-step2-tri').css('left', 210 + 202 + 'px');
        }
        $('.gui-mid-top').addClass('gui-choose');
        $('.gui-step2').show();
        $('.gui-step2-tri').show();
    },
    step3: function step3() {
        guideCenter.zero();
        $('.gui-mid-m-m').css('flex-basis', ($(window).height() - 36) * 0.82 + 'px');
        $('.gui-mid-m').css('flex-basis', ($(window).height() - 36) * 0.82 * (640 / 1008) + 'px');
        $('.gui-mid-top').css('min-width', guideCenter.keyWidth + 'px');
        $('.gui-mid-m-t').css('flex-basis', ($(window).height() - 36) * 0.09 + 'px');
        $('.gui-mid-m-m').addClass('gui-choose');
        $('.gui-step3').css('left', $('.gui-mid-m').offset().left + $('.gui-mid-m').width() + 12 + 30 + 'px');
        $('.gui-step3-tri').css('left', $('.gui-mid-m').offset().left + $('.gui-mid-m').width() + 30 + 'px');
        $('.gui-step3').css('top', '170px');
        $('.gui-step3-tri').css('top', '188px');
        $('.gui-step3').show();
        $('.gui-step3-tri').show();
    },
    step4: function step4() {
        guideCenter.zero();
        $('.gui-rig-bot').addClass('gui-choose');
        if ($('.gui-mid-top').width() > guideCenter.keyWidth) {
            $('.gui-step4').css('left', 'auto');
            $('.gui-step4-tri').css('left', 'auto');
        } else {
            $('.gui-step4').css('left', $('.gui-rig-bot').offset().left - 20 - 418 + 'px');
            $('.gui-step4-tri').css('left', $('.gui-rig-bot').offset().left - 8 - 12 + 'px');
        }
        $('.gui-step4').show();
        $('.gui-step4-tri').show();
    },
    zero: function zero() {
        $('.gui-step').hide();
        $('.gui-step-tri').hide();
        $('.gui-lef-top,.gui-lef-bot,.gui-mid-top,.gui-mid-m-m,.gui-rig-top,.gui-rig-bot').removeClass('gui-choose');
    },
    complete: function complete() {
        $('.gui').removeClass('gui-show');
        $('.gui-step').hide();
        $('.gui-step-tri').hide();
        window.editor.needGuide = false;
        setTimeout(function () {
            $('.view-head-list-btn2-import').click();
        }, 600);
    },
    resize: function resize() {
        $(window).resize(function () {
            guideCenter.keyWidth = (($(window).height() - 36) * 0.82 * (640 / 1008) > 400 ? ($(window).height() - 36) * 0.82 * (640 / 1008) : 400) | 0;
            if ($('.gui-mid-top').width() > guideCenter.keyWidth) {
                //第二步
                $('.gui-step2').css('left', ($(window).width() - $('.gui-step2').width()) / 2 + 'px');
                $('.gui-step2-tri').css('left', ($(window).width() - $('.gui-step2-tri').width()) / 2 + 'px');
                //第四步
                $('.gui-step4').css('left', 'auto');
                $('.gui-step4-tri').css('left', 'auto');
            } else {
                //第四步
                $('.gui-step4').css('left', $('.gui-rig-bot').offset().left - 20 - 418 + 'px');
                $('.gui-step4-tri').css('left', $('.gui-rig-bot').offset().left - 8 - 12 + 'px');
            }

            //第三步
            // $('.gui-mid-bot').css('height',(($(window).height()-36)*0.82+'px'));//这样写的话，步子大了会突然变的很大。只用resize + js
            // $('.gui-mid-bot').css('width',(($(window).height()-36)*0.82)*(640/1008) + 'px');
            // $('.gui-mid-bot').css('border-top',($(window).height()-36)*0.09+'px' + " solid black");
            // $('.gui-mid-bot').css('border-bottom',($('.gui-mid').height() - ($(window).height()-36)*0.82 - ($(window).height()-36)*0.09) +'px' + " solid black");
            // $('.gui-mid-bot').css('border-left',($('.gui-mid').width() - (($(window).height()-36)*0.82)*(640/1008))/2 +'px' + " solid black");
            // $('.gui-mid-bot').css('border-right',($('.gui-mid').width() - (($(window).height()-36)*0.82)*(640/1008))/2 +'px' + " solid black");

            $('.gui-mid-m-m').css('flex-basis', ($(window).height() - 36) * 0.82 + 'px');
            $('.gui-mid-m').css('flex-basis', ($(window).height() - 36) * 0.82 * (640 / 1008) + 'px');
            $('.gui-mid-top').css('min-width', guideCenter.keyWidth + 'px');
            $('.gui-mid-m-t').css('flex-basis', ($(window).height() - 36) * 0.09 + 'px');
            $('.gui-step3').css('left', $('.gui-mid-m').offset().left + $('.gui-mid-m').width() + 12 + 30 + 'px');
            $('.gui-step3-tri').css('left', $('.gui-mid-m').offset().left + $('.gui-mid-m').width() + 30 + 'px');
            $('.gui-step3').css('top', '170px');
            $('.gui-step3-tri').css('top', '188px');
        });
    }
};

$('.gui-step1-btn').on('click', function () {
    guideCenter.step2();
});
$('.gui-step2-btn-up').on('click', function () {
    guideCenter.step1();
});
$('.gui-step2-btn-down').on('click', function () {
    guideCenter.step3();
});
$('.gui-step3-btn-up').on('click', function () {
    guideCenter.step2();
});
$('.gui-step3-btn-down').on('click', function () {
    guideCenter.step4();
});
$('.gui-step4-btn-rea').on('click', function () {
    guideCenter.step1();
});
$('.gui-step4-btn-com').on('click', function () {
    guideCenter.complete();
});
exports.guide = guide;
},{}],6:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.headBtn = undefined;

var _tool = require('./tool');

var _variable = require('./variable');

var _pageConfig = require('./page-config');

if (document.domain == 'test.realplus.cc' || document.domain == 'www.realplus.cc') {
    //小测试环境使用
    document.domain = "realplus.cc";
}
// import {socketClient} from './socket';
// console.log(socketClient);

var thisToken = (0, _tool.getToken)(location.href);
var thisShortToken = (0, _tool.tokenToShort)(thisToken);
var canPreDoor = false;
var exitJumpDoor = false;
var previewUrl = 'http://test.realplus.cc/?r=product/product/sendmsg&';
var previewUrlFinal = (0, _tool.opeUrl)(previewUrl, location.href);
var preIframe;
var itemCover;
var endItemCover;
var coverUrl = 'http://test.realplus.cc/?r=product/resources/cover&';
var coverUrlFinal = (0, _tool.opeUrl)(coverUrl, location.href);
var socket = null;

function headBtn() {
    previewBtn();
    saveBtn();
    exitBtn();
}

function previewBtn() {
    $('.view-head-list-btn1-view').on('click', function () {
        canPreDoor = true;

        if (window.editor.enterConfigPage) {
            (0, _pageConfig.deleteChangeConfig)();
        }
        (0, _pageConfig.proConfigEnableChange)();
        RealEdit.save(thisShortToken);
        (0, _pageConfig.clearDeleteArr)();

        socket = io.connect('http://123.56.177.30:3080');
        socket.emit('join', {
            key: RealEdit.PID
        });
        socket.on('message', function (msg) {
            var result = msg.msg;
            var code = 1;
            if (result) {
                var code = result.code || 1;
            }
            if (code == 0) {
                var data = msg.msg.data;
                renderAlert(data);
                socket.disconnect();
            }
        });
    });

    $('.alert2-close').on('click', function () {
        $('.alert2-view-frame-box').empty();
        $('.alert2-qr-img').attr('src', '');
        $('#preview-alert').removeClass('alert2-online').removeClass('alert2-update').removeClass('alert2-offline');
        $('.alert2-btn-up').off();
        $('.alert2-btn-down').off();
    });
}

function saveBtn() {
    RealEdit.on(RealEdit.Event.SAVE_COMPLETE, onSaveComplete);
    $('.view-head-list-btn1-save').on('click', function () {
        if (RealEdit.isChange()) {
            if (window.editor.enterConfigPage) {
                (0, _pageConfig.deleteChangeConfig)();
            }
            (0, _pageConfig.proConfigEnableChange)();
            RealEdit.save(thisShortToken);
            (0, _pageConfig.clearDeleteArr)();
        } else {
            (0, _tool.slideBlock)('保存成功');
        }
    });
}

function canPre() {
    $('#preview-alert').modal({ backdrop: 'static', keyboard: false });
    $('.alert2-loading-box').show();
    var alertMarginTop = $(window).height() > $('.alert2-content').height() ? ($(window).height() - $('.alert2-content').height()) / 2 : 0;
    $('.alert2-dialog').css('marginTop', alertMarginTop + 'px');
    $.ajax({
        url: previewUrlFinal,
        type: 'POST',
        success: function success(result) {
            console.log(result);
            // var data = (JSON.parse(result)).result;
            // console.log(data);
            //renderAlert(data);
        },
        error: function error(_error) {
            console.log(_error);
        }
    });
}

function renderAlert(data) {
    console.log('=============预览数据==============');
    console.log(data);
    $('.alert2-view-text').html(data.title);
    switch (data.status) {
        case 'online':
            $('#preview-alert').addClass('alert2-online');
            $('.alert2-qr-img-official').attr('src', data.onlineimg);
            break;
        case 'update':
            $('#preview-alert').addClass('alert2-update');
            $('.alert2-qr-img-official').attr('src', data.onlineimg);
            $('.alert2-qr-img-test').attr('src', data.notonlineimg);
            break;
        default:
            $('#preview-alert').addClass('alert2-offline');
            $('.alert2-qr-img-test').attr('src', data.notonlineimg);
    }
    var previewHtmlUrl;
    //添加涂璇的方法
    if (data.status === 'online') {
        previewHtmlUrl = data.online;
    } else {
        previewHtmlUrl = data.notonline;
    }
    console.log(previewHtmlUrl);
    var previewIframeFinal = _variable.previewIframe.replace('$htmlpreview', previewHtmlUrl);
    $('.alert2-view-frame-box').append(previewIframeFinal);
    $('.alert2-view-frame-box').find('.alert2-view-iframe').on('load', function () {
        preIframe = document.querySelector('.alert2-view-iframe');
        $('.alert2-loading-box').hide();
    });
}

window.updatePageNum = function (current, total) {
    $('.alert2-view-frame-page').html(current + '/' + total);
};

window.previewInit = function (current, total) {
    $('.alert2-view-frame-page').html(current + '/' + total);
    $('.alert2-btn-up').on('click', function () {
        preIframe.contentWindow.mcjs.DOMInterface.prevView();
    });

    $('.alert2-btn-down').on('click', function () {
        preIframe.contentWindow.mcjs.DOMInterface.nextView();
    });
};

function onSaveComplete(e) {
    if (canPreDoor) {
        canPre();
    } else {
        (0, _tool.slideBlock)('保存成功');
    }
    canPreDoor = false;

    if (exitJumpDoor) {
        exitJumpDoor = false;
        location.href = 'http://test.realplus.cc/?r=product/product/index';
    }
}

function exitBtn() {
    $('.page-head-exit-click').on('click', function () {
        (0, _pageConfig.proConfigEnableChange)();
        if (!RealEdit.isChange()) {
            location.href = 'http://test.realplus.cc/?r=product/product/index';
        } else {
            $('#alert-exit').modal({ backdrop: 'static', keyboard: false });
            var alertMarginTop = $(window).height() >= $('.alert-exit-height').height() ? ($(window).height() - $('.alert-exit-height').height()) / 2 : 0;
            $('.alert-exit-width').css('marginTop', alertMarginTop + 'px');
        }
    });

    $('.alert-exit-body-btn-no').on('click', function () {
        $('#alert-exit').modal('hide');
        location.href = 'http://test.realplus.cc/?r=product/product/index';
    });

    $('.alert-exit-body-btn-yes').on('click', function () {
        $('#alert-exit').modal('hide');
        exitJumpDoor = true;
        if (window.editor.enterConfigPage) {
            (0, _pageConfig.deleteChangeConfig)();
        }
        RealEdit.save(thisShortToken);
        (0, _pageConfig.clearDeleteArr)();
    });
}

exports.headBtn = headBtn;
},{"./page-config":11,"./tool":15,"./variable":16}],7:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.leftItemOrder = exports.leftOpe = undefined;

var _scrollbar = require('./scrollbar');

var _render = require('./render');

var _opeSwi = require('./ope-swi');

var _opeEle = require('./ope-ele');

var leftItemIndex;
var choosedLeftItem = null;
var choosedLeftItemName = '';

function leftOpe() {
    itemChoose();
    leftItemExchange();
    deleteItem();
    deleteItemCertain();
    sortTable();
    (0, _scrollbar.scrollbar)();
    setCover();
}

function itemChoose() {
    $('.page-body-scroll-list').on('click', '.page-list-unit', function () {
        //选中样式
        if ($(this).hasClass('page-list-unit-state-folded')) {
            $('.page-body-scroll-list > li').removeClass('page-list-unit-state-folded-click');
            $(this).addClass('page-list-unit-state-folded-click');
        } else {
            $('.page-body-scroll-list > li').removeClass('page-list-unit-state-click');
            $(this).addClass('page-list-unit-state-click');
        }

        //元素界面归零
        (0, _opeEle.elementReturnZero)();
        //设为封面相关逻辑，初始化的时候可以加上
        window.editor.coverNeedIndex = Number($(this).find('.page-list-unit-num').text()) - 1;
        if ($(this).prop('data-coverflag')) {
            $('.view-cover').addClass('view-cover-state-click');
            window.editor.coverChangeDoor = false;
        } else {
            $('.view-cover').removeClass('view-cover-state-click');
            window.editor.coverChangeDoor = true;
        }

        var leftIndex = Number($(this).find('.page-list-unit-num').text()) - 1;

        (0, _render.renderMiddle)(leftIndex);
        (0, _render.renderSwi)();
        (0, _render.renderMusic)();
        (0, _opeSwi.isForbidSwi)();
        opeTabToSwi();
    });
}

function opeTabToSwi() {
    $('.ope-head li:nth-child(2) a').focus();
    $('.ope-head li:nth-child(2) a').tab('show');
}

function setCover() {
    //临时寄宿在这
    $('.view-cover').on('click', function () {
        if (window.editor.coverChangeDoor) {
            $(this).addClass('view-cover-state-click');
            window.editor.coverChangeDoor = false;
            RealEdit.List.setCover(window.editor.coverNeedIndex);
            $('.page-list-unit').prop('data-coverflag', null);
            if ($('.page-list-unit-state-click').length === 1) {
                $('.page-list-unit-state-click').prop('data-coverflag', 'applyflag');
            }
            if ($('.page-list-unit-state-folded-click').length === 1) {
                $('.page-list-unit-state-folded-click').prop('data-coverflag', 'applyflag');
            }
        }
    });
}

function leftItemExchange() {
    $('.page-body-top-exchange').on('click', function () {
        if ($(this).hasClass('page-body-top-exchange-state-folded')) {
            $(this).removeClass('page-body-top-exchange-state-folded');
            $('.page-list-unit').removeClass('page-list-unit-state-folded');
            $('.page-list-unit.page-list-unit-state-folded-click').addClass('page-list-unit-state-click').removeClass('page-list-unit-state-folded-click');
        } else {
            $(this).addClass('page-body-top-exchange-state-folded');
            $('.page-list-unit').addClass('page-list-unit-state-folded');
            $('.page-list-unit.page-list-unit-state-click').addClass('page-list-unit-state-folded-click').removeClass('page-list-unit-state-click');
        }

        (0, _scrollbar.canScroll)();
        $('.page-body-scroll-bar').css('top', '0px');
    });
}

function deleteItem() {
    $('.page-body-scroll-list').on('click', '.page-list-btn-delete', function (e) {
        e.stopPropagation();
        leftItemIndex = $(this).parents('.page-list-unit').find('.page-list-unit-num').text();
        choosedLeftItemName = $(this).parents('.page-list-unit').find('.page-list-unit-show-name').text();
        $('.alert-del-body-text').html(choosedLeftItemName);
        $('#alert-del').modal({ backdrop: 'static', keyboard: false });
        var alertMarginTop = $(window).height() >= $('.alert-del-height').height() ? ($(window).height() - $('.alert-del-height').height()) / 2 : 0;
        $('.alert-del-width').css('marginTop', alertMarginTop + 'px');
        choosedLeftItem = $(this).parentsUntil('.wePageList', '.page-list-unit');
    });
}

function deleteItemCertain() {
    $('.alert-del-body-btn').on('click', function () {
        $('#alert-del').modal('hide');
        var firstItemMargin = $('.page-list-unit:first-of-type').css('marginTop');
        RealEdit.List.removePageAt(leftItemIndex - 1);
        if (choosedLeftItem.prop('data-coverflag')) {
            $('.view-cover').removeClass('view-cover-state-click');
        }
        choosedLeftItem.remove();
        $('.page-list-unit:first-of-type').css('marginTop', firstItemMargin);
        leftItemOrder();
        (0, _scrollbar.newDomRefresh)();
        (0, _scrollbar.itemChange)();
        (0, _scrollbar.canScroll)();
        (0, _scrollbar.deleteItemBug)();
        (0, _scrollbar.rememberScrollBarPosition)();
        if ($('.page-list-unit').length === 0) {
            mcjs.Edit.clearStage();
            window.editor.spacePageDoor = true;
            (0, _render.renderZero)();
            $('.cover-right').show();
        } else {
            if ($('.page-list-unit-state-folded').length === 0) {
                if ($('.page-list-unit-state-click').length === 0) {
                    $('.page-list-unit:first').addClass('page-list-unit-state-click');
                    var leftIndex1 = $('.page-list-unit:first').find('.page-list-unit-num').text() - 1;
                    (0, _render.renderMiddle)(0);
                    (0, _render.renderSwi)();
                    (0, _render.renderMusic)();
                };
            } else {
                if ($('.page-list-unit-state-folded-click').length === 0) {
                    $('.page-list-unit:first').addClass('page-list-unit-state-folded-click');
                    var leftIndex2 = $('.page-list-unit:first').find('.page-list-unit-num').text() - 1;
                    (0, _render.renderMiddle)(0);
                    (0, _render.renderSwi)();
                    (0, _render.renderMusic)();
                }
            };
        }
        (0, _opeSwi.isForbidSwi)();
    });
}

function sortTable() {
    var firstItemMarginTop;
    $(".page-body-scroll-list").sortable({
        scroll: true,
        scrollSensitivity: 120,
        scrollSpeed: 50,
        tolerance: "pointer",
        axis: 'y',
        start: function start(event, ui) {
            firstItemMarginTop = $('.page-list-unit:first').css('marginTop');
        },
        update: function update(event, ui) {
            var beforeIndex = ui.item.find('.page-list-unit-num').text() - 1;
            leftItemOrder();
            var afterIndex = ui.item.find('.page-list-unit-num').text() - 1;
            RealEdit.List.setPageIndex(beforeIndex, afterIndex);
            $('.page-list-unit:gt(0)').css('marginTop', '0px');
            $('.page-list-unit:first').css('marginTop', firstItemMarginTop);
            (0, _render.renderSwiNum)();
            (0, _opeSwi.isForbidSwi)();
        }
    });
};

function leftItemOrder() {
    $('.page-body-top-num').html('(' + $('.page-body-scroll-list > .page-list-unit').length + ')');
    for (var i = 0; i < $('.page-body-scroll-list > .page-list-unit').length; i++) {
        $(document.querySelectorAll('.page-list-unit-num')[i]).html(i + 1);
    };
};

exports.leftOpe = leftOpe;
exports.leftItemOrder = leftItemOrder;
},{"./ope-ele":8,"./ope-swi":10,"./render":12,"./scrollbar":14}],8:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.renderLayer = exports.moveVideo = exports.renderTime = exports.videoDuration = exports.elementReturnZero = exports.eleOpe = undefined;

var _variable = require('./variable');

var _ele_video = require('./ele_video');

var _blockInput = require('./block-input');

var _tool = require('./tool');

var videoBlock = null; //import {renderDrop} from './render';

var btnOpeData = [{ txt: '拨打电话', uid: 'phone' }, { txt: '跳转网页', uid: 'turnweb' }, { txt: '跳转页面', uid: 'turnpage' }, { txt: '提交信息', uid: 'subinfo' }, { txt: '跳转分享页', uid: 'sharelayer' }, { txt: '续播视频', uid: 'continueplay' }, { txt: '显示浮层', uid: 'showmask' }];

function eleOpe() {
    RealEdit.on(RealEdit.Event.SET_ELEMENT, function () {
        var ele = RealEdit.List.getPage().element;
        renderPane(ele);
        opeTabToCom();
    });

    opePane();
}

//将右侧tab切换切换到组件列表
function opeTabToCom() {
    $('.ope-head a:first').focus();
    $('.ope-head a:first').tab('show');
}

function opePane() {
    opeButton();
    opeInput();
    opeCombobox();
    opeVideo();
    //opeSingleSelection();
    //opeMultipleSelection();
}

function opeButton() {
    //渲染触发动作列表
    for (var i = 0; i < btnOpeData.length; i++) {
        $('.ope-body-ele-move-list').append(_variable.eleOpeTriOption.replace('$uid', btnOpeData[i].uid).replace('$txt', btnOpeData[i].txt));
    };

    //触发动作列表选择
    $('.ope-body-ele-move-list > li').on('click', function () {
        $('.ope-body-ele-move-btn-click-text').text($(this).text());
        RealEdit.Element.setBtnTriAction($(this).text());
        RealEdit.Element.setBtnTriContent('');

        RealEdit.Element.setInputBindBtn(); //改变input组件绑定的按钮组

        $('.ope-body-ele-addr-val').val('');
        $('.ope-body-ele-phone-val').val('');
        matchCon($(this).text());
    });

    //触发方式按钮点击
    // $('.ope-body-ele-type-btn-group > button').on('click',function(){
    //     $('.ope-body-ele-type-btn-group > button').removeClass('ope-base-btn3-click');
    //     $(this).addClass('ope-base-btn3-click');
    //     RealEdit.Element.setBtnTriEvent($(this).text());
    // });

    opeContent();
}

// 看来初始化一个按钮很必要
//根据下拉列表的不同匹配相应的内容
function matchCon(txt) {
    $('.ope-body-ele-button-sec-init').hide();
    switch (txt) {
        case '拨打电话':
            $('.ope-body-ele-button-sec-phone').show();
            break;
        case '跳转网页':
            $('.ope-body-ele-button-sec-addr').show();
            break;
        case '跳转页面':
            $('.ope-body-ele-button-sec-page').show();
            var pageNum = RealEdit.List.totlaPageNum();
            RealEdit.Element.setBtnTriContent('1');
            $('.ope-body-ele-page-btn-click-text').text('1');
            $('.ope-body-ele-page-list').empty();
            for (var i = 0; i < pageNum; i++) {
                $('.ope-body-ele-page-list').append('<li><a>' + (i + 1) + '<a/></li>');
            }
            break;
    }
}

function opeContent() {

    $('.ope-body-ele-phone-val').on('input', function () {
        RealEdit.Element.setBtnTriContent($(this).val());
    });

    $('.ope-body-ele-addr-val').on('input', function () {
        RealEdit.Element.setBtnTriContent($(this).val());
    });

    $('.ope-body-ele-page-list').on('click', 'li', function () {
        $('.ope-body-ele-page-btn-click-text').text($(this).find('a').text());
        RealEdit.Element.setBtnTriContent($(this).find('a').text());
    });
}

//点击按钮时渲染DOM
function renderPane(btnInfo) {

    $('.ope-body-ele-title-down').show();

    elementReturnZero();

    var currentType = btnInfo.currentType;
    $('.ope-body-ele-type-text').text(currentType);
    // var currentID = btnInfo[currentType].current;
    // $('.ope-body-ele-name-text').text(currentID);
    var currentName = btnInfo[currentType].currentName;
    $('.ope-body-ele-name-text').text(currentName);

    if (currentType == 'button') {
        $('.ope-body-ele-button-sec').show();
        renderButton(btnInfo);
    };

    if (currentType == 'text_input') {
        $('.ope-body-ele-input-sec').show();
        renderInput(btnInfo);
    };

    if (currentType == 'single_selection') {
        $('.ope-body-ele-title-down').hide();
        //$('.ope-body-ele-radio-sec').show();
        //renderSingleSelection(btnInfo);
    }

    if (currentType == 'multiple_selection') {
        $('.ope-body-ele-title-down').hide();
        //$('.ope-body-ele-checkbox-sec').show();
        //renderMultipleSelection(btnInfo);
    }

    if (currentType == 'combobox') {
        $('.ope-body-ele-select-sec').show();
        renderCombobox(btnInfo);
    }
    if (currentType == 'video') {
        $('.ope-v-sec').show();
        renderVideo(btnInfo);
    }
};

var dotRenderArr = [];
var srcUrl = 'http://test.realplus.cc/?r=product/resources/Getresources&';
var srcUrlFinal = (0, _tool.opeUrl)(srcUrl, location.href);
var videoNode = null;
var videoCurrent = '';
var videoDuration = '';
var videoBlockWidth = $('.v_slider').width();
function renderVideo(info) {
    if (videoBlock) {} else {
        videoBlock = new _blockInput.blockInput($('.ope-v-time-cycle'), 0, 60, 0, '', function () {
            var time = Number($('.ope-v-time-cycle .ope-base-time-input').val().replace('秒', ''));
            RealEdit.Element.setVideoCycle(videoCurrent | 0, time);
        });
        videoBlock.init();
    }

    //视频
    //if(!videoNode){
    if (1) {
        var videoUrl = _variable.jsonPre + RealEdit.List.getPage().videoPath[0];
        var videoId = info[info.currentType].current;
        videoNode = document.getElementById(videoId);
        // videoNode = document.createElement('video');
        // videoNode.src = videoUrl;
        // videoNode.width = 320;
        // videoNode.height = 600;
        // videoNode.style.position = 'absolute';
        // videoNode.style.zIndex = 5;
        //$('#mcjs').append($(videoNode));
        exports.videoDuration = videoDuration = videoNode.duration;
        _ele_video.eleVideo.run();
        $('.ope-v-time-totel').text(renderTime(videoDuration));
        if (!videoNode.paused) {
            $('.ope-v-play').addClass('ope-v-play-stop').removeClass('ope-v-play-play');
        }
        // $(videoNode).on('loadedmetadata',function(){//获取视频长度
        //     videoDuration = videoNode.duration;
        //     eleVideo.run();
        //     $('.ope-v-time-totel').text(renderTime(videoDuration));
        // });
        // $(videoNode).on('canplay',function(){
        //     //console.log(videoNode.duration);
        // });
        $(videoNode).on('ended', function () {
            $('.ope-v-play').removeClass('ope-v-play-stop').addClass('ope-v-play-play');
            //eleVideo.setBlockPosition(0);
        });
        // $(videoNode).on('playing',function(){//不能实时获取
        //     //console.log('playing:' + videoNode.currentTime);
        // });
        $(videoNode).on('timeupdate', function () {
            videoCurrent = videoNode.currentTime;
            $('.ope-v-time-current').text(renderTime(videoCurrent));
            var ratio = (videoCurrent / videoDuration * 100 | 0) / 100;
            var cur = ratio * videoBlockWidth - 7;
            if (_ele_video.eleVideo.clickBlock) {
                return;
            };
            _ele_video.eleVideo.setBlockPosition(cur, videoCurrent | 0);
        });

        var videoArr = info[info.currentType].arr;
        for (let i = 0; i < videoArr.length; i++) {
            if (videoId == videoArr[i].id) {
                dotRenderArr = videoArr[i].dotArr;
                if (dotRenderArr) {
                    for (let i = 0; i < dotRenderArr.length; i++) {
                        var renderPos = dotRenderArr[i].dotTime / (videoDuration | 0) * videoBlockWidth | 0;
                        _ele_video.eleVideo.addDotForRender(renderPos);
                        //var id = dotRenderArr[i].jsData.id;
                        //$('.ope-v-move-list li[data-id=' + id + '] a').attr('disabled','disabled');
                    }
                }
            }
        }

        disabledLayer();
    }
}

//根据时间，来判断是否有对应的数组，进而渲染浮层下来列表标题
function renderLayer(sec) {
    //dotRenderArr --> layerArrUser --> dotRenderArr
    var name = '';
    var cycle = 0;
    if (dotRenderArr) {
        for (let i = 0; i < dotRenderArr.length; i++) {
            if (sec == dotRenderArr[i].dotTime) {
                name = dotRenderArr[i].name;
                cycle = dotRenderArr[i].cycle;
                $('.ope-v-move-btn-click-text').text(name);
            }
        }
        if (name == '') {
            $('.ope-v-move-btn-click-text').text('未选择');
        } else {
            $('.ope-v-move-btn-click-text').text(name);
        }
    }

    if (videoBlock) {
        videoBlock.time = cycle;
        videoBlock.init();
    }
}

function renderTime(sec) {
    var secInt = sec | 0;
    var finalmin = secInt / 60 | 0;
    if (finalmin == 0) {
        finalmin = '00';
    } else if (String(finalmin).length == 1) {
        finalmin = '0' + finalmin;
    }
    var finalsec = secInt % 60;
    if (finalsec == 0) {
        finalsec = '00';
    } else if (String(finalsec).length == 1) {
        finalsec = '0' + finalsec;
    }
    return finalmin + ':' + finalsec;
}

var layerArr = [];
var layerArrUser = [];

function opeVideo() {
    $('.ope-v-play').on('click', function () {
        if ($(this).hasClass('ope-v-play-play')) {
            $(this).removeClass('ope-v-play-play').addClass('ope-v-play-stop');
            videoNode.play();
        } else {
            $(this).removeClass('ope-v-play-stop').addClass('ope-v-play-play');
            videoNode.pause();
        }
    });

    $('.ope-v-right').on('click', function () {
        videoNode.currentTime += 1;
    });

    $('.ope-v-left').on('click', function () {
        videoNode.currentTime -= 1;
    });
    //先检查数组有米有，有就重写
    $('.ope-v-move-list').on('click', 'a', function () {
        if (Boolean($(this).attr('disabled'))) {
            return false;
        };
        $('.ope-v-move-btn-click-text').text($(this).text());
        var name = $(this).text();
        var id = $(this).parent().attr('data-id');
        videoNode.pause();
        var time = videoCurrent | 0;
        if (name != '未选择') {
            _ele_video.eleVideo.addDot();
            for (var i = 0; i < layerArr.length; i++) {
                if (id == layerArr[i].jsData.id) {
                    var obj = layerArr[i];
                    obj.dotTime = time;
                    obj.used = true;
                    RealEdit.Element.addVideoDot(obj);
                    var id = layerArr[i].jsData.id;
                    $('.ope-v-move-list li[data-id=' + id + '] a').attr('disabled', 'disabled');
                }
            }
        } else {
            _ele_video.eleVideo.removeDot();
            var id = RealEdit.Element.removeVideoDot(time);
            $('.ope-v-move-list li[data-id=' + id + '] a').attr('disabled', null);
        }
        resolveUsedLayer();
    });

    $.ajax({
        url: srcUrlFinal + '&type=layer',
        success: function success(result) {
            var result = JSON.parse(result);
            var data = result.result;
            $.ajaxSettings.async = false;
            $('.ope-v-move-list').empty();
            $('.ope-v-move-list').append(`<li data-id='noLayer'><a href='javascript:;'>未选择</a></li>`);
            for (var i = 0; i < data.length; i++) {
                (function (e) {
                    var time = data[e].addtime;
                    var url = _variable.jsonPre + data[i].datas;
                    $.getJSON(url, function (data) {
                        var o = {};
                        for (var item in data) {
                            o[item] = data[item];
                        }
                        o.time = time;
                        o.used = false;
                        $('.ope-v-move-list').append(`<li data-id=${o.jsData.id}><a href='javascript:;'>${o.name}</a></li>`);
                        layerArr.push(o);
                    });
                })(i);
            }
            $.ajaxSettings.async = true;
        }
    });

    resolveUsedLayer();
}

//这个函数把已经选择使用的遮罩层放在一个数组
function resolveUsedLayer() {
    var allPage = RealEdit.List.getPages();
    for (let i = 0; i < allPage.length; i++) {
        let element = allPage[i].element;
        for (let item in element) {
            if (item === 'video') {
                let video = element[item];
                let videoArr = video.arr;
                for (let i = 0; i < videoArr.length; i++) {
                    let dotArr = videoArr[i].dotArr;
                    for (let i = 0; i < dotArr.length; i++) {
                        let id = dotArr[i].jsData.id;
                        let used = dotArr[i].used;
                        let obj = {
                            id: id,
                            used: used
                        };
                        layerArrUser.push(obj);
                    }
                }
            }
        }
    }
    disabledLayer();
}

function disabledLayer() {
    for (let i = 0; i < layerArrUser.length; i++) {
        let id = layerArrUser[i].id;
        $('.ope-v-move-list li[data-id=' + id + '] a').attr('disabled', 'disabled');
    }
}

function moveVideo(sec) {
    $('.ope-v-play').removeClass('ope-v-play-stop').addClass('ope-v-play-play');
    videoNode.pause();
    videoNode.currentTime = sec;
}

function renderButton(btnInfo) {
    RealEdit.Element.setBtnTriEvent('点击时');

    if ($('.ope-body-ele-type-btn-click').prop('disabled')) {
        $('.ope-body-ele-type-btn-click,.ope-body-ele-type-btn-block,.ope-body-ele-move-btn-click').prop('disabled', null);
    }

    var currentType = btnInfo.currentType;
    var currentID = btnInfo.button.current;
    var btnArr = btnInfo.button.arr;

    for (var i = 0; i < btnArr.length; i++) {
        if (btnArr[i].id == currentID) {

            $('.ope-body-ele-type-btn-group > button').removeClass('ope-base-btn3-click');
            $('.ope-body-ele-move-btn-click-text').text('--');
            $('.ope-body-ele-button-sec-init').hide();
            $('.ope-body-ele-addr-val').val('');
            $('.ope-body-ele-phone-val').val('');

            var currentObj = btnArr[i];

            if (currentObj.trigger) {
                var btnEvent = currentObj.trigger.triEvent;
                var btnAction = currentObj.trigger.triAction;
                var btnContent = currentObj.trigger.triContent;

                for (var i2 = 0; i2 < $('.ope-body-ele-type-btn-group > button').length; i2++) {
                    if ($('.ope-body-ele-type-btn-group > button:nth-child(' + (i2 + 1) + ')').text() == btnEvent) {
                        $('.ope-body-ele-type-btn-group > button:nth-child(' + (i2 + 1) + ')').addClass('ope-base-btn3-click');
                    }
                }

                for (var i3 = 0; i3 < $('.ope-body-ele-move-list > li').length; i3++) {
                    if ($('.ope-body-ele-move-list > li:nth-child(' + (i3 + 1) + ') > a').text() == btnAction) {
                        $('.ope-body-ele-move-btn-click-text').text(btnAction);
                    }
                }

                switch (btnAction) {
                    case '拨打电话':
                        $('.ope-body-ele-button-sec-phone').show();
                        $('.ope-body-ele-phone-val').val(btnContent);
                        break;
                    case '跳转网页':
                        $('.ope-body-ele-button-sec-addr').show();
                        $('.ope-body-ele-addr-val').val(btnContent);
                        break;
                    case '跳转页面':
                        $('.ope-body-ele-button-sec-page').show();
                        var pageNum = RealEdit.List.totlaPageNum();
                        $('.ope-body-ele-page-btn-click-text').text(btnContent);
                        $('.ope-body-ele-page-list').empty();
                        for (var i4 = 0; i4 < pageNum; i4++) {
                            $('.ope-body-ele-page-list').append('<li><a>' + (i4 + 1) + '<a/></li>');
                        }
                        break;
                }
            }
        }
    }
}

function renderInput(btnInfo) {

    $('.ope-body-ele-input-type-btn-group > button').attr('disabled', null);
    var currentType = btnInfo.currentType;
    var currentID = btnInfo[currentType].current;
    var inputArr = btnInfo[currentType].arr;
    for (var i = 0; i < inputArr.length; i++) {
        if (inputArr[i].id == currentID) {
            var currentObj = inputArr[i];
            $('.ope-body-ele-input-type-btn-group > button').removeClass('ope-base-btn3-click');
            if (currentObj.inputData) {
                var name = currentObj.inputData.name;
                var inputType = currentObj.inputData.inputType;
                var infoType = currentObj.inputData.infoType;

                if (name) {
                    $('.ope-body-ele-input-name-val').val(name);
                } else {
                    $('.ope-body-ele-input-name-val').val(null);
                }

                for (var i2 = 0; i2 < $('.ope-body-ele-input-type-btn-group > button').length; i2++) {
                    if ($('.ope-body-ele-input-type-btn-group > button:nth-child(' + (i2 + 1) + ')').text() == inputType) {
                        $('.ope-body-ele-input-type-btn-group > button:nth-child(' + (i2 + 1) + ')').addClass('ope-base-btn3-click');
                    };
                }

                if (infoType) {
                    $('.ope-body-ele-input-info-btn-click-text').text(infoType);
                }
            } else {
                currentObj.inputData = {};
                currentObj.inputData.inputType = '必填项'; //临时
                $('.ope-body-ele-input-type-btn-click').addClass('ope-base-btn3-click');
                $('.ope-body-ele-input-name-val').val(null);
                currentObj.inputData.infoType = '全部类型';
                $('.ope-body-ele-input-info-btn-click-text').text('全部类型');
            };
        }
    }
}

var singleItem = `<input placeholder="选项$cnn（用于生成数据表单）" data-num=$num class="ope-base-input-val ope-body-ele-radio-btn-name-val">`;
var multipleItem = `<input placeholder="选项$cnn（用于生成数据表单）" data-num=$num class="ope-base-input-val ope-body-ele-checkbox-btn-name-val">`;

function renderSingleSelection(btnInfo) {
    var currentType = btnInfo.currentType;
    var currentID = btnInfo[currentType].current;
    var arr = btnInfo[currentType].arr;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].id == currentID) {
            var currentObj = arr[i];
            var num = currentObj.itemLength;
            RealEdit.Element.setSingleItemLength(num);
            if (currentObj.single) {
                var title = currentObj.single.titleName;
                var item = currentObj.single.item;
                $('.ope-body-ele-radio-title-name-val').val(title);
                $('.ope-body-ele-radio-box').empty();
                for (var j = 0; j < num; j++) {
                    $('.ope-body-ele-radio-box').append(singleItem.replace('$num', j).replace('$cnn', arabToChinese(j + 1)));
                }
                for (var k = 0; k < $('.ope-body-ele-radio-btn-name-val').length; k++) {
                    $($('.ope-body-ele-radio-btn-name-val')[k]).val(item[k]);
                }
            }
        }
    }
}

function renderMultipleSelection(btnInfo) {
    var currentType = btnInfo.currentType;
    var currentID = btnInfo[currentType].current;
    var arr = btnInfo[currentType].arr;
    for (var i = 0; i < arr.length; i++) {
        if (arr[i].id == currentID) {
            var currentObj = arr[i];
            var num = currentObj.itemLength;
            RealEdit.Element.setMultipleItemLength(num);
            if (currentObj.multiple) {
                var title = currentObj.multiple.titleName;
                var item = currentObj.multiple.item;
                $('.ope-body-ele-checkbox-title-name-val').val(title);
                $('.ope-body-ele-checkbox-box').empty();
                for (var j = 0; j < num; j++) {
                    $('.ope-body-ele-checkbox-box').append(multipleItem.replace('$num', j).replace('$cnn', arabToChinese(j + 1)));
                }
                for (var k = 0; k < $('.ope-body-ele-checkbox-btn-name-val').length; k++) {
                    $($('.ope-body-ele-checkbox-btn-name-val')[k]).val(item[k]);
                }
            }
        }
    }
}

function opeMultipleSelection() {
    $('.ope-body-ele-checkbox-title-name-val').on('input', function () {
        RealEdit.Element.setMultipleTitle($(this).val());
    });
    $('.ope-body-ele-checkbox-box').on('input', '.ope-body-ele-checkbox-btn-name-val', function () {
        RealEdit.Element.setMultipleItemTitle(Number($(this).attr('data-num')), $(this).val());
        if ($(this).val() == '') {
            RealEdit.Element.setMultipleItemTitle(Number($(this).attr('data-num')), '选项' + arabToChinese(Number($(this).attr('data-num')) + 1));
        }
    });
}

function opeSingleSelection() {
    $('.ope-body-ele-radio-title-name-val').on('input', function () {
        RealEdit.Element.setSingleTitle($(this).val());
    });
    $('.ope-body-ele-radio-box').on('input', '.ope-body-ele-radio-btn-name-val', function () {
        RealEdit.Element.setSingleItemTitle(Number($(this).attr('data-num')), $(this).val());
        if ($(this).val() == '') {
            RealEdit.Element.setSingleItemTitle(Number($(this).attr('data-num')), '选项' + arabToChinese(Number($(this).attr('data-num')) + 1));
        }
    });
}

var selectItem = '<div class="ope-base-input-box ope-base-select-input-box clearfix" data-num =$num><input placeholder="请输入内容（用于生成数据表单）" class="ope-base-input-val ope-ele-select-input-val"><button class="ope-base-input-delete ope-ele-select-input-delete"></button></div>';

function renderCombobox(btnInfo) {
    var currentType = btnInfo.currentType;
    var currentID = btnInfo[currentType].current;
    var inputArr = btnInfo[currentType].arr;
    for (var i = 0; i < inputArr.length; i++) {
        if (inputArr[i].id == currentID) {
            var currentObj = inputArr[i];
            if (!currentObj.select) {
                RealEdit.Element.addSelectItem();
            }
            if (currentObj.select) {
                var title = currentObj.select.titleName;
                var arr = currentObj.select.item;
                $('.ope-body-ele-select-title-name-val').val(title);
                $('.ope-body-ele-select-box').empty();
                if (arr) {
                    for (var k = 0; k < arr.length; k++) {
                        $('.ope-body-ele-select-box').append(selectItem.replace('$num', k));
                    }
                    for (var j = 0; j < arr.length; j++) {
                        if (j == 0) {
                            $($('.ope-base-select-input-box')[j]).find('.ope-ele-select-input-delete').attr('disabled', 'disabled');
                        }
                        $($('.ope-base-select-input-box')[j]).find('.ope-ele-select-input-val').val(arr[j]);
                    }
                } else {
                    //RealEdit.Element.addSelectItem();
                }
            }
        }
    }
}

function opeCombobox() {
    $('.ope-body-ele-select-title-name-val').on('input', function () {
        RealEdit.Element.setSelectTitle($(this).val());
    });

    $('.ope-body-ele-select-box').on('input', '.ope-ele-select-input-val', function () {
        RealEdit.Element.setSelectItemTitle(Number($(this).parents('.ope-base-select-input-box').attr('data-num')), $(this).val());
    });

    $('.ope-body-ele-select-box').on('click', '.ope-ele-select-input-delete', function () {
        $(this).parents('.ope-base-select-input-box').remove();
        RealEdit.Element.removeSelectItemTitle($(this).parents('.ope-base-select-input-box').attr('data-num'));
        var num = $('.ope-base-select-input-box').length;
        for (var i = 0; i < num; i++) {
            $($('.ope-base-select-input-box')[i]).attr('data-num', i);
        }
    });

    $('.ope-body-ele-select-add').on('click', function () {
        $('.ope-body-ele-select-box').append(selectItem.replace('$num', $('.ope-base-select-input-box').length));
        RealEdit.Element.addSelectItem();
    });
}

var infoTypeData = [{ txt: '全部类型', key: 'all_type' }, { txt: '电话', key: 'phone_type' }, { txt: '邮箱', key: 'mail_type' }];

var inputLiDom = '<li><a href="#" data-uid="$uid">$txt</a><li>';

function opeInput() {
    //初始化渲染信息类型列表
    $('.ope-body-ele-input-info-list').empty();
    for (var i = 0; i < infoTypeData.length; i++) {
        $('.ope-body-ele-input-info-list').append(inputLiDom.replace('$uid', infoTypeData[i].key).replace('$txt', infoTypeData[i].txt));
    }
    //输入框名称输入
    $('.ope-body-ele-input-name-val').on('input', function () {
        RealEdit.Element.setInputName($('.ope-body-ele-input-name-val').val());
    });
    //输入性质点击
    $('.ope-body-ele-input-type-btn-group > button').on('click', function () {
        $('.ope-body-ele-input-type-btn-group > button').removeClass('ope-base-btn3-click');
        $(this).addClass('ope-base-btn3-click');
        RealEdit.Element.setInputType($(this).text());
    });
    //信息类型选择
    $('.ope-body-ele-input-info-list a').on('click', function () {
        $('.ope-body-ele-input-info-btn-click-text').text($(this).text());
        RealEdit.Element.setInputInfoType($(this).text());
    });
}

function elementReturnZero() {
    $('.ope-body-ele-button-sec').hide();
    $('.ope-body-ele-input-sec').hide();
    $('.ope-body-ele-radio-sec').hide();
    $('.ope-body-ele-checkbox-sec').hide();
    $('.ope-body-ele-select-sec').hide();
    $('.ope-v-sec').hide();
    $('.ope-body-ele-type-text').text('--');
    $('.ope-body-ele-name-text').text('--');
}

function arabToChinese(an) {
    var chineseNum = ['十一二三四五六七八九', '零十二三四五六七八九'];
    var chineseArr = [];
    var arabArr = String(an).split('').reverse();
    for (var i = 0; i < arabArr.length; i++) {
        chineseArr.push(chineseNum[i][arabArr[i]]);
    }
    chineseArr = chineseArr.reverse();
    if (chineseArr[0] == '十' && chineseArr[1] == '十') {
        chineseArr.pop();
    }
    return chineseArr.join('');
}

$('.ope-body-ele-select-scroll').scrollbar();
$('.ope-body-ele-radio-scroll').scrollbar();
$('.ope-body-ele-checkbox-scroll').scrollbar();
//初始化搞个默认渲染按钮，包括跳转至
//跳转至相关逻辑

exports.eleOpe = eleOpe;
exports.elementReturnZero = elementReturnZero;
exports.videoDuration = videoDuration;
exports.renderTime = renderTime;
exports.moveVideo = moveVideo;
exports.renderLayer = renderLayer;
},{"./block-input":2,"./ele_video":3,"./tool":15,"./variable":16}],9:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.musicUploadLimit = exports.musicOpe = undefined;

var _tool = require('./tool');

var _render = require('./render');

var _variable = require('./variable');

var _pageConfig = require('./page-config');

var music = '.ope-body-music-';
var musicUid;
var delMusicUrl = 'http://test.realplus.cc/?r=product/resources/delmusic&';
var delMusicFinalUrl = (0, _tool.opeUrl)(delMusicUrl, location.href);
function musicOpe() {
	$(music + 'close' + ',' + music + 'open').on('click', function () {
		$(music + 'close' + ',' + music + 'open').removeClass('ope-base-btn2-box-click');
		$(this).addClass('ope-base-btn2-box-click');
		(0, _pageConfig.ifForbinDefaultMusicLogo)();
		// if($(this).hasClass('ope-body-music-close')){
		// 	$(music+'pos-btn').prop('disabled','disabled');
		// 	RealEdit.Music.disabled();
		// 	mcjs.DOMInterface.hideMusicBtn();
		// };
		// if($(this).hasClass('ope-body-music-open')){
		// 	$(music+'pos-btn').prop('disabled',null);
		// 	RealEdit.Music.enalbed();
		// 	if(RealEdit.Music.position === -1){
		//
		// 	} else {
		// 		mcjs.DOMInterface.showMusicBtn(RealEdit.getObjByUID(RealEdit.Music.position).key);
		// 	}
		// };
	});

	(0, _tool.baseDrop)(music + 'pos-menu', music + 'pos-text', function (uid) {
		RealEdit.Music.position = uid;
		mcjs.DOMInterface.showMusicBtn(RealEdit.getObjByUID(RealEdit.Music.position).key);
	});

	playMusic();

	chooseMusic();

	uploadMusic();

	musicApply();

	musicItemDelete();

	uploadMusicAlertHide();
}

function playMusic() {
	var weMusicClicked;
	var audio = document.querySelector(music + 'play');
	$(music + 'body').on('click', music + 'item', function () {
		var currentDomUrl = $(this).attr('data-url');
		if (audio.src === currentDomUrl) {} else {
			audio.src = currentDomUrl;
		}
		$(music + 'item').not($(this)).removeClass('ope-body-music-item-state-focus').removeClass('ope-body-music-item-state-play');

		if ($(this).hasClass('ope-body-music-item-state-focus')) {} else {
			$(music + 'item' + '>' + music + 'item-back').css('width', 0);
			audio.currentTime = 0;
		}

		$(this).addClass('ope-body-music-item-state-focus');
		weMusicClicked = $(this).find(music + 'item-back');

		if (audio.readyState === 4) {
			if ($(this).hasClass('ope-body-music-item-state-play')) {
				$(this).removeClass('ope-body-music-item-state-play');
				audio.pause();
			} else {
				$(this).addClass('ope-body-music-item-state-play');
				audio.play();
			}
		} else {
			//第一次走这里，不是第一次走上面
			audio.onloadeddata = function () {
				if ($(this).hasClass('ope-body-music-item-state-play')) {
					$(this).removeClass('ope-body-music-item-state-play');
					audio.pause();
				} else {
					$(this).addClass('ope-body-music-item-state-play');
					audio.play();
				}
			}.bind(this);
		}
	});

	$(music + 'play').on('timeupdate', function () {
		weMusicClicked.css('width', audio.currentTime / audio.duration * 100 + '%');
	});
	$(music + 'play').on('ended', function () {
		weMusicClicked.css('width', 0);
		weMusicClicked.parentsUntil(music + 'list', music + 'item').removeClass('ope-body-music-item-state-play');
	});
}

function chooseMusic() {
	$(music + 'body').on('click', music + 'item-choose', function (e) {
		var musicName = $(this).parents(music + 'item').find(music + 'item-name').text();
		var musicUid = $(this).parents(music + 'item').attr('data-uid');
		e.stopPropagation();
		$(music + 'list' + '>' + music + 'item').not($(this).parentsUntil(music + 'list', music + 'item')).removeClass('ope-body-music-item-state-choose');
		if ($(this).parentsUntil(music + 'list', music + 'item').hasClass('ope-body-music-item-state-choose')) {
			$(this).parentsUntil(music + 'list', music + 'item').removeClass('ope-body-music-item-state-choose');
			$(music + 'choose').addClass('ope-body-music-choose-state-no');
			RealEdit.Music.selectMusic = -1;
		} else {
			$(this).parentsUntil(music + 'list', music + 'item').addClass('ope-body-music-item-state-choose');
			$(music + 'choose').removeClass('ope-body-music-choose-state-no');
			$(music + 'choose' + ' > span:nth-child(2)').text(musicName);
			RealEdit.Music.selectMusic = musicUid;
		}
	});
}
function uploadMusic() {
	var uploadMusicUrl = 'http://test.realplus.cc/?r=product/resources/addmusic&';
	var musicUploadUrlFinal = (0, _tool.opeUrl)(uploadMusicUrl, location.href);

	$(music + 'add').on('click', function (e) {
		$(this).removeClass('ope-body-music-add-state-big');
		if (window.editor.musicUploadDoor) {
			$(music + 'upload').val('');
			$(music + 'upload').click();
		}
	});

	$(music + 'upload').on('change', function (e) {
		uploadMusicNo();
		var form = document.querySelector(music + 'form');
		var musicData = new FormData(form);
		$.ajax({
			url: musicUploadUrlFinal,
			type: 'POST',
			processData: false,
			contentType: false,
			cache: false,
			data: musicData,
			xhr: function xhr() {
				var xhr = $.ajaxSettings.xhr();
				xhr.upload.addEventListener('progress', function (event) {
					if (event.lengthComputable) {
						var percentComplete = event.loaded / event.total;
						$('.ope-body-music-progress').css('width', (percentComplete * 100 | 0) + '%');
					}
				}, false);
				return xhr;
			},
			success: function success(result) {
				var needResult = JSON.parse(result);
				if (needResult.code === '0') {
					RealEdit.Music.addMyMusic(needResult.result.name, needResult.result.size, needResult.result.url, needResult.result.uid);
					var list = [];
					list.push(needResult.result);

					(0, _render.musicUploadPane)(music, list);

					(0, _render.renderMusicItem)(music + 'program', _variable.musicListOption, list, 'no');
					uploadMusicYes();
					musicUploadLimit();
				} else {
					uploadMusicYes();
					uploadMusicAlertShow(needResult.msg);
				}
				$('.ope-body-music-progress').css('width', '0%');
			},
			error: function error(_error) {
				console.log(_error);
				$('.ope-body-music-progress').css('width', '0%');
				uploadMusicYes();
			}
		});
	});
}

function musicApply() {
	$(music + 'app').on('click', function () {
		if ($('.ope-body-music-item-choose').length === 1) {
			RealEdit.Music.applyGlobe();
		}
	});
}

function musicItemDelete() {
	$(music + 'program-music').on('click', music + 'item-delete', function (e) {
		musicUid = $(this).parents('.ope-body-music-item').prop('dataset').uid;
		e.stopPropagation();
		$('#alert-music-delete').modal({ backdrop: 'static', keyboard: false });
		var alertMarginTop = $(window).height() >= $('.alert-music-delete-height').height() ? ($(window).height() - $('.alert-music-delete-height').height()) / 2 : 0;
		$('.alert-music-delete-width').css('marginTop', alertMarginTop + 'px');
	});

	$('.alert-music-delete-btn').on('click', function () {
		$('#alert-music-delete').modal('hide');
		deleteMusic(musicUid);
	});
}

function musicUploadLimit() {
	if ($('.ope-body-music-program > .ope-body-music-item').length === 5) {
		$('.ope-body-music-add').addClass('ope-body-music-add-state-f');
		window.editor.musicUploadDoor = false;
	} else {
		$('.ope-body-music-add').removeClass('ope-body-music-add-state-f');
		window.editor.musicUploadDoor = true;
	}

	$('.ope-body-music-add-num').html($('.ope-body-music-program > .ope-body-music-item').length + '/5');
}

function uploadMusicNo() {
	$('.ope-body-music-add').addClass('ope-body-music-add-state-f');
	window.editor.musicUploadDoor = false;
}

function uploadMusicYes() {
	$('.ope-body-music-add').removeClass('ope-body-music-add-state-f');
	window.editor.musicUploadDoor = true;
}

function uploadMusicAlertShow(text) {
	$('.alert-music-response-text').html(text);
	$('#alert-music-response').modal({ backdrop: 'static', keyboard: false });
	var alertMarginTop = $(window).height() >= $('.alert-music-response-height').height() ? ($(window).height() - $('.alert-music-response-height').height()) / 2 : 0;
	$('.alert-music-response-width').css('marginTop', alertMarginTop + 'px');
}

function uploadMusicAlertHide() {
	$('.alert-music-response-btn').on('click', function () {
		$('#alert-music-response').modal('hide');
	});
}

function deleteMusic(id) {
	$.ajax({
		url: delMusicFinalUrl,
		type: 'POST',
		data: { uid: id },
		success: function success(result) {
			console.log(result);
			$('.ope-body-music-item[data-uid=' + id + ']').remove();
			if (RealEdit.Music.selectMusic === id) {
				$(music + 'choose').addClass('ope-body-music-choose-state-no');
				RealEdit.Music.selectMusic = -1;
			}
			musicUploadLimit();
		},
		error: function error(_error2) {
			console.log(_error2);
		}
	});
}
exports.musicOpe = musicOpe;
exports.musicUploadLimit = musicUploadLimit;
},{"./page-config":11,"./render":12,"./tool":15,"./variable":16}],10:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.isForbidSwi = exports.swiOpe = undefined;

var _tool = require('./tool');

var _variable = require('./variable');

var _render = require('./render');

function swiOpe() {
	var swi = '.ope-body-swi-';

	(0, _tool.baseDrop)(swi + 'up-ges-list', swi + 'up-ges-btn-click-text', function (uid) {
		RealEdit.Transform.prevItem.triggert = uid;
	});
	(0, _tool.baseDrop)(swi + 'up-eff-list', swi + 'up-eff-btn-click-text', function (uid) {
		RealEdit.Transform.prevItem.effect = uid;
		var list = RealEdit.Transform.prevItem.dirList;
		RealEdit.Transform.prevItem.dir = list[0].uid;
		var title = RealEdit.Transform.prevItem.dir;
		(0, _render.renderDrop)(swi + 'up-dir-btn-click-text', swi + 'up-dir-list', _variable.dirOption, title, list);
	});
	(0, _tool.baseDrop)(swi + 'up-dir-list', swi + 'up-dir-btn-click-text', function (uid) {
		RealEdit.Transform.prevItem.dir = uid;
	});
	(0, _tool.baseDrop)(swi + 'down-ges-list', swi + 'down-ges-btn-click-text', function (uid) {
		RealEdit.Transform.nextItem.triggert = uid;
	});
	(0, _tool.baseDrop)(swi + 'down-eff-list', swi + 'down-eff-btn-click-text', function (uid) {
		RealEdit.Transform.nextItem.effect = uid;
		var list = RealEdit.Transform.nextItem.dirList;
		RealEdit.Transform.nextItem.dir = list[0].uid;
		var title = RealEdit.Transform.nextItem.dir;
		(0, _render.renderDrop)(swi + 'down-dir-btn-click-text', swi + 'down-dir-list', _variable.dirOption, title, list);
	});
	(0, _tool.baseDrop)(swi + 'down-dir-list', swi + 'down-dir-btn-click-text', function (uid) {
		RealEdit.Transform.nextItem.dir = uid;
	});

	$(swi + 'up-pre').on('click', function () {
		var prev = RealEdit.selectPageIndex - 1;
		if (prev !== -1) {
			mcjs.Edit.preview(RealEdit.CjsManager.getPage(prev), 'prev');
		}
	});
	$(swi + 'down-pre').on('click', function () {
		var next = RealEdit.selectPageIndex + 1;
		if (next !== RealEdit.totlaPageNum) {
			mcjs.Edit.preview(RealEdit.CjsManager.getPage(next), 'next');
		}
	});

	$(swi + 'up-app').on('click', function () {
		RealEdit.Transform.applyGlobePrev();
		(0, _tool.slideBlock)('操作成功');
	});
	$(swi + 'down-app').on('click', function () {
		RealEdit.Transform.applyGlobeNext();
		(0, _tool.slideBlock)('操作成功');
	});
}

//下面四个函数是切换区上下两部分的启用与禁止。
//第一项，上一页切换禁用。最后一项，下一页切换禁用。
//点击dom,初始化，移动dom,删除dom,导入dom的时候检测
function forbidUp() {
	$('.ope-body-swi-up-ges-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-up-eff-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-up-dir-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-up-pre').prop('disabled', 'disabled');
	$('.ope-body-swi-up-app').prop('disabled', 'disabled');
	$('.ope-body-swi-up-time > .ope-base-time-forbid').show();
};

function allowUp() {
	$('.ope-body-swi-up-ges-btn-click').prop('disabled', null);
	$('.ope-body-swi-up-eff-btn-click').prop('disabled', null);
	$('.ope-body-swi-up-dir-btn-click').prop('disabled', null);
	$('.ope-body-swi-up-pre').prop('disabled', null);
	$('.ope-body-swi-up-app').prop('disabled', null);
	$('.ope-body-swi-up-time > .ope-base-time-forbid').hide();
};

function forbidDown() {
	$('.ope-body-swi-down-ges-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-down-eff-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-down-dir-btn-click').prop('disabled', 'disabled');
	$('.ope-body-swi-down-pre').prop('disabled', 'disabled');
	$('.ope-body-swi-down-app').prop('disabled', 'disabled');
	$('.ope-body-swi-down-time > .ope-base-time-forbid').show();
};

function allowDown() {
	$('.ope-body-swi-down-ges-btn-click').prop('disabled', null);
	$('.ope-body-swi-down-eff-btn-click').prop('disabled', null);
	$('.ope-body-swi-down-dir-btn-click').prop('disabled', null);
	$('.ope-body-swi-down-pre').prop('disabled', null);
	$('.ope-body-swi-down-app').prop('disabled', null);
	$('.ope-body-swi-down-time > .ope-base-time-forbid').hide();
};

function isForbidSwi() {
	var currentNum = Number($('.page-list-unit-state-click').find('.page-list-unit-num').text());
	var totleNum = $('.page-list-unit').length;
	if (currentNum === 1) {
		forbidUp();
	} else {
		allowUp();
	}
	if (currentNum === totleNum) {
		forbidDown();
	} else {
		allowDown();
	}
}

exports.swiOpe = swiOpe;
exports.isForbidSwi = isForbidSwi;
},{"./render":12,"./tool":15,"./variable":16}],11:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
exports.ifForbinDefaultMusicLogo = exports.deleteChangeConfig = exports.ajaxHandleSrc = exports.clearDeleteArr = exports.proConfigEnableChange = exports.configBtn = undefined;

var _tool = require('./tool');

var _variable = require('./variable');

var _addSource = require('./add-source');

var srcUrl = 'http://test.realplus.cc/?r=product/resources/Getresources&';
var srcUrlFinal = (0, _tool.opeUrl)(srcUrl, location.href);
var conPreItem = '<iframe scrolling="no" class="pcon-item-frame-tag" src="$htmlpreview"></iframe>';
var cloudUrl = 'http://test.realplus.cc/?r=product/resources/cloud&';
var cloudUrlFinal = (0, _tool.opeUrl)(cloudUrl, location.href);
var choosedCongig = [];
var deleteConfigArr = [];
var firstEnter = true;
var renderConfigArr = [{
    type: 'musicBtn',
    str: '<div class="pcon-item pcon-item-music" data-type="musicBtn"><div class="pcon-item-show"><img class="pcon-item-img" src="$img_preview"></div><div class="pcon-item-choose clearfix"><p class="pcon-item-choose-text">$textName</p><button class="pcon-item-choose-btn"></button></div><div class="pcon-item-use clearfix"><div class="pcon-item-use-left clearfix"><div class="pcon-item-bg"><div class="pcon-item-block"></div></div><p class="pcon-item-text">启用</p></div><p class="pcon-item-time">$time</p></div><div class="pcon-item-border"></div><div class="pcon-item-frame" data-type="musicBtn"></div></div>'
}, {
    type: 'background',
    str: '<div class="pcon-item pcon-item-bgimg" data-type="background"><div class="pcon-item-show"><img class="pcon-item-img" src="$img_preview"></div><div class="pcon-item-choose clearfix"><p class="pcon-item-choose-text">$textName</p><button class="pcon-item-choose-btn"></button></div><div class="pcon-item-use clearfix"><div class="pcon-item-use-left clearfix"><div class="pcon-item-bg"><div class="pcon-item-block"></div></div><p class="pcon-item-text">启用</p></div><p class="pcon-item-time">$time</p></div><div class="pcon-item-border"></div><div class="pcon-item-frame" data-type="background"></div></div>'
}, {
    type: 'indexLoading',
    str: '<div class="pcon-item pcon-item-load" data-type="indexLoading"><div class="pcon-item-show"><img class="pcon-item-img" src="$img_preview"></div><div class="pcon-item-choose clearfix"><p class="pcon-item-choose-text">$textName</p><button class="pcon-item-choose-btn"></button></div><div class="pcon-item-use clearfix"><div class="pcon-item-use-left clearfix"><div class="pcon-item-bg"><div class="pcon-item-block"></div></div><p class="pcon-item-text">启用</p></div><p class="pcon-item-time">$time</p></div><div class="pcon-item-border"></div><div class="pcon-item-frame" data-type="indexLoading"></div></div>'
}, {
    type: 'shareLayer',
    str: '<div class="pcon-item pcon-item-mask" data-type="shareLayer"><div class="pcon-item-show"><img class="pcon-item-img" src="$img_preview"></div><div class="pcon-item-choose clearfix"><p class="pcon-item-choose-text">$textName</p><button class="pcon-item-choose-btn"></button></div><div class="pcon-item-use clearfix"><div class="pcon-item-use-left clearfix"><div class="pcon-item-bg"><div class="pcon-item-block"></div></div><p class="pcon-item-text">启用</p></div><p class="pcon-item-time">$time</p></div><div class="pcon-item-border"></div><div class="pcon-item-frame" data-type="shareLayer"></div></div>'
}, {
    type: 'logoLayer',
    str: '<div class="pcon-item pcon-item-logo" data-type="logoLayer"><div class="pcon-item-show"><img class="pcon-item-img" src="$img_preview"></div><div class="pcon-item-choose clearfix"><p class="pcon-item-choose-text">$textName</p><button class="pcon-item-choose-btn"></button></div><div class="pcon-item-use clearfix"><div class="pcon-item-use-left clearfix"><div class="pcon-item-bg"><div class="pcon-item-block"></div></div><p class="pcon-item-text">启用</p></div><p class="pcon-item-time">$time</p></div><div class="pcon-item-border"></div><div class="pcon-item-frame" data-type="logoLayer"></div></div>'
}];

//刷新后，配置初始信息，用于保存时比较是否改变，是否改变项目状态
var initialConfigEnable = {};

function configBtn() {
    conPane();
}

function conPane() {
    //在元素上绑定事件，进行交互
    //'配置页面'按钮
    $('.view-head-list-btn2-config').on('click', function () {

        window.editor.enterConfigPage = true;

        $('.pcon-box').addClass('pcon-box-show');

        if (window.editor.cloudDoor) {
            $('.pcon-upload-bg').removeClass('pcon-upload-bg-close');
        } else {
            $('.pcon-upload-bg').addClass('pcon-upload-bg-close');
        }

        // $('.pcon-box').show();

        if (firstEnter) {
            ajaxHandleSrc();
            //firstEnter = false;//这一句依赖异步任务
        }
    });
    //'返回编辑'按钮
    $('.pcon-head-return').on('click', function () {
        $('.pcon-box').removeClass('pcon-box-show');
        //$('.pcon-box').hide();
        //$('.pcon-list').empty();
        $('.pcon-ope-all').removeClass('pcon-ope-all-state-active');
        $('.pcon-list > .pcon-item').removeClass('pcon-item-state-choose');
        choosedCongig = [];
    });
    //配置项目选择按钮
    $('.pcon-list').on('click', '.pcon-item-choose-btn', function () {
        if ($(this).parents('.pcon-item').hasClass('pcon-item-state-choose')) {
            $(this).parents('.pcon-item').removeClass('pcon-item-state-choose');
            choosedCongig.splice(choosedCongig.indexOf($(this).parents('.pcon-item').attr('data-type')), 1);
        } else {
            $(this).parents('.pcon-item').addClass('pcon-item-state-choose');
            choosedCongig.push($(this).parents('.pcon-item').attr('data-type'));
        }

        if (choosedCongig.length == $('.pcon-list > .pcon-item').length) {
            $('.pcon-ope-all').addClass('pcon-ope-all-state-active');
        } else {
            $('.pcon-ope-all').removeClass('pcon-ope-all-state-active');
        }

        if (choosedCongig.length == 0) {
            //分模块，分组件，组件状态，组件方法啊//可视状态和逻辑(数据处理)
            $('.pcon-head-delete').addClass('pcon-head-delete-forbin');
            $('.pcon-head-delete').attr('disabled', 'disabled');
        } else {
            $('.pcon-head-delete').removeClass('pcon-head-delete-forbin');
            $('.pcon-head-delete').attr('disabled', null);
        }
    });
    //全选按钮的逻辑
    $('.pcon-ope-all').on('click', function () {
        choosedCongig = [];
        if ($(this).hasClass('pcon-ope-all-state-active')) {
            $(this).removeClass('pcon-ope-all-state-active');
            $('.pcon-list > .pcon-item').removeClass('pcon-item-state-choose');
        } else {
            $(this).addClass('pcon-ope-all-state-active');
            $('.pcon-list > .pcon-item').addClass('pcon-item-state-choose');

            for (var i = 0; i < renderConfigArr.length; i++) {
                if (renderConfigArr[i].exist) {
                    choosedCongig.push(renderConfigArr[i].type);
                }
            }
        }

        if (choosedCongig.length == 0) {
            //分模块，分组件，组件状态，组件方法啊
            $('.pcon-head-delete').addClass('pcon-head-delete-forbin');
            $('.pcon-head-delete').attr('disabled', 'disabled');
        } else {
            $('.pcon-head-delete').removeClass('pcon-head-delete-forbin');
            $('.pcon-head-delete').attr('disabled', null);
        }
    });
    //刷新数据
    $('.pcon-ope-refresh').on('click', function () {
        $('.pcon-ope-refresh').attr('disabled', 'disabled');
        $('.pcon-list').empty();
        ajaxHandleSrc();
        setTimeout(function () {
            $('.pcon-ope-refresh').attr('disabled', null);
        }, 1000);
    });
    //删除按钮
    $('.pcon-head-delete').on('click', function () {
        for (var i = 0; i < choosedCongig.length; i++) {
            $('.pcon-item[data-type=' + choosedCongig[i] + ']').remove();
            for (var j = 0; j < renderConfigArr.length; j++) {
                if (choosedCongig[i] == renderConfigArr[j].type) {
                    renderConfigArr[j].hasDeleted = true;
                    deleteConfigArr.push(renderConfigArr[j].html_preview.substring(0, renderConfigArr[j].html_preview.indexOf('?')));
                    deleteConfigArr.push(renderConfigArr[j].img_icon.substring(0, renderConfigArr[j].img_icon.indexOf('?')));
                    deleteConfigArr.push(renderConfigArr[j].img_preview.substring(0, renderConfigArr[j].img_preview.indexOf('?')));
                    deleteConfigArr.push(renderConfigArr[j].json);
                }
            }
        }

        RealEdit.ProConfig.setDeleteArr(deleteConfigArr);
        $('.pcon-ope-all').removeClass('pcon-ope-all-state-active');
        $('.pcon-list > .pcon-item').removeClass('pcon-item-state-choose');
        choosedCongig = [];
        $('.pcon-head-delete').addClass('pcon-head-delete-forbin');
        $('.pcon-head-delete').attr('disabled', 'disabled');
        RealEdit.DataManager.updateVer();
    });
    //素材上传按钮
    $('.pcon-upload-bg').on('click', function () {
        if ($(this).hasClass('pcon-upload-bg-close')) {
            $(this).removeClass('pcon-upload-bg-close');
        } else {
            $(this).addClass('pcon-upload-bg-close');
        }

        if (window.editor.cloudDoor) {
            window.editor.cloudDoor = false;
        } else {
            window.editor.cloudDoor = true;
        }

        $.ajax({
            url: cloudUrlFinal,
            type: 'POST',
            success: function success(result) {
                console.log(result);
            },
            error: function error(_error) {
                console.log(_error);
            }
        });
    });
    //'启用'按钮
    $('.pcon-list').on('click', '.pcon-item-bg', function () {
        var type = $(this).parents('.pcon-item').attr('data-type');
        if ($(this).hasClass('pcon-item-bg-active')) {
            $(this).removeClass('pcon-item-bg-active');
            RealEdit.ProConfig.disabledConfig(type);
        } else {
            $(this).addClass('pcon-item-bg-active');
            RealEdit.ProConfig.enableConfig(type);
        };

        if (type == 'musicBtn') {
            ifForbinDefaultMusicLogo();
        }
    });
}

//背景音效开启按钮，默认音乐logo，配置自定义音乐logo
function ifForbinDefaultMusicLogo() {
    var openBtn = $('.ope-body-music-open').hasClass('ope-base-btn2-box-click');
    var musicConfig = RealEdit.ProConfig.getEnableByType('musicBtn');

    if (openBtn && !musicConfig) {
        $('.ope-body-music-pos-btn').prop('disabled', null);
        //RealEdit.Music.enalbed();
        if (RealEdit.Music.position === -1) {
            RealEdit.Music.position = 'wRe7nhdqlL';
            mcjs.DOMInterface.showMusicBtn(RealEdit.getObjByUID(RealEdit.Music.position).key);
        } else {
            mcjs.DOMInterface.showMusicBtn(RealEdit.getObjByUID(RealEdit.Music.position).key);
        }
    } else {
        $('.ope-body-music-pos-btn').prop('disabled', 'disabled');
        //RealEdit.Music.disabled();
        mcjs.DOMInterface.hideMusicBtn();
    }

    if (openBtn) {
        RealEdit.Music.enalbed();
    } else {
        RealEdit.Music.disabled();
    }
    console.log('re音乐状态:' + RealEdit.Music.isEnabled());
}

//清空删除配置数组的函数
function clearDeleteArr() {
    deleteConfigArr = [];
}

//接收与处理数据
function ajaxHandleSrc() {
    $.ajax({
        url: srcUrlFinal + '&type=config',
        //url:srcUrlFinal,
        dataType: 'json', //不写还不行
        success: function success(result) {
            var resultArr = result.result;
            if (result.result) {
                parseJson(resultArr);
            }
        }
    });
};

//解析json函数
function parseJson(arr) {
    var srcArr = arr.reverse();
    $.ajaxSettings.async = false;
    for (var i = 0; i < srcArr.length; i++) {
        (function (e) {
            var srcItem = srcArr[e];
            var jsonUrl = _variable.jsonPre + srcItem.datas;
            var jsonForDelete = srcItem.datas;
            var time = srcItem.addtime;
            $.getJSON(jsonUrl, function (data) {
                dataToRE(data);
                renderData(data, time, jsonForDelete); //注意先后顺序
            });
        })(i);
    }
    $.ajaxSettings.async = true;
    firstEnter = false;
    renderConfig(); //我把代码流程写错了啊
}

//数据传送到RE里面
function dataToRE(data) {
    RealEdit.ProConfig.addConfig(data);
};

//最终‘启用’状态是否改变//布尔值可以比较吗？
function proConfigEnableChange() {
    for (var item in initialConfigEnable) {
        if (initialConfigEnable[item].enable != RealEdit.ProConfig.getEnableByType(item)) {
            if (item == 'musicBtn') {
                if (RealEdit.Music.isEnabled()) {
                    RealEdit.DataManager.updateProConfigVer(item);
                }
            }
        }
    }
}

//处理除传来的数据，让数据有顺序
function renderData(data, time, json) {
    if (firstEnter) {
        if (!initialConfigEnable[data.type]) {
            initialConfigEnable[data.type] = {};
        }
        initialConfigEnable[data.type].enable = RealEdit.ProConfig.getEnableByType(data.type);
    }

    for (var i = 0; i < renderConfigArr.length; i++) {
        if (renderConfigArr[i].type == data.type) {
            if (renderConfigArr[i].time) {
                if (renderConfigArr[i].time == time) {
                    //console.log('素材没有更新！！！！！！');
                } else {
                    renderConfigArr[i].hasDeleted = false;
                }
            }
            renderConfigArr[i].time = time;
            renderConfigArr[i].json = json;
            for (var j in data) {
                if (!(j == 'type' || j == 'jsData')) {
                    if (!firstEnter) {
                        if (!(renderConfigArr[i][j] == data[j])) {
                            //刷新时更新版本
                            if (renderConfigArr[i].type == 'musicBtn') {
                                if (RealEdit.Music.isEnabled()) {
                                    RealEdit.DataManager.updateProConfigVer(renderConfigArr[i].type);
                                }
                            }
                        }
                    }
                    renderConfigArr[i][j] = data[j]; //我之前的深复制还是不够深，都递归了。
                    renderConfigArr[i].exist = true;
                }
            }
        }
    }
    //renderConfig();
}

//配置悬浮预览的逻辑
function hoverPre() {
    $('.pcon-list').on('mouseenter', '.pcon-item-frame', function () {
        for (var i = 0; i < renderConfigArr.length; i++) {
            if (renderConfigArr[i].type == $(this).attr('data-type')) {
                //var conPreItemFinal = conPreItem.replace('$htmlpreview',jsonPre + renderConfigArr[i].html_preview + '?' + timeStamp() + htmlPreWidth);
                var conPreItemFinal = conPreItem.replace('$htmlpreview', _variable.jsonPre + renderConfigArr[i].html_preview + _variable.htmlPreWidth);
                $(this).append(conPreItemFinal);
            }
        }
    });

    $('.pcon-list').on('mouseleave', '.pcon-item-frame', function () {
        $(this).empty();
    });
};
hoverPre();

//渲染配置项目
function renderConfig() {
    for (var i = 0; i < renderConfigArr.length; i++) {
        if (renderConfigArr[i].exist) {
            if (!renderConfigArr[i].hasDeleted) {
                var srcFinal = renderConfigArr[i].str.replace('$img_preview', _variable.jsonPre + renderConfigArr[i].img_preview).replace('$time', (0, _addSource.timeFormat)(renderConfigArr[i].time)).replace('$textName', renderConfigArr[i].name);
                $('.pcon-list').append(srcFinal);
                var isEnable = RealEdit.ProConfig.getEnableByType(renderConfigArr[i].type);

                if (isEnable) {
                    $('.pcon-item[data-type=' + renderConfigArr[i].type + ']').find('.pcon-item-bg').addClass('pcon-item-bg-active');
                } else {
                    $('.pcon-item[data-type=' + renderConfigArr[i].type + ']').find('.pcon-item-bg').removeClass('pcon-item-bg-active');
                }
            }
        }
    }
}

//把删除后的配置页，是否启用改成false
function deleteChangeConfig() {
    var allArr = ['musicBtn', 'background', 'indexLoading', 'shareLayer', 'logoLayer'];
    for (var i = 0; i < $('.pcon-item').length; i++) {
        allArr.splice(allArr.indexOf($($('.pcon-item')[i]).attr('data-type')), 1);
    }

    for (var j = 0; j < allArr.length; j++) {
        //console.log(allArr[j]);
        RealEdit.ProConfig.disabledConfig(allArr[j]);
    }
}

exports.configBtn = configBtn;
exports.proConfigEnableChange = proConfigEnableChange;
exports.clearDeleteArr = clearDeleteArr;
exports.ajaxHandleSrc = ajaxHandleSrc;
exports.deleteChangeConfig = deleteChangeConfig;
exports.ifForbinDefaultMusicLogo = ifForbinDefaultMusicLogo;

//问题
//配置和素材走一个接口，影响我计数。然后，素材多了，配置页找不到。
//编辑页canvas怎么办呢?
},{"./add-source":1,"./tool":15,"./variable":16}],12:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.renderSwiNum = exports.canvansSize = exports.leftSize = exports.renderZero = exports.renderMusic = exports.renderSwi = exports.renderMiddle = exports.renderLeft = exports.renderDrop = exports.renderMusicItem = exports.musicUploadPane = exports.render = undefined;

var _variable = require('./variable');

var _tool = require('./tool');

var _blockInput = require('./block-input');

var _opeMusic = require('./ope-music');

var _pageConfig = require('./page-config');

var upBlockInput = null;
var downBlockInput = null;
function render(arr) {
	var leftArr = arr;
	var leftIndex = RealEdit.selectPageIndex;
	renderLeft(leftArr);

	// var leftIndex = Number($('.page-list-unit:first').find('.page-list-unit-num').text()) - 1;
	// RealEdit.selectPageIndex = leftIndex;

	renderMiddle(leftIndex);

	renderSwi();

	renderMusic();
}
function renderLeft(arr) {
	for (var i = 0; i < arr.length; i++) {
		var leftSrcDom = _variable.leftItem.replace(/\$srcname/g, arr[i].name).replace('$preIcon', _variable.jsonPre + arr[i].iconUrl + '?' + (0, _tool.timeStamp)()).replace('$srcnum', arr[i].index + 1).replace('$srcuid', arr[i].uid);
		$('.page-body-scroll-list').append(leftSrcDom);
	}
	//$('.page-list-unit:first').addClass('page-list-unit-state-click');
	$('.page-list-unit:nth-child(' + (RealEdit.selectPageIndex + 1) + ')').addClass('page-list-unit-state-click');
	leftSize();
	initCover(arr);
}

function leftSize() {
	$('.page-body-scroll-list').css('height', $(window).height() - 74 + 'px');
}

function initCover(arr) {
	for (var i = 0; i < arr.length; i++) {
		if (arr[i].covered) {
			$('.page-list-unit:nth-child(' + (i + 1) + ')').prop('data-coverflag', 'applyflag');
			if (i === 0) {
				$('.view-cover').addClass('view-cover-state-click');
			}
		}
	}
}

function renderMiddle(index) {
	canvansSize();
	RealEdit.selectPageIndex = index;
	console.log('=============jsData:', RealEdit.CjsManager.getPage(index));
	mcjs.Edit.load(RealEdit.CjsManager.getPage(index));
	$('#mcjs').find('canvas').css('width', '100%');
	$('#mcjs').find('canvas').css('height', '100%');
	$('#mcjs').find('canvas').css('top', '0');
}
function canvansSize() {
	$('#mcjs').css('height', ($(window).height() - 36) * 0.82 + 'px');
	$('#mcjs').css('width', ($(window).height() - 36) * 0.82 * (640 / 1008) + 'px');
	$('.view-pad').css('height', ($(window).height() - 36) * 0.09 + 'px');
}

function renderSwiNum() {
	var swi = '.ope-body-swi-';
	$(swi + 'order-text').text($('.page-list-unit-state-click').find('.page-list-unit-num').text());
	//$(swi+'order-text').text(RealEdit.selectPageIndex + 1);
}
function renderSwi() {
	var swi = '.ope-body-swi-';
	renderSwiNum();

	var prevItem = RealEdit.Transform.prevItem;
	renderDrop(swi + 'up-ges-btn-click-text', swi + 'up-ges-list', _variable.gesOption, prevItem.triggert, prevItem.triggertList);
	renderDrop(swi + 'up-eff-btn-click-text', swi + 'up-eff-list', _variable.effOption, prevItem.effect, prevItem.effectList);
	renderDrop(swi + 'up-dir-btn-click-text', swi + 'up-dir-list', _variable.dirOption, prevItem.dir, prevItem.dirList);
	var nextItem = RealEdit.Transform.nextItem;
	renderDrop(swi + 'down-ges-btn-click-text', swi + 'down-ges-list', _variable.gesOption, nextItem.triggert, nextItem.triggertList);
	renderDrop(swi + 'down-eff-btn-click-text', swi + 'down-eff-list', _variable.effOption, nextItem.effect, nextItem.effectList);
	renderDrop(swi + 'down-dir-btn-click-text', swi + 'down-dir-list', _variable.dirOption, nextItem.dir, nextItem.dirList);

	if (upBlockInput) {
		if (prevItem.time === undefined) {
			upBlockInput.time = 0;
		} else {
			upBlockInput.time = prevItem.time;
		}
		upBlockInput.timeMax = prevItem.timeMax;
		upBlockInput.timeMin = prevItem.timeMin;
		upBlockInput.changeInit();
	} else {
		upBlockInput = new _blockInput.blockInput($(swi + 'up-time'), prevItem.time, prevItem.timeMax, prevItem.timeMin, '', function () {
			RealEdit.Transform.prevItem.time = Number($('.ope-body-swi-up-time .ope-base-time-input').val().replace('秒', ''));
		});
		upBlockInput.init();
	}

	if (downBlockInput) {
		if (nextItem.time === undefined) {
			downBlockInput.time = 0;
		} else {
			downBlockInput.time = nextItem.time;
		}
		downBlockInput.timeMax = nextItem.timeMax;
		downBlockInput.timeMin = nextItem.timeMin;
		downBlockInput.changeInit();
	} else {
		downBlockInput = new _blockInput.blockInput($(swi + 'down-time'), nextItem.time, nextItem.timeMax, nextItem.timeMin, '', function () {
			RealEdit.Transform.nextItem.time = Number($('.ope-body-swi-down-time .ope-base-time-input').val().replace('秒', ''));
		});
		downBlockInput.init();
	}
}
function renderMusic() {
	var music = '.ope-body-music-';
	musicDoor(music);

	var musicItem = RealEdit.Music;
	renderDrop(music + 'pos-text', music + 'pos-menu', _variable.musicPosOption, musicItem.position, musicItem.positionList);
	var myMusicList = RealEdit.Music.myList;
	musicUploadPane(music, myMusicList);
	renderMusicItem(music + 'program', _variable.musicListOption, myMusicList);
	(0, _opeMusic.musicUploadLimit)();
	var sysMusicList = RealEdit.Music.systemList;
	renderMusicItem(music + 'off', _variable.musicListOption, sysMusicList);
	musicChoosePane(music);
}
function renderDrop(titleclass, listclass, listdom, itemtitle, itemlist) {
	if (itemtitle === -1 || itemtitle === undefined) {
		$(titleclass).text('无');
	} else {
		$(titleclass).text(RealEdit.getObjByUID(itemtitle).txt);
	}
	$(listclass).empty();
	for (var i = 0; i < itemlist.length; i++) {
		var listDomFinal = listdom.replace('$key', itemlist[i].key).replace('$uid', itemlist[i].uid).replace('$txt', itemlist[i].txt);
		$(listclass).append(listDomFinal);
	}
}
function musicDoor(music) {
	var door = RealEdit.Music.isEnabled();

	console.log(door);

	if (door) {
		// if(RealEdit.Music.position === -1){
		//
		// } else {
		// 	mcjs.DOMInterface.showMusicBtn(RealEdit.getObjByUID(RealEdit.Music.position).key);
		// }
		$(music + 'pos-btn').prop('disabled', null);
		$(music + 'state' + ' button').removeClass('ope-base-btn2-box-click');
		$(music + 'open').addClass('ope-base-btn2-box-click');
	} else {
		// mcjs.DOMInterface.hideMusicBtn();
		//  	$(music+'pos-btn').prop('disabled','disabled');
		$(music + 'state' + ' button').removeClass('ope-base-btn2-box-click');
		$(music + 'close').addClass('ope-base-btn2-box-click');
	}
	(0, _pageConfig.ifForbinDefaultMusicLogo)();
}

function musicUploadPane(music, list) {
	if (list.length === 0) {
		$(music + 'add').addClass('ope-body-music-add-state-big');
	} else {
		$(music + 'add').removeClass('ope-body-music-add-state-big');
	}
}

function renderMusicItem(menuclass, listdom, list, clearList) {
	if (arguments.length === 3) {
		$(menuclass).empty();
	}
	var sizeKb, sizeMb, sizeFormat;
	for (var i = 0; i < list.length; i++) {
		sizeKb = Math.round(list[i].size / 1024 * 10) / 10;
		sizeMb = Math.round(list[i].size / (1024 * 1024) * 10) / 10;
		if (sizeMb > 1) {
			sizeFormat = sizeMb + 'MB';
		} else {
			sizeFormat = sizeKb + 'KB';
		}
		var listDomFinal = listdom.replace('$size', sizeFormat).replace(/\$txt/g, (list[i].txt ? list[i].txt : list[i].name).replace(/\.mp3$/, '')).replace('$uid', list[i].uid).replace('$url', list[i].url);
		$(menuclass).append(listDomFinal);
	}
}

function musicChoosePane(music) {
	var musicSelect = RealEdit.Music.selectMusic;
	if (musicSelect === -1 || musicSelect === undefined) {
		$(music + 'choose').addClass('ope-body-music-choose-state-no');
	} else {
		$('.ope-body-music-item[data-uid = ' + musicSelect + ']').addClass('ope-body-music-item-state-choose');
		$(music + 'choose').removeClass('ope-body-music-choose-state-no');
		var musicItemForName = RealEdit.getObjByUID(musicSelect);
		var musicItemName = musicItemForName.txt.replace(/\.mp3$/, '');
		$(music + 'choose' + ' > span:nth-child(2)').text(musicItemName);
	}
}

function renderZero() {
	var swi = '.ope-body-swi-';
	$(swi + 'order-text').text('--');
	$(swi + 'up-ges-btn-click-text').text('无');
	$(swi + 'up-ges-list').empty();
	$(swi + 'up-eff-btn-click-text').text('无');
	$(swi + 'up-eff-list').empty();
	$(swi + 'up-dir-btn-click-text').text('无');
	$(swi + 'up-dir-list').empty();
	upBlockInput.time = 0;
	upBlockInput.changeInit();
	$(swi + 'down-ges-btn-click-text').text('无');
	$(swi + 'down-ges-list').empty();
	$(swi + 'down-eff-btn-click-text').text('无');
	$(swi + 'down-eff-list').empty();
	$(swi + 'down-dir-btn-click-text').text('无');
	$(swi + 'down-dir-list').empty();
	downBlockInput.time = 0;
	downBlockInput.changeInit();

	var music = '.ope-body-music-';
	$(music + 'pos-text').text('无');
	$(music + 'pos-menu').empty();
	$(music + 'pos-btn').prop('disabled', 'disabled');
	$(music + 'state' + ' button').removeClass('ope-base-btn2-box-click');
	$(music + 'close').addClass('ope-base-btn2-box-click');
	mcjs.DOMInterface.hideMusicBtn();
}

exports.render = render;
exports.musicUploadPane = musicUploadPane;
exports.renderMusicItem = renderMusicItem;
exports.renderDrop = renderDrop;
exports.renderLeft = renderLeft;
exports.renderMiddle = renderMiddle;
exports.renderSwi = renderSwi;
exports.renderMusic = renderMusic;
exports.renderZero = renderZero;
exports.leftSize = leftSize;
exports.canvansSize = canvansSize;
exports.renderSwiNum = renderSwiNum;
},{"./block-input":2,"./ope-music":9,"./page-config":11,"./tool":15,"./variable":16}],13:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
exports.resizeFun = undefined;

var _render = require('./render');

var _leftList = require('./left-list');

var _scrollbar = require('./scrollbar');

function resizeFun() {
	$(window).resize(function () {
		(0, _render.canvansSize)();
		(0, _render.leftSize)();
		(0, _scrollbar.newDomRefresh)();
		(0, _scrollbar.correctScrollBarPosition)();
		(0, _scrollbar.canScroll)();
	});
}

exports.resizeFun = resizeFun;
},{"./left-list":7,"./render":12,"./scrollbar":14}],14:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
var scrollBarMaxLimit = $('.page-body-scroll-list').height() - $('.page-body-scroll-bar').height(); //滚动条的top范围
var contentMoveTotel = $('.page-list-unit').length * $('.page-list-unit').outerHeight() - $('.page-body-scroll-list').height(); //内容的移动范围
var mouseWheelUnit = 30; //滚轮滑动滚动条移动的最,这个的话，最好项目多的时候就让他快些。
var scrollRatio = contentMoveTotel / scrollBarMaxLimit;
var mousePositionY1, //鼠标按下时clientY的值
mousePositionY2, //鼠标移动时clientY的值
mouseMoveDistance, //鼠标移动的距离
scrollPositionStart; //拖动滚动条时，滚动条的起始
var canScrollDoor;
var scrollBarPosition; //滚动条top占容器高的比例

function scrollbar() {
	newDomRefresh(); //在列表的高在动态赋值之后，才能计算比例。
	canScroll();
	correctScrollBarPosition();
	mouseWheelEvent();
	scrollMoveEvent();
}

function mouseWheelEvent() {
	$('.page-body-scroll-list').on('mousewheel DOMMouseScroll', function (e) {
		e.stopPropagation();
		e.preventDefault();
		var mouseWheelDirection;
		if (e.type === 'mousewheel') {
			mouseWheelDirection = e.originalEvent.wheelDelta;
		} else {
			mouseWheelDirection = -e.originalEvent.detail;
		}
		if (canScrollDoor) {
			if (mouseWheelDirection < 0) {
				$('.page-body-scroll-bar').css('top', Number($('.page-body-scroll-bar').css('top').replace('px', '')) + mouseWheelUnit <= scrollBarMaxLimit ? Number($('.page-body-scroll-bar').css('top').replace('px', '')) + mouseWheelUnit + 'px' : scrollBarMaxLimit + 'px');
				contentScroll();
			} else {
				$('.page-body-scroll-bar').css('top', 0 <= Number($('.page-body-scroll-bar').css('top').replace('px', '')) - mouseWheelUnit ? Number($('.page-body-scroll-bar').css('top').replace('px', '')) + -mouseWheelUnit + 'px' : 0 + 'px');
				contentScroll();
			}
		}
		rememberScrollBarPosition();
	});
}

function scrollMoveEvent() {
	$('.page-body-scroll-bar').on('mousedown', function (e) {
		e.preventDefault();
		$('.box').addClass('user-select');
		textSelectedBug();
		mousePositionY1 = e.clientY;
		scrollPositionStart = Number($('.page-body-scroll-bar').css('top').replace('px', ''));
		$('body').on('mousemove', scrollBarMove);
	});
	$(window).on('mouseup', function (e) {
		$('.box').removeClass('user-select');
		$('body').off('mousemove');
	});
}

//滚动条移动函数
function scrollBarMove(e) {
	mousePositionY2 = e.clientY;
	mouseMoveDistance = mousePositionY2 - mousePositionY1; //初始点 + 移动距离 --> 新的位置;初始点应该是滚动条的top不是位置1
	if (scrollPositionStart + mouseMoveDistance <= scrollBarMaxLimit && 0 <= scrollPositionStart + mouseMoveDistance) {
		$('.page-body-scroll-bar').css('top', scrollPositionStart + mouseMoveDistance + 'px');
		contentScroll();
	} else if (scrollPositionStart + mouseMoveDistance > scrollBarMaxLimit) {
		//先检查，后赋值，防止乱跳。但是滑动幅度大的话，就没有赋值。到不了头
		$('.page-body-scroll-bar').css('top', scrollBarMaxLimit + 'px');
		contentScroll();
	} else {
		$('.page-body-scroll-bar').css('top', 0 + 'px');
		contentScroll();
	}
	rememberScrollBarPosition();
}
//内容滚动的函数
function contentScroll() {
	$('.page-list-unit:first-of-type').css('marginTop', -Number($('.page-body-scroll-bar').css('top').replace('px', '')) * scrollRatio + 'px');
}

//新进入时，导入的时候，复制dom或删除dom的时候，有些需要刷新。缩放的时候
function newDomRefresh() {
	scrollBarMaxLimit = $('.page-body-scroll-list').height() - $('.page-body-scroll-bar').height();
	contentMoveTotel = $('.page-list-unit').length * $('.page-list-unit').outerHeight() - $('.page-body-scroll-list').height();
	scrollRatio = contentMoveTotel / scrollBarMaxLimit;
}

//何时显示滚动条的函数
function canScroll() {
	if ($('.page-list-unit').length * $('.page-list-unit').outerHeight() - $('.page-body-scroll-list').height() > 0) {
		canScrollDoor = true;
		$('.page-body-scroll-bar').show();
	} else {
		canScrollDoor = false;
		$('.page-body-scroll-bar').hide();
		$('.page-list-unit:first-of-type').css('marginTop', 0);
	}
}

//滚动或滑动的时候，保存滚动条top占容器高的比例
function rememberScrollBarPosition() {
	scrollBarPosition = Number($('.page-body-scroll-bar').css('top').replace('px', '')) / ($('.page-body-scroll-list').height() - $('.page-body-scroll-bar').height());
}

//窗口缩放的时候，纠正滚动条位置，然后纠正内容位置。
function correctScrollBarPosition() {
	$('.page-body-scroll-bar').css('top', scrollBarPosition * ($('.page-body-scroll-list').height() - $('.page-body-scroll-bar').height()) + 'px');
	contentScroll();
}

//添加新的项目，或者删除的时候改变滚动条位置
function itemChange() {
	if ($('.page-list-unit:first-of-type').css('marginTop')) {
		$('.page-body-scroll-bar').css('top', -Number($('.page-list-unit:first-of-type').css('marginTop').replace('px', '')) / scrollRatio + 'px');
	}
}

//修正删除时候的bug

function deleteItemBug() {
	if ($('.page-list-unit').outerHeight()) {
		var diff = $('.page-body-scroll-list').height() - ($('.page-list-unit').length * $('.page-list-unit').outerHeight() + Number($('.page-list-unit:first-of-type').css('marginTop').replace('px', '')));
		if (diff > 0 && canScrollDoor) {
			$('.page-list-unit:first-of-type').css('marginTop', Number($('.page-list-unit:first-of-type').css('marginTop').replace('px', '')) + diff + 'px');
			$('.page-body-scroll-bar').css('top', $('.page-body-scroll-list').height() - $('.page-body-scroll-bar').height() + 'px');
		}
	}
}

//修正选择文本之后拖动不能选中的bug
function textSelectedBug() {
	if (window.hasOwnProperty('getSelection')) {
		window.getSelection().removeAllRanges();
	} else if (document.body.hasOwnProperty('createTextRange')) {
		var rng = document.body.createTextRange();
		rng.collapse(true);
		rng.select();
	}
}

exports.scrollbar = scrollbar;
exports.correctScrollBarPosition = correctScrollBarPosition;
exports.newDomRefresh = newDomRefresh;
exports.canScroll = canScroll;
exports.itemChange = itemChange;
exports.rememberScrollBarPosition = rememberScrollBarPosition;
exports.deleteItemBug = deleteItemBug;
},{}],15:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
function getToken(locHref) {
	var token;
	if (locHref.split('?')[1].indexOf('#') === -1) {
		token = locHref.split('?')[1];
	} else {
		token = locHref.split('?')[1].substring(0, locHref.split('?')[1].indexOf('#'));
	}
	return token;
}

function tokenToShort(token) {
	var shortToken;
	shortToken = token.replace('token=', '');
	return shortToken;
}

function opeUrl(proUrl, locHref) {
	var token;
	if (locHref.split('?')[1].indexOf('#') === -1) {
		token = locHref.split('?')[1];
	} else {
		token = locHref.split('?')[1].substring(0, locHref.split('?')[1].indexOf('#'));
	}
	return proUrl + token;
}

function timeStamp() {
	var timestamp = Date.parse(new Date());
	timestamp = String(timestamp);
	timestamp = timestamp.substring(0, timestamp.length - 3);
	return timestamp;
}

function baseDrop(menu, choose, cb) {
	$(menu).on('click', 'li', function () {
		$(choose).text($(this).find('a').text());
		var uid = $(this).find('a').attr('data-uid');
		cb(uid);
	});
}

function slideBlock(text, backgroundImgDoor) {
	if (window.editor.slideBlockDoor) {
		if (arguments.length === 1) {
			$('.slide-block').removeClass('slide-block-false');
		} else if (arguments.length === 2) {
			if (backgroundImgDoor === true) {
				$('.slide-block').removeClass('slide-block-false');
			} else {
				$('.slide-block').addClass('slide-block-false');
			}
		}

		$('.slide-block').html(text);
		$('.slide-block').css('left', (($(window).width() - $('.slide-block').width()) / 2 | 0) + 'px');
		window.editor.slideBlockDoor = false;
		$('.slide-block').removeClass('slide-block-state1 slide-block-state2').addClass('slide-block-state1');
		setTimeout(function () {
			$('.slide-block').removeClass('slide-block-state1 slide-block-state2').addClass('slide-block-state2');
			window.editor.slideBlockDoor = true;
		}, 1300);
	}
}

var canvasAttr = {
	'style': 'background-color:#fff',
	'data-entry-class': 'Main',
	'data-orientation': 'portrait',
	'data-scale-mode': 'noBorder',
	'data-resolution-mode': 'retina',
	'data-frame-rate': '30',
	'data-content-width': '640',
	'data-content-height': '1008',
	'data-show-paint-rect': 'false',
	'data-multi-fingered': '2',
	'data-show-fps': 'false',
	'data-show-log': 'false',
	'data-log-filter': '',
	'data-show-fps-style': 'x:0,y:0,size:20'
};

function canvasReady() {
	for (var item in canvasAttr) {
		$('#mcjs').attr(item, canvasAttr[item]);
	}
}

exports.getToken = getToken;
exports.tokenToShort = tokenToShort;
exports.opeUrl = opeUrl;
exports.baseDrop = baseDrop;
exports.canvasReady = canvasReady;
exports.slideBlock = slideBlock;
exports.timeStamp = timeStamp;
},{}],16:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
    value: true
});
window.editor = {};
window.editor.spacePageDoor = false; //没办法
window.editor.musicUploadDoor; //是否可以上传音乐
window.editor.coverNeedIndex; //设为封面的参数
window.editor.coverChangeDoor = true; //是否可以更换封面
window.editor.slideBlockDoor = true; //是否显示小滑块的逻辑
window.editor.cloudDoor = true; //共享云开关的状态
window.editor.needGuide = false; //指导层相关
window.editor.enterConfigPage = false; //是否进入配置页
window.editor.checkUpdate = function () {
    console.log('20177191634');
};
var jsonPre = 'http://preview.realplus.cc/';
//var leftItem = '<li class="page-list-unit clearfix" data-srcname="$srcname"><span class="page-list-unit-num">$srcnum</span><div class="page-list-unit-show"><img class="page-list-unit-show-img img-responsive" src="$preIcon"/><p class="page-list-unit-show-name">$srcname</p></div><div class="page-list-unit-btn clearfix"><button class="page-list-btn-delete"></button><button class="page-list-btn-copy"></button></div></li>';
var leftItem = '<li class="page-list-unit clearfix" data-srcname="$srcname" data-uid="$srcuid"><span class="page-list-unit-num">$srcnum</span><div class="page-list-unit-show"><img class="page-list-unit-show-img img-responsive" src="$preIcon"/><p class="page-list-unit-show-name">$srcname</p></div><div class="page-list-unit-btn clearfix"><button class="page-list-btn-delete"></button></div></li>';
var gesOption = '<li><a href="#" data-key="$key" data-uid="$uid">$txt</a></li>';
var effOption = '<li><a href="#" data-dir="$dir" data-uid="$uid">$txt</a></li>';
var dirOption = '<li><a href="#" data-uid="$uid">$txt</a></li>';
var musicPosOption = '<li><a href="javascript:;" data-uid="$uid">$txt</a></li>';
var eleOpeTriOption = '<li><a href="javascript:;" data-uid="$uid">$txt</a></li>';
var musicListOption = '<li class="ope-body-music-item" data-uid="$uid" data-url="$url"><p class="ope-body-music-item-back"></p><p class="ope-body-music-item-front clearfix"><button class="ope-body-music-item-choose"></button><span class="ope-body-music-item-name" title="$txt">$txt</span><span class="ope-body-music-item-size">$size</span><button class="ope-body-music-item-delete"></button></p></li>';
var srcItem = '<div class="source-item" data-srcname="$srcname" data-srcid="$srcid"><div class="source-item-border"></div><div class="source-item-choose"></div><div class="source-item-box clearfix"><img class="source-item-img" src="$imgPreview"/><div class="source-item-text"><p class="source-item-name">$srcname</p><p class="source-item-time">$srctime</p></div></div><div class="source-item-frame"></div></div>';
var srcPreItem = '<iframe scrolling="no" class="source-item-iframe-tag" src="$htmlpreview"></iframe>';
var htmlPreWidth = "&width=232";
var previewIframe = '<iframe scrolling="no" name="preview" class="alert2-view-iframe" src="$htmlpreview"></iframe>';
exports.jsonPre = jsonPre;
exports.leftItem = leftItem;
exports.gesOption = gesOption;
exports.effOption = effOption;
exports.dirOption = dirOption;
exports.musicPosOption = musicPosOption;
exports.musicListOption = musicListOption;
exports.srcItem = srcItem;
exports.srcPreItem = srcPreItem;
exports.htmlPreWidth = htmlPreWidth;
exports.previewIframe = previewIframe;
exports.eleOpeTriOption = eleOpeTriOption;
},{}]},{},[4])