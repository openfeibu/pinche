;(function(){
		// 测试
	var host = "";
	var filter = new Vue({
		el : "#filter",
		data : {
			filterData : {
				type : 0,
				from_place : null,
				to_place : null,
				mid_place : null,
				start_time : null,
				user_count : null,
				page : 1
			},

			// 拼车类型
			pageSetUp : {
				type : 0,
				page : 1,
				// 数据加载标志
				loaded : false,
			},

			// 加载数据动作类型 1 点击tab或刷新; 2 滚动加载
			loadActinType : 0,

			dataList : []
		},
		created : function(){
			var that = this;
			if(window.location.hash == "#result"){
				layer.open({
					content: "加载中...",
					skin : "msg",
					time: 1,
				});
				var params = {};
				if(localStorage.getItem('search')) {
					params = JSON.parse(localStorage.getItem('search'));
				}
				$.ajax({
					url : host+"/carpool/carpool/listCarpool",
					method : "POST",
					data : params,
					success : function(res){
						that.dataList = res.data;
						that.pageSetUp.page ++;
					},
					complete : function(){
						layer.open({
							content: "加载完成",
							skin : "msg",
							time: 1,
						});
					}
				});
			}
		},
		computed : {
			now : function(){
				return Date.now()/1000;
			}
		},
		methods : {
			filterAction :function() {
				localStorage.setItem('search', JSON.stringify(this.filterData));
				window.location = "filter-result.html#result";
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
		},
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
		detectScroll.call(filter);
	});
})();