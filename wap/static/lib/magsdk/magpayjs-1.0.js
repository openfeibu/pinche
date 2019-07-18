/**
 * MAGpayJSSDK 
 * @version v1.0.0
 * @author  MAGpayAPP 团队
 * 最后修改时间 2015-7-20
 * Copyright © magpayapp.cc 
 */ 
(function() {
  magpay={};
  magpay.VERSION = '1.0';
  window.magpay=magpay;
  magpay.callbacks={  
  };
  function iosConnect(callback) {
    if(window.androidclient){
      return;
    }
    if (window.WebViewJavascriptBridge) { 
      return callback(WebViewJavascriptBridge); 
    }else{
      document.addEventListener('WebViewJavascriptBridgeReady', function(evt) {
        callback(WebViewJavascriptBridge);
      }, false); 
    }
    if (window.WVJBCallbacks) { 
      return window.WVJBCallbacks.push(callback); 
    }else{
      window.WVJBCallbacks = [callback];
      var WVJBIframe = document.createElement('iframe');
      WVJBIframe.style.display = 'none';
      WVJBIframe.src = 'wvjbscheme://__BRIDGE_LOADED__';
      document.documentElement.appendChild(WVJBIframe);
      setTimeout(function() { 
        document.documentElement.removeChild(WVJBIframe); 
      }, 0);
    }

  }

   iosConnect(function(bridge){
    if(bridge.init && typeof bridge.init === 'function'){
      try{
          // 捕获两次bridge init的异常，让代码正常执行
          bridge.init(function(message, responseCallback) {
            
          });
        } catch(err){

        }
    }
    bridge.registerHandler('mappayJsCallBack', function(data, responseCallback) {
           var call=JSON.parse(data);
           var id=call.id;
           var val=call.val;
           var callback=magpay.callbacks[id];
           if(callback){
             if(callback.type&&callback.type=='json'){
               val=JSON.parse(val);
             }
             callback.success(val);
           }
      });
   })
  magpay .iosConnect = iosConnect;
  magpay.jsCallBack=function(id,val){
     var callback=magpay.callbacks[id];
     if(callback){
       if(callback.type&&callback.type=='json'){
         val=JSON.parse(val);
       }
       callback.success(val);
     }
   }
   /**
    * 微信支付
    */
    magpay.wxpay=function(config,success,fail){
       magpay.callbacks.wxpaySuccess={
           type:'',
           success:success
       };
      magpay.callbacks.wxpayOnFail={
           type:'',
           success:fail
       };
       var configstr=JSON.stringify(config);
       if(window.magpayclient){
         window.magpayclient.wxpay(configstr);
       }
       iosConnect(function(bridge){
         bridge.callHandler('magpaywxpay',configstr,function(rs){});  
       });
    }
    
    
    /**
     *阿里支付
     **/
    magpay.alipay=function(config,success,fail){
       magpay.callbacks.alipaySuccess={
           type:'',
           success:success
       };
      magpay.callbacks.alipayOnFail={
           type:'',
           success:fail
       };
       var configstr=JSON.stringify(config);
       if(window.magpayclient){
         window.magpayclient.alipay(configstr);
       }
       iosConnect(function(bridge){
         bridge.callHandler('magpayalipay',configstr,function(rs){});  
       });
    }

    /************************* 微信JS支付 ******************************/
    //核心调用微信客户端支付
    var onBridgeReady = function(data, succallback, failcallback) {
        WeixinJSBridge.invoke(
            'getBrandWCPayRequest', {
                "appId": data.appid,     //公众号名称，由商户传入
                "timeStamp": data.timeStamp + '',         //时间戳，自1970年以来的秒数
                "nonceStr":  data.noncestr, //随机串
                "package": data.package_,
                "signType": "MD5",         //微信签名方式：
                "paySign": data.sign //微信签名
            },
            function(res) {
                if(res.err_msg == "get_brand_wcpay_request:ok" ) {
                    if(typeof succallback == 'function') {
                        succallback();
                    }
                } else {
                    if(failcallback && typeof failcallback == 'function') {
                        failcallback();
                    } else {
                        alert('支付失败');
                    }
                }
            }
        );
    }
    //商户调用入口
    //succallback 支付成功后的回调函数
    magpay.wxjspay = function(data, succallback, failcallback) {
        if (typeof WeixinJSBridge == "undefined") {
            if (document.addEventListener) {
                var loadindex = layer.open({type: 2, shadeClose: false});
                document.addEventListener('WeixinJSBridgeReady', function() {
                    layer.close(loadindex);
                    onBridgeReady(data, succallback, failcallback);
                }, false);
            } else if (document.attachEvent) {
                var loadindex = layer.open({type: 2, shadeClose: false});
                document.attachEvent('WeixinJSBridgeReady', function() {
                    layer.close(loadindex);
                    onBridgeReady(data, succallback, failcallback);
                });
                document.attachEvent('onWeixinJSBridgeReady', function() {
                    layer.close(loadindex);
                    onBridgeReady(data, succallback, failcallback);
                });
            }
        } else {
            onBridgeReady(data, succallback, failcallback);
        }
    }



})();


 