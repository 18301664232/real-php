/**
 * Created by lp on 2017/2/10.
 */
$(function(){
    var oh=$(window).height();
    var oh_=(oh-208)*0.7;
    $('.mianlist').height(oh_)
    console.log(oh,oh_)
    window.onresize=function(){
         oh=$(window).height();
         oh_=(oh-208)*0.7;
         $('.mianlist').height(oh_)
        console.log(oh,oh_)
    }
})