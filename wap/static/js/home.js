!function(){"use strict";function e(e,t,n){var o=this;1==n&&(this.pageSetUp.loaded=!1),layer.open({content:"加载中...",skin:"msg",time:1}),$.ajax({url:a+"/carpool/carpool/listCarpool",method:"POST",data:{type:e,page:t},success:function(e){switch(n){case 1:o.dataList=e.data,o.pageSetUp.page++;break;case 2:0==e.data.length&&(o.pageSetUp.loaded=!0,layer.open({content:"没有更多记录了...",skin:"msg",time:1})),o.dataList=o.dataList.concat(e.data),o.pageSetUp.page++}}})}function t(){var e={isMagAndroid:!1,isMagIos:!1};return window.androidclient&&(e.isMagAndroid=!0),mag.iosConnect(function(t){e.isMagIos=!0}),e}var a="",n=t(),o=new Vue({el:"#home",data:{shareImage:"",dataList:[],pageSetUp:{type:0,page:1,loaded:!1},loadActinType:0,carPoolType:0,banner_path:"",notice_title:""},created:function(){var e=this;$.ajax({url:a+"/carpool/carpool/getShareInfo",method:"GET",async:!1,crossDomain:!0,data:{},success:function(t){e.shareImage=t.data.share_pic,document.title=t.data.share_title}}),t(),e.magUserLogin(),$.ajax({url:a+"/carpool/carpool/listCarpool",method:"POST",crossDomain:!0,data:{type:e.type},success:function(t){e.dataList=t.data;e.pageSetUp.page++}}),$.ajax({url:a+"/carpool/carpool/getBannerPathAndNotice",method:"POST",crossDomain:!0,data:{},success:function(t){e.banner_path=t.data.path,e.notice_title=t.data.notice_title}})},computed:{now:function(){return Date.now()/1e3}},methods:{switchTab:function(t){var a=this.pageSetUp.page=1,n=this.loadActinType=1;this.pageSetUp.type=t,$(event.target).addClass("current").siblings().removeClass("current"),e.call(this,t,a,n)},formatTime:function(e,t){var t=t||"yyyy-MM-dd hh:mm",a=new Date;e&&(e=parseInt(e),a.setTime(1e3*e));var n={"M+":a.getMonth()+1,"d+":a.getDate(),"h+":a.getHours(),"m+":a.getMinutes(),"s+":a.getSeconds(),"q+":Math.floor((a.getMonth()+3)/3),S:a.getMilliseconds()};/(y+)/.test(t)&&(t=t.replace(RegExp.$1,(a.getFullYear()+"").substr(4-RegExp.$1.length)));for(var o in n)new RegExp("("+o+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?n[o]:("00"+n[o]).substr((""+n[o]).length)));return t},refreshPage:function(){var t=this.pageSetUp.type,a=this.pageSetUp.page=1,n=this.loadActinType=1,o=this;$(window).scrollTop()>50&&$("body, html").animate({scrollTop:0},500,function(){e.call(o,t,a,n)})},magUserLogin:function(){var e=sessionStorage.token;e||mag.userLogin(function(e){var t="",o="";n.isMagAndroid&&(t=e.nickname,o=e.faceurl),n.isMagIos&&(t=e.name,o=e.facurl),$.ajax({url:a+"/carpool/user/magUserLogin",method:"POST",crossDomain:!0,data:{openid:e.openid,name:t,head:o},success:function(e){if(e.success){var t=e.data.token;sessionStorage.token=t,layer.open({content:"登录成功",skin:"msg",time:1})}else layer.open({content:e.msg,skin:"msg",time:1})}})},function(){layer.open({content:"fail...",skin:"msg",time:1})})},calRecentDay:function(e){var t=new Date,a=t.getFullYear(),n=t.getMonth(),o=t.getDate(),s=new Date(a,n,o,0,0,0);s=s.getTime()/1e3;var i=e-s;return i>0&&i<86400?"今":i>86400&&i<172800?"明":void 0}}}),s=_.debounce(function(){var t=this,a=this.pageSetUp.type,n=this.pageSetUp.page,o=2,s=$("body").height(),i=$(window).height(),r=$(window).scrollTop()+i,c=s-r;c<30&&s>i&&!this.pageSetUp.loaded&&e.call(t,a,n,o)},500);$(window).on("scroll",function(){s.call(o)})}();