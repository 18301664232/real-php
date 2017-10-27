$(function() {

        // //显示可视化视图
        // if ($('#echart').children().length <= 0) {
        //     //流量初始化ajax
        //     //echartFlow('today');
        //     //这个是例子
        //     var arr = [
        //         ['2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10','2017-10-10', 2, 3, 4, 5, 6, 5, , 6, 4, 5, 6, 6, 4, 5, 6],
        //         [10000, 9000, 10, 0.05, 2000, 0, 1, 0, 0, 0, 1, 0, 0,0, 1, 0, 0,0, 1, 0, 0,0, 1, 0, 0,0, 1, 0, 0,0, 1, 0, 0,0, 1, 0, 0,0, 0, 0, 100],
        //         [8000, 1000, 200, 1000, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1000],
        //         [7000, 100, 200, 300, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 650, 1000]
        //     ];
        //     var arrX = arr[0];
        //     var arrY = arr[1];
        //     var arrY2 = arr[2];
        //     var arrY3 = arr[3];
        //     arrY = arrConvers(arrY);
        //     arrY2 = arrConvers(arrY2);
        //     arrY3 = arrConvers(arrY3);
        //     showEchart(arrX, arrY, arrY2, arrY3);
        // }
        //echart
        var search_type = 'flow';
    var search_time_type = 'now';

        //搜索
        $('.self-search-btn').click(function () {
            echartFlow('myself' ,search_type,$('.input-one').val(),$('.input-two').val())

        })



        //流量总览和流量详情切换
        $('.flow-tab li').click(function() {
            $('.echart-category a').eq(0).addClass('active').siblings().removeClass('active');
            var index = $(this).index();
            $(this).addClass('active');
            $(this).siblings().removeClass('active');
                if(index == 0){
                  search_type = 'flow';
                    echartFlow('now','flow');
                }
                if(index == 1){
                    search_type = 'user';
                    echartFlow('now','user');
                }
                if(index == 2){
                    search_type = 'product';
                    echartFlow('now','product');
                }
        })


        //点击切换查询条件
        var arrDate = ['now', 'prev', 'prev_seven', 'prev_thirty'];
        $('.echart-category a').click(function() {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
            search_time_type = arrDate[$(this).index()];
            //请求对应流量
            echartFlow(arrDate[$(this).index()],search_type);
        })


        //数据弹出框日期选择插件
        $('#rhDataConChannelTimeSelect').dateRangePicker({
            maxDays: 30,
            separator: ' - ',
            autoClose: true,
            getValue: function() {
                if ($('#rhDataConChannelTimeFrom').val() && $('#rhDataConChannelTimeTo').val())
                    return $('#rhDataConChannelTimeFrom').val() + ' - ' + $('#rhDataConChannelTimeTo').val();
                else
                    return '';
            },
            setValue: function(s, s1, s2) {
                $('#rhDataConChannelTimeFrom').val(s1);
                $('#rhDataConChannelTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function() {
            console.log($('#rhDataConChannelTimeFrom').val() + ' to ' + $('#rhDataConChannelTimeTo').val());
        });
    })
    /**
     * [showEchart description] echart图表配置
     * @param  {[type]} arrX [横轴显示]
     * @param  {[type]} arrY [数轴显示]
     * @return {[type]}      [description]
     */

function showEchart(arrX, arrY, arrY2, arrY3,Xstr_arr,Xstr) {
    var myChart = echarts.init(document.getElementById('echart'), 'roma');
    var option = {
        tooltip: {
            show: true,
            trigger: 'axis',
            axisPointer: { // 坐标轴指示器，坐标轴触发有效
                type: 'shadow', // 默认为直线，可选为：'line' | 'shadow'
            },
            // formatter: function(datas) {
            //     var res = datas[0].name + '<br/>',
            //         val;
            //     for (var i = 0, length = datas.length; i < length; i++) {
            //         if (typeof(datas[i].value) == 'number') {
            //             if (datas[i].value >= 1000 && datas[i].value < 1000000) {
            //                 datas[i].value = datas[i].value / 1000 + 'GB'
            //             } else if (datas[i].value >= 1000000) {
            //                 datas[i].value = datas[i].value / 1000000 + 'TB';
            //             } else {
            //                 datas[i].value = datas[i].value + 'MB';
            //             }
            //             val = datas[i].value
            //         } else {
            //             val = 0;
            //         }

            //         res += datas[i].seriesName + '：' + val + '<br/>';

            //     }
            //     return res;
            // }
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
            data: Xstr_arr,
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
                // formatter: function(value) {
                //     if (value > 0) {
                //         if (value >= 1000 && value < 1000000) {
                //             value = value / 1000 + 'GB'
                //         } else if (value >= 1000000) {
                //             value = value / 1000000 + 'TB';
                //         } else {
                //             value = value + 'MB';
                //         }
                //         return value;
                //     }
                // }
            }
        }],
        series: [{
            "name": Xstr[0],
            "type": "bar",
            "data": arrY,
            "barWidth": '',
            "barMinHeight": '1',
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
            "name": Xstr[1],
            "type": "bar",
            "data": arrY2,
            "barWidth": '',
            "barMinHeight": '1',
            lineWidth: "10%",
            itemStyle: {
                normal: {
                    color: '#4bc74e',
                    lineStyle: {
                        color: '#4bc74e'
                    }
                }
            }
        }, {
            "name": Xstr[2],
            "type": "bar",
            "data": arrY3,
            "barWidth": '',
            "barMinHeight": '1',
            lineWidth: "10%",
            itemStyle: {
                normal: {
                    color: '#ff4747',
                    lineStyle: {
                        color: '#ff4747'
                    }
                }
            }
        }]
    };

    // 为echarts对象加载数据 
    myChart.setOption(option);
}

