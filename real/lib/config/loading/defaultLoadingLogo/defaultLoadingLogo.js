var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
//pageName=Loading
var mcjs;
(function (mcjs) {
    var custom;
    (function (custom) {
        var defaultLoadingLogo = (function (_super) {
            __extends(defaultLoadingLogo, _super);
            function defaultLoadingLogo() {
                return _super.call(this) || this;
            }
            defaultLoadingLogo.prototype.initLib = function () {
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
                (lib.realapp_17c2170cf49ef092e946600f2876680a = function () {
                    this.spriteSheet = ss["realapp_e07faf970427407d3c207d2b9a288abd_atlas_P_"];
                    this.gotoAndStop(0);
                }).prototype = p = new cjs.Sprite();
                (lib.realapp_47bf420aea36875d6921aeefe55786e3 = function () {
                    this.spriteSheet = ss["realapp_e07faf970427407d3c207d2b9a288abd_atlas_P_"];
                    this.gotoAndStop(1);
                }).prototype = p = new cjs.Sprite();
                (lib.realapp_bec0dcb29f85afed8459827484289eb1 = function () {
                    this.spriteSheet = ss["realapp_e07faf970427407d3c207d2b9a288abd_atlas_P_"];
                    this.gotoAndStop(2);
                }).prototype = p = new cjs.Sprite();
                (lib.realapp_e511464f39e0e06d978f1a8343a2086f = function () {
                    this.spriteSheet = ss["realapp_e07faf970427407d3c207d2b9a288abd_atlas_P_"];
                    this.gotoAndStop(3);
                }).prototype = p = new cjs.Sprite();
                (lib.loadingBg = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {});
                    // Layer 1
                    this.instance = new lib.realapp_17c2170cf49ef092e946600f2876680a();
                    this.instance.setTransform(-105, -105);
                    this.timeline.addTween(cjs.Tween.get(this.instance).wait(1));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-105, -105, 210, 210);
                (lib.Symbol1 = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {});
                    // logo
                    this.instance = new lib.realapp_47bf420aea36875d6921aeefe55786e3();
                    this.instance.setTransform(-64.5, -68.1);
                    this.timeline.addTween(cjs.Tween.get(this.instance).wait(30));
                    // Layer 2
                    this.instance_1 = new lib.loadingBg();
                    this.instance_1.setTransform(-1.5, -0.6, 0.476, 0.476);
                    this.instance_1._off = true;
                    this.timeline.addTween(cjs.Tween.get(this.instance_1).wait(15).to({ _off: false }, 0).to({
                        scaleX: 0.75,
                        scaleY: 0.75
                    }, 14).wait(1));
                    // Layer 3
                    this.instance_2 = new lib.loadingBg();
                    this.instance_2.setTransform(-1.5, -0.6, 0.476, 0.476);
                    this.timeline.addTween(cjs.Tween.get(this.instance_2).to({
                        scaleX: 0.75,
                        scaleY: 0.75
                    }, 15).to({ scaleX: 1, scaleY: 1, alpha: 0 }, 14).wait(1));
                    // Layer 4
                    this.instance_3 = new lib.loadingBg();
                    this.instance_3.setTransform(-1.5, -0.6, 0.75, 0.75);
                    this.timeline.addTween(cjs.Tween.get(this.instance_3).to({
                        scaleX: 1,
                        scaleY: 1,
                        alpha: 0
                    }, 15).wait(15));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-80.3, -79.3, 157.5, 157.5);
                (lib.Loading = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, {
                        _cover: 29,
                        _introStart: 0,
                        _introFinished: 29,
                        _outroStart: 30,
                        _outroFinished: 31
                    });
                    // timeline functions:
                    this.frame_0 = function () {
                        this.dispatchEvent("mcIntroStart", this);
                    };
                    this.frame_29 = function () {
                        this.dispatchEvent("mcIntroFinished", this);
                        this.stop();
                    };
                    this.frame_30 = function () {
                        this.dispatchEvent("mcOutroStart", this);
                    };
                    this.frame_31 = function () {
                        this.dispatchEvent("mcOutroFinished", this);
                        this.stop();
                    };
                    // actions tween:
                    this.timeline.addTween(cjs.Tween.get(this).call(this.frame_0).wait(29).call(this.frame_29).wait(1).call(this.frame_30).wait(1).call(this.frame_31).wait(1));
                    // txt
                    this.instance = new lib.realapp_e511464f39e0e06d978f1a8343a2086f();
                    this.instance.setTransform(348.5, 948.8);
                    this.instance_1 = new lib.realapp_bec0dcb29f85afed8459827484289eb1();
                    this.instance_1.setTransform(200.7, 948.8);
                    this.instance_2 = new lib.Symbol1();
                    this.instance_2.setTransform(313, 256.1, 1, 1, 0, 0, 0, -1.6, -0.6);
                    this.txt = new cjs.Text("100%", "20px 'Helvetica'", "#666666");
                    this.txt.name = "txt";
                    this.txt.lineHeight = 26;
                    this.txt.lineWidth = 75;
                    this.txt.setTransform(279.7, 378.6);
                    this.timeline.addTween(cjs.Tween.get({}).to({ state: [{ t: this.txt }, { t: this.instance_2 }, { t: this.instance_1 }, { t: this.instance }] }).to({ state: [] }, 30).wait(2));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-1, -1, 642, 1010);
                return new lib.Loading();
            };
            return defaultLoadingLogo;
        }(mcjs.ui.component.IndexLoading));
        custom.defaultLoadingLogo = defaultLoadingLogo;
    })(custom = mcjs.custom || (mcjs.custom = {}));
})(mcjs || (mcjs = {}));
