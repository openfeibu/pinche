define(
    [
        './router',
        'common/components/topwelcome',
        '../config/index',
        '../user/index',
        '../content/index',
        '../statistics/index',
        '../changepswd/index',
        '../banner/index',
        '../pay/index',
        '../price/index'
    ],
    function (router){

        var App = Vue.extend({
            el: function(){
                return '#app';
            },
            data: function(){
                return {
                    routes: {
                        topnavi: [
                            {
                                path: '/config',
                                name: '配置项'
                            },
                            {
                                path: '/content',
                                name: '拼车信息'
                            },
                            {
                                path: '/banner',
                                name: '幻灯片'
                            },
                            {
                                path: '/user',
                                name: '用户列表'
                            },
                            {
                                path: '/statistics',
                                name: '充值统计'
                            },
                           
                          
                            {
                                path: '/pay',
                                name: '充值配置'
                            },
                            {
                                path: '/price',
                                name: '计费设置'
                            },
                           {
                                path: '/changepswd',
                                name: '修改密码'
                            }
                        ]
                    },
                    userIsLogined: typeof sessionStorage.userinfo !== 'undefined', // 暂时简单处理
                    username: '',
                    password: ''
                };
            },
            ready: function () {

            },
            methods: {
                userLogin: function () {
                    if(!this.username.length && !this.password.length){
                        alert('请填写用户名和密码');
                        return false;
                    }
                    var me = this;
                    $.post('/carpool/admin/login', {
                        account: this.username,
                        password: this.password
                    }, function (res) {
                        layer.msg(res.msg, { time: 1000 });
                        if(res.success){
                            me.userIsLogined = true;
                            if(window.sessionStorage){
                                sessionStorage.userinfo = encodeURIComponent(JSON.stringify({
                                    name: me.username,
                                    pswd: me.password
                                }));
                            }
                            router.go({
                                name: 'config',
                                params: {

                                }
                            });
                        }
                    }, 'json');
                }
            }
        });
        router.start(App, '#app');
        return App;

});
