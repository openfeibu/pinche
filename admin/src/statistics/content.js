define(['./templates', 'app/basicvue'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '充值统计',
                list: {
                    total: 0,
                    per_page: 10,
                    current_page: 1,
                    data: []
                },
                total_amount: 0
            };
        },
        computed: {
            page_count: function() {
                return Math.ceil(this.list.total / this.list.per_page);
            }
        },
        ready: function(){
            var me = this;
            me.pageInfos();
            me.getOrderTotalMoney();
        },
        methods: {
            pageInfos: function() {
                var me = this;
                var loadindex = layer.load();
                $.post('/carpool/pay/getAllCashPay', {
                    page: me.list.current_page,
                    step: me.list.per_page
                }, function (res) {
                    layer.close(loadindex);
                    if(res.success){
                        me.list = res.data;
                    }
                }, 'json');
            },
            getOrderTotalMoney: function() {
                var me = this;
                var loadindex = layer.load();
                $.post('/carpool/pay/totalCashMoney', {},
                    function (res) {
                        layer.close(loadindex);
                    if(res.success){
                        me.total_amount = res.data[0]['money'];
                    }
                }, 'json');
            }
        }
    });

});
