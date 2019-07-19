;(function(){
	"use strict";
	// 发布找车
			// 测试
	var host = "";
	var iswx = isWeixin();
	var ismag = isMag();
	var seekMode = new Vue({
		el : '#seekMode',
		data : {
			// 发布拼车信息
			postCarpoolInfo : {
				sex : null,
				name : null,
				phone : null,
				user_count : 1,// 座位或人默认为1
				type: 1,// 默认拼车类型
				from_place : null,
				to_place : null,
				mid_place: null,
				start_time : null,
				car : null,
				note : null
			},
			// 是否勾选免责声明
			isRead : false,
			// 验证表单有效性
			formValidation : false,
			//发布金额，默认-1
			post_cost: -1,
		},
		watch:{
			postCarpoolInfo: {
				handler : function(watchDataList){
					for(var item in watchDataList){
						if(watchDataList[item]){	
							localStorage[item] = watchDataList[item];
						}
					}
				},
				deep : true
			}
		},
		created : function(){
			var that = this;
			if(iswx) {
				var token = sessionStorage.getItem('token');
				if(!token) {
					var code = getQueryString('code');
					if(sessionStorage) {
						if(!sessionStorage.wxcode) {
							code = null;
						}
					}
					if(!code) {
						if(sessionStorage) {
							sessionStorage.wxcode = true;
						}
						var pathname = window.location.pathname;
						var location = 'seekcar';
						if(pathname.indexOf('seek-person') != -1) {
							location = 'seekperson';
						}
						$.ajax({
							url : host + '/carpool/Weixin/getAuthUrl',
							method : 'POST',
							crossDomain : true,
							data : {
								location: location
							},
							success : function(res){
								window.location.href = res.data;
							}
						});
					} else {
						$.ajax({
							url : host + '/carpool/Weixin/getOpenid',
							method : 'POST',
							crossDomain : true,
							data : {
								code: code
							},
							success : function(res){
								if(res.success) {
									if(res.data) {
										var token = res.data;
										sessionStorage.setItem('token', token);
										layer.open({
											content: '登录成功',
											skin: 'msg',
											time: 1
										});
									}
									that.getUserInfo();
								} else {
									layer.open({
										content: res.msg,
										skin: 'msg',
										time: 1
									});
								}
							}
						});
					}
				} else {
					that.getUserInfo();
				}
			} else {
				that.getUserInfo();
			}
		},
		methods : {
			toggleRead : function(){
				this.isRead ? this.isRead = false : this.isRead = true;
			},
			getUserInfo: function() {
				var that = this;
				$.ajax({
					url : host+"/carpool/carpool/getUserInfo",
					method : "GET",
					success : function(res) {
						if(res.success) {
							var dataList = res.data;
							that.postCarpoolInfo['name'] = dataList['name'];
							that.postCarpoolInfo['sex'] = dataList['sex'];
							that.postCarpoolInfo['phone'] = dataList['phone'];
							that.post_cost = res['post_cost'];
						}
					}
				});
			},
			postData : function(type){
				this.postCarpoolInfo.type = type;
				var that = this;
				// 验证提交的表单
				checkForm(type);
				if(this.formValidation) {
					layer.open({type: 2, shadeClose: false});
					var paySource = 2;
					if(iswx) {
						paySource = 3;
					} else if(ismag.isMagAndroid || ismag.isMagIos) {
						paySource = 2;
					} else {
						paySource = 5;
					}
					$.ajax({
						url : host+"/carpool/carpool/createCarpoolNew",
						method : "POST",
						data : {
							name: that.postCarpoolInfo.name,
							phone: that.postCarpoolInfo.phone,
							sex: that.postCarpoolInfo.sex,
							from_place: that.postCarpoolInfo.from_place,
							to_place: that.postCarpoolInfo.to_place,
							mid_place: that.postCarpoolInfo.mid_place,
							start_time: that.postCarpoolInfo.start_time,
							user_count: that.postCarpoolInfo.user_count,
							note: that.postCarpoolInfo.note,
							type: that.postCarpoolInfo.type,
							car: that.postCarpoolInfo.car,
							paySource: paySource //1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
						},
						success : function(res){
							if(res.success) {
								var need_pay = res.need_pay;
								if(need_pay) {
									var pay_params = res.pay_params;
									if(paySource == 2) {
										magpay.wxpay({
											paydata: JSON.stringify(pay_params)
										}, function() {
											window.location = "home.html";
										}, function(){
											alert('支付失败');
										});
									} else if(paySource == 3) {
										layer.closeAll();
										magpay.wxjspay(pay_params, function() {
											window.location = "home.html";
										},function(){
											alert('支付失败');
										});
									}
								} else {
									layer.open({
										content: res.msg,
										skin: 'msg',
										time: 1
									});
									window.location = "home.html";
									// localStorage.clear();
								}
							} else {
								layer.open({
									content: res.msg,
									skin: 'msg',
									time: 5
								});
							}
						}
					});
				} else {
					if(!that.isRead) {
						layer.open({
							content : '未勾选《微信拼车平台免责声明》',
							skin : 'msg',
							time : 2
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
			closeNotice : function(e){
				$(e.currentTarget).parent().fadeOut(200);
			}
		},
	});

	function checkForm(type){
		for(var item in seekMode.postCarpoolInfo){
			if(seekMode.postCarpoolInfo[item] === null && item !== "note" && item !== "mid_place" && item !== "car"){
				seekMode.formValidation = false;
				return false;
			}else if(!seekMode.isRead){
				seekMode.formValidation = false;
				return false;
			}else{
				seekMode.formValidation = true;
			}
		}
	}

	//是否在微信浏览器中打开
	function isWeixin() {
		var ua = navigator.userAgent.toLowerCase();
		var iswx = ua.indexOf('micromessenger') != -1;
		return iswx;
		// localStorage.setItem('isWeixin', iswx);
	}

	//是否在马甲浏览器中打开
	function isMag() {
		var result = {
			isMagAndroid : false,
			isMagIos : false
		}
		if(window.androidclient) {
			result.isMagAndroid = true;
		}
		mag.iosConnect(function(bridge){
			result.isMagIos = true;
		});
		return result;
	}

	//查询浏览器参数
	function getQueryString(name) {
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if(r != null) {
			return  unescape(r[2]);
		}
		return null;
	}


})();
