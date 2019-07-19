;(function(){
	"use strict";

	// 测试
	var host = "https://pin.0633weixiaobao.com";
	var ismag = isMag();
	// 首页
	var home = new Vue({
		el : '#home',
		data: {
			shareImage: '',
			dataList : [],

			// 拼车类型
			pageSetUp : {
				// 首页tab类型type
				type : 0,
				page : 1,
				// 数据加载标志
				loaded : false,
			},

			// 加载数据动作类型 1 点击tab或刷新; 2 滚动加载
			loadActinType : 0,

			// 当前tab栏
			carPoolType : 0,
			banner_path: '',
			notice_title: ''
		},
		created : function() {
			var that = this;
			$.ajax({
				url : host + '/carpool/carpool/getShareInfo',
				method : 'GET',
				async: false,
				crossDomain : true,
				data : {},
				success : function(res){
					that.shareImage = res.data.share_pic;
					document.title = res.data.share_title;
				}
			});
			isMag();
			that.magUserLogin();
			$.ajax({
				url : host + '/carpool/carpool/listCarpool',
				method : 'POST',
				crossDomain : true,
				data : {
					type : that.type
				},
				success : function(res){
					var dataList = that.dataList = res.data;
					that.pageSetUp.page ++;
				}
			});
			$.ajax({
				url : host + '/carpool/carpool/getBannerPathAndNotice',
				method : 'POST',
				crossDomain : true,
				data : {},
				success : function(res){
					that.banner_path = res.data.path;
					that.notice_title = res.data.notice_title;
				}
			});
		},
		computed : {
			now : function(){
				return Date.now()/1000;
			}
		},
		methods : {
			// tab切换
			switchTab : function(type){
				var that = this,
					page = this.pageSetUp.page =  1,
					actionType = this.loadActinType = 1;
				this.pageSetUp.type = type;
				$(event.target).addClass('current').siblings().removeClass('current');
				updateCarpoolList.call(this, type, page, actionType);
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
			refreshPage : function(){
				var type = this.pageSetUp.type,
					page = this.pageSetUp.page = 1,
					actionType = this.loadActinType = 1,
					that = this;
				if($(window).scrollTop()>50){
					$("body, html").animate({scrollTop : 0}, 500, function(){
						updateCarpoolList.call(that, type, page, actionType);					
					});
				}
			},
			
			magUserLogin: function() {
				var _token = sessionStorage['token'];
				if(!_token) {
					// var isMagAndroid = localStorage.getItem('isMagAndroid');
					// var isMagIos = localStorage.getItem('isMagIos');
					mag.userLogin(function(res) {
						var name = '';
						var head = '';
						if(ismag.isMagAndroid) {
							name = res.nickname;
							head = res.faceurl;
						}
						if(ismag.isMagIos) {
							name = res.name;
							head = res.facurl;
						}
						$.ajax({
							url : host + '/carpool/user/magUserLogin',
							method : 'POST',
							crossDomain : true,
							data : {
								openid : res.openid,
								name: name,
								head: head
							},
							success : function(res){
								if(res.success) {
									var token = res.data.token;
									sessionStorage['token'] = token;
									layer.open({
										content: '登录成功',
										skin: 'msg',
										time: 1
									});
								} else {
									layer.open({
										content: res.msg,
										skin: 'msg',
										time: 1
									});
								}
							}
						});
					}, function() {
						layer.open({
							content: 'fail...',
							skin: 'msg',
							time: 1
						});
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
		}

		layer.open({
			content: '加载中...',
			skin: 'msg',
			time: 1 //2秒后自动关闭
		});

		$.ajax({
			url : host + '/carpool/carpool/listCarpool',
			method : 'POST',
			data : {
				type : type,
				page : page,
			},

			success : function(res){

				switch (actionType){
					case 1:{
						that.dataList = res.data;
						that.pageSetUp.page ++;
						break;
						}
					case 2:{

						if(res.data.length == 0){
							that.pageSetUp.loaded = true;
							layer.open({
								content: '没有更多记录了...'
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
		detectScroll.call(home);
	});

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