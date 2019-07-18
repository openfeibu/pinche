;(function(){
	'use strict';

	// 编辑用户资料
	var editProfile = new Vue({
		el : '#editProfile',
		data : {
			name: null,
			phone: null,
			sex: '1'
		},
		created : function(){
			for(var item in this.$data) {
				if(typeof localStorage[item] === "undefined"){
					this.$data[item] = '';
					localStorage[item] = '';
				}else{
					this.$data[item] = localStorage[item];
				}
			}
		},
		methods : {
			saveUserInfo : function(){
				localStorage.name = this.name;
				localStorage.phone = this.phone;
				localStorage.sex = this.sex;
				window.history.back();
			}
		}
	});
})();