/**
 * 流量ajax请求
 */
echartFlow('now','flow');
function echartFlow(time ,search_type, start, end) {
    var time = time || '';
    var startDate = start || '';
    var endDate = end || '';
    $.ajax({
        type: 'get',
        url: window_request_url.admin_index_list,
        data: {
            time_type: time,
            start_time: startDate,
            end_time: endDate
        },
        dataType: 'json',
        success: function(data) {
            if (data.code == 0) {
                if(search_type =='flow'){
                    var arrX = data.result.data.group_time;
                    var arrY = data.result.data.pv;
                    var arrY2 = data.result.data.uv;
                    var arrY3 = data.result.data.total_flow/1024/1024/1024;
                    var Xstr_arr = ['PV走势','UV走势','消耗走势'];
                    var Xstr = ['PV走势','UV走势','消耗走势'];
                    $('.pv-uv-total-box p').eq(1).text(data.result.count.pv);
                    $('.pv-uv-total-box p').eq(0).text('总PV');
                    $('.pv-uv-total-box p').eq(3).text(data.result.count.uv);
                    $('.pv-uv-total-box p').eq(2).text('总UV');
                    $('.pv-uv-total-box p').eq(5).text(data.result.count.total_flow/1024/1024/1024);
                    $('.pv-uv-total-box p').eq(4).text('总消耗');

                }else if(search_type =='user'){
                    var arrX = data.result.data.group_time;
                    var arrY = data.result.data.register;
                    var arrY2 = data.result.data.issuance_user;
                    var arrY3 = data.result.data.total_money;
                    var Xstr_arr = ['注册用户','发布用户','消费金额'];
                    var Xstr = ['注册用户','发布用户','消费金额'];
                    $('.pv-uv-total-box p').eq(1).text(data.result.count.register);
                    $('.pv-uv-total-box p').eq(0).text('总注册用户');
                    $('.pv-uv-total-box p').eq(3).text(data.result.count.issuance_user);
                    $('.pv-uv-total-box p').eq(2).text('总发布用户');
                    $('.pv-uv-total-box p').eq(5).text(data.result.count.total_money);
                    $('.pv-uv-total-box p').eq(4).text('总消费金额');

                }else if(search_type =='product'){
                    var arrX = data.result.data.group_time;
                    var arrY = data.result.data.free_product;
                    var arrY2 = data.result.data.pay_product;
                    var arrY3 = data.result.data.issuance_product;
                    var Xstr_arr = ['免费项目','付费项目','发布数量'];
                    var Xstr = ['免费项目','付费项目','发布数量'];
                    $('.pv-uv-total-box p').eq(1).text(data.result.count.free_product);
                    $('.pv-uv-total-box p').eq(0).text('总免费项目');
                    $('.pv-uv-total-box p').eq(3).text(data.result.count.pay_product);
                    $('.pv-uv-total-box p').eq(2).text('总付费项目');
                    $('.pv-uv-total-box p').eq(5).text(data.result.count.issuance_product);
                    $('.pv-uv-total-box p').eq(4).text('总发布项目');

                }
                showEchart(arrX, arrY, arrY2, arrY3,Xstr_arr,Xstr);
            }else{

            }
        },
        error: function(xhr, type) {
            console.log(xhr);
            console.log(type);
        }

    })
}

function arrConvers(arr) {
    return arr.map(function(value) {
        if (value == 0) {
            value = 0;
        }
        return value;
    })
}