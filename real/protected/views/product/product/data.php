
<!-- 数据按钮弹出框 -->
<!-- Modal -->
<div class="modal rhModel" id="rhaDataConAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog rhDataConModalDialog">
        <div class="modal-content rhDataConModalContent">
            <p class="rhDataTempStatement">现阶段免费开放</p>
            <p class="rhDataConAlertHead clearfix">
                <span class="rhDataConAlertHeadText">数据管理</span>
                <button class="rhDataConAlertHeadClose" data-dismiss="modal"></button>
            </p>
            <div class="rhDataConAlertBody">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs rhDataConTabMenu" role="tablist">
                    <li role="presentation" class="rhDataConTabMenuChannel active"><a href="#rhDataConTabMenuChannel" role="tab" data-toggle="tab">渠道数据</a></li>
                    <li role="presentation" class="rhDataConTabMenuPage"><a href="#rhDataConTabMenuPage" role="tab" data-toggle="tab">页面事件</a></li>
                    <li role="presentation" class="rhDataConTabMenuButton"><a href="#rhDataConTabMenuButton" role="tab" data-toggle="tab">按钮事件</a></li>
                    <li role="presentation" class="rhDataConTabMenuInter"><a href="#rhDataConTabMenuInter" role="tab" data-toggle="tab">表单数据</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content rhDataConTabContent">
                    <div role="tabpanel" class="tab-pane rhDataConTabContentChannel active" id="rhDataConTabMenuChannel">

                        <div class="rhDataConTabTimePannal clearfix">
                            <span class="rhDataConTabTimePannalText">日期选择:</span>
                            <button str="all" class="rhDataConTabTimeFirstBtn rhDataConTabTimeChoosed ">全部</button>
                            <button str="today">今日</button>
                            <button str="ttoday">昨日</button>
                            <button str="tttoday">最近48小时</button>
                            <button str="t7today">近7日</button>
                            <button str="t30today">近30日</button>
                            <span class="rhDataConTabTimeSelect" id="rhDataConChannelTimeSelect"><input class="rhDataConTabTimeFrom" id="rhDataConChannelTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo" id="rhDataConChannelTimeTo" size="20" value=""></span>
                        </div>

                        <div class="rhDataConChannelTableBox">
                            <table class="rhDataConChannelTable table-hover table">
                                <thead>
                                    <tr>
                                        <th>渠道名称</th>
                                        <th>浏览次数&nbsp;(PV)</th>
                                        <th>独立访客&nbsp;(UV)</th>
                                        <th>IP</th>
                                        <th>新增独立访客</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <button type="button" class="rhDataConExport">导出数据</button>

                    </div>
                    <div role="tabpanel" class="tab-pane rhDataConTabContentPage" id="rhDataConTabMenuPage">
                        <div class="rhDataConTabTimePannal clearfix">
                            <span class="rhDataConTabTimePannalText">日期选择:</span>
                            <button  str="all" class="rhDataConTabTimeFirstBtn rhDataConTabTimeChoosed ">全部</button>
                            <button str="today">今日</button>
                            <button str="ttoday">昨日</button>
                            <button str="tttoday">最近48小时</button>
                            <button str="t7today">近7日</button>
                            <button str="t30today">近30日</button>
                            <span class="rhDataConTabTimeSelect" id="rhDataConPageTimeSelect"><input class="rhDataConTabTimeFrom" id="rhDataConPageTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo" id="rhDataConPageTimeTo" size="20" value=""></span>
                        </div>

                        <div class='rhDataChannelSelectBox clearfix'>
                            <p class='rhDataChannelSelectText'>渠道选择:</p>
                            <div class='rhDataChannelSelectButton rhDataChannelSelectButton_page clearfix'><span class='rhDataChannelSelectTitle'>全部渠道</span><span class="caret"></span>
                                <ul class='rhDataChannelSelectList rhDataChannelSelectList_page'>


                                </ul>
                            </div>
                        </div>

                        <div class="rhDataConPageTableBox">
                            <table class="rhDataConPageTable table-hover table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>页面名称</th>
                                        <th>浏览次数&nbsp;(PV)</th>
                                        <th>独立访客&nbsp;(UV)</th>
                                        <th>页面平均停留时长</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <button type="button" class="rhDataConExport">导出数据</button>

                    </div>
                    <div role="tabpanel" class="tab-pane rhDataConTabContentButton" id="rhDataConTabMenuButton">

                        <div class="rhDataConTabTimePannal clearfix">
                            <span class="rhDataConTabTimePannalText">日期选择:</span>
                            <button str="all" class="rhDataConTabTimeFirstBtn rhDataConTabTimeChoosed ">全部</button>
                            <button str="today">今日</button>
                            <button str="ttoday">昨日</button>
                            <button str="tttoday">最近48小时</button>
                            <button str="t7today">近7日</button>
                            <button str="t30today">近30日</button>
                            <span class="rhDataConTabTimeSelect" id="rhDataConButtonTimeSelect"><input class="rhDataConTabTimeFrom" id="rhDataConButtonTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo" id="rhDataConButtonTimeTo" size="20" value=""></span>
                        </div>

                        <div class='rhDataChannelSelectBox clearfix'>
                            <p class='rhDataChannelSelectText'>渠道选择:</p>
                            <div class='rhDataChannelSelectButton rhDataChannelSelectButton_button clearfix'><span class='rhDataChannelSelectTitle'>全部渠道</span><span class="caret"></span>
                                <ul class='rhDataChannelSelectList rhDataChannelSelectList_button'>


                                </ul>
                            </div>
                        </div>

                        <div class="rhDataConButtonTableBox">
                            <table class="rhDataConButtonTable table-hover table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>按钮名称</th>
                                        <th>所在页面</th>
                                        <th>点击量</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <button type="button" class="rhDataConExport">导出数据</button>

                    </div>
                    <div role="tabpanel" class="tab-pane rhDataConTabContentInter" id="rhDataConTabMenuInter">

                        <div class="rhDataConTabTimePannal clearfix">
                            <span class="rhDataConTabTimePannalText">日期选择:</span>
                            <button str="all" class="rhDataConTabTimeFirstBtn rhDataConTabTimeChoosed">全部</button>
                            <button str="today">今日</button>
                            <button str="ttoday">昨日</button>
                            <button str="tttoday">最近48小时</button>
                            <button str="t7today">近7日</button>
                            <button str="t30today">近30日</button>
                            <span class="rhDataConTabTimeSelect" id="rhDataConInterTimeSelect"><input class="rhDataConTabTimeFrom" id="rhDataConInterTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo" id="rhDataConInterTimeTo" size="20" value=""></span>
                        </div>

                        <div class='rhDataChannelSelectBox clearfix'>
                            <p class='rhDataChannelSelectText'>渠道选择:</p>
                            <div class='rhDataChannelSelectButton rhDataChannelSelectButton_form clearfix'><span class='rhDataChannelSelectTitle'>全部渠道</span><span class="caret"></span>
                                <ul class='rhDataChannelSelectList rhDataChannelSelectList_form'>


                                </ul>
                            </div>
                        </div>

                        <div class="rhDataConInterTableBox">
                            <table class="rhDataConInterTable table-hover table">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>按钮名称</th>
                                        <th>提交总数</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <button type="button" class="rhDataConExport">导出数据</button>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(function () {

        //一个初始化的逻辑
        $('.rhDataConAlertHeadClose').on('click', function () {
            $('.rhDataConTabMenu > li').removeClass('active');
            $('.rhDataConTabContent > .tab-pane').removeClass('active');
            $('.rhDataConTabMenu > li:first').addClass('active');
            $('.rhDataConTabContent > .tab-pane:first').addClass('active');
            $('.rhDataConTabTimePannal > button').removeClass('rhDataConTabTimeChoosed');
            $('.rhDataConTabTimePannal > .rhDataConTabTimeFirstBtn').addClass('rhDataConTabTimeChoosed');
        });



//数据事件初始化
        $('.wtProItemBox').on('click', '.wtProItemHoverData', function () {
            var p_id = $(this).parent().parent().find('.wtProItemHoverTitle').html();
            product_id = p_id.substr(-10);
            $('#rhaDataConAlert').attr('pid', product_id);
            $('.rhDataChannelSelectList_button,.rhDataChannelSelectList_form,.rhDataChannelSelectList_page').html('');
            $('tbody').html('');
            //初始渠道选项
            var data = ajax(product_id, 'all', '#rhDataConTabMenuChannel');
            $('.rhDataConTabMenu li').removeAttr('ck');
            for (var key in data.result) {
                var qd = '<li>' + data.result[key].name + '</li>';
                $('.rhDataChannelSelectList_button,.rhDataChannelSelectList_form,.rhDataChannelSelectList_page').append(qd);
            }

            $('#rhaDataConAlert').modal({backdrop: 'static', keyboard: false});
            var rhMarginTop = ($(window).height() >= $('.rhDataConModalContent').height()) ? ($(window).height() - $('.rhDataConModalContent').height()) / 2 : 0;
            $('.rhDataConModalDialog').css('marginTop', rhMarginTop + 'px');
        });

        //选项卡初始化
        $('.rhDataConTabMenuChannel,.rhDataConTabMenuPage,.rhDataConTabMenuButton,.rhDataConTabMenuInter').on('click', function () {
            var type = 'all';
            var id = $(this).find('a').attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');
            if ($(id).find('tbody').html() == '' && typeof ($(this).attr('ck')) == "undefined") {
                $(this).attr('ck', 'yes');
                // $(id).find('tbody').html('');
                ajax(product_id, type, id);
            }

        })


//数据日期点击(渠道)
        $('.rhDataConTabTimePannal button').on('click', function () {
            //清空日期
            $(this).parent().find('input').val('');
            var type = $(this).attr('str');
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            //获取渠道
            var qd = $(this).parent().next().find('.rhDataChannelSelectButton').find('span').eq(0).html();
            var product_id = $('#rhaDataConAlert').attr('pid');
            ajax(product_id, type, id, '', '', qd);
        })



        function ajax(product_id, type, id, starttime = '', endtime = '', qd = '') {
            var result;
            var status = 'ditch';
            if (id == '#rhDataConTabMenuChannel') {
                status = 'ditch';
            } else if (id == '#rhDataConTabMenuPage') {
                status = 'page';
            } else if (id == '#rhDataConTabMenuButton') {
                status = 'button';
            } else if (id == '#rhDataConTabMenuInter') {
                status = 'userdata';
            }
            var url = '<?php echo U('statistics/statistics/Getdata') ?>';
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    product_id: product_id,
                    type: type,
                    class: status,
                    endtime: endtime,
                    starttime: starttime,
                    qd: qd
                },
                dataType: "json",
                async: false,
                success: function (data) {
                    var nr = '';
                    for (var key in data.result) {
                        if (status == 'ditch') {
                            nr += '<tr><td>' + data.result[key].name + '</td><td>' + data.result[key].pv + '</td><td>' + data.result[key].uv + '</td><td>' + data.result[key].ip + '</td><td>' + data.result[key].nv + '</td></tr>';
                        } else if (status == 'button') {
                            nr += '<tr><td></td><td>' + data.result[key].button_name + '</td><td>' + data.result[key].page + '</td><td>' + data.result[key].total + '</td></tr>';
                        } else if (status == 'userdata') {
                            nr += '<tr><td></td><td>' + data.result[key].button_name + '</td><td>' + data.result[key].total + '</td></tr>';
                        } else if (status == 'page') {
                            var nub = parseFloat(data.result[key].avg);

                            nr += '<tr><td></td><td>' + data.result[key].page_name + '</td><td>' + data.result[key].pv + '</td><td>' + data.result[key].uv + '</td><td>' + nub.toFixed(2) + '</td></tr>';
                        }

                    }
                   
                    $(id).find('tbody').html(nr);
                    result = data;
                }
            })
            return result;
        }



