define(['ueditor'], function(){
    // 时间戳过滤器
    Vue.filter('time', function (value, format) {
        if(value) {
            value = value * 1000;
            var date = new Date(value);
            var default_value = date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
            if(format) {
                if(format == 'yyyy-MM-dd HH:mm:ss') {
                    return default_value;
                } else if(format == 'yyyy-MM-dd HH:mm') {
                    return date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours() + ":" + date.getMinutes();
                } else if(format == 'yyyy-MM-dd HH') {
                    return date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + date.getDate() + " " + date.getHours();
                } else if(format == 'yyyy-MM-dd') {
                    return date.getFullYear() + '-' + (date.getMonth() + 1) + "-" + date.getDate();
                }
            } else {
                return default_value;
            }
        }
        return '';
    });

    // 定义百度UEditor 指令
    Vue.directive('ueditor', {
        twoWay: true,
        bind: function(){
            var me = this;
            try {
                $(me.el).hide();
                setTimeout(function(){
                    var ueditor = me.ueditor = new UE.ui.Editor();
                    ueditor.render(me.el);
                    $(me.el).show();
                    ueditor.ready(function() {
                        ueditor.addListener('contentChange', function(){
                            me.set(ueditor.getContent());
                        });
                    });
                }, 100);
            } catch(e) {
                console.log('ueditor', e);
            }
        },
        update: function(val, oldVal){
            var me = this;
            try{
                me.ueditor.setContent(val);
            }catch (e){
                setTimeout(function(){
                    try {
                        me.ueditor.setContent(val);
                    }catch (e){}

                }, 200);
            }
        },
        unbind: function(){
            this.ueditor.destroy();
            $('#edui_fixedlayer').remove();
        }
    });

    return Vue.extend({
        methods: {

        }
    });
});