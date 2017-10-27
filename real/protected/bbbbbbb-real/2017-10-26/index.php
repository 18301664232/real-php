<link rel="stylesheet" href="<?php echo STATICS ?>css/flow_page.css">
<script src="<?php echo STATICS ?>js/echarts.min.js"></script>
<script src="<?php echo STATICS ?>js/flow_page.js"></script>
<section class="flow-header clearfix">
    <div>
        <h1>财务管理</h1>
        <nav class="nav">
            <ul class="clearfix">
                <li class="active">流量详情</li>
                <!--                    <li>发票管理</li>
                                    <li>合同管理</li>
                                    <li>代金券管理</li>-->
            </ul>
        </nav>
    </div>
</section>
<section class="flow-main">
    <ul class="flow-tab nav nav-tabs">
        <li class="active">流量总览</li>
        <li>流量明细</li>
    </ul>
    <section class="flow-content">
        <!-- 流量总览 -->
        <section class="flow-total active">
            <div class="set-control clearfix">
                <div class="control-left cleafix">
                    <div class="checkbox-box clearfix">
                        <input type="checkbox" id="flowFlag" <?php if ($status == 'open'): ?> checked="checked"<?php endif; ?> >
                        <label class="flow-flag" for="flowFlag"><span>flowFlag</span></label>
                    </div>
                    <p>可用流量剩余预警
                        <span>（<i class="cishu-icon"><b class="cishu-word"></b></i>设置阈值低于
                            <span class="tip-num">
                                <em><b><?php echo $nub ?></b>
                                    <input type="hidden" id="tipNum"/>G
                                </em>
                            </span>提醒）
                        </span>
                    </p>
                    <div class="btn-area">
                        <a href="javascript:void(0)" class="modify">修改</a>
                        <div class="saveOrCancel">
                            <a href="javascript:void(0)" class="cancel-btn">取消</a>
                            <span style="color:#ccc;margin:0px 3px">|</span>
                            <a href="javascript:void(0)" class="save-btn">保存</a>
                        </div>
                    </div>
                    <p class="tip-word">只能输入1-3位整数且不为0</p>
                </div>
                <div class=control-right>
                    <a href="<?php echo U('finance/pay/select') ?>">购买流量包>></a>
                </div>
            </div>
            <ul class="flow-item-list">
                <?php foreach ($data as $k => $v): ?>
                    <?php if ($v['status'] == 'use'): ?>
                        <li class="flow-on clearfix">
                        <?php elseif ($v['status'] == 'after'): ?>
                        <li class="flow-expire clearfix">
                        <?php elseif ($v['status'] == 'over'): ?>
                        <li class=" flow-off clearfix">
                        <?php endif; ?>
                        <div class="flow-item-left">
                            <h3><?php echo $v['name'] ?></h3>
                            <p>有效期：<span><?php echo date('Y.m.d', $v['addtime']) ?></span>~<span><?php echo date('Y.m.d', $v['addtime'] + $v['timespan'] * 3600 * 24) ?></span></p>
                            <div class="flows-shengyu">
                                <span class="title">剩余流量</span>
                                <div class="flow-progress clearfix">
                                    <div class="progress"><?php echo number_format(($v['water'] / (1024 * 1024 * 1024)), 2, '.', '') ?></div>
                                    <div class="flow-num-box">
                                        <span class="flow-num"><?php echo number_format(($v['water'] - $v['use_water']) / (1024 * 1024 * 1024), 2, '.', '') ?></span>G
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flow-item-right">
                            <div class="flow-status flow-on"></div>
                            <div class="flow-cycle text-center">
                                剩余天数<span><?php echo ceil(($v['addtime'] + $v['timespan'] * 3600 * 24 - time()) / (24 * 3600)) ?></span>天
                            </div>
                        </div>
                    </li>
                <?php endforeach; ?>

            </ul>
        </section>
        <!-- 流量明细 -->
        <section class="flow-detail clearfix">
            <div class="detail-left">
                <div class="final-flow">
                    <p>
                        付费流量总消耗：<span><?php echo $water_all?></span>
                    </p>
                </div> 
                <div class="detail-search-box">
                    
               
                <div class='detail-search'>
                    <input type="text" class=""  value ='' placeholder="输入关键字">
                    <a href="javascript:void(0)" class="search-btn"></a>
                </div>
                    <div class="search-list-box">
                <ul class="search-list">

                </ul>
                    </div>
                     </div> 
            </div>
            <div class="detail-right">
                <div class="echart-category">
                    <a str="today" class="active">今日</a>
                    <a href="javascript:void(0)" str="ttoday">昨日</a>
                    <a href="javascript:void(0)" str="t7today">近7日</a>
                    <a href="javascript:void(0)" str="t30today">近30日</a>
                </div>
                <div class="select-area clearfix">
                    <p class="title">时间筛选：</p>
                    <div class="select-date clearfix">
                        <span class="rhDataConTabTimeSelect" id="rhDataConChannelTimeSelect"><input class="rhDataConTabTimeFrom" id="rhDataConChannelTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo" id="rhDataConChannelTimeTo" size="20" value=""></span>
                    </div>
                    <button class="btn btn-primary">搜索</button>
                </div>
                <div class="flow-info clearfix">
                    <div class="info-title">
                        <h3></h3>
                        <p>
