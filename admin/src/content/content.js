define(['./templates', 'app/basicvue'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '拼车信息',
                list: {
                    total: 0,
                    per_page: 10,
                    current_page: 1,
                    data: []
                },
                hasnext: false,
                type: 0,
                phone: ''
            };
        },
        computed: {
            page_count: function() {
                return Math.ceil(this.list.total / this.list.per_page);
            }
        },
        ready: function(){
            var me = this;
            me.pageContent();
        },
        methods: {
            pageContent: function() {
                var me = this;
                var loadindex = layer.load();
                $.get('/carpool/admin/listContent', {
                    page: me.list.current_page,
                    step: me.list.per_page,
                    type: me.type,
                    phone: me.phone
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
                me.pageContent();
            },
            delContent: function(id) {
                var me = this;
                layer.confirm('是否确认删除？', function() {
                    $.post('/carpool/admin/delContent', {
                        id: id
                    }, function (res) {
                        layer.msg('删除成功');
                        me.pageContent();
                    }, 'json');
                });
            },
            topContent: function(id) {
                var me = this;
                var index = layer.confirm('是否确认置顶一小时？', function() {
                    layer.close(index);
                    $.post('/carpool/admin/topContent', {
                        id: id
                    }, function (res) {
                        if(res.success) {
                            layer.alert('成功置顶到：' + res.msg);
                        }
                    }, 'json');
                });
            }
        }
    });

});
