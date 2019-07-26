define(['./templates', 'app/basicvue'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '用户',
                list: {
                    total: 0,
                    per_page: 10,
                    current_page: 1,
                    data: []
                },
                hasnext: false
            };
        },
        computed: {
            page_count: function() {
                return Math.ceil(this.list.total / this.list.per_page);
            }
        },
        ready: function(){
            var me = this;
            me.pageUser();
        },
        methods: {
            pageUser: function() {
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/admin/listUser', {
                    page: me.list.current_page,
                    step: me.list.per_page
                }, function (res) {
                    layer.close(loadindex);
                    if(res.success) {
                        me.list = res.data;
                    }
                }, 'json');
            },
            page: function($p) {
                var me = this;
                if($p > me.list.total) {
                    $p = me.list.total;
                }
                if($p < 1) {
                    $p = 1;
                }
                me.list.current_page = $p;
                me.pageUser();
            },
            be_driver:function(id) {
                var me = this;
                var loadpage = layer.open({
                    type: 1,//Page层类型
                    area: ['400px', '500px'],
                    title: '编辑',
                    closeBtn: 1, //不显示关闭按钮
                    btn: ["确定", "取消"],
                    shade: 0.6,//遮罩透明度
                    // maxmin: true  ,//允许全屏最小化
                    anim: 1,//0-6的动画形式，-1不开启
                    content: '<ul class="layui-form" lay-filter="edit-form">'+
                                '<li class="layui-form-item">'+
                                '<label class="layui-form-label">车主姓名：</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="realname" id="realname" value="" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                '</div>'+
                                '</li>'+
                                '<li class="layui-form-item">'+
                                '<label class="layui-form-label">身份证：</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="idcard" id="idcard" value="" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                '</div>'+
                                '</li>'+
                                '<li class="layui-form-item">'+
                                '<label class="layui-form-label">车牌：</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="car_license" id="car_license" value="" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                '</div>'+
                                '</li>'+
                                '<li class="layui-form-item">'+
                                '<label class="layui-form-label">车型：</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="car_name" id="car_name" value="" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                '</div>'+
                                '</li>'+
                                '<li class="layui-form-item">'+
                                '<label class="layui-form-label">车颜色：</label>'+
                                '<div class="layui-input-block">'+
                                '<input type="text" name="car_color" id="car_color" value="" placeholder="请输入" autocomplete="off" class="layui-input">'+
                                '</div>'+
                                '</li>'+
                            '</ul>',
                    success: function (content) {

                    },
                    btn1: function (content) {
                        var user_id = id;
                        var realname = $("#realname").val().trim();
                        var idcard = $("#idcard").val().trim();
                        var car_license = $("#car_license").val().trim();
                        var car_name = $("#car_name").val().trim();
                        var car_color = $("#car_color").val().trim();
                        me.be_driver_save(user_id,realname,idcard,car_license,car_name,car_color,loadpage);
                    }
                });
            },
            be_driver_save:function (user_id,realname,idcard,car_license,car_name,car_color,loadpage) {
                var me = this;
                var loadindex = layer.load();
                var parameter = {
                    user_id:user_id,
                    realname:realname,
                    idcard:idcard,
                    car_license:car_license,
                    car_name:car_name,
                    car_color:car_color,
                    status:1
                };
                $.ajax({
                    type: 'POST',
                    url: '/carpool/admin/beDriver',
                    data: parameter ,
                    dataType: 'json',
                    error:function(res){
                        layer.close(loadindex);
                        layer.msg("网络异常");
                    },
                    success: function(res){
                        layer.close(loadindex);
                        if(res.success) {
                            layer.close(loadpage);
                            me.pageUser();
                        }else{
                            layer.msg(res.msg);
                        }
                    }
                });
            }
        }
    });

});
