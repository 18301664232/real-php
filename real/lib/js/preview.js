var previewWidth = GetQueryString('width') || 640;
var previewScaleW = previewWidth / 640;
var previewHeight = GetQueryString('height') || 1008 * previewScaleW;
var previewScaleH = previewHeight / 1008;

formatDom();

function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = window.location.search.substr(1).match(reg);
    if (r != null)return unescape(r[2]);
    return null;
}

function addCssByStyle(cssString) {
    var doc = document;
    var style = doc.createElement("style");
    style.setAttribute("type", "text/css");

    if (style.styleSheet) {// IE
        style.styleSheet.cssText = cssString;
    } else {// w3c
        var cssText = doc.createTextNode(cssString);
        style.appendChild(cssText);
    }

    var heads = doc.getElementsByTagName("head");
    if (heads.length)
        heads[0].appendChild(style);
    else
        doc.documentElement.appendChild(style);
}

function formatDom() {
    addCssByStyle('canvas {width: ' + previewWidth + 'px;display: block;}');

    var div1 = document.getElementById('animation_container');
    var div2 = document.getElementById('dom_overlay_container');
    var canvas = document.getElementById('canvas');
    //is cc 2017
    if (div1 != null) {
        div1.style.width = '0px';
        div1.style.height = '0px';
        div1.style.backgroundColor = null;
        console.log(div1.style.width)
    }

    if (div2 != null) {
        div2.style.width = previewWidth + 'px';
        div2.style.height = previewHeight + 'px';
        div2.style.backgroundColor = null;
        console.log(div2.style.width)
    }

    if(canvas){
        //canvas.style.backgroundColor = null;
    }
}

