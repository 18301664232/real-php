
<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/flow.css">

<body>
    <div class="flow-box">

        <div class="his-box">
            <p class="his-head">我的订单</p>
            <div class="his-table-box">
                <table class="table his-table">
                    <thead>
                        <tr>
                            <th>订单编号</th>
                            <th>全部流量包</th>
                            <th>创建时间</th>
                            <th>支付时间</th>
                            <th>金额</th>
                            <th>
                                <div class="dropdown"><button id="his-state" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">使用状态<span class="caret"></span></button>
                                    <ul class="dropdown-menu" aria-labelledby="his-state">
                                        <li>全部状态</li>
                                        <li>已支付</li>
                                        <li>未支付</li>
                                    </ul>
                                </div>
                            </th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data)): ?>
                            <?php foreach ($data as $k => $v): ?>
                                <?php if ($v['status'] == 'yes'): ?>
                                    <tr class="his-table-pay-yes">
                                    <?php else: ?>
                                    <tr class="his-table-pay-no">
                                    <?php endif; ?>
                                    <td><?php echo $v['order_no'] ?></td>
                                    <td><?php echo $v['detail'] ?></td>
                                    <td><?php echo date('Y-m-d H:i:s', $v['addtime']) ?></td>
                                    <td><?php if ($v['paytime']) {
                                echo date('Y-m-d H:i:s', $v['paytime']);
                            } ?></td>
                                    <td><?php echo $v['money'] ?></td>
                                    <?php if ($v['status'] == 'yes'): ?>
                                        <td class="his-table-state">已支付</td>
                                        <td><a class="his-table-ope" href="<?php echo U('finance/pay/pay', array('order' => $v['order_no'])) ?>">再次购买</a></td>
                                    <?php else: ?>
                                        <td class="his-table-state">未支付</td>
                                        <td><a class="his-table-ope" href="<?php echo U('finance/pay/pay', array('order' => $v['order_no'],'pay'=>'first_pay')) ?>">去支付</a></td>
                                <?php endif; ?>
                                </tr>
    <?php endforeach; ?>
<?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script type="text/javascript">
        //查看各种状态的历史订单
        //全部状态
        $('.dropdown-menu > li:nth-child(1)').on('click', function () {
            $('tbody > tr').show();
        })
        //已经支付
        $('.dropdown-menu > li:nth-child(2)').on('click', function () {
            $('tbody > tr').hide();
            $('.his-table-pay-yes').show();
        })
        //未支付
        $('.dropdown-menu > li:nth-child(3)').on('click', function () {
            $('tbody > tr').hide();
            $('.his-table-pay-no').show();
        })
    </script>
</body>

</html>
