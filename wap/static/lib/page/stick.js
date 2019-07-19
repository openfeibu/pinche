;(function(){
		// 测试
	var host = "";
	var iswx = isWeixin();
	var ismag = isMag();
	var stickInfo = new Vue({
		el : "#stickInfo",
		data : {
			// 置顶订单ID
			id : null,

			// 置顶价格
			stick_price: 10,

			// 置顶时间
			stick_time : 6
		},
		created : function(){
			var that = this;
			that.id = getQueryString('id');
			$.ajax({
				url : host+"/carpool/carpool/getTopDayCost",
				method : "GET",
				data : {},
				success : function(res) {
					that.stick_price = res.data;
				}
			});


		},
		methods : {
			showSelectInfo : function() {
				$(event.target).parent().addClass("selected").siblings().removeClass('selected');
			},
			submitStick : function() {
				var that = this;
				if(that.id && that.stick_time) {
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
						url : host+"/carpool/carpool/createTopOrder",
						method : "POST",
						data : {
							id: that.id,
							hour: that.stick_time,
							paySource: paySource //1:小程序、2：微信APP、3：微信JS支付、4、支付宝APP、5、支付宝手机网站
						},
						success : function(res){
							if(res.success) {
								var pay_params = res.data;
								if(paySource == 2) {
									magpay.wxpay({
										paydata: JSON.stringify(pay_params)
									}, function() {
										// window.history.back();
										window.location="stick-success.html";
									}, function() {
										alert('付款失败');
									});
								} else if(paySource == 3) {
									magpay.wxjspay(pay_params, function() {
										// window.history.back();
										window.location="stick-success.html";
									},function(){
										alert('支付失败');
									});
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
				}
			}
		}
	});

	//查询浏览器参数
	function getQueryString(name) {
		var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		var r = window.location.search.substr(1).match(reg);
		if(r != null) {
			return  unescape(r[2]);
		}
		return null;
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
})();