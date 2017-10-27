<!-- 工具下载 -->
<div class="dl-show">
    <div class="dl-show-inner clearfix">
        <div class="dl-show-imgsection"></div>
        <div class="dl-show-explain">
            <p class="dl-show-p1">立即开启</p>
            <p class="dl-show-p2">还原初心的H5协同工具</p>
            <p class="dl-show-p3">运行于flash中的扩展插件，极大缩短H5作品设计周期。</p>
            <p class="dl-show-p4">从视觉设计到云端上传，一气呵成。</p>
            <a id="download_btn" class="dl-show-button" href="javascript:void(0)">免费下载</a>
            <p class="dl-show-p5">适用Animate cc及以上版本（win暂不支持CC 2017）</p>
            <p class="dl-show-p6">版本：V1.4.1&nbsp;&nbsp;&nbsp;&nbsp;适用系统：win/mac</p>
        </div>
    </div>
</div> 
<!-- 安装步骤 -->
<div class="dl-setup">
    <div class="install-step">
        <img style="width:1280px" src="<?php echo STATICS ?>images/extensions.png" alt="">
    </div>
</div>
<script>
    (function () {
        var isMac = function () {
            return /macintosh|mac os x/i.test(navigator.userAgent);
        }();
        var isWindows = function () {
            return /windows|win32/i.test(navigator.userAgent);
        }();
        var downloadBtn = document.getElementById('download_btn');
        if (isMac) {
            downloadBtn.href = '<?php echo DOWNLOAD_MAC ?>'
        } else {
            downloadBtn.href = '<?php echo DOWNLOAD_PC ?>'
        }
    })()
</script>