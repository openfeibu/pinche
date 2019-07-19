define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/config': {
                name: 'config',
                component: require('./content')
            }
        });

});
