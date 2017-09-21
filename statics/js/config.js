/**
 * Created by aj on 2016/3/9.
 */

var _bridge=null;

//获取分享信息
function setShareToAndroid(){
    HostApp.receiveShareData(title,desc,link,imgUrl);
}

function sendShareToAndroid(){
    setShareToAndroid();
}

function updataCount(){
    var countTxt=document.getElementById("count");
    if(countTxt){
    var count =parseInt(countTxt.textContent);
    count++;
    countTxt.textContent=count.toString();
    }
}

function action_click(){
        if(_bridge!=null){
        _bridge.callHandler('getToken');
    }else{
        HostApp.getToken();
    }
}
//跳转到新的页面
function goPage(id){
    console.log(id);

        if(_bridge!=null){
        _bridge.callHandler('goPage', id + "");
    }else{
        HostApp.goPage(id+"");
    }
}

//进入商品详情
var getMobileType = function(){
    var type = "";
    var u = navigator.userAgent, app = navigator.appVersion;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if(isAndroid){type="android"}
    else if(isiOS){type="ios"}
    return type;
}
function connectWebViewJavascriptBridge(callback) {
    callback(WebViewJavascriptBridge);
                /*if (window.WebViewJavascriptBridge) {
                    callback(WebViewJavascriptBridge)
                } else {
                    document.addEventListener('WebViewJavascriptBridgeReady', function() {
                        callback(WebViewJavascriptBridge)
                    }, false)
                }*/
            };

function goGoodsPage(goods_id){
    var type = getMobileType();
    if(type == "ios"){
    try{
            connectWebViewJavascriptBridge(function(bridge) {bridge.callHandler('goGoodsPage', goods_id+"");});
            }catch(e){
                window.location.href = 'http://h5.shop.secwk.com/App/shareGoods?gid='+goods_id;
           }
        }else if(type == "android"){
            try{
                HostApp.goGoodsPage(goods_id+"");
            }
            catch(e){
                window.location.href = 'http://h5.shop.secwk.com/App/shareGoods?gid='+goods_id;
            }
        }
    }



 function setupWebViewJavascriptBridge(callback) {
                          if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
                          if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
                          window.WVJBCallbacks = [callback];
                          var WVJBIframe = document.createElement('iframe');
                          WVJBIframe.style.display = 'none';
                          WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
                          document.documentElement.appendChild(WVJBIframe);
                          setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
                          }

setupWebViewJavascriptBridge(function(bridge) {
    _bridge=bridge;
    bridge.registerHandler('getShareToIos', function(data, responseCallback) {
        var responseData = { 'title':title,'desc':desc,'link':link,'imgUrl':imgUrl };
        responseCallback(responseData);
    });

    bridge.registerHandler('updataCountIos', function(data, responseCallback) {
        updataCount();
    });
});


var getMobileType = function(){
    var type = "";
    var u = navigator.userAgent, app = navigator.appVersion;
    var isAndroid = u.indexOf('Android') > -1 || u.indexOf('Linux') > -1; //android终端或者uc浏览器
    var isiOS = !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
    if(isAndroid){type="android"}
    else if(isiOS){type="ios"}
    return type;
}
