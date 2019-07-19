require.config({
    baseUrl: 'src',
    shim: {
        'jquery': {
            exports: '$'
        },
        'vue': {
            exports: 'Vue'
        },
        'page': {
            exports: 'page'
        },
        'underscore': {
            exports: '_'
        },
        'templates': {
            exports: 'templates'
        }
    },
    paths: {
        'jquery': 'src/libs/js/jquery-1.8.1.min',
        'vue': 'src/libs/js/vue',
        'page': 'src/libs/js/page',
        'templates': 'src/templates',
        'underscore': 'src/libs/js/underscore'
    }
});
requirejs(['templates','jquery','vue','page','underscore'], function (templates) {
    window.templates=templates;
    requirejs(['app']);
});