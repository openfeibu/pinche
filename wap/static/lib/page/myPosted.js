;(function(){
		// 测试
	var host = "";
	var myPosted = new Vue({
		el : "#myPosted",
		data:{
			dataList : [],
			// 拼车类型
			pageSetUp : {
				type : 0,
				page : 1,
				// 数据加载标志
				loaded : false,
			},

			// 加载数据动作类型 1 点击tab或刷新; 2 滚动加载
			loadActinType : 0,
		},
		created : function(){
			var that = this;
			isWeixin();
			var iswx = localStorage.getItem('isWeixin');
			if(iswx == 'true') {
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
						$.ajax({
							url : host + '/carpool/Weixin/getAuthUrl',
							method : 'POST',
							crossDomain : true,
							data : {
								location: 'mypost'
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
										that.listMyCarpool();
									}
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
					that.listMyCarpool();
				}
			} else {
				that.listMyCarpool();
			}
		},
		computed : {
			now : function(){
				return Date.now()/1000;
			}
		},
		methods : {
			listMyCarpool: function() {
				var that = this;
				$.ajax({
					url : host+"/carpool/carpool/myCarpool",
					method : "POST",
					success : function(res){
						that.dataList = res.data;
						that.pageSetUp.page ++;
					}
				});
			},
			// 格式化日期
			formatTime: function(timestamp, fmt){
				var fmt = fmt || 'yyyy-MM-dd hh:mm';
				var date = new Date();
				if(timestamp) {
				   timestamp = parseInt(timestamp);
				   date.setTime(timestamp*1000);
				}
				var meta = {
				  "M+" : date.getMonth()+1,                 //月份
				  "d+" : date.getDate(),                    //日
				  "h+" : date.getHours(),                   //小时
				  "m+" : date.getMinutes(),                 //分
				  "s+" : date.getSeconds(),                 //秒
				  "q+" : Math.floor((date.getMonth()+3)/3), //季度
				  "S"  : date.getMilliseconds()             //毫秒
				};
				if(/(y+)/.test(fmt))
				  fmt=fmt.replace(RegExp.$1, (date.getFullYear()+"").substr(4 - RegExp.$1.length));
				for(var k in meta) {
					if(new RegExp("("+ k +")").test(fmt)) {
						fmt = fmt.replace(RegExp.$1, (RegExp.$1.length==1) ? (meta[k]) : (("00"+ meta[k]).substr((""+ meta[k]).length)));
					}
				}
				return fmt;
			},
			editOrder:function(id){
				window.location = "edit-post.html?id=" + id;
			},
			delOrder:function(id){
				var that = this;
				layer.open({
					content: '是否确认删除？',
					btn: ['是', '否'],
					yes: function(index) {
						layer.close(index);
						$.ajax({
							url : host+"/carpool/carpool/delCarpool",
							data: {
								id: id
							},
							method : "POST",
							success : function(res) {
								that.listMyCarpool();
							}
						});
					}
				});
			},
			stickOperate:function(id){
				window.location="stick-info.html?id="+id;
			},
			refreshPage : function(){
				var type = this.pageSetUp.type,
					page = this.pageSetUp.page = 1,
					actionType = this.loadActinType = 1;
				if($(window).scrollTop()>50){
					$("body, html").animate({scrollTop : 0}, 500, function(){
						updateCarpoolList.call(that, type, page, actionType);					
					});
				}
			},
			//TODO 计算今天或明天
			calRecentDay : function(startTime){
				var today = new Date(),
						today_year = today.getFullYear(),
						today_month = today.getMonth(),
						today_day = today.getDate();
				var copyToday = new Date(today_year,today_month,today_day, 0, 0, 0);
						copyToday = copyToday.getTime()/1000;
				var minus = startTime - copyToday;
						if( minus > 0 && minus < 86400){
							return '今';
						}else if( minus > 86400 && minus < 172800){
							return '明';
						}
			}
		}
	});
	function updateCarpoolList (type, page, actionType){
		var that = this;
		if(actionType == 1){
			this.pageSetUp.loaded = false;
			this.pageSetUp.page ++;
		}

		layer.open({
			content: '加载中...',
			skin: 'msg',
			time: 1 //2秒后自动关闭
		});

		$.ajax({
			url : host + '/carpool/carpool/myCarpool',
			method : 'POST',
			data : {
				type : type,
				page : page,
			},

			success : function(res){

				switch (actionType){
					case 1:{
						that.dataList = res.data;
						break;
						}
					case 2:{

						if(res.data.length == 0){
							that.pageSetUp.loaded = true;
							layer.open({
								content: '没有更多记录了'
								,skin: 'msg'
								,time: 1
							});
						}
						// 加载列表
						that.dataList = that.dataList.concat(res.data);
						that.pageSetUp.page ++;
						break;
					}
				}
			}
		});
	}

	var detectScroll = _.debounce(function(){
		var that = this;
		var type = this.pageSetUp.type,
				page = this.pageSetUp.page,
				actionType = 2;
		// 滚动距离判断
		var fullHeight = $("body").height(),
				windowHeight = $(window).height(),
				scrollHeight = $(window).scrollTop() + windowHeight,
				remainHeight = fullHeight - scrollHeight;
		
		if(remainHeight < 30 && fullHeight > windowHeight && !this.pageSetUp.loaded){
			updateCarpoolList.call(that, type, page, actionType);
		}
	},500);

	$(window).on("scroll", function(){
		detectScroll.call(myPosted);
	});

	//是否在微信浏览器中打开
	function isWeixin() {
		var ua = navigator.userAgent.toLowerCase();
		var iswx = ua.indexOf('micromessenger') != -1;
		localStorage.setItem('isWeixin', iswx);
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