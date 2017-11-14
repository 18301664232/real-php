<?php require_once 'creat.php'; ?>
<?php require_once 'del.php'; ?>
<?php require_once 'preview.php'; ?>
<?php require_once 'status.php'; ?>
<?php require_once 'setting.php'; ?>
<?php require_once 'append.php'; ?>
<?php require_once 'guide.php'; ?>
<?php require_once 'open.php'; ?>
<?php require_once 'dellogo.php'; ?>
<?php require_once 'data.php'; ?>
<button class="rhToTop"></button>
<div class='wtmenu'>
    <div class="container">
        <p>企业工作台</p>
        <a href="javascript:;" class="wtMyItem wtMyItemChoosed">我的项目</a>
        <!--		<a href="javascript:;" class="wtMyCollection">我的收藏</a>
                        <a href="javascript:;" class="wtMyPublic">我的公开</a>-->
        <a class="btn btn-default wtCreatePro">创建项目</a>
    </div>
</div>

<!-- 我的项目展示区域 -->
<div class='wtPro wtProPannal'>
    <!-- 项目菜单 -->
    <!--  -->

    <div class="container wtProMenu">
        <ul class="clearfix wtProMenuList">
            <li class="wtProMenuListAll wtProMenuListItemChoosed"><a href="javascript:;"><span>全部项目&nbsp;</span><span>(<?php echo $data['count'] ?>)</span></a></li> 
            <li class="wtProMenuListOnline"><a href="javascript:;"><span>已上线&nbsp;</span><span>(<?php echo $data['online_count'] ?>)</span></a></li>
            <li class="wtProMenuListOffline"><a href="javascript:;"><span>未上线&nbsp;</span><span>(<?php echo (int) $data['notonline_count'] + (int) $data['empty_count'] ?>)</span></a></li>
            <li class="wtProMenuListUpdate"><a href="javascript:;"><span>待更新&nbsp;</span><span>(<?php echo $data['update_count'] ?>)</span></a></li>

            <li class="wtProSearchItem clearfix"><input type="text" class="wtProSearch" placeholder="输入关键字"/><button class=" wtProSeachBtn"></button></li>
        </ul>
    </div>

    <div class="container wtProBtn">
        <ul class="clearfix wtProBtnList wtProMenuListOnlineBtnList">
            <li class="wtProBtnListAllOff"><button class="btn btn-default">批量下线</button></li>
            <li class="wtProBtnListAllChoose"><button class="btn btn-default clearfix"><span><span class="wtProBtnListAllChooseDot"></span></span><span>全选</span></button></li>
            <li class="wtProBtnListCertain wtProBtnListCertainDisabled"><button class="btn btn-default" disabled="disabled">确定</button></li>
        </ul>
        <ul class="clearfix wtProBtnList wtProMenuListOfflineBtnList">
            <li class="wtProBtnListAllOn"><button class="btn btn-default">批量上线</button></li>
            <li class="wtProBtnListAllChoose"><button class="btn btn-default clearfix"><span><span class="wtProBtnListAllChooseDot"></span></span><span>全选</span></button></li>
            <li class="wtProBtnListCertain wtProBtnListCertainDisabled"><button class="btn btn-default" disabled="disabled">确定</button></li>
        </ul>
        <ul class="clearfix wtProBtnList wtProMenuListUpdateBtnList">
            <li class="wtProBtnListAllUpdate"><button class="btn btn-default">批量更新</button></li>
            <li class="wtProBtnListAllChoose"><button class="btn btn-default clearfix"><span><span class="wtProBtnListAllChooseDot"></span></span><span>全选</span></button></li>
            <li class="wtProBtnListCertain wtProBtnListCertainDisabled"><button class="btn btn-default" disabled="disabled">确定</button></li>
        </ul>
    </div>

    <div class="container wtProItemBox clearfix">
        <!-- 具体项目 -->
        <!-- <div class="wtProItem wtProItemTagStateInit"> -->
        <!-- <div class="wtProItem wtProItemTagStateOn"> -->
        <!-- <div class="wtProItem wtProItemTagStateOff"> -->
        <!-- <div class="wtProItem wtProItemTagStateUpdate"> -->
        <?php foreach ($data['data'] as $k => $v): ?>

            <div id="<?php echo $v['product_id'] ?>" <?php if ($v['online'] == 'online'): ?>class="wtProItem wtProItemTagStateOn" <?php elseif ($v['online'] == 'update'): ?>class="wtProItem wtProItemTagStateUpdate" 
                 <?php elseif ($v['online'] == 'notonline'): ?>class="wtProItem wtProItemTagStateOff" <?php elseif ($v['online'] == 'empty'): ?>class="wtProItem wtProItemTagStateInit"  <?php endif; ?>>


                <!-- 初始的html区域 -->
                <?php if (empty($v['cover'])): ?>
                    <img class="wtProItemImg" class="img-responsive" src="<?php echo STATICS ?>images/wtProImg.png"/>
                <?php else: ?>
                    <img class="wtProItemImg" class="img-responsive" src="<?php echo $v['cover'] ?>"/>
                <?php endif; ?>
                <div class="wtProItemTiTle">
                    <p><?php echo $v['title'] ?></p>
                </div>

                <!-- 平常鼠标移上去的模板 -->
                <div class="wtProItemHover">
                    <p class="wtProItemHoverTitle">ID:&nbsp;<?php echo $v['product_id'] ?></p>
                    <p class="wtProItemHoverFlow"><!--项目大小:<?php //echo $v['p_size']  ?>MB--></p>
                    <div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOn">
                        <button class="btn btn-default wtProItemHoverDownload ">下线</button>
                        <button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button>
                        <button class="btn btn-default wtProItemHoverView">预览</button>
                        <button class="btn btn-default wtProItemHoverEditor">编辑</button>
                        <button class="btn btn-default wtProItemHoverData">数据</button>
                    </div>

                    <div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionOff">
                        <button class="btn btn-default wtProItemHoverUpload">上线</button>
                        <button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button>
                        <button class="btn btn-default wtProItemHoverView">预览</button>
                        <button class="btn btn-default wtProItemHoverEditor">编辑</button>
                        <button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button>
                    </div>

                    <div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionUpdate">
                        <button class="btn btn-default wtProItemHoverDownload">下线</button>
                        <button class="btn btn-default wtProItemHoverUpdate">更新</button>
                        <button class="btn btn-default wtProItemHoverView">预览</button>
                        <button class="btn btn-default wtProItemHoverEditor">编辑</button>
                        <button class="btn btn-default wtProItemHoverData">数据</button>
                    </div>

                    <div class="wtProItemHoverBtnSection wtProItemHoverBtnSectionInit">
                        <button class="btn btn-default wtProItemHoverUpload disabledBtn" disabled="disabled">上线</button>
                        <button class="btn btn-default wtProItemHoverUpdate disabledBtn" disabled="disabled">更新</button>
                        <button class="btn btn-default wtProItemHoverView disabledBtn" disabled="disabled">预览</button>
                        <button class="btn btn-default wtProItemHoverEditor">编辑</button>
                        <button class="btn btn-default wtProItemHoverData disabledBtn" disabled="disabled">数据</button>
                    </div>

                    <p class="wtProItemHoverLastEditor"><?php if (!empty($v['updatetime'])): ?>最后编辑：<?php echo $v['updatetime'] ?><?php endif; ?></p>
                    <div class="wtProItemHoverControl clearfix">
                        <div class='wtProDeleteLogo clearfix'>
                            <?php if ($v['pay'] == 'no'): ?>
                                <button class='wtProDeleteLogoBtn'>
                                <?php else: ?>
                                    <button class='wtProDeleteLogoBtn wtProDeleteLogoBtnClick'> 
                                    <?php endif; ?>

                                    <div></div>
                                </button>
                                <p class='wtProDeleteLogoText'>去除logo</p>
                        </div>
                        <a class="wtProItemHoverControlSetting" href="javascript:;"></a>
                        <?php if ($v['is_open'] == 'yes' && $v['online'] != 'empty'): ?>
                            <a class="wtProItemHoverControlPublic wtProItemHoverControlPublicState" href="javascript:;"></a>
                        <?php elseif ($v['is_open'] == 'no' && $v['online'] != 'empty'): ?>
                            <a class="wtProItemHoverControlPublic" href="javascript:;"></a>
                        <?php endif; ?>

                        <a class="wtProItemHoverControlDelete" href="javascript:;"></a>

                    </div>
                </div>

                <!-- 选择界面 -->
                <div class="wtProItemChoose">
                    <a href="javascript:;">
                        <div></div>
                    </a>
                </div>

                <!-- 项目状态的标签 -->
                <p class="wtProItemState wtProItemStateOn">已上线</p>
                <p class="wtProItemState wtProItemStateOff">未上线</p>
                <p class="wtProItemState wtProItemStateOffZero">未上线</p>
                <p class="wtProItemState wtProItemStateUpdate">待更新</p>
            </div>
        <?php endforeach; ?>
    </div>

