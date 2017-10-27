<link rel="stylesheet" type="text/css" href="<?php echo STATICS ?>css/account-center.css">
<body>
    <div class="title-sec">
        <div class="title-box clearfix">
            <p class="title-text">账户中心</p>
            <ul class="title-list">
                <li class="title-current"><a href="<?php echo U('user/user/info') ?>">账户资料</a></li>
                <li><a href="<?php echo U('user/user/safety') ?>">账户安全</a></li>
                <li><a href="<?php echo U('user/user/workorder') ?>">工单管理</a></li>
            </ul>
        </div>
    </div>
    <div class="doc-sec">
        <div class="doc-head clearfix">
            <div class="doc-left">
                <?php if ($data["headimg"] == ''): ?>
                    <img src="<?php echo STATICS ?>images/ac-head.png" class="doc-img">
                <?php else: ?>
                    <img src="<?php echo $data['headimg'] ?>" class="doc-img">
                <?php endif; ?>
            </div>
            <div class="doc-right">
                <input type="file" class="doc-file">
                <button class="doc-head-btn">修改头像</button>
                <p class="doc-head-text">建议上传&nbsp;256&nbsp;*&nbsp;256&nbsp;px&nbsp;大小的图片</p>
            </div>
        </div>
        <div class="doc-input">
            <p class="base-p doc-name">昵称</p>
            <div class="base-input-box doc-name-box clearfix">
                <input type="text" placeholder="昵称只能输入汉字、字母及数字，不能包含特殊符号且不超过16个字符" class="base-input doc-name-input" value="<?php echo $data['nickname'] ?>">
                <p class="base-input-fb doc-name-fb">输入错误请修改</p>
            </div>
            <p class="base-p doc-intro">介绍</p>
            <div class="base-input-box doc-intro-box clearfix">
                <input type="text" placeholder="介绍只能输入汉字、字母及数字，不能包含特殊符号且不超过30个字符" class="base-input doc-intro-input" value="<?php echo $data['signature'] ?>">
                <p class="base-input-fb doc-intro-fb">输入错误请修改</p>
            </div>
            <p class="base-p doc-site">所在地</p>
            <div class="doc-site-box clearfix">
                <select class="base-input doc-site-province"></select>
                <select class="base-input doc-site-city"></select><span class="doc-caret doc-caret-province"></span><span class="doc-caret doc-caret-city"></span>
            </div>
            <button class="base-btn doc-save">保存</button>
            </d	iv>
        </div>
        <div class="wtSlideBlock"></div>

        <script type="text/javascript" src="<?php echo STATICS ?>js/data.js"></script>
        <script type="text/javascript" src="<?php echo STATICS ?>js/jquery.city.select.min.js"></script>
        <script type="text/javascript">
            //反馈小滑块
            var wtSlideBlockDoor = true;
            function wtSlideBlock(text, backgroundImgDoor) {
                if (wtSlideBlockDoor) {
                    if (backgroundImgDoor) {
                        $('.wtSlideBlock').addClass('wtSlideBlockFalse');
                    } else {
                        $('.wtSlideBlock').removeClass('wtSlideBlockFalse');
                    }
                    $('.wtSlideBlock').html(text);
                    $('.wtSlideBlock').css('left', ((($(window).width() - $('.wtSlideBlock').width()) / 2) | 0) + 'px');
                    wtSlideBlockDoor = false;
                    $('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState1');
                    setTimeout(function () {
                        $('.wtSlideBlock').removeClass('wtSlideBlockState1 wtSlideBlockState2').addClass('wtSlideBlockState2');
                        wtSlideBlockDoor = true;
                    }, 1300);
                }
            }

            var checkName = /^[\u4E00-\u9FA5A-Za-z0-9]{1,30}$/;
            var checkIntro = /^[\u4E00-\u9FA5A-Za-z0-9]{1,40}$/;
            //上传头像相关逻辑
            $('.doc-head-btn').on('click', function () {
                $('.doc-file').val('');
                $('.doc-file').one('change', function (e) {
                    var file = e.target.files[0];
                    var fileReader = new FileReader();
                    fileReader.readAsDataURL(file);
                    $(fileReader).on('load', function () {
                        $('.doc-img').attr('src', fileReader.result);
                    });

                    //此处有ajax上传
                });
                $('.doc-file').click();
            });
            //省市选择联动

            locInit({
                province: '<?php echo $data['province'] ?>',
                city: '<?php echo $data['city'] ?>'
            });

            function locInit(locObj) {

                var locId = [11, 1101]

                for (var i = 0; i < data.length; i++) {
                    if (data[i].name === locObj.province) {
                        locId[0] = data[i].id;
                        var city = data[i].cities;
                        for (var j = 0; j < city.length; j++) {
                            if (city[j].name === locObj.city) {
                                locId[1] = city[j].id;
                            }
                        }

                    }
                }

                $('.doc-site-province,.doc-site-city').citylist({
                    data: data,
                    id: 'id',
                    children: 'cities',
                    name: 'name',
                    metaTag: 'name',
                    selected: locId
                });
            }
            //保存按钮的逻辑
            $('.doc-save').on('click', function () {
                var checkNameResult = checkName.test($('.doc-name-input').val());
                var checkIntroResult = checkIntro.test($('.doc-intro-input').val());
                var province = $('.doc-site-province option:selected').attr('value');
                var city = $('.doc-site-city option:selected').attr('value');
                var headimg = $('.doc-img').attr('src');
                var nickname = $('.doc-name-input').val();
                var signature = $('.doc-intro-input').val();
                if (!checkNameResult && nickname != '') {
                    $('.doc-name-box').addClass('base-input-box-fb');
                    //$('.doc-name-box > .base-input-fb').text('自定义文本');
                    return false;
                }
                if (!checkIntroResult && signature != '') {
                    $('.doc-intro-box').addClass('base-input-box-fb');
                    //$('.doc-intro-box > .base-input-fb').text('自定义文本');
                    return false;
                }

                //在这里发送昵称，介绍，所在地，等信息。
                var url = '<?php echo U('user/user/updateinfo') ?>';
                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: "json",
                    data: {
                        headimg: headimg,
                        nickname: nickname,
                        signature: signature,
                        province: province,
                        city: city

                    },
                    success: function (data) {
                        if (data.code == 0) {
                            window.location.reload();
                            wtSlideBlock('保存成功');
                        } else {
                            wtSlideBlock('保存失败', true);
                        }

                    }
                });


            });
            //输入框获得焦点的逻辑
            $('.doc-name-input,.doc-intro-input').on('focus', function () {
                $(this).parent().removeClass('base-input-box-fb');
            });
        </script>
</body>
