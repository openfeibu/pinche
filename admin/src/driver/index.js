define(
    [
        'require',
        'app/router',
        './content'
    ],
    function(require, router){

        router.map({
            '/driver': {
                name: 'driver',
                component: require('./content')
            }
        });

});
