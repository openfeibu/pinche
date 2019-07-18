define(['./templates', 'app/basicvue'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '修改密码',
                oldpswd: '',
                newpswd: ''
            };
        },
        methods: {
            submitChange: function () {
                if(!this.oldpswd.length || !this.newpswd.length){
                    layer.msg('请填写密码', { time: 1000 });
                    return false;
                }
                $.post('/carpool/admin/changePassword', {
                    old_password: this.oldpswd,
                    password: this.newpswd
                }, function (res) {
                    layer.msg(res.msg, { time: 1000 });
                    if(res.success){
                    }
                }, 'json');
            }
        }
    });

});
