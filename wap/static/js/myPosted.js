!function(){function e(e,t,a){var n=this;1==a&&(this.pageSetUp.loaded=!1,this.pageSetUp.page++),layer.open({content:"加载中...",skin:"msg",time:1}),$.ajax({url:o+"/carpool/carpool/myCarpool",method:"POST",data:{type:e,page:t},success:function(e){switch(a){case 1:n.dataList=e.data;break;case 2:0==e.data.length&&(n.pageSetUp.loaded=!0,layer.open({content:"没有更多记录了",skin:"msg",time:1})),n.dataList=n.dataList.concat(e.data),n.pageSetUp.page++}}})}function t(){var e=navigator.userAgent.toLowerCase(),t=e.indexOf("micromessenger")!=-1;localStorage.setItem("isWeixin",t)}function a(e){var t=new RegExp("(^|&)"+e+"=([^&]*)(&|$)"),a=window.location.search.substr(1).match(t);return null!=a?unescape(a[2]):null}var o="",n=new Vue({el:"#myPosted",data:{dataList:[],pageSetUp:{type:0,page:1,loaded:!1},loadActinType:0},created:function(){var e=this;t();var n=localStorage.getItem("isWeixin");if("true"==n){var s=sessionStorage.getItem("token");if(s)e.listMyCarpool();else{var i=a("code");sessionStorage&&(sessionStorage.wxcode||(i=null)),i?$.ajax({url:o+"/carpool/Weixin/getOpenid",method:"POST",crossDomain:!0,data:{code:i},success:function(t){if(t.success){if(t.data){var a=t.data;sessionStorage.setItem("token",a),layer.open({content:"登录成功",skin:"msg",time:1}),e.listMyCarpool()}}else layer.open({content:t.msg,skin:"msg",time:1})}}):(sessionStorage&&(sessionStorage.wxcode=!0),$.ajax({url:o+"/carpool/Weixin/getAuthUrl",method:"POST",crossDomain:!0,data:{location:"mypost"},success:function(e){window.location.href=e.data}}))}}else e.listMyCarpool()},computed:{now:function(){return Date.now()/1e3}},methods:{listMyCarpool:function(){var e=this;$.ajax({url:o+"/carpool/carpool/myCarpool",method:"POST",success:function(t){e.dataList=t.data,e.pageSetUp.page++}})},formatTime:function(e,t){var t=t||"yyyy-MM-dd hh:mm",a=new Date;e&&(e=parseInt(e),a.setTime(1e3*e));var o={"M+":a.getMonth()+1,"d+":a.getDate(),"h+":a.getHours(),"m+":a.getMinutes(),"s+":a.getSeconds(),"q+":Math.floor((a.getMonth()+3)/3),S:a.getMilliseconds()};/(y+)/.test(t)&&(t=t.replace(RegExp.$1,(a.getFullYear()+"").substr(4-RegExp.$1.length)));for(var n in o)new RegExp("("+n+")").test(t)&&(t=t.replace(RegExp.$1,1==RegExp.$1.length?o[n]:("00"+o[n]).substr((""+o[n]).length)));return t},editOrder:function(e){window.location="edit-post.html?time=123&id="+e},delOrder:function(e){var t=this;layer.open({content:"是否确认删除？",btn:["是","否"],yes:function(a){layer.close(a),$.ajax({url:o+"/carpool/carpool/delCarpool",data:{id:e},method:"POST",success:function(e){t.listMyCarpool()}})}})},stickOperate:function(e){window.location="stick-info.html?id="+e},refreshPage:function(){var t=this.pageSetUp.type,a=this.pageSetUp.page=1,o=this.loadActinType=1;$(window).scrollTop()>50&&$("body, html").animate({scrollTop:0},500,function(){e.call(that,t,a,o)})},calRecentDay:function(e){var t=new Date,a=t.getFullYear(),o=t.getMonth(),n=t.getDate(),s=new Date(a,o,n,0,0,0);s=s.getTime()/1e3;var i=e-s;return i>0&&i<86400?"今":i>86400&&i<172800?"明":void 0}}}),s=_.debounce(function(){var t=this,a=this.pageSetUp.type,o=this.pageSetUp.page,n=2,s=$("body").height(),i=$(window).height(),r=$(window).scrollTop()+i,l=s-r;l<30&&s>i&&!this.pageSetUp.loaded&&e.call(t,a,o,n)},500);$(window).on("scroll",function(){s.call(n)})}();