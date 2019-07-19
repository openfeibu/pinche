/**
 * MAGJSSDK 
 * @version v1.0.0
 * @author  MAGAPP 团队
 * 最后修改时间 2015-7-20
 * Copyright © magapp.cc 
 */ 
(function() {
  var root = this;
  var previousdmag = root.mag;
  var mag = function(obj) {
    if (obj instanceof mag) return obj;
    if (!(this instanceof mag)) return new _(obj);
    this._wrapped = obj;
  };
  
  if (typeof exports !== 'undefined') {
    if (typeof module !== 'undefined' && module.exports) {
      exports = module.exports = mag;
    }
    exports.mag = mag;
  } else {
    root.mag = mag;
  }
  
  mag.VERSION = '1.0';
  
  mag.callbacks={
      
  };
  
  function iosConnect(callback) {
     //在android的webview中，直接返回
    if(window .androidclient){
      return;
    }
    
    //iOS UIWebView 的JsBridge
    if (window.WebViewJavascriptBridge) { 
      return callback(WebViewJavascriptBridge); 
    }else{
      document.addEventListener('WebViewJavascriptBridgeReady', function(evt) {
        callback(WebViewJavascriptBridge);
      }, false); 
    }
   
    //iOS WKWebView 的JsBridge
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
      //iOS UIWebView 的bridge对象初始化
    if(bridge.init && typeof bridge.init === 'function'){
      bridge.init(function(message, responseCallback) {
       
      });
    }
      bridge.registerHandler('jsCallBack', function(data, responseCallback) {
           var call=JSON.parse(data);
           var id=call.id;
           var val=call.val;
           var callback=mag.callbacks[id];
           if(callback){
             if(callback.type&&callback.type=='json'){
               val=JSON.parse(val);
             }
             callback.success(val);
           }
      });
   })
  //
  mag .iosConnect = iosConnect;
  //js回调
  mag.jsCallBack=function(id,val){
     var callback=mag.callbacks[id];
     if(callback){
       if(callback.type&&callback.type=='json'){
         val=JSON.parse(val);
       }
       callback.success(val);
     }
   }
 

   /**
    * 获取用户经纬度
    */
    mag.getLocation=function(fun){
       if(!fun)return;
       mag.callbacks.getLocation={
           type:'json',
           success:fun
       };
       if(window .androidclient){
         window .androidclient.getLocation();
       }
       iosConnect(function(bridge){
         bridge.callHandler('getLocation');  
       });
    }
    
    mag.getDeviceId=function(fun){
       if(!fun)return;
       if(window .androidclient){
          fun(window .androidclient.getDeviceId());
       }
       iosConnect(function(bridge){
         bridge.callHandler('getDeviceId','',function(rs){
            fun(rs);
         });  
       });
    }
  //评论组件
  mag.showCommentWin=function(config,fun){
       mag.callbacks.showCommentWin={
           type:'json',
           success:fun
       };
       if(window .androidclient){
          window .androidclient.showCommentWin(JSON.stringify(config));
       }
       mag .iosConnect(function(bridge){
          bridge.callHandler('showCommentWin',JSON.stringify(config),function(rs){});  
       });
    }
   /**
     * 预览图片
     */
    mag.previewImage=function(config){
      var constr=JSON.stringify(config);
      if(window .androidclient){
          window .androidclient.previewImage(constr);
       }
       iosConnect(function(bridge){
         bridge.callHandler('previewImage',constr,function(rs){
         });  
       });
    }

   /**
     * 图片选择
     */
    mag.picPick=function(config){
       var constr=JSON.stringify(config);
      if(window .androidclient){
          window .androidclient.onPickPic(constr);
       }
       iosConnect(function(bridge){
         bridge.callHandler('onPickPic',constr,function(rs){
         });  
       }); 
    }
    mag.registPicPick=function(config){
       mag.callbacks.picPickPreview={
           type:'json',
           success:config.preview
       };
        mag.callbacks.picPickSuccess={
           type:'json',
           success:config.success
       };
       mag.callbacks.picPickFail={
           type:'json',
           success:config.fail
       };
    }
    /**
     * 手机抖动
     */
    mag.vibrate=function(){
       if(window .androidclient){
          window .androidclient.vibrate();
       }
       iosConnect(function(bridge){
         bridge.callHandler('vibrate','',function(rs){
         });  
       });
    }
    
   mag.userLogin=function(funsuccess,funfail){
       mag.callbacks.userLoginSuccess={
           type:'json',
           success:funsuccess
       };
        mag.callbacks.userLoginFail={
           type:'json',
           success:funfail
       };
        if(window .androidclient){
          window .androidclient.userLogin();
       }
       iosConnect(function(bridge){
         bridge.callHandler('userLogin','',function(rs){
         });  
       });
   }
    mag.tel=function(tel){
       if(window .androidclient){
          window .androidclient.tel(tel);
        }
        iosConnect(function(bridge){
             bridge.callHandler('tel',tel,function(rs){
             });  
           });
    }

    mag.sms=function(tel,content){
       if(window .androidclient){
          window .androidclient.sms(tel,content);
        }
        iosConnect(function(bridge){
             var data={tel:tel,content:content};
             bridge.callHandler('sms',JSON.stringify(data),function(rs){
             });  
           });
    }
    mag.jumpTo=function(url){
       if(window .androidclient){
          window .androidclient.jumpTo(url);
        }
        iosConnect(function(bridge){
         bridge.callHandler('jumpTo',url,function(rs){
                                                                     
         });  
       });
    }
    mag.closeWin=function(){
       if(window .androidclient){
            window .androidclient.finish();
        }
        iosConnect(function(bridge){
            bridge.callHandler('finish','',function(rs){
               });  
             });
    }
  mag.clientSetup=function(config){
        iosConnect(function(bridge){
            bridge.callHandler('_clientSetup',JSON.stringify(config),function(rs){  });  
        });
    }
  

    mag.share=function(config,fun){
        mag.callbacks.share={
           type:'json',
           success:fun
       };
       if(window .androidclient){
           if(!config.plat){
              config.plat=-1;
           }
            window .androidclient.share(config.plat+"",config.url,config.title,config.content,config.img);
        }
        iosConnect(function(bridge){
            bridge.callHandler('share',JSON.stringify(config),function(rs){
               });  
        });
    }
     mag.startShake=function(fun){
      mag.callbacks.phoneShark={
           success:fun
       };
       if(window .androidclient){
            window .androidclient.startShake();
        }
        iosConnect(function(bridge){
            bridge.callHandler('startShake','',function(rs){
               });  
        });
    }
    mag.stopShake=function(){
       if(window .androidclient){
            window .androidclient.stopShake();
        }
        iosConnect(function(bridge){
            bridge.callHandler('stopShake','',function(rs){
               });  
        });
    }

    mag.qrcode=function(fun){
       if(!fun)return;
       mag.callbacks.qrcode={
           type:'json',
           success:fun
       };
       if(window .androidclient){
         window .androidclient.qrcode();
       }
       iosConnect(function(bridge){
         bridge.callHandler('qrcode');  
       });
    }
    /**
     *  config={
     *        icon:'',
     *        navis:[{icon:'http://magapp.house3s.com/upload/img/20150518/1431925023648576.png',name:'下载页',url:'http://magapp.test.duohuo.net/appdownload'}]
     *        };
     **/
    mag.naviRight=function(config){
      var config=JSON.stringify(config);
      if(window .androidclient){
          window .androidclient.naviRight(config);
       }
       iosConnect(function(bridge){
         bridge.callHandler('naviRight',config,function(rs){
         });  
       });
    }

    /**
    *   微信支付
    *   mag.registWxpay({
    *     success:function(){
    *       alert("支付成功回调")
    *     },
    *     fail:function(code){
    *       alert(code)
    *     }
    *   });
    *   mag.wxpay({
    *      appId:'',
    *      partnerId:'',
    *      prepayId:'',
    *      packageValue:'',
    *      nonceStr:'',
    *      timeStamp:'',
    *      sign:''
    *   });
    */
    mag.wxpay=function(config){
      var constr=JSON.stringify(config);
      if(window.androidclient){
          window.androidclient.wxpay(constr);
       }
       iosConnect(function(bridge){
         bridge.callHandler('wxpay',constr,function(rs){
         });  
       }); 
    }
    mag.registWxpay=function(config){
       mag.callbacks.wxpaySuccess={
           type:'',
           success:config.success
       };
       mag.callbacks.wxpayFail={
           type:'',
           success:config.fail
       };
    }
     

})();


 