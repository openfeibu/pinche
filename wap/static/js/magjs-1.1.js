!function(){function n(n){if(!window.androidclient){if(window.WebViewJavascriptBridge)return n(WebViewJavascriptBridge);if(document.addEventListener("WebViewJavascriptBridgeReady",function(i){n(WebViewJavascriptBridge)},!1),window.WVJBCallbacks)return window.WVJBCallbacks.push(n);window.WVJBCallbacks=[n];var i=document.createElement("iframe");i.style.display="none",i.src="wvjbscheme://__BRIDGE_LOADED__",document.documentElement.appendChild(i),setTimeout(function(){document.documentElement.removeChild(i)},0)}}var i=this,c=(i.mag,function(n){return n instanceof c?n:this instanceof c?void(this._wrapped=n):new _(n)});"undefined"!=typeof exports?("undefined"!=typeof module&&module.exports&&(exports=module.exports=c),exports.mag=c):i.mag=c,c.VERSION="1.0",c.callbacks={},n(function(n){n.init&&"function"==typeof n.init&&n.init(function(n,i){}),n.registerHandler("jsCallBack",function(n,i){var e=JSON.parse(n),o=e.id,t=e.val,a=c.callbacks[o];a&&(a.type&&"json"==a.type&&(t=JSON.parse(t)),a.success(t))})}),c.iosConnect=n,c.jsCallBack=function(n,i){var e=c.callbacks[n];e&&(e.type&&"json"==e.type&&(i=JSON.parse(i)),e.success(i))},c.getLocation=function(i){i&&(c.callbacks.getLocation={type:"json",success:i},window.androidclient&&window.androidclient.getLocation(),n(function(n){n.callHandler("getLocation")}))},c.getDeviceId=function(i){i&&(window.androidclient&&i(window.androidclient.getDeviceId()),n(function(n){n.callHandler("getDeviceId","",function(n){i(n)})}))},c.showCommentWin=function(n,i){c.callbacks.showCommentWin={type:"json",success:i},window.androidclient&&window.androidclient.showCommentWin(JSON.stringify(n)),c.iosConnect(function(i){i.callHandler("showCommentWin",JSON.stringify(n),function(n){})})},c.previewImage=function(i){var c=JSON.stringify(i);window.androidclient&&window.androidclient.previewImage(c),n(function(n){n.callHandler("previewImage",c,function(n){})})},c.picPick=function(i){var c=JSON.stringify(i);window.androidclient&&window.androidclient.onPickPic(c),n(function(n){n.callHandler("onPickPic",c,function(n){})})},c.registPicPick=function(n){c.callbacks.picPickPreview={type:"json",success:n.preview},c.callbacks.picPickSuccess={type:"json",success:n.success},c.callbacks.picPickFail={type:"json",success:n.fail}},c.vibrate=function(){window.androidclient&&window.androidclient.vibrate(),n(function(n){n.callHandler("vibrate","",function(n){})})},c.userLogin=function(i,e){c.callbacks.userLoginSuccess={type:"json",success:i},c.callbacks.userLoginFail={type:"json",success:e},window.androidclient&&window.androidclient.userLogin(),n(function(n){n.callHandler("userLogin","",function(n){})})},c.tel=function(i){window.androidclient&&window.androidclient.tel(i),n(function(n){n.callHandler("tel",i,function(n){})})},c.sms=function(i,c){window.androidclient&&window.androidclient.sms(i,c),n(function(n){var e={tel:i,content:c};n.callHandler("sms",JSON.stringify(e),function(n){})})},c.jumpTo=function(i){window.androidclient&&window.androidclient.jumpTo(i),n(function(n){n.callHandler("jumpTo",i,function(n){})})},c.closeWin=function(){window.androidclient&&window.androidclient.finish(),n(function(n){n.callHandler("finish","",function(n){})})},c.clientSetup=function(i){n(function(n){n.callHandler("_clientSetup",JSON.stringify(i),function(n){})})},c.share=function(i,e){c.callbacks.share={type:"json",success:e},window.androidclient&&(i.plat||(i.plat=-1),window.androidclient.share(i.plat+"",i.url,i.title,i.content,i.img)),n(function(n){n.callHandler("share",JSON.stringify(i),function(n){})})},c.startShake=function(i){c.callbacks.phoneShark={success:i},window.androidclient&&window.androidclient.startShake(),n(function(n){n.callHandler("startShake","",function(n){})})},c.stopShake=function(){window.androidclient&&window.androidclient.stopShake(),n(function(n){n.callHandler("stopShake","",function(n){})})},c.qrcode=function(i){i&&(c.callbacks.qrcode={type:"json",success:i},window.androidclient&&window.androidclient.qrcode(),n(function(n){n.callHandler("qrcode")}))},c.naviRight=function(i){var i=JSON.stringify(i);window.androidclient&&window.androidclient.naviRight(i),n(function(n){n.callHandler("naviRight",i,function(n){})})},c.wxpay=function(i){var c=JSON.stringify(i);window.androidclient&&window.androidclient.wxpay(c),n(function(n){n.callHandler("wxpay",c,function(n){})})},c.registWxpay=function(n){c.callbacks.wxpaySuccess={type:"",success:n.success},c.callbacks.wxpayFail={type:"",success:n.fail}}}();