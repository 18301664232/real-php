
<!-- 指导层  -->
<div class='wt-guide'>
    <div class='wt-guide-left'>
        <div class='wt-guide-left-top'>
            <div class='wt-guide-left-top-left'></div>
            <div class='wt-guide-left-top-right'></div>
        </div>
        <div class='wt-guide-left-bottom'></div>
    </div>
    <div class='wt-guide-middle'>
        <div class='wt-guide-middle-top'>
            <div class='guide-step-box guide-step1-box'></div>
            <div class='guide-step-box-border guide-step1-box-border'></div>
            <div class="guide-step guide-step1">
                <p class="guide-step1-text">点击此按钮可创建新的H5项目</p>
                <div class="guide-step1-btn-gro clearfix">
                    <button class="guide-step1-btn">下一步</button>
                </div>
            </div>
            <div class="guide-step-tri guide-step1-tri"></div>

            <div class='guide-step-box guide-step2-box'></div>
            <div class='guide-step-box-border guide-step2-box-border'></div>
            <div class="guide-step guide-step2">
                <p class="guide-step2-text1">个人设计的H5作品将在此栏目内展示。</p>
                <div class="guide-step2-btn-gro clearfix">
                    <button class="guide-step2-btn-down">下一步</button>
                    <button class="guide-step2-btn-up">上一步</button>
                </div>
            </div>
            <div class="guide-step-tri guide-step2-tri"></div>

            <div class='guide-step-box guide-step3-box'></div>
            <div class='guide-step-box-border guide-step3-box-border'></div>
            <div class="guide-step guide-step3">
                <p class="guide-step3-text">此处显示本账户当前创建的所有项目</p>
                <div class="guide-step3-btn-gro clearfix">
                    <button class="guide-step3-btn-com">完成</button>
                    <button class="guide-step3-btn-rea">重看</button>
                </div>
            </div>
            <div class="guide-step-tri guide-step3-tri"></div>
        </div>
        <div class='wt-guide-middle-bottom'></div>
    </div>
    <div class='wt-guide-right'>
        <div class='wt-guide-right-top'>
            <div class='wt-guide-right-top-left'></div>
            <div class='wt-guide-right-top-right'></div>
        </div>
        <div class='wt-guide-right-bottom'></div>
    </div>
</div>

<script>
    $(function () {


        var guide = <?php echo empty(Yii::app()->session['user']['last_time']) ? 1 : 2 ?>;
        if (guide == 1) {
            var t = getCookie('real_init');
            if (t == '') {
                guideCenter.init();
                setCookie('real_init', 'ok', 7);
            }
        }


    })

</script>