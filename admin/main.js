require.config({
    baseUrl: 'src',
    shim: {
        'layer': {
            deps: ['jquery'],
            exports: 'layer'
        },
        'jquery-ui': {
            deps: ['jquery'],
            exports: 'jquery-ui'
        },
        'fileupload': {
            deps:['jquery', 'jquery-ui'],
            exports: 'fileupload'
        },
        'ueditor': {
            deps: [
                'ueditor-ZeroClipboard',
                'ueditor-config'
            ],
            exports: 'UE',
            init:function(ZeroClipboard){
                //导出到全局变量，供ueditor使用
                window.ZeroClipboard = ZeroClipboard;
            }
        }
    },
    paths: {
        'jquery': 'libs/js/jquery-1.8.1.min',
        'jquery-ui': 'libs/js/jquery-ui-1.9.2.custom.min',
        'fileupload': 'libs/js/jquery.fileupload',
        'Vue': 'libs/js/vue',
        'underscore': 'libs/js/underscore',
        'vue-router': 'libs/js/vue-router',
        'layer': 'libs/js/layer/layer',
        'ueditor': 'libs/js/ueditor/ueditor.all.min',
        'ueditor-config': 'libs/js/ueditor/ueditor.config',
        'ueditor-ZeroClipboard': 'libs/js/ueditor/third-party/zeroclipboard/ZeroClipboard.min',
    }
});

require(['Vue','vue-router','jquery','underscore', 'layer'],function (Vue,VueRouter) {
    window.VueRouter=VueRouter;
    window.Vue=Vue;
    window.UEDITOR_HOME_URL = "/admin/src/libs/js/ueditor/";
    requirejs(['app/app']);
})
