!function(){"use strict";function o(o){for(var e in i.postCarpoolInfo){if(null===i.postCarpoolInfo[e]&&"note"!==e&&"mid_place"!==e&&"car"!==e)return i.formValidation=!1,!1;if(!i.isRead)return i.formValidation=!1,!1;i.formValidation=!0}}function e(){var o=navigator.userAgent.toLowerCase(),e=o.indexOf("micromessenger")!=-1;return e}function n(){var o={isMagAndroid:!1,isMagIos:!1};return window.androidclient&&(o.isMagAndroid=!0),mag.iosConnect(function(e){o.isMagIos=!0}),o}function t(o){var e=new RegExp("(^|&)"+o+"=([^&]*)(&|$)"),n=window.location.search.substr(1).match(e);return null!=n?unescape(n[2]):null}var a="",s=e(),r=n(),i=new Vue({el:"#seekMode",data:{postCarpoolInfo:{sex:null,name:null,phone:null,user_count:1,type:1,from_place:null,to_place:null,mid_place:null,start_time:null,car:null,note:null},isRead:!1,formValidation:!1,post_cost:-1},watch:{postCarpoolInfo:{handler:function(o){for(var e in o)o[e]&&(localStorage[e]=o[e])},deep:!0}},created:function(){var o=this;if(s){var e=sessionStorage.getItem("token");if(e)o.getUserInfo();else{var n=t("code");if(sessionStorage&&(sessionStorage.wxcode||(n=null)),n)$.ajax({url:a+"/carpool/Weixin/getOpenid",method:"POST",crossDomain:!0,data:{code:n},success:function(e){if(e.success){if(e.data){var n=e.data;sessionStorage.setItem("token",n),layer.open({content:"登录成功",skin:"msg",time:1})}o.getUserInfo()}else layer.open({content:e.msg,skin:"msg",time:1})}});else{sessionStorage&&(sessionStorage.wxcode=!0);var r=window.location.pathname,i="seekcar";r.indexOf("seek-person")!=-1&&(i="seekperson"),$.ajax({url:a+"/carpool/Weixin/getAuthUrl",method:"POST",crossDomain:!0,data:{location:i},success:function(o){window.location.href=o.data}})}}}else o.getUserInfo()},methods:{toggleRead:function(){this.isRead?this.isRead=!1:this.isRead=!0},getUserInfo:function(){var o=this;$.ajax({url:a+"/carpool/carpool/getUserInfo",method:"GET",success:function(e){if(e.success){var n=e.data;o.postCarpoolInfo.name=n.name,o.postCarpoolInfo.sex=n.sex,o.postCarpoolInfo.phone=n.phone,o.post_cost=e.post_cost}}})},postData:function(e){this.postCarpoolInfo.type=e;var n=this;if(o(e),this.formValidation){layer.open({type:2,shadeClose:!1});var t=2;t=s?3:r.isMagAndroid||r.isMagIos?2:5,$.ajax({url:a+"/carpool/carpool/createCarpoolNew",method:"POST",data:{name:n.postCarpoolInfo.name,phone:n.postCarpoolInfo.phone,sex:n.postCarpoolInfo.sex,from_place:n.postCarpoolInfo.from_place,to_place:n.postCarpoolInfo.to_place,mid_place:n.postCarpoolInfo.mid_place,start_time:n.postCarpoolInfo.start_time,user_count:n.postCarpoolInfo.user_count,note:n.postCarpoolInfo.note,type:n.postCarpoolInfo.type,car:n.postCarpoolInfo.car,paySource:t},success:function(o){if(o.success){var e=o.need_pay;if(e){var n=o.pay_params;2==t?magpay.wxpay({paydata:JSON.stringify(n)},function(){window.location="home.html"},function(){alert("支付失败")}):3==t&&magpay.wxjspay(n,function(){window.location="home.html"},function(){alert("支付失败")})}else layer.open({content:o.msg,skin:"msg",time:1}),window.location="home.html"}else layer.open({content:o.msg,skin:"msg",time:5})}})}else n.isRead?layer.open({content:"发布信息不完整",skin:"msg",time:2}):layer.open({content:"未勾选《微信拼车平台免责声明》",skin:"msg",time:2})},closeNotice:function(o){$(o.currentTarget).parent().fadeOut(200)}}})}();