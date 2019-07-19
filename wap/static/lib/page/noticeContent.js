;(function(){
		// 测试
	var host = "";
	"use strict";
	var seekMode = new Vue({
		el : '#noticeContent',
		data : {
			content : ''
		},
		created : function(){
			var that = this;
			$.ajax({
				url : host+"/carpool/carpool/getNoticeContent",
				method : "GET",
				data: {},
				success : function(res) {
					if(res.success) {
						that.content = res.data;
					}
				}
			});
		}
	});
})();