//数据弹出框日期选择插件（渠道）
        $('#rhDataConChannelTimeSelect').dateRangePicker({
            separator: ' - ',
            autoClose: true,
            getValue: function ()
            {
                if ($('#rhDataConChannelTimeFrom').val() && $('#rhDataConChannelTimeTo').val())
                    return $('#rhDataConChannelTimeFrom').val() + ' - ' + $('#rhDataConChannelTimeTo').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#rhDataConChannelTimeFrom').val(s1);
                $('#rhDataConChannelTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function () {

            var starttime = $('#rhDataConChannelTimeFrom').val();
            var endtime = $('#rhDataConChannelTimeTo').val();
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');

            ajax(product_id, '', id, starttime, endtime);
            $(this).parent().parent().find('button').removeClass('rhDataConTabTimeChoosed');
            $('#rhDataConChannelTimeFrom').attr('value', $('#rhDataConChannelTimeFrom').val());
            $('#rhDataConChannelTimeTo').attr('value', $('#rhDataConChannelTimeTo  ').val());
        })


        //页面
        $('#rhDataConPageTimeSelect').dateRangePicker({
            separator: ' - ',
            autoClose: true,
            getValue: function ()
            {
                if ($('#rhDataConPageTimeFrom').val() && $('#rhDataConPageTimeTo').val())
                    return $('#rhDataConPageTimeFrom').val() + ' - ' + $('#rhDataConPageTimeTo').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#rhDataConPageTimeFrom').val(s1);
                $('#rhDataConPageTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function () {
            var starttime = $('#rhDataConPageTimeFrom').val();
            var endtime = $('#rhDataConPageTimeTo').val();
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');
            var qd = $('#rhDataConPageTimeSelect').parent().next().find('.rhDataChannelSelectButton').find('span').eq(0).html();
            ajax(product_id, '', id, starttime, endtime, qd);
            $(this).parent().parent().find('button').removeClass('rhDataConTabTimeChoosed');
            $('#rhDataConPageTimeFrom').attr('value', $('#rhDataConPageTimeFrom').val());
            $('#rhDataConPageTimeTo').attr('value', $('#rhDataConPageTimeTo').val());
        });

        //按钮
        $('#rhDataConButtonTimeSelect').dateRangePicker({
            separator: ' - ',
            autoClose: true,
            getValue: function ()
            {
                if ($('#rhDataConButtonTimeFrom').val() && $('#rhDataConButtonTimeTo').val())
                    return $('#rhDataConButtonTimeFrom').val() + ' - ' + $('#rhDataConButtonTimeTo').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#rhDataConButtonTimeFrom').val(s1);
                $('#rhDataConButtonTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function () {
            var starttime = $('#rhDataConButtonTimeFrom').val();
            var endtime = $('#rhDataConButtonTimeTo').val();
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');
            var qd = $('#rhDataConButtonTimeSelect').parent().next().find('.rhDataChannelSelectButton').find('span').eq(0).html();
            ajax(product_id, '', id, starttime, endtime, qd);
            $(this).parent().parent().find('button').removeClass('rhDataConTabTimeChoosed');
            $('#rhDataConButtonTimeFrom').attr('value', $('#rhDataConButtonTimeFrom').val());
            $('#rhDataConButtonTimeTo').attr('value', $('#rhDataConButtonTimeTo').val());
        });


//用户
        $('#rhDataConInterTimeSelect').dateRangePicker({
            separator: ' - ',
            autoClose: true,
            getValue: function ()
            {
                if ($('#rhDataConInterTimeFrom').val() && $('#rhDataConInterTimeTo').val())
                    return $('#rhDataConInterTimeFrom').val() + ' - ' + $('#rhDataConInterTimeTo').val();
                else
                    return '';
            },
            setValue: function (s, s1, s2)
            {
                $('#rhDataConInterTimeFrom').val(s1);
                $('#rhDataConInterTimeTo').val(s2);
            }
        }).bind('datepicker-closed', function () {
            var starttime = $('#rhDataConInterTimeFrom').val();
            var endtime = $('#rhDataConInterTimeTo').val();
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');
            var qd = $('#rhDataConInterTimeSelect').parent().next().find('.rhDataChannelSelectButton').find('span').eq(0).html();
            ajax(product_id, '', id, starttime, endtime, qd);
            $(this).parent().parent().find('button').removeClass('rhDataConTabTimeChoosed');
            $('#rhDataConInterTimeFrom').attr('value', $('#rhDataConInterTimeFrom').val());
            $('#rhDataConInterTimeTo').attr('value', $('#rhDataConInterTimeTo').val());
        });


        $('.rhDataChannelSelectButton_page,.rhDataChannelSelectButton_button,.rhDataChannelSelectButton_form').on('click', function () {
            $(this).find('ul').toggle();
        });
        //渠道筛选
        $('.rhDataChannelSelectList_page,.rhDataChannelSelectButton_button,.rhDataChannelSelectButton_form').on('click', 'li', function () {
            $(this).parents('.rhDataChannelSelectButton').find('.rhDataChannelSelectTitle').text($(this).text());
            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            var product_id = $('#rhaDataConAlert').attr('pid');
            var qd = $(this).html();
            if ($(this).parent().parent().parent().parent().hasClass('.rhDataConTabTimeChoosed')) {
                var type = $(this).parent().parent().parent().parent().find('.rhDataConTabTimeChoosed').attr('str');
                ajax(product_id, type, id, '', '', qd);
            } else {
                var starttime = $(this).parent().parent().parent().parent().find('input').eq(0).attr('value');
                var endtime = $(this).parent().parent().parent().parent().find('input').eq(1).attr('value');
                ajax(product_id, '', id, starttime, endtime, qd);
            }

        });


        //导表
        $('.rhDataConExport').on('click', function () {

            var url = '<?php echo REAL . U('statistics/statistics/Getdata') ?>';
            var product_id = $('#rhaDataConAlert').attr('pid');
            url += "&product_id=" + product_id;

            var id = $(".rhDataConTabMenu li[class*='active'] a").attr('href');
            if (id == '#rhDataConTabMenuChannel') {
                status = 'ditch';
            } else if (id == '#rhDataConTabMenuPage') {
                status = 'page';
                var qd = $(this).parent().find('.rhDataChannelSelectButton').find('span').eq(0).html();
                url += "&qd=" + qd;
            } else if (id == '#rhDataConTabMenuButton') {
                status = 'button';
                var qd = $(this).parent().find('.rhDataChannelSelectButton').find('span').eq(0).html();
                url += "&qd=" + qd;
            } else if (id == '#rhDataConTabMenuInter') {
                status = 'userdata';
                var qd = $(this).parent().find('.rhDataChannelSelectButton').find('span').eq(0).html();
                url += "&qd=" + qd;
            }
            if ($(id).find('button').hasClass('rhDataConTabTimeChoosed')) {
                var type = $(this).parents('.tab-pane').find('.rhDataConTabTimeChoosed').attr('str');
                url += "&type=" + type;
            } else {
                var starttime = $(this).parent().find('input').eq(0).attr('value');
                var endtime = $(this).parent().find('input').eq(1).attr('value');
                url += "&starttime=" + starttime;
                url += "&endtime=" + endtime;
            }
            url += "&class=" + status;
            //没数据不能导出
            if ($(id).find('tbody').html() == '') {
                alert('没数据不能导出');
                return false;
            }
            url += "&excel=yes";
            window.location.href = url;
        })

    });


</script>