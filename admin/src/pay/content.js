define(['./templates', 'app/basicvue','fileupload'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '充值金额配置',
                list: {
                    data: []
                },
                hasnext: false
            };
        },
        computed: {
           
        },
        ready: function(){
            var me = this;
            me.listPaySetting();
        },
        methods: {
            listPaySetting: function() {
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/pay/getPaySetting', {}, 
                    function (res) {
                    layer.close(loadindex);
                    if(res.success) {
                        me.list.data = res.data;

                    }
                }, 'json');
            }
        }
    });

});
