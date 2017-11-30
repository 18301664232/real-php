$(function(){
    var QRstr = '<div class="QQ-QRcode-box"><div class="QQ-QRcode"><img src="statics/user/images/QRcode_realapp.png" alt=""><p>扫码添加QQ交流群</p></div></div>'
    $('body').append(QRstr);

    ;(function($, window, document, undefined){

        function QRcodeComponent(){
            this.QRbox = $('.QQ-QRcode-box');
            this.QRcode = $('.QQ-QRcode');
        }
        QRcodeComponent.prototype.toggleSlow = function(){
            this.QRbox.click(function(){
                this.QRcode.slideToggle('fast');
            }.bind(this));
            $(document).on('selectstart', function(){
                return false;
            })
        }
        window.create = function(){
            var temp = new QRcodeComponent();
            return temp.toggleSlow();
        }
    })(jQuery, window, document);
    create();
})
