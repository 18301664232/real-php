var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
//pageName=defaultLoading
var mcjs;
(function (mcjs) {
    var custom;
    (function (custom) {
        var defaultLoading = (function (_super) {
            __extends(defaultLoading, _super);
            function defaultLoading() {
                return _super.call(this) || this;
            }
            defaultLoading.prototype.initLib = function () {
                var img = mcjs.RES.imgs;
                var cjs = mcjs.RES.cjs;
                var ss = mcjs.RES.ss;
                var p;
                var lib = {};
                this.lib = lib;
                var that = this; // shortcut to reference prototypes
                lib.webFontTxtFilters = {};
                lib.webfontAvailable = function (family) {
                    lib.properties.webfonts[family] = true;
                    var txtFilters = lib.webFontTxtFilters && lib.webFontTxtFilters[family] || [];
                    for (var f = 0; f < txtFilters.length; ++f) {
                        txtFilters[f].updateCache();
                    }
                };
                // symbols:
                (lib.realapp_4af32e86c7a894659f9cd93179111af0 = function () {
                    this.spriteSheet = ss["realapp_126882065ce7faa6b7d2b0e303b58d93_atlas_P_"];
                    this.gotoAndStop(0);
                }).prototype = p = new cjs.Sprite();
                (lib.realapp_786c73dda035a241f755a5fa7b73419d = function () {
                    this.spriteSheet = ss["realapp_126882065ce7faa6b7d2b0e303b58d93_atlas_P_"];
                    this.gotoAndStop(1);
                }).prototype = p = new cjs.Sprite();
                (lib.cirlcle = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {});
                    // Layer 1
                    this.instance = new lib.realapp_786c73dda035a241f755a5fa7b73419d();
                    this.instance.setTransform(-22, -22);
                    this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-22, -22, 44, 44);
                (lib.circleMc = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {});
                    // cirlcle
                    this.instance = new lib.cirlcle();
                    this.instance.setTransform(-1, -1);
                    this.timeline.addTween(cjs.Tween.get(this.instance).to({ rotation: 360 }, 19).wait(1));
                    // Bitmap 8
                    this.instance_1 = new lib.realapp_4af32e86c7a894659f9cd93179111af0();
                    this.instance_1.setTransform(-54, -44);
                    this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(20));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-54, -44, 106, 106);
                (lib.defaultLoading = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {
                        _cover: 30,
                        _introStart: 0,
                        _introFinished: 30,
                        _outroStart: 31,
                        _outroFinished: 32
                    });
                    // timeline functions:
                    this.frame_0 = function () {
                        this.dispatchEvent("mcIntroStart", this);
                    };
                    this.frame_30 = function () {
                        this.dispatchEvent("mcIntroFinished", this);
                        this.stop();
                    };
                    this.frame_31 = function () {
                        this.dispatchEvent("mcOutroStart", this);
                    };
                    this.frame_32 = function () {
                        this.dispatchEvent("mcOutroFinished", this);
                        this.stop();
                    };
                    // actions tween:
                    this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(30).call(this.frame_30).wait(1).call(this.frame_31).wait(1).call(this.frame_32).wait(1));
                    // Layer 3
                    this.txt = new cjs.Text("100%", "20px 'Helvetica'", "#666666");
                    this.txt.textAlign = "center";
                    this.txt.lineHeight = 26;
                    this.txt.lineWidth = 156;
                    this.txt.setTransform(318.1, 488.9);
                    this.timeline.addTween(cjs.Tween.get(this.txt).to({ _off: true }, 31).wait(2));
                    // movieclip
                    this.instance = new lib.circleMc();
                    this.instance.setTransform(321.1, 405.1);
                    this.timeline.addTween(cjs.Tween.get(this.instance).to({ _off: true }, 31).wait(2));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-1, -1, 642, 1010);
                return new lib.defaultLoading();
            };
            return defaultLoading;
        }(mcjs.ui.component.IndexLoading));
        custom.defaultLoading = defaultLoading;
    })(custom = mcjs.custom || (mcjs.custom = {}));
})(mcjs || (mcjs = {}));