</div>
<!-- 我的收藏展示区域 -->
<div class="wtPro wtColPannal">
    <div class="wtColPannalBox clearfix">

        <div class="wtColPannalBoxItem">
            <img class="img-responsive wtColItemImg" src="<?php echo STATICS ?>images/wtColItemImg.png"/>
            <div class="wtColItemInfo">
                <p class="wtColItemName">RESPONSIVE</p>
                <div class="wtColItemAuthorInfo clearfix">
                    <div class="wtColItemAuthorHeadImgBox">
                        <a class="wtColItemAuthorHeadImgLink" href="javascript:;">
                            <img class="img-responsive wtColItemAuthorHeadImg" src="<?php echo STATICS ?>images/wtColItemAuthorHeadImg.png"/>
                        </a>
                    </div>
                    <div class="wtColItemAuthorTxtBox">
                        <p class='wtColItemAuthorNameBox'><a class='wtColItemAuthorName' href="javascript:;">西露的苹果</a></p>
                        <p class="wtColItemOtherBox clearfix">
                            <span class="wtColItemColNum">3800</span>
                            <span class="wtColItemViewNum">15000</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="wtColItemMask">
                <p class="wtColItemMaskText">本作品为百度洗白之路H5作品，融合百度多为交互大师半天的心血所创作，绝无仅有之佳作。</p>
                <p class="wtColItemMaskBtn clearfix">
                    <button class="wtColItemMaskBtnLook">查看</button>
                    <button class="wtColItemMaskBtnCol"></button>
                </p>
            </div>

        </div>

    </div>


