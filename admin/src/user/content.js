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
            }
        }
    });

});
