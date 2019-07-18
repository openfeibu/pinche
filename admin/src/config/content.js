define(['./templates', 'app/basicvue', 'fileupload'], function(templates, BasicVue){

    return BasicVue.extend({
        name: 'admin-content',
        template: templates.getHtml('tpl/content.html'),
        props: [],
        data: function () {
            return {
                title: '配置项',
                config: {

                }
            };
        },
        methods: {
            saveConfig: function(){
                var me = this;
                var loadindex = layer.load();
                $.post('/carpool/admin/setConfig', {
                    configs: JSON.stringify(me.config)
                }, function (res) {
                    layer.close(loadindex);
                    layer.msg(res.msg, { time: 1000 });
                    if(res.success){
                        me.getConfig();
                    }
                }, 'json');
            },
            getConfig: function() {
                var me = this;
                var loadindex = layer.load();
                $.post('/carpool/admin/getConfig', {}, function (rs) {
                    layer.close(loadindex);
                    if(rs.success){
                        me.config = rs.data;
                        me.config.carpool_post_cost = me.config.carpool_post_cost == '' ? 0 : me.config.carpool_post_cost;
                        me.config.carpool_top_time_cost = me.config.carpool_top_time_cost == '' ? 0 : me.config.carpool_top_time_cost;
                    }
                }, 'json');
            }
        },
        ready: function() {
            var me = this;
            me.getConfig();
            var upload = $('#fileupload');
            upload.attr('data-url', '/carpool/upload/uploadPic');
            upload.fileupload({
                dataType:'json',
                done: function(e, data) {
                    me.config.config_ad_banner = data.result.data
                },
                progressall: function(e, data) {
                    //
                },
                submit: function(e, data) {
                    console.log('11');
                }
            });

            var upload_share = $('#fileupload_share');
            upload_share.attr('data-url', '/carpool/upload/uploadPic');
            upload_share.fileupload({
                dataType:'json',
                done: function(e, data) {
                    me.config.config_share_pic = data.result.data
                },
                progressall: function(e, data) {
                    //
                },
                submit: function(e, data) {
                    console.log('11');
                }
            });
        }
    });

});
