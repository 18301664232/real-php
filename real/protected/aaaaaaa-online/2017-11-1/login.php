
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta charset="UTF-8">
        <title>登录页</title>
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/common.css">
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo STATICSADMIN ?>css/login.css">
        <script src="<?php echo STATICSADMIN ?>js/jquery.min.js"></script>
        <script src="<?php echo STATICSADMIN ?>js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="jumbotron">
            <h1 class="text-center RealTitle"> RealApp后台管理系统</h1>
        </div>
        <div class="form-box">
            <div class="form-container">
                <form class="form-login center-block">
                    <div class="form-group">
                        <label>用户名</label>
                        <input type="text" id="username" placeholder="请输入用户名" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>密码</label>
                        <input type="password" id="password"  placeholder="请输入密码" class="form-control">
                    </div>
                    <div class="form-group btn-area">
                        <button type="button" class="btn btn-success">登陆</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
<script type="text/javascript">
    $(".btn-success").click(function () {
        var username = $("#username").val();
        var password = $("#password").val();

        $.ajax({
            type: "POST",
            url: "<?php echo U('admin/login/login') ?>",
            data: "username=" + username + "&password=" + password,
            dataType: "json",
            success: function (data) {

                if (data.code == 0) {
                    window.location.href = '<?php echo U('admin/manage/index') ?>'
                } else {
                    alert(data.msg);
                }
                ;
            }
        });
    })
</script>

