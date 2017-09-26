<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/regtype.css"/>
<div class="logonHead clearfix">
    <p>
        <a href="javascript:;" class="logonHistoryBack">返回</a>
    </p>
    <p>
        <a href="<?php echo U('user/login/login') ?>">已有账户，从这里<span>登录</span></a>
    </p>
</div>
<div class="logonDivider">
    <img class="img-response" src="<?php echo STATICS ?>images/rtLogoSmall.png"/>
</div>
<div class="rtBody">
    <p class="rtP1">选择适合您的产品版本</p>
    <div class="rtChooseBox">
        <a class="rtPerSection" href="<?php echo U('user/register/indexs') ?>">
            <div>
                <p>个人版</p>
                <img class="img-response" src="<?php echo STATICS ?>images/rtPersonal.png"/>
                <p>适用于个人设计师</p>
                <p>单人工作的利器</p>
                <p>可直接使用</p>
            </div>
        </a>
        <a class="rtBusSection" href="<?php echo U('user/register/indexs', array('type' => 2)) ?>">
            <div>
                <p>企业版</p>
                <img class="img-response" src="<?php echo STATICS ?>images/rtBusiness.png"/>
                <p>适用于企业用户</p>
                <p>包含企业管理等功能</p>
                <p>需提供企业资质</p>
            </div>
        </a>
    </div>
</div>