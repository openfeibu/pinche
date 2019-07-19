define(['./templates', 'app/basicvue'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '设置单价',
                list: {},
            };
        },
        ready: function(){
            var me = this;
            me.listPaySetting();
        },
        methods: {
            listPaySetting: function() {
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/admin/selectPrice', {},
                    function (res) {
                        layer.close(loadindex);
                        if(res.success) {
                            me.list = res;
                        }
                    }, 'json');
            },
            submitChange: function () {
                if(!this.price.length){
                    layer.msg('请填写金额', { time: 1000 });
                    return false;
                }
                $.post('/carpool/admin/changePrice', {
                    price: this.price
                }, function (res) {
                    layer.msg(res.msg, { time: 1000 });
                    if(res.success){
                    }
                }, 'json');
            }
        }
    });

});
