var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
var mcjs;
(function (mcjs) {
    var custom;
    (function (custom) {
        var music_btn = (function (_super) {
            __extends(music_btn, _super);
            function music_btn() {
                return _super.call(this) || this;
            }
            music_btn.prototype.initLib = function () {
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
                (lib.realh5_11433348103 = function () {
                    this.spriteSheet = ss["music_btn_atlas"];
                    this.gotoAndStop(0);
                }).prototype = p = new cjs.Sprite();
                (lib.realh5_11435983103 = function () {
                    this.spriteSheet = ss["music_btn_atlas"];
                    this.gotoAndStop(1);
                }).prototype = p = new cjs.Sprite();
                (lib.container = function (mode, startPosition, loop) {
                    this.initialize(mode, startPosition, loop, { _on: 0, _off: 13 });
                    // movieclip
                    this.instance = new lib.realh5_11433348103();
                    this.instance_1 = new lib.realh5_11435983103();
                    this.timeline.addTween(cjs.Tween.get({}).to({ state: [{ t: this.instance }] }).to({ state: [{ t: this.instance_1 }] }, 13).wait(15));
                }).prototype = p = new cjs.MovieClip();
                p.nominalBounds = new cjs.Rectangle(-1, -1, 642, 1010);
                return new lib.container();
            };
            return music_btn;
        }(mcjs.ui.component.MusicBtn));
        custom.music_btn = music_btn;
    })(custom = mcjs.custom || (mcjs.custom = {}));
})(mcjs || (mcjs = {}));
