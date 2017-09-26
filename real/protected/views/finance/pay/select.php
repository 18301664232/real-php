
<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/flow.css">
<body>
    <div class="flow-box">  
        <div class="cho-box">
            <div class="cho-head">流量包购买</div>
            <div class="cho-body clearfix">
                <?php $i = 0;
                foreach ($data as $k => $v): ?>
                        <?php if ($i % 3 == 0): ?>
                        <div class="cho-pac cho-pac1 cho-pack-color-blue" val="<?php echo $v['id'] ?>">
                            <?php elseif ($i % 3 == 1): ?>
                            <div class="cho-pac cho-pac1 cho-pack-color-green" val="<?php echo $v['id'] ?>">   
                                <?php elseif ($i % 3 == 2): ?>
                                <div class="cho-pac cho-pac1 cho-pack-color-orange" val="<?php echo $v['id'] ?>">
    <?php endif; ?>
                                <div class="cho-pac-border-top cho-pac1-border-top"></div>
                                <div class="cho-pac-inner">
                                    <div class="cho-pac-info-box cho-pac1-info-box">
                                        <p class="cho-pac-info1 cho-pac1-info1 clearfix"><span class="cho-pac-info1-flow cho-pac1-info1-flow"><?php echo $v['name'] ?></span><span class="cho-pac-info1-unit cho-pac1-info1-unit">￥</span><span class="cho-pac-info1-price cho-pac1-info1-price"><?php echo $v['money'] ?></span></p>
                                        <p class="cho-pac-info2 cho-pac1-info2 clearfix"><span class="cho-pac-info2-type cho-pac1-info2-type">年度包</span></p>
                                    </div>
                                    <p class="cho-pac-period cho-pac1-period">有效期：自购买之日起12月内</p>
                                    <div class="cho-pac-sel-bg cho-pac1-sel-bg"></div>
                                    <div class="cho-pac-sel-img"></div>
                                </div>
                            </div>
                            <?php $i++ ?>
                            <?php if ($i % 3 != 0): ?>
                                <div class="cho-divider"></div>
                            <?php endif; ?>
<?php endforeach; ?>
                    </div>
                    <div class="cho-bot clearfix">
                        <!--这里写页面跳转-->
                        <a class="cho-bot-pay btn disabled" href="javascript:;">结算</a><a class="cho-bot-history" href="<?php echo U('finance/pay/list') ?>">查看历史订单</a></div>
                </div>
            </div>
            <script type="text/javascript">
                //选择流量包样式的逻辑
                $('.cho-pac').on('click', function () {
                    if ($(this).hasClass('cho-pac-sel')) {
                        $(this).removeClass('cho-pac-sel');
                    } else {
                        $(this).addClass('cho-pac-sel');
                    }
                    if ($('.cho-pac-sel').length !== 0) {
                        $('.cho-bot-pay').removeClass('disabled');
                    } else {
                        $('.cho-bot-pay').addClass('disabled');
                    }
                });

                $('.cho-bot-pay').on('click', function () {
                    var id = '';
                    $('.cho-pac-sel').each(function () {
                        id += $(this).attr('val') + ',';

                    });
                    var url = '<?php echo U('finance/pay/payinfo') ?>';

                    $.post(url, {data: id}, function (token) {
                        window.location.href = '<?php echo U('finance/pay/pay') ?>' + '&token=' + token;
                    });

                })

            </script>
            </body>

            </html>
