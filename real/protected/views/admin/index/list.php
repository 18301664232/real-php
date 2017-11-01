<!---->
<!--/**-->
<!-- * Created by PhpStorm.-->
<!-- * User: syl-->
<!-- * Date: 2017/10/26-->
<!-- * Time: 16:00-->
<!-- */-->

<link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/admin_index.css">
<script src="<?php echo STATICSADMIN ?>javascript/moment.min.js"></script>
<script src="<?php echo STATICSADMIN ?>javascript/jquery.daterangepicker.min.js"></script>
<script src="<?php echo STATICSADMIN ?>javascript/echarts.min.js"></script>

<script src="<?php echo STATICSADMIN ?>javascript/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo STATICSADMIN ?>javascript/admin_index.js"></script>
<div class="container-fluid">
                <section class="flow-main">
                    <ul class="flow-tab nav nav-tabs">
                        <li class="active">流量趋势</li>
                        <li>用户趋势</li>
                        <li>项目趋势</li>
                    </ul>
                    <section class="flow-content">
                        <!-- 流量明细 -->
                        <section class="flow-detail clearfix">
                            <div class="has-project clearfix active">
                                <div class="detail-right">
                                    <div class="query-box clearfix">
                                        <div class="echart-category">
                                            <a class="active">今日</a>
                                            <a href="javascript:void(0)">昨日</a>
                                            <a href="javascript:void(0)">近7日</a>
                                            <a href="javascript:void(0)">近30日</a>
                                        </div>
                                        <div class="select-area clearfix">
                                            <p class="title">时间筛选：</p>
                                            <div class="select-date clearfix">
                                                <span class="rhDataConTabTimeSelect" id="rhDataConChannelTimeSelect"><input class="rhDataConTabTimeFrom Wdate input-one" type="text"  onfocus="WdatePicker()" id="rhDataConChannelTimeFrom" size="20" value=""> - <input class="rhDataConTabTimeTo Wdate input-two" onfocus="WdatePicker()" id="rhDataConChannelTimeTo" size="20" value=""></span>
                                            </div>
                                            <button class="btn btn-primary date-sure-btn self-search-btn">搜索</button>
                                        </div>
                                    </div>
                                    <!-- pv uv total -->
                                    <div class="pv-uv-total-box clearfix">
                                        <div>
                                            <p>总PV数</p>
                                            <p class="pv">100000</p>
                                        </div>
                                        <div>
                                            <p>总UV数</p>
                                            <p class="uv">787878</p>
                                        </div>
                                        <div>
                                            <p>流量消耗（T）</p>
                                            <p class="all-total">12777</p>
                                        </div>
                                    </div>
                                    <!-- echear -->
                                    <div id="echart" style="min-height:520px;width:100%;padding-top:30px">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </section>
                </section>
            </div>