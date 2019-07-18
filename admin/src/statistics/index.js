define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/statistics': {
                name: 'statistics',
                component: require('./content')
            }
        });

});