</div>

<!-- 我的发布展示区域 -->
<div class="wtPro wtPubPannal">
    <div class="wtPubPannalBox clearfix">

        <div class="wtPubPannalBoxItem">
            <img class="img-responsive wtPubItemImg" src="<?php echo STATICS ?>images/wtColItemImg.png"/>
            <div class="wtPubItemInfo">
                <p class="wtPubItemName">RESPONSIVE</p>
                <div class="wtPubItemAuthorInfo clearfix">
                    <div class="wtPubItemAuthorHeadImgBox">
                        <img class="img-responsive wtPubItemAuthorHeadImg" src="<?php echo STATICS ?>images/wtColItemAuthorHeadImg.png"/>
                    </div>
                    <div class="wtPubItemAuthorTxtBox">
                        <p class='wtPubItemAuthorNameBox'>西露的苹果</p>
                        <p class="wtPubItemOtherBox clearfix">
                            <span class="wtPubItemColNum">3800</span>
                            <span class="wtPubItemViewNum">15000</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="wtPubItemMask">
                <p class="wtPubItemMaskText">本作品为百度洗白之路H5作品，融合百度多为交互大师半天的心血所创作，绝无仅有之佳作。</p>
                <p class="wtPubItemMaskBtn clearfix">
                    <button class="wtPubItemMaskBtnLook">查看</button>
                    <button class="wtPubItemMaskBtnCol"></button>
                </p>
            </div>
        </div>


    </div>
</div>



<!-- 我的收藏以及我的发布查看弹框 -->
<div class="modal" id="rhaLookUpAlert" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog rhViewModalDialog">
        <div class="modal-content rhViewModalContent clearfix">
            <div class="rhaQrSec">
                <div class="rhaLookUpUserBox">
                    <a class="rhaLookUpUserImgLink" href="javascript:;">
                        <img class="rhaLookUpUserImg" src="<?php echo STATICS ?>images/rhaLookUpUserImg.png"/>
                    </a>
                </div>
                <p class="rhaLookUpUserName"><a href="javascript:;" class="rhaLookUpUserNameLink">milan3243</a></p>
                <p class="rhaLookUpUserItemText"><span class="rhaLookUpUserItemNum">2</span>&nbsp;个公开项目</p>
                <img class="rhaLookUpQr" src="<?php echo STATICS ?>images/rhaLookUpUserQr.png"/>
                <p class="rhaLookUpQrText">扫码进行分享/查看</p>
            </div>
            <div class="rhaViewSec">
                <p class="rhaViewTextBox clearfix">
                    <img class="rhaViewLabel" src="<?php echo STATICS ?>images/rhaViewLabelOnline.png"/>
                    <span class="rhaViewText">Nike 新品上市</span>
                </p>
                <canvas id="rhaLookUpCanvas" class="rhaViewCanvas" width="290" height="520"></canvas>
                <button type="type" class="rhaViewClose" data-dismiss="modal"></button>
                <div class="rhaViewBtnGroup">
                    <button type="button" class="rhaViewBtnUp"></button>
                    <button type="button" class="rhaViewBtnDown"></button>
                </div>
            </div>
        </div>
    </div>
</div>






<script>
    $(function () {

//项目编辑
        $('.wtProItemBox').on('click', '.wtProItemHoverEditor', function () {
            var p_id = $(this).parent().parent().parent().find('.wtProItemHoverTitle').html();
            p_id = p_id.substr(-10);
            window.location.href = "<?php echo U('product/resources/local') ?>" + '&product_id=' + p_id;
        });

    });



</script>