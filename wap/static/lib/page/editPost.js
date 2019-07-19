;(function(){
	"use strict";

		// 测试
	var host = "";

	var seekMode = new Vue({
		el : '#editPost',
		data : {
			// 发布拼车信息
			postCarpoolInfo : {
				name : null,
				phone : null,
				// 座位或人默认为1
				user_count : 1,
				// 默认拼车类型
				type: 1,
				from_place : null,
				to_place : null,
				start_time : null,
				car : null,
				mid_place: null,
				note : null
			},
			// 验证表单有效性
			formValidation : false
		},
		created : function(){
			var that = this;
			var id = getQueryString('id');
			$.ajax({
				url : host + "/carpool/carpool/getCarpool",
				method : "GET",
				data: {
					id: id
				},
				success : function(res) {
					if(res.success) {
						that.postCarpoolInfo = res.data;
						that.postCarpoolInfo.start_time = res.data.startTimeDateStr + 'T' + res.data.startTimeTimeStr;
					}
				}
			});
		},
		methods : {
			postData : function(type) {
				var that = this;
				// 验证提交的表单
				checkForm(type);
				if(this.formValidation) {
					$.ajax({
						url : host+"/carpool/carpool/editCarpool",
						method : "POST",
						data : that.postCarpoolInfo,
						success : function(res) {
							window.location = "my-posted.html";
						}
					});
				} else {
					layer.open({
						content : '发布信息不完整',
						skin : 'msg',
						time : 2
					});
				}
			}
		},
	});
	function checkForm(type) {
		for(var item in seekMode.postCarpoolInfo){
			if(seekMode.postCarpoolInfo[item] === null && item !== "note" && item !== "car" && item !== "mid_place") {
				seekMode.formValidation = false;
				return false;
			} else {
				seekMode.formValidation = true;
			}
		}
	};

	function getQueryString(name) {
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if(r != null) {
			return  unescape(r[2]);
		}
		return null;
	}
})();