<!--                            <span>时间：<em></em></span>-->
                            <span>项目ID：<em id="superid"></em></span>
                        </p>
                    </div>
                    <div class="info-flow">
                        <h3>付费流量总消耗<em id="superwater"></em></h3>
<!--                        <p>上线<span>45</span>天</p>-->
                    </div>
                </div>
                <!-- echear -->
                <div id="echart" style="height:420px">
                </div>
            </div>
        </section>
    </section>
</section>

<script>
    $(function () {
        var count = <?php echo $count ?>;
        if (count >= 5) {
            // $('#flowFlag').prop('checked',false);
            $('#flowFlag').prop('disabled', 'disabled');
            $('.modify').removeClass('active');
            $('.modify').unbind();
        }
        $('.flow-flag').on('click', function () {
            if (count < 5) {
                $.ajax({
                    type: "POST",
                    url: '<?php echo U('finance/water/editstatus') ?>',
                    data: {
                    },
                    dataType: "json",
                    success: function (data) {
                    }
                });
            }

        });

        //剩余流量总量
        var surplus = 0;
        $('.flow-on').each(function () {
            surplus += Number($(this).find('.flow-num').text());
        })

        $('.saveOrCancel .save-btn').on('click', function () {
            var t = $(this);
            var nub = $('#tipNum').val();
            //设置流量预警验证纯数字
            var flowReg = /^([1-9])([0-9]?)([0-9]?)$/;
            if (!flowReg.test(nub)) {
                $('.tip-word').addClass('active').text('只能输入1-3位整数且不能为0');
                return;
            } else if (Number(nub) > surplus) {
                $('.tip-word').addClass('active').text('阈值只可小于当前剩余流量');
                return;
            }

            $.ajax({
                type: "POST",
                url: '<?php echo U('finance/water/editnub') ?>',
                data: {
                    'nub': nub
                },
                dataType: "json",
                success: function (data) {
                    if (data.code == 0) {
                        wtSlideBlock('修改成功');
                        saveOrCancelBtn(t, 'save');
                    } else {
                        wtSlideBlock(data.msg, true);
                    }

                }
            });

        });



        // 点击查询
        $('.search-btn').on('click', function () {
            var keyword = $('.detail-search').find('input').val();
            $.ajax({
                type: "POST",
                url: '<?php echo U('product/product/ajax') ?>',
                data: {
                    page: 1,
                    pagesize: 999,
                    keyword: keyword
                },
                async: false,
                dataType: "json",
                success: function (data) {
                    var nr = '';
                    if (data.code == '0' && data.result != '') {
                        for (var key in data.result.data) {
                            if (data.result.data[key].online != 'empty') {
                                if (key == 0) {
                                    nr += ' <li class="active" pid=' + data.result.data[key].product_id + '>';
                                } else {
                                    nr += ' <li pid=' + data.result.data[key].product_id + '>';
                                }
                                nr += '<p>' + data.result.data[key].title + '</p>';
                                nr += '<p>' + getLocalTime(data.result.data[key].addtime) + '-创建</p>';
                                nr += '</li>';
                            }
                        }

                    }
                    var product_id = data.result.data[0].product_id;
                    detail(product_id, 'today');
                    $('.search-list').html(nr);
                }
            });
        })

        //echart
        //流量总览和流量详情切换
        $('.flow-tab li').click(function () {
            var index = $(this).index();
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
            $('.flow-content section').removeClass('active');
            $('.flow-content section').eq(index).addClass('active');

            //显示可视化视图
            if ($('.flow-detail').hasClass('active')) {
                if ($('#echart').children().length <= 0) {
                    //加载流量明细列表
                    $('.search-btn').click();
                    // var product_id = $(".search-list li[class*='active']").attr('pid');
                    //  detail(product_id, 'today');
                }
            }
        })


        function getLocalTime(nS) {
            return new Date(parseInt(nS) * 1000).toLocaleDateString();
        }

        //流量明细做侧边栏切换 

        $('.search-list').on('click', 'li', function () {
            if (!$(this).hasClass('active')) {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            }
            //获取id
            var product_id = $(this).attr('pid');
            var type = $(".echart-category a[class*='active']").attr('str');

            detail(product_id, type);

        })
        //时间
        $('.echart-category a').click(function () {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            var product_id = $("#superid").html();
            var type = $(".echart-category a[class*='active']").attr('str');
            detail(product_id, type);
        })

        //数据弹出框日期选择插件
        $('#rhDataConChannelTimeSelect').dateRangePicker({
            maxDays: 30,
            separator: ' - ',
            autoClose: true,
            getValue: function () {
                if ($('#rhDataConChannelTimeFrom').val() && $('#rhDataConChannelTimeTo').val())
                    return $('#rhDataConChannelTimeFrom').val() + ' - ' + $('#rhDataConChannelTimeTo').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2) {
                $('#rhDataConChannelTimeFrom').val(s1);
                $('#rhDataConChannelTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function () {

        });

        $('.btn-primary').on('click', function () {
            var starttime = $('#rhDataConChannelTimeFrom').val();
            var endtime = $('#rhDataConChannelTimeTo').val();
            var product_id = $("#superid").html();
            detail(product_id, '', starttime, endtime);

        })



  /**
     * [showEchart description] echart图表配置
     * @param  {[type]} arrX [横轴显示]
     * @param  {[type]} arrY [数轴显示]
     * @return {[type]}      [description]
     */
function showEchart(arrX, arrY, arrY2) {
    var myChart = echarts.init(document.getElementById('echart'), 'roma');
    var option = {
        tooltip: {
            show: true,
            trigger: 'axis',
            axisPointer: { // 坐标轴指示器，坐标轴触发有效
                type: 'shadow', // 默认为直线，可选为：'line' | 'shadow'
            },
            formatter: function(datas) {
                var res = datas[0].name + '<br/>',
                    val;
                for (var i = 0, length = datas.length; i < length; i++) {
                        if(typeof(datas[i].value)=='number'){
                            if (datas[i].value >= 1000 && datas[i].value < 1000000) {
                                datas[i].value = datas[i].value / 1000 + 'GB'
                            } else if (datas[i].value >= 1000000) {
                                datas[i].value = datas[i].value / 1000000 + 'TB';
                            } else {
                                datas[i].value = datas[i].value + 'MB';
                            }
                            val = datas[i].value
                        }else{
                            val = 0;
                        }
                        
                        res += datas[i].seriesName + '：' + val + '<br/>';
               
                }
                return res;
            }
        },
        toolbox: {
            show: true,
            feature: {
                mark: {
                    show: true
                },
                dataView: {
                    show: false
                },
                magicType: {
                    show: true,
                    type: ['line', 'bar']
                },
                restore: {
                    show: true
                },
                saveAsImage: {
                    show: false
                },
            }
        },
        legend: {
            data: ['免费流量', '付费流量'],
            left: 'center',
        },
        xAxis: [{
            type: 'category',
            data: arrX,
            nameGap: '20',
            nameTextStyle: {
                color: '#286090',
                fontWeight: 200,
                fontSize: 12,
            }
        }],
        // dataZoom: {
        //     type: 'inside'
        // },
        yAxis: [{
            type: 'value',
            nameGap: '20',
            min: 0,
            nameTextStyle: {
                color: '#286090',
                fontWeight: 200,
                fontSize: 12,
            },
            axisLabel: {
                formatter: function(value) {
                    if(value>0){
                        if (value >= 1000 && value < 1000000) {
                            value = value / 1000 + 'GB'
                        } else if (value >= 1000000) {
                            value = value / 1000000 + 'TB';
                        } else {
                            value = value + 'MB';
                        }
                        return value;
                    }
                }
            }
        }],
        series: [{
            "name": "免费流量",
            "type": "bar",
            "data": arrY,
            "barWidth": '40%',
            "barMinHeight": '2',
            lineWidth: "10%",
            itemStyle: {
                normal: {
                    color: '#395999',
                    lineStyle: {
                        color: '#395999'
                    }
                }
            }
        }, {
            "name": "付费流量",
            "type": "bar",
            "data": arrY2,
            "barWidth": '40%',
            "barMinHeight": '2',
            lineWidth: "10%",
            itemStyle: {
                normal: {
                    color: '#4bc74e',
                    lineStyle: {
                        color: '#4bc74e'
                    }
                }
            }
        }]
    };

    // 为echarts对象加载数据 
    myChart.setOption(option);
}

function arrConvers(arr){
    return arr.map(function(value){
        if (value==0) {
            value = 0;
        }
        return value;
    })
}


        function detail(product_id, type = 'today', starttime = '', endtime = '') {
            $.ajax({
                type: "POST",
                url: '<?php echo U('finance/water/detail') ?>',
                data: {
                    product_id: product_id,
                    type: type,
                    starttime: starttime,
                    endtime: endtime
                },
                async: false,
                dataType: "json",
                success: function (data) {
                    var n_pay = arrConvers(data.result.n_pay);
                    var y_pay = arrConvers(data.result.y_pay);
                    showEchart(data.result.time, n_pay, y_pay);
                    $("#superid").html(product_id);
                    $("#superwater").html(data.result.total);
                }

            })

        }


    })
</script>